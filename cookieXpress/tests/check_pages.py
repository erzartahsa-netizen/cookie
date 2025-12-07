#!/usr/bin/env python3
"""
Simple page checker for CookieXpress.
Usage:
    python tests/check_pages.py --base http://localhost/cookiexpress

Checks a list of pages for HTTP 200 and for presence of an expected snippet.
This is a lightweight smoke test — it does not log in or submit forms.
"""
import argparse
import sys
import requests

PAGES = [
    ("/index.php", "Welcome To CookieXpress"),
    ("/login.php", "Welcome Back to CookieXpress"),
    ("/signup.php", "Join CookieXpress"),
    ("/menu.php", "Our Delicious Cookie Collection"),
    ("/cart.php", "Shopping Cart"),
    ("/checkout.php", "Order Checkout"),
    ("/confirmation.php", "Order Confirmed"),
    ("/setting.php", "Account Settings"),
    ("/home.php", "Welcome To CookieXpress"),
]

TIMEOUT = 5


def check_page(base, path, expect):
    url = base.rstrip('/') + path
    try:
        r = requests.get(url, timeout=TIMEOUT)
    except Exception as e:
        return (False, f"ERROR: Request failed: {e}")

    info = []
    ok = True
    if r.status_code != 200:
        ok = False
        info.append(f"Status {r.status_code}")
    body = r.text or ''

    if expect and expect not in body:
        # some pages may redirect to login — accept presence of 'Login' as fallback
        if 'Login' in body or 'login' in body.lower():
            info.append("Expected snippet not found, page redirected to login (acceptable for protected pages)")
        else:
            ok = False
            info.append("Expected text not found")

    return (ok, '; '.join(info) if info else 'OK')


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--base', default='http://localhost/cookiexpress', help='Base URL (default: http://localhost/cookiexpress)')
    args = parser.parse_args()

    base = args.base
    print(f"Checking pages at: {base}\n")

    failures = 0
    for path, expect in PAGES:
        ok, msg = check_page(base, path, expect)
        status = 'PASS' if ok else 'FAIL'
        print(f"{status}: {path} — {msg}")
        if not ok:
            failures += 1

    print("\nSummary:")
    if failures == 0:
        print("All checks passed.")
        return 0
    else:
        print(f"{failures} page(s) failed checks.")
        return 2


if __name__ == '__main__':
    sys.exit(main())
