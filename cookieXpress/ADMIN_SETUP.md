# CookieXpress Admin Panel - Setup Instructions

## Step 1: Create Admin Account in Database

### Using phpMyAdmin:
1. Open `http://localhost/phpmyadmin`
2. Select the **`cookiexpress.com`** database
3. Click on the **`users`** table
4. Click **"Insert"** button

### Using SQL (Easier Method):
1. Go to **SQL** tab in phpMyAdmin
2. Paste this query (change the password):

```sql
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@cookiexpress.com', '$2y$10$hashed_password_here', 'admin');
```

**To generate a hashed password:**
- Create a temporary PHP file with:
```php
<?php echo password_hash('mypassword123', PASSWORD_DEFAULT); ?>
```
- Replace `$2y$10$hashed_password_here` with the output

---

## Step 2: Access Admin Panel

1. **Login URL**: `http://localhost/cookieXpress/admin/login.php`
2. **Username**: `admin@cookiexpress.com` (the email from Step 1)
3. **Password**: The password you set in Step 1

---

## Step 3: Navigate Admin Dashboard

After login, you'll see the admin dashboard with:
- **Dashboard**: Overview with stats and recent orders
- **Products**: Manage product stock, edit, delete, add new
- **Orders**: Manage order status (pending, shipped, delivered, etc.)
- **Users**: View and edit customer information

---

## Key Features

### ✅ Change Product Stock
1. Go to **Products**
2. Find product → Enter new stock → Click **Update**

### ✅ Change Order Status
1. Go to **Orders**
2. Find order → Select status from dropdown → Click **Update**
3. Status options:
   - pending → confirmed → processing → shipped → delivered
   - Or cancelled at any point

### ✅ Add New Product
1. Click **+ Add New Product** button
2. Fill in: Name, Description, Price, Category, Stock
3. Click **Add Product**

### ✅ View Order Details
1. Click **View** button on any order
2. See customer info, address, and notes

---

## Quick Login (After Setup)

**URL**: `http://localhost/cookieXpress/admin/login.php`

**Default Admin Credentials**:
- Email: `admin@cookiexpress.com`
- Password: `mypassword123` (or what you set)

---

## Troubleshooting

**Can't login?**
- Verify admin account exists in users table with `role = 'admin'`
- Check password is hashed correctly
- Make sure database name is `cookiexpress.com`

**404 Page Not Found?**
- Make sure admin folder is at: `D:\xampp\htdocs\cookieXpress\admin`
- Restart XAMPP (Apache + MySQL)

**Orders not showing?**
- Make sure orders exist in database
- Check MySQL is running
- Try refreshing the page

---

## File Structure

```
/admin/
├── login.php              # Admin login page
├── dashboard.php          # Main admin dashboard
├── products.php           # Manage products & stock
├── orders.php             # Manage order status
├── users.php              # Manage users
├── add-product.php        # Add new product form
├── edit-product.php       # Edit existing product
├── edit-user.php          # Edit user info
├── logout.php             # Logout
├── admin.css              # Admin styling
└── README.md              # Detailed documentation
```

---

**Ready to start managing orders and products! 🍪**
