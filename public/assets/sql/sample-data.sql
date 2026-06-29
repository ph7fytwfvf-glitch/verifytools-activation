INSERT INTO licenses (license_key, email, status, max_activations, expires_at) VALUES
('DEMO-AAAA-BBBB-CCCC', 'demo@example.com', 'active', 3, DATE_ADD(NOW(), INTERVAL 90 DAY)),
('EXPIRED-1111-2222-3333', 'old@example.com', 'active', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
('SUSPENDED-0000-0000-0000', 'suspend@example.com', 'suspended', 1, NULL);
