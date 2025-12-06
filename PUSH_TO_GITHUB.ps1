# PowerShell script to push Antigravity project to GitHub
# Run this from PowerShell (not WSL) in the project directory

# Navigate to project directory
Set-Location "C:\Users\Geoff\OneDrive\Desktop\Newbeards&Bucks12-5"

# Verify git is ready
Write-Host "Checking git status..." -ForegroundColor Cyan
git status

Write-Host ""
Write-Host "Ready to push to GitHub" -ForegroundColor Green
Write-Host "Repository: https://github.com/squishier8123/antigravity-wordpress-fixes" -ForegroundColor Cyan

# This command will open your browser for authentication
Write-Host ""
Write-Host "Pushing to GitHub (this will open your browser to authenticate)..." -ForegroundColor Yellow
git push -u origin master

Write-Host ""
Write-Host "✓ Push complete!" -ForegroundColor Green
Write-Host "Your repo is now live at: https://github.com/squishier8123/antigravity-wordpress-fixes" -ForegroundColor Cyan
