-- SQL commands to create the tables for the CRM System

--
-- Table structure for table `users`
--
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    company_name VARCHAR(255),
    pwd VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

--
-- Table structure for table `companies`
--
CREATE TABLE companies (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    industry VARCHAR(255),
    location VARCHAR(255),
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `contacts`
--
CREATE TABLE contacts (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (company_id) REFERENCES COMPANIES(company_id) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `deals`
--
CREATE TABLE deals (
    deal_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    contact_id INT NOT NULL,
    company_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    value DECIMAL(12, 2),
    stage ENUM('Lead', 'Negotiation', 'Won', 'Lost') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES CONTACTS(contact_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (company_id) REFERENCES COMPANIES(company_id) ON DELETE CASCADE ON UPDATE CASCADE
);