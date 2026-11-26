
@echo off
echo Cleaning up...

rmdir /s /q node_modules
del package-lock.json

echo Installing Vite 6...
call npm install -D vite@^6

echo Installing dependencies...
call npm install

echo Building assets...
call npm run build

echo Clearing Laravel cache...
call php artisan optimize:clear

echo Done! You can now run: npm run dev and php artisan serve

pause
