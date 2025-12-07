-- CookieXpress Database Schema
-- This SQL creates all necessary tables for the CookieXpress website

CREATE DATABASE IF NOT EXISTS `cookiexpress.com`;
USE `cookiexpress.com`;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(15),
    address TEXT,
    city VARCHAR(50),
    postal_code VARCHAR(10),
    profile_image VARCHAR(255),
    role VARCHAR(20) DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    category VARCHAR(50),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Cart items table
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_code VARCHAR(20) NOT NULL UNIQUE,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    shipping_method VARCHAR(50),
    shipping_address TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order items table (items in each order)
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY(product_id) REFERENCES products(id)
);

-- Sample Products Data
INSERT INTO products (name, description, price, category, stock) VALUES
('Classic Chocolate Chip', 'Rich chocolate chip cookies with premium dark chocolate', 25000, 'Classic', 50),
('Double Chocolate Delight', 'Double layered chocolate cookies for chocolate lovers', 28000, 'Premium', 40),
('Vanilla Dream', 'Soft vanilla cookies with a buttery taste', 22000, 'Classic', 45),
('Strawberry Bliss', 'Fresh strawberry flavored cookies', 26000, 'Fruit', 35),
('Peanut Butter Power', 'Creamy peanut butter cookies with chunks', 24000, 'Premium', 30),
('Almond Delight', 'Crunchy almond cookies with white chocolate', 27000, 'Premium', 25),
('Sugar Rush', 'Colorful sugar cookies perfect for celebrations', 20000, 'Classic', 60),
('Matcha Green Tea', 'Exotic matcha green tea cookies', 29000, 'Specialty', 20);
