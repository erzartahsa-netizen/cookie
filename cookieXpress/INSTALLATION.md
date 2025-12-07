# CookieXpress Website - Setup & Installation Guide

## 🍪 Project Overview
CookieXpress is a modern, fully-featured cookie e-commerce website with MySQL/phpMyAdmin integration via XAMPP.

## 📁 Project Structure

```
cookieXpress/
├── config/
│   └── config.php          # Database configuration
├── imagecookie/            # Image assets
├── index.php              # Landing page
├── login.php              # User login
├── signup.php             # User registration
├── home.php               # User dashboard
├── menu.php               # Product catalog
├── cart.php               # Shopping cart
├── checkout.php           # Order checkout
├── confirmation.php       # Order confirmation
├── setting.php            # User profile settings
├── logout.php             # Logout
├── style.css              # Main stylesheet
├── login.css              # Login page styles
├── signup.css             # Signup page styles
├── home.css               # Home page styles
├── menu.css               # Menu page styles
├── cart.css               # Cart page styles
├── checkout.css           # Checkout styles
├── confirmation.css       # Confirmation styles
├── setting.css            # Settings page styles
├── web.sql                # Database schema
└── README.md              # This file
```

## 🔧 Prerequisites

- XAMPP installed with PHP and MySQL
- Apache and MySQL services running
- phpMyAdmin access

## 📋 Installation Steps

### 1. Database Setup

1. **Create Database:**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `cookiexpress`

2. **Import SQL Schema:**
   - Go to Import tab
   - Select `web.sql` file from the project
   - Click "Go" to import all tables

### 2. File Setup

1. **Place project folder:**
   - Copy entire `cookieXpress` folder to: `C:\xampp\htdocs\`

2. **Verify configuration:**
   - Open `config/config.php`
   - Ensure database credentials match your XAMPP setup:
     - Host: `localhost`
     - Username: `root`
     - Password: `` (empty by default)
     - Database: `cookiexpress`

### 3. Access the Website

Open in browser: `http://localhost/cookieXpress/`

## 🎯 Features

### User Authentication
- Sign up with username, email, and password
- Secure login with password hashing
- Session management
- User profile management

### Product Catalog
- Browse all cookies with categories
- View product details and pricing
- Check stock availability
- Search and filter options

### Shopping Cart
- Add/remove items from cart
- Update quantities
- Real-time price calculation
- Persistent cart storage

### Checkout Process
- Shipping information form
- Multiple shipping methods
- Delivery address management
- Order summary

### Order Management
- Order confirmation with unique order code
- Order history tracking
- Status updates (Pending, Confirmed, Delivered)
- Invoice details

### User Account
- Profile information management
- Shipping address settings
- Password change functionality
- View order history

## 💾 Database Tables

1. **users** - User account information
2. **products** - Cookie products catalog
3. **cart_items** - Shopping cart items
4. **orders** - Customer orders
5. **order_items** - Items in each order

## 🎨 Design Features

- Modern, responsive design
- Brown color scheme matching cookie theme
- Mobile-friendly layout
- Smooth animations and transitions
- Consistent navigation bar across all pages
- Professional UI/UX

## 🔐 Security Features

- SQL injection prevention with prepared statements
- Password hashing with PHP password_hash()
- Session-based authentication
- Input validation and sanitization
- HTTPS ready

## 📱 Responsive Design

- Works on desktop, tablet, and mobile
- Flexible grid layouts
- Mobile-optimized navigation
- Touch-friendly buttons and forms

## 🛠️ Technical Stack

- **Backend:** PHP 7.0+
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Server:** Apache (via XAMPP)

## 📝 Sample Products

The database comes pre-populated with 8 sample cookie products:
- Classic Chocolate Chip (Rp 25,000)
- Double Chocolate Delight (Rp 28,000)
- Vanilla Dream (Rp 22,000)
- Strawberry Bliss (Rp 26,000)
- Peanut Butter Power (Rp 24,000)
- Almond Delight (Rp 27,000)
- Sugar Rush (Rp 20,000)
- Matcha Green Tea (Rp 29,000)

## 🚀 Getting Started

1. **Create Test Account:**
   - Go to Sign Up page
   - Enter username, email, and password
   - Submit form

2. **Browse Products:**
   - Click "Go to Menu" or visit `/menu.php`
   - Add cookies to cart

3. **Checkout:**
   - Click cart icon
   - Review items
   - Click "Proceed to Checkout"
   - Fill shipping information
   - Place order

4. **View Orders:**
   - Return to home page
   - Check "Recent Orders" section

## 🐛 Troubleshooting

### Database Connection Error
- Ensure XAMPP MySQL is running
- Check database credentials in `config/config.php`
- Verify database `cookiexpress` exists

### Page Not Found
- Ensure project is in `C:\xampp\htdocs\cookieXpress\`
- Check that Apache is running
- Clear browser cache

### Login Issues
- Verify user exists in database
- Check password is correct (case-sensitive)
- Clear session cookies

## 📧 Support

For issues or questions, check the error messages displayed on pages for debugging information.

---

**Version:** 1.0  
**Last Updated:** December 4, 2025
