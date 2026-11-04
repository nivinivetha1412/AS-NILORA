AS NILORA — PHP + MySQL jewellery store
========================================

PROJECT CONTENTS
- Responsive storefront, category browsing, product details and search
- Session-based shopping bag/cart
- Checkout with Cash on Delivery or WhatsApp order handoff
- Admin login and product/category/order management
- Product photo uploads

IMPORTANT: PHP DOES NOT RUN ON GITHUB PAGES
GitHub is suitable for storing this project code. GitHub Pages only hosts static
HTML/CSS/JavaScript and cannot execute PHP or connect this PHP app to MySQL.
To make the complete store work online, use a PHP + MySQL hosting provider.
Upload this project to that hosting account, then connect your GitHub repository
using the provider's deployment option if available, or upload the ZIP through
its file manager. GitHub alone will not make this PHP shop live.

REQUIREMENTS
- PHP 8.1+ with PDO MySQL enabled
- MySQL 5.7+ or MariaDB
- Apache hosting (recommended) with HTTPS

LOCAL TESTING (OPTIONAL)
1. Install a local PHP/MySQL stack such as XAMPP.
2. Put this folder inside htdocs.
3. Create a MySQL database named as_nilora and import database.sql.
4. For local XAMPP defaults, config.php uses database user root and blank password.
5. Set ASN_BASE_URL=/AS-NILORA if the folder is named AS-NILORA under htdocs.
6. Open http://localhost/AS-NILORA/ in your browser.
7. Visit /setup.php once to create the first admin account, then DELETE setup.php.

LIVE HOSTING DEPLOYMENT
1. Buy/choose PHP + MySQL hosting and add your domain/subdomain there.
2. Create a MySQL database and database user in the hosting control panel.
3. Import database.sql using phpMyAdmin. If the host does not allow CREATE DATABASE,
   create the database in the control panel first, then import the table statements
   after removing the first two CREATE DATABASE / USE lines from database.sql.
4. Upload the project files to the domain's document root (often public_html).
5. In the hosting control panel, set these environment variables if supported:
   ASN_DB_HOST, ASN_DB_NAME, ASN_DB_USER, ASN_DB_PASS
   ASN_BASE_URL should be empty for a domain-root install.
   ASN_WHATSAPP_NUMBER should be your WhatsApp number with country code and digits only.
   ASN_STORE_EMAIL should be your customer-support email.
6. If environment variables are not available, create config.local.php beside config.php
   with the following contents, replacing every example value. This file is excluded
   from Git by .gitignore and must NEVER be uploaded to a public GitHub repository.

   <?php
   // Do not share or commit this file.
   putenv('ASN_DB_HOST=localhost');
   putenv('ASN_DB_NAME=YOUR_HOST_DATABASE_NAME');
   putenv('ASN_DB_USER=YOUR_HOST_DATABASE_USER');
   putenv('ASN_DB_PASS=YOUR_HOST_DATABASE_PASSWORD');
   putenv('ASN_BASE_URL=');
   putenv('ASN_WHATSAPP_NUMBER=91XXXXXXXXXX');
   putenv('ASN_STORE_EMAIL=you@example.com');

7. Open https://YOUR-DOMAIN/setup.php and create a strong admin password (12+ chars).
8. Immediately DELETE setup.php from the hosting account.
9. Sign in at https://YOUR-DOMAIN/admin/login.php and add your real products/photos.
10. Confirm HTTPS works, test a small order, and set up database backups.

GITHUB UPLOAD
1. Create a new GitHub repository, e.g. AS-NILORA.
2. Upload the project files and folders (not the ZIP file if you want GitHub to show
   the source files). Keep config.local.php and .env out of the repository.
3. You can later deploy these same files to PHP hosting. GitHub Pages cannot run them.

STORE DETAILS TO UPDATE BEFORE LAUNCH
- Replace the placeholder WhatsApp number 919000000000 with your actual number.
- Replace hello@asnilora.in with your real support email if different.
- Add your logo as assets/images/logo.png (transparent PNG recommended).
- Add your actual product photos, descriptions, prices and stock in Admin.
- Review delivery charges, return policy, privacy policy and terms before accepting orders.

ORDER / PAYMENT NOTES
The checkout supports Cash on Delivery and WhatsApp order handoff. It does NOT
currently collect online card/UPI payments. A payment gateway requires a merchant
account, server-side integration and webhook verification. Never collect UPI PINs,
OTP codes or card details directly in this website.

SECURITY
- Use HTTPS and a unique strong admin password.
- Delete setup.php immediately after creating the first admin.
- Never publish config.local.php, database passwords, customer data or database backups.
- Back up the database and uploaded product images regularly.
