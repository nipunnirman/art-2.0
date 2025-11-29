-- Database Schema for Through My Pencil Art Business
-- MySQL Database

-- Create Database
CREATE DATABASE IF NOT EXISTS through_my_pencil;
USE through_my_pencil;

-- Users Table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL,
    address TEXT,
    city VARCHAR(50),
    country VARCHAR(50),
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    INDEX idx_email (email)
);

-- Categories Table
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table (Gallery Items)
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    size VARCHAR(20),
    category_id INT,
    image_url VARCHAR(255),
    stock_quantity INT DEFAULT 0,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id),
    INDEX idx_category (category_id),
    INDEX idx_price (price)
);

-- Gift Boxes Table
CREATE TABLE gift_boxes (
    gift_box_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    includes TEXT, -- JSON format for included items
    image_url VARCHAR(255),
    is_popular BOOLEAN DEFAULT FALSE,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Custom Orders Table
CREATE TABLE custom_orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    size VARCHAR(20) NOT NULL,
    characters INT NOT NULL,
    frame_option VARCHAR(20),
    frame_color VARCHAR(20),
    delivery_option VARCHAR(50),
    total_price DECIMAL(10, 2) NOT NULL,
    reference_images TEXT, -- JSON array of image URLs
    special_instructions TEXT,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'partial', 'completed', 'refunded') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status)
);

-- Shopping Cart Table
CREATE TABLE cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(100), -- For guest users
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    INDEX idx_user (user_id),
    INDEX idx_session (session_id)
);

-- Cart Items Table
CREATE TABLE cart_items (
    cart_item_id INT PRIMARY KEY AUTO_INCREMENT,
    cart_id INT NOT NULL,
    product_id INT,
    gift_box_id INT,
    quantity INT DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (gift_box_id) REFERENCES gift_boxes(gift_box_id),
    INDEX idx_cart (cart_id)
);

-- Orders Table
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_address TEXT NOT NULL,
    shipping_city VARCHAR(50),
    shipping_country VARCHAR(50),
    shipping_postal_code VARCHAR(20),
    delivery_option VARCHAR(50),
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    tracking_number VARCHAR(100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    INDEX idx_user (user_id),
    INDEX idx_order_number (order_number),
    INDEX idx_status (order_status)
);

-- Order Items Table
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT,
    gift_box_id INT,
    custom_order_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (gift_box_id) REFERENCES gift_boxes(gift_box_id),
    FOREIGN KEY (custom_order_id) REFERENCES custom_orders(order_id),
    INDEX idx_order (order_id)
);

-- Reviews Table
CREATE TABLE reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT,
    order_id INT,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    reviewer_name VARCHAR(100),
    reviewer_country VARCHAR(50),
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    INDEX idx_product (product_id),
    INDEX idx_rating (rating)
);

-- Contact Messages Table
CREATE TABLE contact_messages (
    message_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_is_read (is_read)
);

-- Newsletter Subscribers Table
CREATE TABLE newsletter_subscribers (
    subscriber_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL,
    INDEX idx_email (email)
);

-- Insert Sample Categories
INSERT INTO categories (category_name, description) VALUES
('Family Portraits', 'Beautiful family portraits capturing precious moments'),
('Pet Portraits', 'Custom pet portraits of your beloved companions'),
('Individual Portraits', 'Single person portraits with stunning detail'),
('Couple Portraits', 'Romantic couple portraits'),
('Memorial Portraits', 'Cherished memorial portraits'),
('Business Portraits', 'Professional headshots and business portraits');

