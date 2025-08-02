CREATE DATABASE crm_system;
USE crm_system;

CREATE TABLE users (
   user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    company_name VARCHAR(255) DEFAULT null,
    pwd VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, pwd) 
VALUES('johndoe', 'john.doe@example.com', 
'$2y$10$Y9gX3C.D.hJ/v9iV.gA5d.wT2iPzQxU2oR/O6E.LzG/K8B.c7uC.G'), -- password: password123
('janesmith', 'jane.smith@example.com', 
'$2y$10$Z.aN9b.C.dE/f0gH.iJ/kL.mN1oP2qR3sT4uV5wX6yZ7aB8c9d0E');  -- password: password456

DESCRIBE users;
SELECT * FROM users;
 
DROP TABLE users;

CREATE TABLE companies (
   company_id INT AUTO_INCREMENT PRIMARY KEY,
   user_id INT NOT NULL,
    company_domain VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    owner VARCHAR(255),
    industry VARCHAR(255),
    country VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    employees INT,
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO companies (
   user_id, company_domain, name, owner, industry,
    country, state, postal_code, employees, notes
) VALUES
(1, 'innovatek.com', 'Innovatek Solutions', 'Nikita Sharma', 'Computer Software', 'India', 'Maharashtra', '400001', 250, 'Focused on AI & ML-based enterprise tools.'),
(1, 'greenmed.org', 'GreenMed Healthcare', 'Amitabh Rao', 'Healthcare', 'India', 'Delhi', '110001', 120, 'Specialized in green biotech medical innovations.'),
(1, 'learnix.in', 'Learnix Academy', 'Priya Mehta', 'Education', 'India', 'Karnataka', '560002', 80, 'E-learning platform for coding and design.'),
(1, 'craftpulse.net', 'CraftPulse', 'Rahul Dev', 'Arts and Crafts', 'India', 'Rajasthan', '302001', 60, 'Local artisans platform for handmade exports.'),
(1, 'finbox.io', 'FinBox Ltd.', 'Isha Kapoor', 'Finance', 'India', 'Mumbai', '400703', 300, 'Startup for credit risk & financial analytics.');

INSERT INTO companies (logo) VALUE ('company-default.png');

DESCRIBE companies;
SELECT * FROM companies;
ALTER TABLE companies DROP COLUMN logo;
ALTER TABLE companies ADD COLUMN phone VARCHAR(20) AFTER company_domain;
ALTER TABLE companies ADD COLUMN logo varchar(255) AFTER phone;
UPDATE companies SET company_id = 1 WHERE user_id=1;

UPDATE companies SET user_id = 1 WHERE company_id=3;
DROP TABLE companies;



DROP TABLE IF EXISTS company_contacts;

CREATE TABLE company_contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    contact_id INT NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES contacts(contact_id) ON DELETE CASCADE,
    UNIQUE KEY unique_link (company_id, contact_id)
);

SELECT * FROM company_contacts;
DROP TABLE company_contacts;
TRUNCATE TABLE company_contacts;

INSERT INTO company_contacts (user_id, company_id, contact_id)
VALUES
    (1, 11, 1),
    (1, 11, 2),
    (1, 11, 3);


-- contacts table --
CREATE TABLE contacts (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
   company_id INT NOT NULL,
   user_id INT NOT NULL,
    email VARCHAR(255),
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    contact_owner VARCHAR(100),
    phone VARCHAR(20),
    lifecycle_stage VARCHAR(100),
    lead_status VARCHAR(100),
    logo varchar(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


INSERT INTO contacts (
   company_id,user_id, email, first_name, last_name, contact_owner,
    phone, lifecycle_stage, lead_status, logo
) VALUES
(11, 1, 'jane.doe@example.com', 'Jane', 'Doe', 'Arun Thakur', '9876543210', 'Lead', 'New', 'jane_doe.jpg'),

(11, 1, 'john.smith@example.com', 'John', 'Smith', 'Arun Thakur', '7890123456', 'Customer', 'Contacted', 'john_smith.png'),

(11, 1, 'alex.jones@example.com', 'Alex', 'Jones', 'Arun Thakur', '9812345678', 'Opportunity', 'Qualified', 'alex_jones.png'),

(11, 1, 'priya.rai@example.com', 'Priya', 'Rai', 'Arun Thakur', '9123456780', 'Lead', 'Open Deal', 'priya_rai.jpg');


SELECT * FROM contacts;
UPDATE contacts SET user_id=1 WHERE  contact_id=4;
DROP TABLE contacts;
DROP TABLE IF EXISTS contacts;
ALTER TABLE contacts DISCARD TABLESPACE;
DELETE FROM contacts WHERE contact_id = 2;
SHOW COLUMNS FROM contacts;


CREATE TABLE deals (
    deal_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    deal_stage ENUM('Visitor Engaged', 'Lead Captured', 'Demo Delivered', 'In Negotiation', 'Deal Won', 'Deal Lost') NOT NULL,
    amount DECIMAL(10,2),
    close_date DATE,
    contact_owner VARCHAR(255),
    deal_type ENUM('New', 'Existing'),
    priority TINYINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS deals;
SELECT * from deals;
ALTER TABLE deals CHANGE contact_owner deal_owner VARCHAR(255);

CREATE TABLE contact_deals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    deal_id INT NOT NULL,
    contact_id INT NOT NULL,
    FOREIGN KEY (deal_id) REFERENCES deals(deal_id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES contacts(contact_id) ON DELETE CASCADE,
    UNIQUE (deal_id, contact_id)
);

SELECT * FROM contact_deals;

CREATE TABLE company_deals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    deal_id INT NOT NULL,
    company_id INT NOT NULL,
    FOREIGN KEY (deal_id) REFERENCES deals(deal_id) ON DELETE CASCADE,
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE,
    UNIQUE (deal_id, company_id)
);

SELECT * FROM company_deals;

UPDATE deals SET user_id = 1 WHERE  deal_id=3;
SELECT * FROM deals;
DROP TABLE deals;


