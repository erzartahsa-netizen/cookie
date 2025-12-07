# CookieXpress - Database Setup & Authentication Test Guide

## Step 1: Start XAMPP

1. Open **XAMPP Control Panel**
2. Click **Start** next to Apache
3. Click **Start** next to MySQL

Wait until both show "Running" status (green).

## Step 2: Import Database

### Option A: Using phpMyAdmin (Easy)

1. Open browser: `http://localhost/phpmyadmin`
2. Click **New** in left sidebar
3. Enter database name: `cookiexpress`
4. Click **Create**
5. Select the newly created `cookiexpress` database
6. Click **Import** tab
7. Click **Choose File** and select `web.sql` from your project folder
8. Click **Go**
9. ✅ Done! Database is imported with sample data.

### Option B: Using MySQL Command Line

Open PowerShell and run:

```powershell
cd D:\xampp\mysql\bin
.\mysql -u root -p < "D:\xampp\htdocs\cookiexpress\web.sql"
```

(Leave password blank when prompted; just press Enter)

## Step 3: Verify Database Import

In phpMyAdmin:

1. Click on `cookiexpress` database
2. You should see 5 tables:
   - `users` (empty, ready for signup)
   - `products` (8 sample cookies pre-loaded)
   - `cart_items`
   - `orders`
   - `order_items`

3. Click **products** table → you should see 8 cookies with prices.

✅ If you see these, database is correctly imported!

## Step 4: Test Authentication

### Access the Website

Open browser: `http://localhost/cookiexpress`

You should see the landing page with:
- Welcome message
- Login button
- Sign Up button
- Cookie image (if imagecookie/cookieXpress.png exists)

### Test Sign Up

1. Click **Sign Up** button
2. Fill in the form:
   - **Username**: testuser123
   - **Email**: test@example.com
   - **Password**: password123
   - **Confirm Password**: password123
3. Click **Create Account** button
4. You should see: **"Account created successfully! Redirecting to login..."**
5. After 2 seconds, redirected to login page

**Expected behavior:**
- ✅ Success message displays
- ✅ Redirects to login.php
- ✅ No error messages
- ✅ Form submits (button doesn't just highlight)

### Verify User in Database

In phpMyAdmin:

1. Click `cookiexpress` → `users` table
2. You should see 1 row with:
   - username: `testuser123`
   - email: `test@example.com`
   - password: (hashed string, not plain text)

✅ User successfully created in database!

### Test Login

1. On login page, enter:
   - **Email**: test@example.com
   - **Password**: password123
2. Click **Login** button
3. You should be redirected to **home.php** (dashboard)
4. You should see:
   - "Welcome, testuser123" message
   - Quick action cards (Menu, Cart, Profile)
   - Navigation bar with cart count

**Expected behavior:**
- ✅ Login button submits form (doesn't just highlight)
- ✅ Credentials verified against database
- ✅ Session created (`$_SESSION['user_id']` set)
- ✅ Redirects to home.php
- ✅ Dashboard displays personalized greeting

### Test Invalid Login

1. Go back to login page
2. Try wrong credentials:
   - Email: test@example.com
   - Password: wrongpassword
3. Click **Login**
4. Should see error: **"Invalid email or password!"**
5. Stay on login page (no redirect)

✅ Error handling works!

## Step 5: Test Full Flow (Optional)

After successful login:

1. **Menu** → Browse cookies → Add to cart → Verify items show in cart
2. **Cart** → Update quantities → Remove items → Proceed to checkout
3. **Checkout** → Fill shipping info → Place order
4. **Confirmation** → See order details
5. **Settings** → Edit profile → Change password
6. **Logout** → Redirected to index.php

## Troubleshooting

### "Connection Failed" Error
- **Issue**: Database connection failed
- **Solution**: 
  - Verify MySQL is running (green in XAMPP)
  - Check `config/config.php` credentials match XAMPP (root, no password, localhost)
  - Verify `web.sql` was imported

### "Table 'cookiexpress.users' doesn't exist"
- **Issue**: Database exists but tables not imported
- **Solution**: 
  - Re-import `web.sql` via phpMyAdmin → Import tab
  - Make sure you selected the `cookiexpress` database first

### "Account created successfully" but no redirect
- **Issue**: JavaScript blocked redirect or header() issue
- **Solution**: 
  - Check browser console (F12) for JavaScript errors
  - Try manually navigating to `http://localhost/cookiexpress/login.php`
  - Verify no whitespace before `<?php` in signup.php

### Login button doesn't respond / page doesn't change
- **Issue**: Form not submitting properly
- **Solution**: 
  - Check browser console (F12) for errors
  - Verify `method="POST"` in form tag
  - Verify button has `type="submit"`
  - Try refreshing page and submitting again

### Password doesn't work after signup
- **Issue**: Password might not be hashing correctly
- **Solution**: 
  - Verify PHP version supports `password_hash()` (PHP 5.5+)
  - Re-create account and immediately login
  - Check password doesn't have special characters that might need escaping

## Quick Command to Test

Run the automated page checker:

```powershell
cd D:\xampp\htdocs\cookiexpress
python tests/check_pages.py --base http://localhost/cookiexpress
```

This will verify all pages load correctly.

---

**Still having issues?** Share:
1. The error message you see
2. Steps you took to reproduce
3. Screenshot of the error (if any)
