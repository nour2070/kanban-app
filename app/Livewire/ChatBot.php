<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatBot extends Component
{
    public $message = '';
    public $messages = [];

    public function mount()
    {
        $this->loadMessages();
    }

    // Charger les 20 derniers messages
    public function loadMessages()
    {
        $this->messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('id', 'asc') 
            ->get();
    }

    // Envoyer une suggestion
    public function sendSuggestion($text)
    {
        $this->message = $text;
        $this->sendMessage();
    }

    // Envoyer un message
    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = trim($this->message);

        if ($userMessage === '') {
            return;
        }

        // 1. Enregistrer le message utilisateur
        ChatMessage::create([
            'message' => $userMessage,
            'is_from_admin' => false,
            'user_id' => Auth::id(),
        ]);

        // 2. Obtenir la réponse de Gemini
        $botResponse = $this->askAI($userMessage);

        // 3. Enregistrer la réponse du chatbot
        ChatMessage::create([
            'message' => $botResponse,
            'is_from_admin' => true,
            'user_id' => Auth::id(),
        ]);

        // 4. Réinitialiser le champ
        $this->reset('message');

        // 5. Recharger les messages
        $this->loadMessages();
    }

    // Connexion avec Gemini AI
    private function askAI($message)
    {
        set_time_limit(120);
        ini_set('default_socket_timeout', 120);

        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            Log::error('Gemini API: clé API manquante.');

            return "Le service IA est momentanément indisponible. Veuillez réessayer plus tard.";
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent';

        $systemPrompt = "
Tu es KanbanFlow AI, un assistant intelligent intégré
dans une application de gestion de projets Kanban.

Ton rôle est d'aider les utilisateurs à utiliser KanbanFlow.

Tu peux répondre aux questions concernant :

- La création et la gestion des projets.
- L'ajout, la modification et la suppression des tâches.
- La gestion du Kanban Board.
- Les statuts des tâches.
- Les priorités des tâches.
- L'invitation et la gestion des membres.
- La collaboration entre les membres.
- L'organisation et le suivi des projets.

Règles :

- Réponds toujours en français.
- Donne des réponses simples, claires et utiles.
- Explique les étapes une par une si nécessaire.
- Reste professionnel et amical.
- Utilise des listes lorsque cela facilite la compréhension.
- Si la question n'est pas liée à KanbanFlow,
  explique poliment que tu es spécialisé dans cette application.
- N'invente pas des fonctionnalités qui ne sont pas confirmées.

Question de l'utilisateur :
" . $message;

        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $systemPrompt
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1500 
            ]
        ];

        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

        if ($jsonData === false) {
            Log::error('Gemini: impossible de préparer les données JSON.');

            return "Une erreur est survenue. Veuillez réessayer.";
        }

        
        $maxAttempts = 3;

        // Codes HTTP qui nécessitent une nouvelle tentative
        $retryCodes = [429, 500, 502, 503, 504];

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {

            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,

                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'x-goog-api-key: ' . $apiKey
                ],

                CURLOPT_POSTFIELDS => $jsonData,

                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 90,

                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
            ]);

            // Exécuter la requête
            $response = curl_exec($ch);

            // Récupérer les informations
            $curlError = curl_error($ch);
            $curlErrorNumber = curl_errno($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            // Vérifier les erreurs de connexion
            if ($response === false) {

                Log::warning('Gemini cURL Error', [
                    'attempt' => $attempt,
                    'error_number' => $curlErrorNumber,
                    'error_message' => $curlError
                ]);

                if ($attempt < $maxAttempts) {
                    sleep($attempt);
                    continue;
                }

                return "Impossible de contacter le service IA. Vérifiez votre connexion et réessayez.";
            }

            // Décoder la réponse JSON
            $result = json_decode($response, true);

            // Vérifier les erreurs API
            if ($httpCode !== 200) {

                $errorMessage = $result['error']['message']
                    ?? 'Erreur inconnue';

                Log::warning('Gemini API Error', [
                    'status' => $httpCode,
                    'attempt' => $attempt,
                    'response' => $result
                ]);

                // Réessayer si le serveur est surchargé
                if (in_array($httpCode, $retryCodes) && $attempt < $maxAttempts) {

                    // Attendre 1 seconde puis 2 secondes
                    sleep($attempt);

                    continue;
                }

                // Message adapté selon le type d'erreur
                if ($httpCode === 503) {
                    return "Le service Gemini est actuellement très sollicité. Veuillez patienter quelques instants puis réessayer.";
                }

                if ($httpCode === 429) {
                    return "Le nombre de requêtes autorisées a été atteint. Veuillez patienter avant de réessayer.";
                }

                if ($httpCode === 401 || $httpCode === 403) {
                    return "Problème d'authentification avec Gemini. Vérifiez votre clé API.";
                }

                if ($httpCode === 404) {
                    return "Le modèle Gemini demandé est introuvable. Vérifiez le nom du modèle utilisé.";
                }

                return "Une erreur est survenue avec le service Gemini. Veuillez réessayer plus tard.";
            }

            // Récupérer la réponse générée
            if (isset($result['candidates'][0]['content']['parts'])) {

                $parts = $result['candidates'][0]['content']['parts'];

                $answer = '';

                foreach ($parts as $part) {
                    if (isset($part['text'])) {
                        $answer .= $part['text'];
                    }
                }

                if (!empty(trim($answer))) {
                    return trim($answer);
                }
            }

            // Réponse vide
            Log::warning('Gemini: réponse vide ou sans candidat.', [
                'response' => $result
            ]);

            return "Désolé, Gemini n'a pas pu générer une réponse. Veuillez réessayer.";
        }

        return "Le service IA est momentanément indisponible. Veuillez réessayer plus tard.";
    }

    public function render()
    {
        return view('livewire.chat-bot');
    }
}