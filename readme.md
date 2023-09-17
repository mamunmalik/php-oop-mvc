# PHP Form Submission

A Simple PHP form submission with frontend and backend validation.

## Setup:

All you need is to follow these steps:

1. Create a database name `phpform_db` or change `DB_NAME` in `app/config/config.php` and you can change your custom db settings.
2. Create a table with this command
   ```sql
   CREATE TABLE payments (
       id BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
       amount INT(10) NOT NULL,
       buyer VARCHAR(255) NOT NULL,
       receipt_id VARCHAR(20) NOT NULL,
       items VARCHAR(255) NOT NULL,
       buyer_email VARCHAR(50) NOT NULL,
       buyer_ip VARCHAR(20),
       note TEXT NOT NULL,
       city VARCHAR(20) NOT NULL,
       phone VARCHAR(20) NOT NULL,
       hash_key VARCHAR(255),
       entry_at DATE,
       entry_by INT(10) NOT NULL
   );
   ```
