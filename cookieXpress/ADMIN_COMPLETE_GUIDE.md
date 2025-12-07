# CookieXpress Admin Panel - Complete Guide

## 🎉 What We Built

A complete **Admin Management System** for CookieXpress that lets you:
- ✅ Manage product stock (increase/decrease inventory)
- ✅ Change order status (pending → confirmed → shipped → delivered)
- ✅ View customer orders and details
- ✅ Add/edit/delete products
- ✅ Manage user accounts
- ✅ View sales dashboard with statistics

---

## 📁 Admin Files Created

```
/admin/
├── login.php              # Admin login page
├── dashboard.php          # Dashboard with stats & recent orders
├── products.php           # Product management (stock, edit, delete)
├── orders.php             # Order management & status change
├── users.php              # User management
├── add-product.php        # Add new product form
├── edit-product.php       # Edit existing product
├── edit-user.php          # Edit user profile
├── logout.php             # Logout functionality
├── admin.css              # Complete styling for admin panel
└── README.md              # Detailed admin documentation
```

---

## 🚀 Getting Started

### Step 1: Update Your Database (IMPORTANT!)

Your web.sql file has been updated to include the `role` field in users table.

**Re-import web.sql:**
1. Open `http://localhost/phpmyadmin`
2. Select **`cookiexpress.com`** database
3. Click **SQL** tab
4. Delete all existing tables (Optional, or just add role column manually)
5. Import the updated `web.sql` file
6. Click **Import**

### Step 2: Create Admin Account

**Using phpMyAdmin SQL Query:**

Open SQL tab and run:
```sql
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@cookiexpress.com', '$2y$10$abc123def456', 'admin');
```

**To generate a hashed password:**
Create temp.php and run:
```php
<?php echo password_hash('admin123', PASSWORD_DEFAULT); ?>
```
Copy the output and paste in the query above.

---

## 🔐 Admin Login

**URL**: `http://localhost/cookieXpress/admin/login.php`

**Example Credentials**:
- Email: `admin@cookiexpress.com`
- Password: `admin123` (or what you set)

---

## 📊 Admin Dashboard Features

### 1. Dashboard Overview
```
📦 Total Orders    ← Total number of all orders
⏳ Pending Orders  ← Orders awaiting action (highlighted in yellow)
🍪 Total Products ← Number of products in inventory
👥 Total Users    ← Number of registered customers
```

**Recent Orders Table** shows last 5 orders with:
- Order code
- Customer name
- Total price
- Current status
- Date created
- Quick edit link

---

## 🛍️ Products Management

### View Products
- Go to **Products** page
- See all products in a table with: Name, Price, Category, Stock

### Update Stock (Quick Update)
```
1. Find product in table
2. Enter new quantity in "Stock" field
3. Click "Update" button
4. Stock is instantly updated in database
```

### Edit Product (Full Edit)
```
1. Click "Edit" button on any product
2. Modify: Name, Description, Price, Category, Stock
3. Click "Update Product"
```

### Add New Product
```
1. Click "+ Add New Product" button
2. Fill in:
   - Product Name: "Matcha Green Tea Cookie"
   - Description: "Exotic matcha flavor"
   - Price: "29000"
   - Category: "Specialty"
   - Stock: "50"
3. Click "Add Product"
```

### Delete Product
```
1. Click "Delete" button
2. Confirm deletion
3. Product removed from inventory
```

---

## 📦 Orders Management

### View All Orders
- Go to **Orders** page
- See all customer orders with:
  - Order code (e.g., "ORD-001")
  - Customer name and email
  - Total price
  - Current status
  - Date ordered

### Change Order Status
```
1. Find order in table
2. Click status dropdown
3. Select new status:
   • pending    - New order, not yet processed
   • confirmed  - Customer confirmed order
   • processing - Currently being prepared
   • shipped    - Order sent to customer
   • delivered  - Arrived at customer
   • cancelled  - Order was cancelled
4. Click "Update" button
5. Status changes immediately
```

**Order Status Flow Example:**
```
Customer places order
        ↓
pending (new order)
        ↓
confirmed (you confirm it)
        ↓
processing (preparing cookies)
        ↓
shipped (sent out)
        ↓
delivered (customer received)
```

### View Order Details
```
1. Click "View" button on any order
2. See modal with:
   - Full order code
   - Customer info
   - Total price
   - Shipping address
   - Special notes
```

