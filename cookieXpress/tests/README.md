Quick tests for CookieXpress

Purpose
- Run a lightweight smoke test to verify pages load and include expected content.

Requirements
- Python 3.x with `requests` package installed.
- XAMPP running (Apache + MySQL).
- `cookiexpress` project placed in your XAMPP `htdocs` (e.g. `D:\xampp\htdocs\cookiexpress`).

Install requests (if needed)

```powershell
python -m pip install requests
```

Run tests (PowerShell)

```powershell
cd D:\xampp\htdocs\cookiexpress
.\tests\run_tests.ps1
```

Run tests (manual)

```powershell
python tests/check_pages.py --base http://localhost/cookiexpress
```

Notes
- Some pages (home, cart, checkout, setting, confirmation) require an authenticated session; when not authenticated they may redirect to login. The checker accepts that by reporting the redirect to login as acceptable for protected pages.
- This script does not perform form submissions or login; it's a smoke test that pages are reachable and render expected headings.
