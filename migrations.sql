-- Migration: add role column to users table and example roles
ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'patient';

-- Example: change a user to admin or doctor (run after inserting real user)
-- UPDATE users SET role='admin' WHERE email='admin@example.com';
-- UPDATE users SET role='doctor' WHERE email='doc@example.com';
