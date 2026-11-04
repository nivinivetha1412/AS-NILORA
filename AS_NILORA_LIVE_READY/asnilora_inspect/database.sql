CREATE DATABASE IF NOT EXISTS as_nilora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE as_nilora;

CREATE TABLE IF NOT EXISTS admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 slug VARCHAR(140) NOT NULL UNIQUE,
 description TEXT NULL,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 category_id INT NOT NULL,
 name VARCHAR(180) NOT NULL,
 slug VARCHAR(200) NOT NULL,
 description TEXT NULL,
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 stock INT NOT NULL DEFAULT 0,
 image VARCHAR(255) NULL,
 is_featured TINYINT(1) NOT NULL DEFAULT 0,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_product_category FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_number VARCHAR(40) NOT NULL UNIQUE,
 customer_name VARCHAR(150) NOT NULL,
 phone VARCHAR(30) NOT NULL,
 email VARCHAR(190) NULL,
 address TEXT NOT NULL,
 notes TEXT NULL,
 payment_method VARCHAR(30) NOT NULL DEFAULT 'COD',
 payment_status VARCHAR(30) NOT NULL DEFAULT 'Pending',
 order_status VARCHAR(30) NOT NULL DEFAULT 'New',
 total DECIMAL(10,2) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 product_id INT NULL,
 product_name VARCHAR(180) NOT NULL,
 unit_price DECIMAL(10,2) NOT NULL,
 quantity INT NOT NULL,
 CONSTRAINT fk_item_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT IGNORE INTO categories (name,slug,description) VALUES
('Bracelets','bracelets','Find your everyday and statement bracelets.'),
('Catch Clips','catch-clips','Pretty clips to complete your look.'),
('Function Wear Ornaments','function-wear','Special pieces for celebrations and occasions.'),
('Regular Wear Chains','regular-chains','Simple chains for everyday elegance.'),
('Studs','studs','Beautiful little details for every day.'),
('New Arrivals','new-arrivals','Discover the latest additions.');
