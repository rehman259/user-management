CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE locations (
  id INT PRIMARY KEY AUTO_INCREMENT,
  location_name VARCHAR(255) NOT NULL
);

CREATE TABLE transactions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  transaction_date DATE NOT NULL,
  location_id INT NOT NULL,
  amount DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (location_id) REFERENCES locations(id)
);

CREATE INDEX idx_transactions_date ON transactions(transaction_date);
