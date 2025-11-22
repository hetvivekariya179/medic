CREATE DATABASE medicare;
USE medicare;

-- Users Table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(255)
);

-- Appointments
CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  doctor VARCHAR(100),
  date DATE,
  time TIME,
  symptoms TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Medicines
CREATE TABLE medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  description TEXT,
  price DECIMAL(10,2),
  stock INT,
  image VARCHAR(255)
);

-- Orders
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  medicine_id INT,
  quantity INT,
  total DECIMAL(10,2),
  address TEXT,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
