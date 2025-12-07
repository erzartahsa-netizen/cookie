# 🍪 CookieXpress - Fresh Baked Cookies Delivery

A modern, fully-featured e-commerce website for ordering fresh baked cookies online with MySQL/phpMyAdmin integration via XAMPP.

## ✨ Features

### 🔐 User Management
- Secure user registration and authentication
- Password hashing and session management  
- User profile with delivery address
- Account settings management

### 🛍️ Shopping System
- Browse cookie products by category
- Add to cart with quantity control
- Real-time price calculations
- Stock availability tracking

### 🛒 Cart & Checkout
- Persistent shopping cart
- Multiple shipping options
- Delivery address form
- Order confirmation

### 📦 Order Management
- Unique order codes
- Order history tracking
- Order status updates
- Invoice details

### 🎨 Modern Design
- Responsive layout (desktop, tablet, mobile)
- Professional brown cookie theme
- Smooth animations and transitions
- Intuitive navigation

## 🚀 Quick Start

### Requirements
- XAMPP with PHP 7.0+ and MySQL
- Web browser

### Installation
1. **Setup Database:**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create database `cookiexpress`
   - Import `web.sql`

2. **Deploy Files:**
   - Copy project to `C:\xampp\htdocs\cookieXpress\`
   - Ensure `config/config.php` has correct credentials

3. **Access Website:**
   - Open: `http://localhost/cookieXpress/`

## 📁 Project Structure

```
cookieXpress/
├── config/config.php       # Database connection
├── index.php              # Landing page
├── login.php & signup.php # Authentication
├── home.php               # User dashboard
├── menu.php               # Product catalog
├── cart.php               # Shopping cart
├── checkout.php           # Checkout page
├── confirmation.php       # Order confirmation
├── setting.php            # User profile
├── web.sql                # Database schema
├── style.css              # Main styles
└── [page].css             # Page-specific styles
```

## 💾 Database Design

- **users** - User accounts with shipping info
- **products** - Cookie catalog (8 pre-loaded)
- **cart_items** - Shopping cart storage
- **orders** - Customer orders
- **order_items** - Order line items

## 🎯 User Flow

```
Landing Page (index.php)
    ↓
Sign Up / Login
    ↓
Browse Products (menu.php)
    ↓
Add to Cart (cart.php)
    ↓
Checkout (checkout.php)
    ↓
Order Confirmation (confirmation.php)
    ↓
View Profile (setting.php)
```

## 🔒 Security

- SQL injection prevention
- Password hashing with `password_hash()`
- Session-based authentication
- Input validation & sanitization
- XSS protection with `htmlspecialchars()`

## 📱 Responsive Design

- Mobile-first approach
- Flexible grid layouts
- Touch-friendly interface
- Optimized for all screen sizes

## 🎨 Color Scheme

- Primary Brown: `#653411`
- Dark Brown: `#522504`
- Accent Orange: `#C07239`
- Background: `#f5f5f5`

## 📧 Default Test Account

After importing database:
- Register a new account via Sign Up
- Or create directly in phpMyAdmin

## 🛠️ Technical Stack

- **Backend:** PHP (Procedural)
- **Database:** MySQL (mysqli)
- **Frontend:** HTML5, CSS3, Vanilla JS
- **Server:** Apache (XAMPP)

## 📊 Sample Data

8 pre-loaded cookie products with realistic pricing:
- Classic Chocolate Chip - Rp 25,000
- Double Chocolate Delight - Rp 28,000  
- Vanilla Dream - Rp 22,000
- Strawberry Bliss - Rp 26,000
- Peanut Butter Power - Rp 24,000
- Almond Delight - Rp 27,000
- Sugar Rush - Rp 20,000
- Matcha Green Tea - Rp 29,000

## 🎯 Key Pages

| Page | URL | Purpose |
|------|-----|---------|
| Landing | `/` | Welcome & login/signup |
| Login | `/login.php` | User authentication |
| Signup | `/signup.php` | New user registration |
| Home | `/home.php` | User dashboard |
| Menu | `/menu.php` | Product catalog |
| Cart | `/cart.php` | Shopping cart |
| Checkout | `/checkout.php` | Order placement |
| Confirmation | `/confirmation.php` | Order confirmation |
| Profile | `/setting.php` | Account settings |

## 🐛 Troubleshooting

**Connection Failed?**
- Check MySQL is running in XAMPP
- Verify `config/config.php` credentials
- Ensure database `cookiexpress` exists

**Can't Login?**
- Verify account exists
- Check password (case-sensitive)
- Clear browser cookies

**Missing Images?**
- Place images in `imagecookie/` folder
- Check image paths in HTML

## 📋 For Full Documentation

See `INSTALLATION.md` for detailed setup instructions and troubleshooting guide.

---

**Version:** 1.0  
**Status:** Production Ready  
**Last Updated:** December 4, 2025

Made with ❤️ for cookie lovers everywhere! 🍪
