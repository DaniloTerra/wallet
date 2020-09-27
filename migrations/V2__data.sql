INSERT INTO wallet.`user`
(name, document, email, password)
VALUES
('Rizil', '62012155065', 'rizil@email.com', 'd2a8c574572f972690b07e588be31ecbd4771c0bd60525d2ec2de7e3cf0b1f18'),
('Voauskus', '37517650009', 'voauskus@email.com', '14ad7afee4adfc19ca6cef8cb0edb1a3bbf9ee15d9f4b483cfae35e2030eed96'),
('Laiva', '04152987090', 'laiva@email.com', '786bbe797ec7cae90e091730236b3a56e9d4a6bc72d605cc27b16bd8b68186f9'),
('Eshen', '97280476066', 'eshen@email.com', 'e9495a3666ee16e82d8aec68bc535fb50f3e4272239e2051b6a6ee862ca29659'),
('Tevau', '05790684041', 'tevau@email.com', '2bf5406dc4c284cf7e20f726b01e9d15c80f26746467026a1dcc786b09ba5f38'),
('Vodon', '05494987000161', 'vodon@email.com', 'b19b84db8ee06610b46e891302f19f06256d77ab3d00130804d1b85176083497'),
('Teher', '91649796000163', 'teher@email.com', 'bb4a3cfdf8d1967422e9fc33413e78328ebd4341993d50ebb3b9b86de9992904'),
('Floki', '72184487000110', 'floki@email.com', 'c0ba143766e7061255be057a22c85c1e2284b45c373cfac704755aed861f2f8f'),
('Touxe', '00901670000189', 'touxe@email.com', '76f8a9e798fd18789d78a8db0a75abb889b4eed6fa10453e659beae042a84b11'),
('Sonay', '42198289000145', 'sonay@email.com', '44124700adfee0ed1bc20f9fba2759b95651ec51074590c5e92af82c6ccf5344');

INSERT INTO wallet.`user_wallet`
(user_id, debit, credit)
VALUES
(1, 0.00, 1000.00),
(2, 0.00, 1000.00),
(3, 0.00, 1000.00),
(4, 0.00, 1000.00),
(5, 0.00, 1000.00),
(6, 0.00, 1000.00),
(7, 0.00, 1000.00),
(8, 0.00, 1000.00),
(9, 0.00, 1000.00),
(10, 0.00, 1000.00);
