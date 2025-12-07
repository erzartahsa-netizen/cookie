# 🍪 CookieXpress - Quick Start Guide

## ⚡ Get Started in 3 Steps

### Step 1: Database Setup (2 minutes)

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

2. **Create Database**
   - Go to `http://localhost/phpmyadmin`
   - Click "New" in left sidebar
   - Enter database name: `cookiexpress`
   - Click "Create"

3. **Import Schema**
   - Select `cookiexpress` database
   - Go to "Import" tab
   - Choose `web.sql` file from project
   - Click "Go"

### Step 2: Copy Project Files (1 minute)

1. Copy `cookieXpress` folder to `C:\xampp\htdocs\`
2. Folder should be at: `C:\xampp\htdocs\cookieXpress\`

### Step 3: Start Using! (1 minute)

1. Open browser
2. Go to: `http://localhost/cookieXpress/`
3. Click "Sign Up" to create account
4. Start shopping! 🍪

---

## 📖 Page Guide

### 🏠 Landing Page (`index.php`)
- First page users see
- Login & Sign Up buttons
- Redirect to home after login

### 👤 Sign Up (`signup.php`)
- New user registration
- Username, email, password required
- Redirect to login after success

### 🔐 Login (`login.php`)
- User authentication
- Email and password
- Redirect to home after login

### 🏡 Home (`home.php`)
- User dashboard
- Quick action cards (Menu, Cart, Profile)
- Recent orders display

### 🍪 Menu (`menu.php`)
- Product catalog
- All cookies with prices
- Add to cart functionality
- View stock status

### 🛒 Cart (`cart.php`)
- View cart items
- Update quantities
- Remove items
- Proceed to checkout

### 💳 Checkout (`checkout.php`)
- Shipping address form
- Payment method selection
- Order summary
- Place order button

### ✅ Confirmation (`confirmation.php`)
- Order confirmation
- Order code and total
- Back to shopping options

### ⚙️ Settings (`setting.php`)
- Update profile info
- Change password
- Shipping address management

---

## 🔑 Key Features

✅ Secure authentication with password hashing  
✅ MySQL database with 5 tables  
✅ Shopping cart with database storage  
✅ Complete checkout flow  
✅ Order management system  
✅ User profile management  
✅ Responsive design  
✅ 8 sample products pre-loaded  

---

## 📊 Sample Test Data

**Products in Database:**
1. Classic Chocolate Chip - Rp 25,000
2. Double Chocolate Delight - Rp 28,000
3. Vanilla Dream - Rp 22,000
4. Strawberry Bliss - Rp 26,000
5. Peanut Butter Power - Rp 24,000
6. Almond Delight - Rp 27,000
7. Sugar Rush - Rp 20,000
8. Matcha Green Tea - Rp 29,000

---

## ⚙️ Configuration

All settings are in: `config/config.php`

```php
$host = "localhost";      // Usually stays as is
$db_user = "root";        // Default XAMPP username
$db_password = "";        // Leave empty (default)
$database = "cookiexpress"; // Database name
```

---

## 🎨 Design Colors

- 🟤 Primary Brown: `#653411`
- 🟤 Dark Brown: `#522504`
- 🟠 Accent Orange: `#C07239`
- ⚫ Dark Text: `#1E1E1E`

---

## 🆘 Common Issues

### "Connection Failed"
- ✓ Is MySQL running in XAMPP?
- ✓ Did you import web.sql?
- ✓ Check config/config.php

### "Table doesn't exist"
- ✓ Import web.sql again
- ✓ Make sure you're using cookiexpress database

### "Page not found"
- ✓ Check file is in `C:\xampp\htdocs\cookieXpress\`
- ✓ Is Apache running?
- ✓ Clear browser cache

### "Login not working"
- ✓ Did you create an account first?
- ✓ Check email/password spelling
- ✓ Try signing up again

---

## 📞 Need Help?

1. **Check INSTALLATION.md** - Full setup guide
2. **Check README.md** - Project overview
3. **Check database** - Verify tables in phpMyAdmin
4. **Check browser console** - Look for JavaScript errors

---

## 🎯 Next Steps

After initial setup:
1. ✓ Test user registration
2. ✓ Browse products
3. ✓ Add items to cart
4. ✓ Complete checkout
5. ✓ Verify order in database

---

**Happy Selling! 🍪**

Version 1.0 | December 2025
