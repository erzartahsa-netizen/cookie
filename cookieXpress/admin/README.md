# CookieXpress Admin Panel Setup Guide

## Overview
The admin panel allows you to manage orders, products, and users for your CookieXpress e-commerce store.

## Accessing the Admin Panel

### 1. Admin Login
- **URL**: `http://localhost/cookieXpress/admin/login.php`
- You need an admin account to access the dashboard

### 2. Create an Admin Account
First, you need to manually create an admin account in the database:

#### Option A: Using phpMyAdmin
1. Open `http://localhost/phpmyadmin`
2. Select `cookiexpress.com` database
3. Click on the `users` table
4. Click "Insert" and add a new row with:
   - `username`: `admin`
   - `email`: `admin@cookiexpress.com` (or your email)
   - `password`: Use this PHP command to generate a hashed password:
     ```php
     <?php echo password_hash('your_password_here', PASSWORD_DEFAULT); ?>
     ```
   - `role`: `admin`

#### Option B: Using SQL Query
In phpMyAdmin, go to the SQL tab and run:
```sql
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@cookiexpress.com', '$2y$10$hashed_password_here', 'admin');
```

Then login with:
- Email: `admin@cookiexpress.com`
- Password: `your_password_here`

---

## Admin Panel Features

### 📊 Dashboard
- **Total Orders**: See total number of orders
- **Pending Orders**: Quick view of pending orders that need attention
- **Total Products**: Total number of products in inventory
- **Total Users**: Total number of registered customers
- **Recent Orders**: Table showing the 5 most recent orders with quick edit links

### 📦 Products Management
**Features:**
- View all products in a table
- **Update Stock**: Quickly change product stock levels (inline form)
- **Edit Product**: Full product editing (name, description, price, category, stock)
- **Delete Product**: Remove products from catalog
- **Add New Product**: Create new products with full details

**Quick Stock Update:**
1. Go to **Products** page
2. Find the product in the table
3. Enter new stock number
4. Click **Update** button
5. Stock is updated immediately

### 🛒 Orders Management
**Features:**
- View all customer orders with order code
- See customer information and order total
- **Change Order Status** with dropdown:
  - `pending` - New order, not yet processed
  - `confirmed` - Order confirmed by customer
  - `processing` - Currently being prepared
  - `shipped` - Order has been shipped
  - `delivered` - Order delivered to customer
  - `cancelled` - Order was cancelled
- **View Order Details**: Click "View" to see full order information including:
  - Order code
  - Customer name and email
  - Total price
  - Shipping address
  - Special notes

**Update Order Status:**
1. Go to **Orders** page
2. Find the order in the table
3. Select new status from dropdown
4. Click **Update** button
5. Status changes immediately

### 👥 Users Management
**Features:**
- View all registered users (customers and admins)
- See user role (customer or admin)
- **Edit User**: Update customer information:
  - Full name
  - Phone number
  - Address
  - City
  - Postal code
- **Delete User**: Remove user accounts (cannot delete yourself)
- See creation date of each account

---

## Common Tasks

### Task 1: Check Pending Orders
1. Go to **Dashboard**
2. See "Pending Orders" stat card
3. Click "View All" link or go to **Orders** page
4. Filter for `pending` status orders

### Task 2: Update Product Stock
1. Go to **Products** page
2. Find product in table
3. Enter new stock quantity
4. Click **Update**

### Task 3: Ship an Order
1. Go to **Orders** page
2. Find the order in the table
3. Select `shipped` from status dropdown
4. Click **Update**

### Task 4: Add New Cookie Product
1. Go to **Products** page
2. Click **+ Add New Product** button
3. Fill in details:
   - Product Name (e.g., "Chocolate Brownie Cookies")
   - Description (e.g., "Rich chocolate brownies in cookie form")
   - Price in Rupiah (e.g., 30000)
   - Category (e.g., "Premium", "Classic", "Specialty")
   - Stock quantity
4. Click **Add Product**

---

## Tips & Best Practices

1. **Regular Stock Check**: Regularly update product stock to avoid overselling
2. **Order Status Updates**: Keep customers informed by updating order status promptly
3. **Product Management**: Remove out-of-stock products or set stock to 0
4. **User Management**: Keep customer records updated for better service

---

## Troubleshooting

### Can't Login?
- Check if admin account exists in database
- Verify email and password are correct
- Make sure the user role is set to 'admin' in database

### Can't See Orders?
- Make sure orders have been created by customers
- Check if MySQL is running
- Verify database connection in `config/config.php`

### Stock Not Updating?
- Check if you clicked the **Update** button
- Verify MySQL is running
- Check database permissions

---

## Database Structure

**Users Table** (with admin role):
```
id | username | email | password | role | full_name | phone | address | city | postal_code | created_at
```

**Products Table**:
```
id | name | description | price | category | stock | created_at | updated_at
```

**Orders Table**:
```
id | user_id | order_code | total_price | status | shipping_address | notes | created_at | updated_at
```

**Order Items Table**:
```
id | order_id | product_id | quantity | price
```

---

## Security Notes

- Admin passwords are hashed using PHP's PASSWORD_DEFAULT algorithm
- Admin panel only accessible with valid admin account
- Always use strong passwords for admin accounts
- Never share admin credentials with customers

---

For more help, contact the CookieXpress development team!
