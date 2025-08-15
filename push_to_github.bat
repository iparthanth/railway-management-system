@echo off
echo Updating remote URL and pushing to GitHub...

cd /d "D:\xampp\htdocs\railway-management-system"

echo Current directory: %cd%

echo.
echo Checking current git status...
git status

echo.
echo Updating remote URL to the new repository...
git remote set-url origin https://github.com/keddardas/railway.git

echo.
echo Verifying remote URL...
git remote -v

echo.
echo Adding all files...
git add .

echo.
echo Committing changes...
git commit -m "Initial commit - Railway Management System"

echo.
echo Pushing to GitHub (main branch)...
git push -u origin master

echo.
echo If the above failed, trying with main branch...
git branch -M main
git push -u origin main

echo.
echo Done! Check your GitHub repository at: https://github.com/keddardas/railway.git
pause