---

## 👥 Users Management

### View All Users
- Go to **Users** page
- See all registered users (customers and admins)
- See user role: `Customer` or `Admin`
- See phone and join date

### Edit User Info
```
1. Click "Edit" button on any user
2. Update:
   - Full name
   - Phone number
   - Address
   - City
   - Postal code
3. Click "Update User"
```

### Delete User
```
1. Click "Delete" button
2. Confirm deletion
3. User account and all orders removed
```

---

## 💡 Common Tasks

### Task: Check How Many Pending Orders?
1. Open **Dashboard**
2. Look at "⏳ Pending Orders" card
3. Number shows immediately

### Task: Update Product Stock from 50 to 30
1. Go to **Products**
2. Find "Classic Chocolate Chip"
3. Change stock value from 50 to 30
4. Click "Update"
5. ✅ Done! Stock saved in database

### Task: Mark Order as Shipped
1. Go to **Orders**
2. Find customer order
3. Dropdown: select `shipped`
4. Click "Update"
5. ✅ Status changed to shipped

### Task: Add New Cookie Product
1. Products → "+ Add New Product"
2. Fill in:
   - Name: "Strawberry Dream Cookie"
   - Description: "Fresh strawberry with white chocolate"
   - Price: "26000"
   - Category: "Fruit"
   - Stock: "40"
3. Click "Add Product"
4. ✅ Product appears in products list

### Task: Remove Out of Stock Product
1. Products → Find "Sugar Rush"
2. Stock is 0
3. Click "Delete"
4. ✅ Product removed

---

## 🔧 Admin Panel Settings

### Order Status Options
```
pending    → Yellow badge (needs action)
confirmed  → Blue badge (confirmed by customer)
processing → Purple badge (being prepared)
shipped    → Cyan badge (on the way)
delivered  → Green badge (completed)
cancelled  → Red badge (cancelled)
```

### User Roles
```
admin    → Can access admin panel
customer → Regular customer (cannot access admin)
```

### Product Categories
```
Classic      → Basic cookies
Premium      → High-quality cookies
Fruit        → Fruit-flavored cookies
Specialty    → Special/exotic flavors
```

---

## 📋 Database Tables Updated

### Users Table (NEW role field)
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(15),
    address TEXT,
    city VARCHAR(50),
    postal_code VARCHAR(10),
    role VARCHAR(20) DEFAULT 'customer',  ← NEW FIELD
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Products Table
```sql
- id, name, description, price, category, stock
- Created products can be managed in admin panel
```

### Orders Table
```sql
- id, order_code, total_price, status, shipping_address, notes
- Status can be changed in admin panel
```

---

## 🔒 Security Features

✅ Admin-only access (login required)
✅ Password hashing (bcrypt)
✅ Session management
✅ SQL injection protection (real_escape_string)
✅ Cannot delete yourself
✅ Admin role verification

---

## 🐛 Troubleshooting

### "404 Page Not Found" Error
**Solution:**
- Make sure files are in: `D:\xampp\htdocs\cookieXpress\admin\`
- Restart Apache in XAMPP
- Clear browser cache

### "Can't Login"
**Solution:**
- Check admin account exists in `users` table
- Verify `role = 'admin'`
- Check email is correct
- Make sure password is hashed (starts with `$2y$`)

### Orders Not Showing
**Solution:**
- Make sure orders exist in database
- Check MySQL is running
- Verify `cookiexpress.com` database exists

### Stock Not Updating
**Solution:**
- Click "Update" button (not just change value)
- Check MySQL connection
- Verify `products` table exists

---

## 📞 Quick Reference

| Page | URL | Function |
|------|-----|----------|
| Admin Login | `/admin/login.php` | Login to admin panel |
| Dashboard | `/admin/dashboard.php` | View stats & recent orders |
| Products | `/admin/products.php` | Manage products & stock |
| Orders | `/admin/orders.php` | Manage order status |
| Users | `/admin/users.php` | Manage customer accounts |

---

## ✨ Next Steps

1. ✅ Create admin account in database
2. ✅ Login to admin panel
3. ✅ Update product stock as needed
4. ✅ Monitor and update order status
5. ✅ Manage customer accounts

---

**Your Admin Panel is Ready! 🍪**

For detailed admin documentation, see: `/admin/README.md`
