-- TFA3: add an avatar column to the users table.
-- Run this on a database that already has the TFA2 tables (local or hosted):
--   1. Select your database (pos_system locally, your if0_... database on the host).
--   2. Open the SQL tab (or Import tab) and run this file.
-- Running it twice gives a harmless "Duplicate column name" error.
--
-- The column stores ONLY the image file name (for example user_3_a1b2c3d4e5f6.jpg).
-- The image itself lives in public/uploads/avatars/. NULL means "no avatar uploaded".

ALTER TABLE users
  ADD COLUMN avatar VARCHAR(255) NULL AFTER full_name;
