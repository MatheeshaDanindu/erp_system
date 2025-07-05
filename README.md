# C-Square ERP System

A simple ERP system built with PHP, MySQL, Bootstrap, and JavaScript for managing Customers, Items, and generating Reports.


## Assumptions

- The provided SQL file creates all necessary tables (`customer`, `item`, `category`, `subcategory`, `invoice`, `invoice_item`, etc.).
- The primary key for the `customer` table is `id`.
- The primary key for the `item` table is `id`.
- Districts, categories, and subcategories are either pre-populated or can be added manually in the database.
- No authentication/user login is implemented.
- The system is intended for demonstration and local use only.
- PHP version 7.4 or higher and MySQL 5.7 or higher are recommended.
- The project is designed to run on XAMPP or similar local server environments.


## Local Setup Instructions

### 1. Prerequisites

- [XAMPP](https://www.apachefriends.org/) or similar local server stack (includes Apache, PHP, MySQL)
- Web browser (Chrome, Firefox, Edge, etc.)

### 2. Clone or Download the Project

- Download the project ZIP or clone the repository:
  ```
  git clone https://github.com/MatheeshaDanindu/csquare_erp.git
  ```
- Place the project folder (`csquare_erp`) in your XAMPP `htdocs` directory:
  ```
  C:\xampp\htdocs\csquare_erp
  ```

### 3. Import the Database

- Start Apache and MySQL from the XAMPP Control Panel.
- Open [phpMyAdmin](http://localhost/phpmyadmin).
- Create a new database, e.g., `csquare_erp`.
- Click the database name, then go to the **Import** tab.
- Choose the provided `.sql` file and click **Go** to import.

### 4. Configure Database Connection

- Open `includes/db.php` and ensure the credentials match your local setup:
  ```php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "csquare_erp";
  ```

### 5. Access the Application

- In your browser, go to:  
  [http://localhost/csquare_erp/](http://localhost/csquare_erp/)

### 6. Using the System

- Use the navigation bar to manage Customers, Items, and view Reports.
- All forms include validation.
- Delete actions require confirmation.
- The footer and header are always fixed to the top and bottom of the display.

---

## Troubleshooting

- If you see database errors, check your database credentials and ensure the database is imported.
- If CSS or JS is not loading, check the paths in `header.php` and `footer.php`.
- For any PHP errors, ensure `display_errors` is enabled in your `php.ini` for debugging.

---

## Credits

- Built with [Bootstrap 5](https://getbootstrap.com/), [PHP](https://www.php.net/), and [MySQL](https://www.mysql.com/).
- Icons by [Bootstrap Icons](https://icons.getbootstrap.com/).

---
