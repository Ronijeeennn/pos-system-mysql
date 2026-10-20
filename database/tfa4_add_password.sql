-- TFA4: add authentication support to the users table.
--
-- Run this on a database that already has the TFA3 tables (local or hosted):
--   1. Select your database (pos_system locally, your if0_... database on the host).
--   2. Open the SQL tab (or the Import tab) and run this file.
-- Running it twice gives a harmless "Duplicate column name" error on the first statement.
--
-- What it does:
--   1. Adds a `password` column that will hold a password_hash() value (never plain text).
--   2. Gives every existing user a hashed password. The hashes below were produced by PHP's
--      password_hash($password, PASSWORD_DEFAULT) and each one has its own random salt.
--      All sample users start with the password:  Welcome123!
--      (Change it after you log in: Edit a user and fill in "New password".)
--   3. Gives any other user that already exists (for example one you added in TFA3) the same
--      starting password, then makes the column NOT NULL so no account can exist without a hash.
--
-- The same result can be produced from code with:  php spark db:seed UserPasswordSeeder

ALTER TABLE users
  ADD COLUMN password VARCHAR(255) NULL AFTER username;

UPDATE users SET password = '$2y$10$EAdJfRzb5qaKQsKLOeqZv..ZHXQzBUUtlAwZ.RVGrEojfRUSjDr8S' WHERE username = 'admin01';
UPDATE users SET password = '$2y$10$TsS3HeZU3GVeZbZRScV/J.btII83x6uHPx7JFvnVWbkYDUrCy7ByG' WHERE username = 'cashier01';
UPDATE users SET password = '$2y$10$1zj5vFLdVgqA6i13Cg1vWewOWCe5Oaa6r7CMfXw1caLTWLUBPorKC' WHERE username = 'cashier02';
UPDATE users SET password = '$2y$10$cGoR8bfe6BfNujdimxvm0OJaikjKtRf5xLWyvnDKDRqnxI2kSM1gu' WHERE username = 'stockclerk01';
UPDATE users SET password = '$2y$10$AIqnc/nGUO8TWOx2vJ9ilOwaZI1gFxw8EXx1uYc9G4ecuHe3lP7Xm' WHERE username = 'manager01';
UPDATE users SET password = '$2y$10$trCGfU9xT3yB40BFpADUQeWgTIK1twOu0F/W/2JnQxy1H8Jjt08OO' WHERE username = 'super01';

-- Any remaining user without a password (for example users created in TFA3):
UPDATE users SET password = '$2y$10$f1rgY0umU9hHFBXsHBglrODOy8pkSKuKc6Aw2Jerk.MznXEZ7keha' WHERE password IS NULL;

ALTER TABLE users
  MODIFY password VARCHAR(255) NOT NULL;
