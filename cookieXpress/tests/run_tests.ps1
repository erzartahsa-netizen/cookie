# PowerShell runner for tests/check_pages.py
# Usage: Open PowerShell, start XAMPP (Apache + MySQL), then run:
#   .\tests\run_tests.ps1

$python = "python"
# If Python isn't on PATH, user should update $python with full path, e.g. "C:\Python39\python.exe"
$base = "http://localhost/cookiexpress"

Write-Host "Running page checks against $base ..." -ForegroundColor Cyan
& $python "tests/check_pages.py" --base $base

if ($LASTEXITCODE -eq 0) {
    Write-Host "All tests passed." -ForegroundColor Green
} else {
    Write-Host "Some tests failed. See output above." -ForegroundColor Red
}
