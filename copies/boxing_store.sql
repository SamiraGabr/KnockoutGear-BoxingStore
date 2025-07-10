-- Database creation
DROP DATABASE IF EXISTS knockout_gear;
CREATE DATABASE knockout_gear;
USE knockout_gear;

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    country VARCHAR(50),
    phone VARCHAR(20),
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product categories junction table
CREATE TABLE product_categories (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product variations
CREATE TABLE product_variations (
    variation_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    variation_type VARCHAR(50) NOT NULL,
    variation_value VARCHAR(50) NOT NULL,
    additional_price DECIMAL(10,2) DEFAULT 0.00,
    stock_quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cart table
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cart items table
CREATE TABLE cart_items (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    variation_id INT,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (variation_id) REFERENCES product_variations(variation_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(20) NOT NULL UNIQUE,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    billing_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    tracking_number VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items table
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    variation_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (variation_id) REFERENCES product_variations(variation_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reviews table
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Wishlist table
CREATE TABLE wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO users (username, email, password, first_name, last_name, is_admin) 
VALUES ('admin', 'admin@boxingstore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', TRUE);

INSERT INTO users (username, email, password, first_name, last_name, address, city, state, zip_code, country, phone)
VALUES ('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', '123 Main St', 'New York', 'NY', '10001', 'USA', '+1234567890');

INSERT INTO categories (name, description) VALUES 
('Gloves', 'Boxing gloves for training and competition'),
('Clothing', 'Training clothes and fight gear'),
('Protective', 'Protective gear for boxing'),
('Accessories', 'Boxing accessories and equipment'),
('Bags', 'Punching bags and training equipment'),
('Footwear', 'Boxing shoes and training footwear');

INSERT INTO products (name, description, price, stock_quantity, image_path, is_featured) VALUES
('Pro Boxing Gloves', 'Professional quality boxing gloves with premium leather construction', 89.99, 50, 'images/products/gloves/pro_boxing_gloves.jpg', TRUE),
('Training Gloves', 'Durable training gloves with multi-layer foam padding', 49.99, 100, 'images/products/gloves/training_gloves.jpg', FALSE),
('Boxing Shorts', 'Breathable polyester boxing shorts with elastic waistband', 29.99, 75, 'images/products/clothing/boxing_shorts.jpg', TRUE),
('Mouthguard', 'Custom-fit mouthguard for maximum protection', 14.99, 200, 'images/products/protective/mouthguard.jpg', FALSE),
('Hand Wraps', '180-inch cotton hand wraps for wrist and knuckle support', 9.99, 150, 'images/products/accessories/hand_wraps.jpg', TRUE),
('Heavy Bag', '100lb filled heavy bag for boxing training', 129.99, 20, 'images/products/bags/heavy_bag.jpg', FALSE),
('Boxing Shoes', 'Lightweight boxing shoes with ankle support', 79.99, 30, 'images/products/footwear/boxing_shoes.jpg', TRUE),
('Headgear', 'Protective headgear with face bar option', 59.99, 40, 'images/products/protective/headgear.jpg', FALSE),
('Jump Rope', 'Speed jump rope for boxing conditioning', 12.99, 80, 'images/products/accessories/jump_rope.jpg', TRUE),
('Training Hoodie', 'Moisture-wicking training hoodie with thumb holes', 39.99, 60, 'images/products/clothing/training_hoodie.jpg', FALSE);

INSERT INTO product_categories (product_id, category_id) VALUES
(1, 1), (2, 1), (3, 2), (4, 3), (5, 4), 
(6, 5), (7, 6), (8, 3), (9, 4), (10, 2);

INSERT INTO product_variations (product_id, variation_type, variation_value, additional_price, stock_quantity) VALUES
(1, 'Size', '10 oz', 0, 15),
(1, 'Size', '12 oz', 0, 20),
(1, 'Size', '14 oz', 0, 15),
(1, 'Size', '16 oz', 5.00, 10),
(1, 'Color', 'Red', 0, 25),
(1, 'Color', 'Black', 0, 25),
(2, 'Size', '12 oz', 0, 40),
(2, 'Size', '14 oz', 0, 35),
(2, 'Size', '16 oz', 0, 25),
(3, 'Size', 'S', 0, 15),
(3, 'Size', 'M', 0, 20),
(3, 'Size', 'L', 0, 20),
(3, 'Size', 'XL', 0, 10),
(3, 'Size', 'XXL', 0, 10),
(7, 'Size', '8', 0, 5),
(7, 'Size', '9', 0, 10),
(7, 'Size', '10', 0, 10),
(7, 'Size', '11', 0, 5),
(7, 'Color', 'White', 0, 15),
(7, 'Color', 'Black', 0, 15);

INSERT INTO reviews (user_id, product_id, rating, comment) VALUES
(2, 1, 5, 'Excellent gloves! Great wrist support and padding.'),
(2, 3, 4, 'Very comfortable shorts, good quality material.'),
(2, 5, 5, 'Perfect length and material for hand wraps.'),
(2, 7, 3, 'Good shoes but run a bit small. Order half size up.');

CREATE VIEW product_ratings AS
SELECT 
    p.product_id,
    p.name,
    COUNT(r.review_id) as review_count,
    IFNULL(AVG(r.rating), 0) as average_rating
FROM products p
LEFT JOIN reviews r ON p.product_id = r.product_id
GROUP BY p.product_id, p.name;

DELIMITER //
CREATE PROCEDURE place_order(
    IN p_user_id INT,
    IN p_shipping_address TEXT,
    IN p_billing_address TEXT,
    IN p_payment_method VARCHAR(50),
    OUT p_order_id INT
)
BEGIN
    DECLARE v_cart_id INT;
    DECLARE v_total DECIMAL(10,2);
    DECLARE v_order_number VARCHAR(20);
    
    SELECT cart_id INTO v_cart_id FROM cart WHERE user_id = p_user_id ORDER BY created_at DESC LIMIT 1;
    
    SELECT SUM(p.price * ci.quantity) INTO v_total
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.cart_id = v_cart_id;
    
    SET v_order_number = CONCAT('ORD-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', FLOOR(RAND() * 10000));
    
    INSERT INTO orders (user_id, order_number, total_amount, shipping_address, billing_address, payment_method)
    VALUES (p_user_id, v_order_number, v_total, p_shipping_address, p_billing_address, p_payment_method);
    
    SET p_order_id = LAST_INSERT_ID();
    
    INSERT INTO order_items (order_id, product_id, variation_id, quantity, price)
    SELECT p_order_id, ci.product_id, ci.variation_id, ci.quantity, p.price
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.cart_id = v_cart_id;
    
    DELETE FROM cart_items WHERE cart_id = v_cart_id;
    DELETE FROM cart WHERE cart_id = v_cart_id;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_order_insert
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
    IF NEW.order_number IS NULL THEN
        SET NEW.order_number = CONCAT('ORD-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', FLOOR(RAND() * 10000));
    END IF;
END //
DELIMITER ;