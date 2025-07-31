-- SQL commands to insert sample data into the CRM System tables
-- Note: The password hashes are placeholders. In a real application,
-- these would be generated using password_hash().

--
-- Sample data for table `users`
--
INSERT INTO users (username, email, password_hash) VALUES
('johndoe', 'john.doe@example.com', '$2y$10$Y9gX3C.D.hJ/v9iV.gA5d.wT2iPzQxU2oR/O6E.LzG/K8B.c7uC.G'), -- password: password123
('janesmith', 'jane.smith@example.com', '$2y$10$Z.aN9b.C.dE/f0gH.iJ/kL.mN1oP2qR3sT4uV5wX6yZ7aB8c9d0E'); -- password: password456

--
-- Sample data for table `companies`
--
INSERT INTO companies (user_id, name, industry, location, notes) VALUES
(1, 'Innovate Inc.', 'Technology', 'San Francisco, CA', 'Leading provider of innovative tech solutions.'),
(1, 'Global Exports', 'Logistics', 'New York, NY', 'Specializes in international shipping and supply chain management.'),
(2, 'Creative Solutions', 'Marketing', 'Chicago, IL', 'A full-service digital marketing agency.'),
(2, 'HealthFirst Clinic', 'Healthcare', 'Boston, MA', 'A primary care clinic with a focus on patient wellness.');

--
-- Sample data for table `contacts`
--
INSERT INTO contacts (user_id,company_id, full_name, email, phone) VALUES
-- John Doe's Contacts
(1, 1, 'Alice Johnson', 'alice.j@innovate.com', '111-222-3333'),
(1, 1, 'Bob Williams', 'bob.w@innovate.com', '111-222-4444'),
(1, 2, 'Charlie Brown', 'charlie.b@globalexports.com', '555-666-7777'),
-- Jane Smith's Contacts
(2, 3, 'Diana Prince', 'diana.p@creativesolutions.com', '888-999-0000'),
(2, 4, 'Eve Adams', 'eve.a@healthfirst.com', '444-555-6666'),
(2, 4, 'Frank Miller', 'frank.m@healthfirst.com', '444-555-7777');

--
-- Sample data for table `deals`
--
INSERT INTO deals (user_id, contact_id,company_id, title, value, stage) VALUES
-- John Doe's Deals
(1, 1, 1, 'New Website Development', 15000.00, 'Negotiation'),
(1, 3, 2, 'International Shipping Contract', 75000.00, 'Won'),
-- Jane Smith's Deals
(2, 4, 3, 'Q4 Marketing Campaign', 25000.00, 'Lead'),
(2, 5, 4, 'Medical Equipment Supply', 120000.00, 'Lost');

-- Note: The IDs for companies, contacts, and deals will be auto-incremented.
-- The INSERT statements above assume a fresh database WHERE user_id 1 is 'johndoe'
-- and thecompany_ids and contact_ids are created in the order they are inserted.