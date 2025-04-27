🍰 Sweet Bites Bakery
Welcome to Sweet Bites Bakery, a simple PHP + MySQL project built using XAMPP, Bootstrap, and vanilla PHP sessions for cart management and user authentication.

This project simulates an online bakery shop where users can:

Register and log in

Browse products

Add products to a shopping cart

View and manage their cart

Checkout (functionality can be extended)

🚀 Features
User registration and login (with password hashing)

Secure session management

Responsive design with Bootstrap

Dynamic cart with item counting

Product listing from database

Simple and clean UI with food-themed backgrounds

🛠️ Technologies Used
PHP

MySQL (via phpMyAdmin in XAMPP)

HTML5 & CSS3

Bootstrap 5

Bootstrap Icons

FontAwesome (optional if extended)

Unsplash Images (for background)

📸 Screenshots

Page	Description
Home	Product listing with "Add to Cart" buttons
Login	Simple login form with a cake background
Cart	View products added to cart
Register	User sign-up form
🛠️ Setup Instructions
Install XAMPP
Download and install XAMPP.

Clone the Repository

bash
Copy
Edit
git clone https://github.com/your-username/sweet-bites-bakery.git
Move Project to XAMPP Directory
Move the project folder to:

makefile
Copy
Edit
C:\xampp\htdocs\
Create the Database

Open phpMyAdmin via http://localhost/phpmyadmin/

Create a database (e.g., bakery)

Import the bakery.sql file if available (or manually create a products and users table).

Edit Database Connection (if needed)
In db.php, ensure the connection matches your local XAMPP setup:

php
Copy
Edit
$conn = new mysqli('localhost', 'root', '', 'bakery');
Run the Project
Go to your browser:

arduino
Copy
Edit
http://localhost/sweet-bites-bakery/login.php
📂 Project Structure
bash
Copy
Edit
sweet-bites-bakery/
├── db.php
├── index.php
├── login.php
├── register.php
├── logout.php
├── cart.php
├── README.md
└── (optional) bakery.sql
✨ To-Do / Future Improvements
Add checkout and payment gateway integration (like MPesa, PayPal)

Allow admin to manage products via an admin panel

Email notifications for orders

Improve form validations

Add quantity management inside the cart

📜 License
This project is open source and free to use for educational purposes.

🙏 Acknowledgments
Unsplash for free cake images

Bootstrap for easy styling

FontAwesome and Bootstrap Icons for icons

Made with ❤️ by [Your Name]

