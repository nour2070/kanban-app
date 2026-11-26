# KanbanFlow 

**KanbanFlow** est une plateforme web collaborative de gestion de projets et de tâches. Elle permet aux équipes de travailler ensemble, de visualiser l'avancement des projets en temps réel et d'organiser les tâches à travers un tableau Kanban interactif.

## Fonctionnalités Principales

- **Authentification & Rôles :** Inscription, connexion, gestion des profils, et système de rôles (Admin / User).
- **Gestion des Projets (CRUD) :** Création, modification et suppression de projets avec dates, couleurs et descriptions.
- **Tableau Kanban Interactif :** 
  - 4 colonnes (To Do, In Progress, Review, Done).
  - **Drag & Drop** fluide propulsé par *SortableJS*.
  - Ajout, suppression et modification de tâches.
- **Collaboration :**
  - Gestion des équipes (inviter des membres aux projets).
  - Assignation des tâches aux membres.
  - Espace de commentaires sur chaque tâche.
- **Notifications & Logs :**
  - Notifications en temps réel (via Pusher).
  - Activity Logs (historique des actions sur le tableau de bord).
- **Dashboard Dynamique :** Statistiques en temps réel, graphiques de progression (Chart.js), et vue globale de l'activité.
- **Assistant AI :** Un ChatBot intelligent intégré (via l'API Google Gemini) pour répondre aux questions des utilisateurs concernant l'application.

## Technologies Utilisées

- **Backend :** Laravel 11 / PHP 8.3
- **Frontend :** Laravel Livewire, Alpine.js, Blade
- **Style :** Tailwind CSS (Dark Mode par défaut)
- **Base de données :** MySQL
- **Gestion des assets :** Vite
- **Drag & Drop :** SortableJS
- **Graphiques :** Chart.js
- **Intelligence Artificielle :** Google Gemini API
- **Notifications temps réel :** Pusher / Laravel Echo

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :
- [PHP >= 8.2](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)
- [MySQL](https://www.mysql.com/)

##  Installation & Démarrage

Suivez ces étapes pour lancer le projet en local :

**Cloner le projet :**
   ```bash
   git clone https://github.com/nour2070/kanban-app.git
   cd kanban-app