-- Insert Sample Products (Gallery Items)
INSERT INTO products (title, description, price, size, category_id, image_url, stock_quantity, is_available) VALUES
('Family Portrait', 'Beautiful family portrait with 4 people', 150.00, 'A4', 1, 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800', 10, TRUE),
('Pet Portrait', 'Adorable dog portrait', 100.00, 'A4', 2, 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=800', 15, TRUE),
('Couple Portrait', 'Romantic couple portrait', 120.00, 'A3', 4, 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800', 12, TRUE),
('Solo Portrait', 'Individual portrait', 80.00, 'A4', 3, 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=800', 20, TRUE),
('Baby Portrait', 'Sweet baby portrait', 90.00, 'A4', 1, 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=800', 10, TRUE);

-- Insert Sample Gift Boxes
INSERT INTO gift_boxes (name, description, price, includes, image_url, is_popular, is_available) VALUES
('Watch Gift Box', 'Premium portrait with elegant watch', 199.00, '["A4 Portrait with Frame", "Premium Watch", "Gift Card", "Luxury Gift Box", "Free Shipping"]', 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=800', TRUE, TRUE),
('Chocolate Delight Box', 'Sweet memories with gourmet chocolates', 129.00, '["A4 Portrait with Frame", "Gourmet Chocolates (500g)", "Gift Card", "Beautiful Gift Box", "Free Shipping"]', 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=800', FALSE, TRUE),
('Mug & Portrait Box', 'Daily reminder with custom mug', 119.00, '["A4 Portrait with Frame", "Custom Photo Mug", "Gift Card", "Gift Box", "Free Shipping"]', 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=800', FALSE, TRUE);

-- Insert Sample Reviews
INSERT INTO reviews (user_id, product_id, rating, review_text, reviewer_name, reviewer_country, is_approved) VALUES
(1, 1, 5, 'Absolutely stunning work! The portrait of my grandmother brought tears to my eyes. Every detail was perfect!', 'Sarah Johnson', 'United States', TRUE),
(1, 2, 5, 'The gift box with the portrait was the best birthday present! Professional service and beautiful packaging.', 'Rajesh Kumar', 'India', TRUE),
(1, 3, 5, 'Amazing talent! The portrait captured my dog''s personality perfectly. Highly recommend to everyone!', 'Emma Williams', 'United Kingdom', TRUE);

-- Create Views for Common Queries

-- View: Available Products
CREATE VIEW available_products AS
SELECT p.*, c.category_name
FROM products p
LEFT JOIN categories c ON p.category_id = c.category_id
WHERE p.is_available = TRUE;

-- View: Order Summary
CREATE VIEW order_summary AS
SELECT 
    o.order_id,
    o.order_number,
    u.full_name,
    u.email,
    o.total_amount,
    o.order_status,
    o.payment_status,
    o.created_at
FROM orders o
JOIN users u ON o.user_id = u.user_id;

-- View: Customer Order History
CREATE VIEW customer_order_history AS
SELECT 
    u.user_id,
    u.full_name,
    u.email,
    COUNT(o.order_id) as total_orders,
    SUM(o.total_amount) as total_spent,
    MAX(o.created_at) as last_order_date
FROM users u
LEFT JOIN orders o ON u.user_id = o.user_id
GROUP BY u.user_id, u.full_name, u.email;

-- Stored Procedures

-- Procedure: Add Item to Cart
DELIMITER //
CREATE PROCEDURE add_to_cart(
    IN p_user_id INT,
    IN p_session_id VARCHAR(100),
    IN p_product_id INT,
    IN p_gift_box_id INT,
    IN p_quantity INT,
    IN p_price DECIMAL(10,2)
)
BEGIN
    DECLARE v_cart_id INT;
    
    -- Get or create cart
    SELECT cart_id INTO v_cart_id 
    FROM cart 
    WHERE (user_id = p_user_id OR session_id = p_session_id)
    ORDER BY created_at DESC 
    LIMIT 1;
    
    IF v_cart_id IS NULL THEN
        INSERT INTO cart (user_id, session_id) VALUES (p_user_id, p_session_id);
        SET v_cart_id = LAST_INSERT_ID();
    END IF;
    
    -- Add item to cart
    INSERT INTO cart_items (cart_id, product_id, gift_box_id, quantity, price)
    VALUES (v_cart_id, p_product_id, p_gift_box_id, p_quantity, p_price);
END //
DELIMITER ;

-- Procedure: Create Order from Cart
DELIMITER //
CREATE PROCEDURE create_order_from_cart(
    IN p_user_id INT,
    IN p_shipping_address TEXT,
    IN p_shipping_city VARCHAR(50),
    IN p_shipping_country VARCHAR(50),
    IN p_delivery_option VARCHAR(50),
    OUT p_order_id INT
)
BEGIN
    DECLARE v_cart_id INT;
    DECLARE v_total DECIMAL(10,2);
    DECLARE v_order_number VARCHAR(50);
    
    -- Get user's cart
    SELECT cart_id INTO v_cart_id 
    FROM cart 
    WHERE user_id = p_user_id 
    ORDER BY created_at DESC 
    LIMIT 1;
    
    -- Calculate total
    SELECT SUM(price * quantity) INTO v_total
    FROM cart_items
    WHERE cart_id = v_cart_id;
    
    -- Generate order number
    SET v_order_number = CONCAT('TMP', YEAR(NOW()), LPAD(FLOOR(RAND() * 999999), 6, '0'));
    
    -- Create order
    INSERT INTO orders (
        user_id, 
        order_number, 
        total_amount, 
        shipping_address, 
        shipping_city, 
        shipping_country,
        delivery_option
    ) VALUES (
        p_user_id, 
        v_order_number, 
        v_total, 
        p_shipping_address, 
        p_shipping_city, 
        p_shipping_country,
        p_delivery_option
    );
    
    SET p_order_id = LAST_INSERT_ID();
    
    -- Copy cart items to order items
    INSERT INTO order_items (order_id, product_id, gift_box_id, quantity, unit_price, total_price)
    SELECT p_order_id, product_id, gift_box_id, quantity, price, price * quantity
    FROM cart_items
    WHERE cart_id = v_cart_id;
    
    -- Clear cart
    DELETE FROM cart_items WHERE cart_id = v_cart_id;
END //
DELIMITER ;

-- Sample Admin User (password: admin123 - hashed with bcrypt)
-- Note: In production, use proper password hashing
INSERT INTO users (full_name, email, phone, password_hash, is_active) VALUES
('Admin User', 'admin@throughmypencil.com', '+1234567890', '$2a$10$rKZLqhqLJlHKLqzqLqzqLeVlYqKqKqKqKqKqKqKqKqKqKqKqKqKqK', TRUE);

-- Indexes for Performance
CREATE INDEX idx_product_availability ON products(is_available, created_at DESC);
CREATE INDEX idx_order_date ON orders(created_at DESC);
CREATE INDEX idx_cart_updated ON cart(updated_at DESC);