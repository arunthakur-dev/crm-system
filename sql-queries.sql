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
DELETE from users where user_id=1;
DROP TABLE users;
UPDATE users SET user_id = 1 WHERE user_id=4;



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

UPDATE companies SET user_id = 1 WHERE company_id=3;
DROP TABLE companies;

CREATE TABLE contacts (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(50), -- linked company
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (company_id) REFERENCES COMPANIES(company_id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO contacts (user_id, company_id, full_name, email, phone) VALUES
-- John Doe's Contacts
(1, 1, 'Alice Johnson', 'alice.j@innovate.com', '111-222-3333'),
(1, 1, 'Bob Williams', 'bob.w@innovate.com', '111-222-4444'),
(1, 2, 'Charlie Brown', 'charlie.b@globalexports.com', '555-666-7777'),
-- Jane Smith's Contacts
(2, 3, 'Diana Prince', 'diana.p@creativesolutions.com', '888-999-0000'),
(2, 4, 'Eve Adams', 'eve.a@healthfirst.com', '444-555-6666'),
(2, 4, 'Frank Miller', 'frank.m@healthfirst.com', '444-555-7777');

SELECT * FROM contacts;
UPDATE contacts SET user_id = 1 WHERE contact_id=4;
DROP TABLE contacts;

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

INSERT INTO deals (user_id, contact_id, company_id, title, value, stage) VALUES
-- John Doe's Deals
(1, 1, 1, 'New Website Development', 15000.00, 'Negotiation'),
(1, 3, 2, 'International Shipping Contract', 75000.00, 'Won'),
-- Jane Smith's Deals
(2, 4, 3, 'Q4 Marketing Campaign', 25000.00, 'Lead'),
(2, 5, 4, 'Medical Equipment Supply', 120000.00, 'Lost');

UPDATE deals SET user_id = 1 WHERE deal_id=3;
SELECT * FROM deals;
DROP TABLE deals;


