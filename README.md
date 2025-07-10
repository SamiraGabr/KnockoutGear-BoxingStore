# Knockout Gear - Boxing Store Web Application

Knockout Gear is a full-stack e-commerce web application meticulously crafted for an online boxing equipment store. It empowers users to seamlessly browse and purchase boxing gear, manage their accounts, submit product reviews, and track their orders. On the administrative side, it provides robust tools for efficient product management. The application boasts a responsive design, featuring a dynamic boxing-themed aesthetic, complete with an engaging hero video on the homepage and a distinctive ring-patterned background.

-----

##  Features

Knockout Gear is packed with functionalities for both customers and administrators.

### User Features

  * **Product Browse:**

      * Discover **featured products** directly on the homepage.
      * Explore a comprehensive catalog of all products with intuitive **category filtering** (e.g., Gloves, Clothing) and a powerful **search functionality**.
      * View essential product details, including **price**, **average rating**, and the **number of reviews**.

  * **Shopping Cart:**

      * **Add products to your cart** with ease (login required).
      * Review your cart contents, displaying product names, prices, quantities, and the **total cost**.
      * **Remove items** from your cart as needed.

  * **Checkout and Orders:**

      * Proceed to **checkout** to place an order, including inputs for shipping and billing addresses.
      * Access your **order history** with detailed information such as order number, date, total amount, status, and individual order items.

  * **Account Management:**

      * **Register a new account** by providing a username, email, password, and optional address/phone details.
      * **Log in** to unlock full access to cart, orders, and review features.
      * View and update your **profile details** (name, email, address, phone).
      * **Log out** securely from your session.

  * **Product Reviews:**

      * **Submit reviews** for products, including a rating (1-5 stars) and comments, once logged in.
      * View all existing reviews for a selected product, complete with ratings, comments, and reviewer usernames.

  * **Search:**

      * Quickly **search products by name or description** with instant results for efficient Browse.

### Admin Features

  * **Product Management:**
      * **Add new products** to the store, specifying details like name, description, price, stock quantity, image, category, and featured status.
      * **Delete existing products** from the inventory.
      * Access to the admin panel is **restricted** to users with `is_admin = TRUE` privileges.

### Technical Features

  * **Database-Driven:**

      * Powered by a **MySQL database** (`knockout_gear`), comprising tables for users, products, categories, carts, orders, reviews, and more.
      * Includes a **stored procedure** (`place_order`) to streamline order creation and a **trigger** (`before_order_insert`) for generating unique order numbers.
      * The database supports **product variations** (e.g., size, color), with UI implementation pending for this feature.

  * **Security:**

      * **Passwords are securely hashed** using PHP's `password_hash()` function for robust storage.
      * **Input sanitization** with `htmlspecialchars()` is applied to prevent Cross-Site Scripting (XSS) attacks.
      * **Session-based authentication** manages user and admin access, ensuring secure interactions.

  * **Responsive Design:**

      * Features a **mobile-friendly layout** with **CSS Grid** for clean product displays across devices.
      * Maintains a consistent boxing theme with striking **red accents** and a distinctive **ring-patterned background**.
      * An immersive **hero video** (`hero_video.mp4`) on the homepage adds dynamic appeal.

-----

## 📂 Directory Structure

```
boxing_store/
├── config/
│   └── db_connect.php                 # Database connection configuration
├── images/
│   ├── store_logo.png                 # Store logo
│   ├── hero_video.mp4                 # Homepage hero video
│   ├── ring_pattern.png               # Background pattern
│   └── products/                      # Product images (e.g., gloves/, clothing/)
├── includes/
│   ├── account.inc.php                # Login and registration logic
│   ├── cart.inc.php                   # Cart operations (add/remove items)
│   ├── cart_page.inc.php              # Cart page data fetching
│   ├── checkout.inc.php               # Checkout and order placement logic
│   ├── index.inc.php                  # Homepage product fetching
│   ├── orders.inc.php                 # Order history and details
│   ├── products.inc.php               # Product listing and filtering
│   ├── reviews.inc.php                # Review submission and display
│   ├── search.inc.php                 # Search functionality
│   └── user.inc.php                   # Admin product management
├── scripts/
│   ├── main.js                        # General client-side JavaScript
│   └── products_script.js             # Cart addition via AJAX
├── styles/
│   ├── account_style.css              # Styles for account and admin pages
│   ├── cart_style.css                 # Cart page styles
│   ├── home_style.css                 # Homepage styles
│   ├── nav_foot_style.css             # Navigation and footer styles
│   ├── order_style.css                # Orders and checkout page styles
│   ├── products_style.css             # Products and search page styles
│   └── reviews_style.css              # Reviews page styles
├── templates/
│   ├── footer.php                     # Footer for all pages
│   ├── logo.php                       # Store logo component
│   ├── logout.php                     # Logout functionality
│   ├── nav.php                        # Navigation bar
│   └── user_cart.php                  # Cart summary for navigation
├── account.php                        # User login, registration, and profile
├── admin.php                          # Admin panel for product management
├── cart.php                           # Shopping cart page
├── checkout.php                       # Checkout and order placement
├── index.php                          # Homepage with featured products
├── orders.php                         # Order history and details
├── products.php                       # Product listing with filters
├── reviews.php                        # Product review submission and display
├── search.php                         # Product search page
├── boxing_store.sql                   # Database schema and sample data
└── README.md                          # This file
```

-----

##  Setup Instructions

Follow these steps to get Knockout Gear running on your local development environment.

### Prerequisites

Before you begin, ensure you have the following installed:

  * **PHP:** Version **7.4** or higher
  * **MySQL:** Version **5.7** or higher
  * **Web Server:** Apache (commonly available via **XAMPP**, **WAMP**, or similar stacks)
  * **Browser:** A modern web browser (e.g., Chrome, Firefox, Edge)

### Installation

1.  **Clone the Repository:**

    ```bash
    git clone https://github.com/your-username/knockout_gear.git
    cd knockout_gear
    ```

2.  **Set Up the Database:**

      * Create a MySQL database named `knockout_gear`.

      * Import the `boxing_store.sql` file into your newly created database. Replace `your_username` with your MySQL username when executing the command:

        ```bash
        mysql -u your_username -p knockout_gear < boxing_store.sql
        ```

      * **Update `config/db_connect.php`** with your MySQL credentials:

        ```php
        <?php
        $host = 'localhost';
        $dbname = 'knockout_gear';
        $username = 'your_username'; // Your MySQL username
        $password = 'your_password'; // Your MySQL password
        ?>
        ```

3.  **Configure the Web Server:**

      * Place the entire `boxing_store` folder into your web server's root directory (e.g., `htdocs` for XAMPP).
      * Ensure the `images/products/` directory has **write permissions** to allow administrators to upload product images (e.g., `chmod 777 images/products/` on Linux/macOS, or adjust permissions via your OS's file explorer).

4.  **Add Images and Video:**

      * Verify that the following files are present in the `images/` directory:
          * `store_logo.png`
          * `hero_video.mp4`
          * `ring_pattern.png`
      * Ensure product images are organized within their respective subdirectories (e.g., `images/products/gloves/pro_boxing_gloves.jpg`). The `image_path` in your `products` table must match these paths.

5.  **Start the Server:**

      * Start your Apache and MySQL services (e.g., using the XAMPP control panel).
      * Access the application by navigating to `http://localhost/boxing_store/` in your web browser.

-----

##  Usage

Here's a quick guide on how to interact with the Knockout Gear application.

### User Workflow

  * **Browse Products:**
      * Visit the homepage (`index.php`) to see featured products and a dynamic hero video.
      * Go to `products.php` to browse all items, filter by category, or use the search bar.
  * **Register/Login:**
      * Access `account.php` to register a new account or log in to an existing one.
      * You can use the sample user credentials: **username: `john_doe`**, **password: `password`**.
  * **Add to Cart:**
      * Click "Add to Cart" on product cards (requires you to be logged in).
      * View your cart at `cart.php` and remove items if needed.
  * **Checkout:**
      * Proceed to `checkout.php` to input shipping and billing details and complete your order.
  * **View Orders:**
      * Check your complete order history at `orders.php`, with detailed information for each past order.
  * **Submit Reviews:**
      * Navigate to `reviews.php`, select a product, and submit your rating and comments.
  * **Search:**
      * Utilize the search form available on `search.php` or `products.php` to quickly find specific items.

### Admin Workflow

  * **Access Admin Panel:**
      * Log in with an administrator account (sample credentials: **username: `admin`**, **password: `password`**) via `account.php`.
      * Navigate directly to `admin.php`.
  * **Manage Products:**
      * From the admin panel, you can add new products by providing their details and uploading images.
      * You can also delete existing products from the store.

-----

##  Technologies Used

Knockout Gear is built with a robust set of technologies:

  * **Backend:** **PHP 7.4+**, **MySQL**
  * **Frontend:** **HTML5**, **CSS3**, **JavaScript**
  * **Database:** **MySQL** with InnoDB engine
  * **Libraries/Frameworks:**
      * **PDO** for secure and efficient database interactions.
      * **CSS Grid** for responsive product layouts.
      * **AJAX** for dynamic cart operations without page reloads.
  * **Styling:** Custom CSS, featuring a distinct boxing theme with red accents and a ring-patterned background.

-----


##  Testing

The `boxing_store.sql` file provides sample data to facilitate comprehensive testing.

  * **Sample Credentials:**

      * **User:** `username: john_doe`, `password: password`
      * **Admin:** `username: admin`, `password: password`

  * **Testing Steps:**

      * Test the **registration and login** functionality on `account.php`.
      * Add products to your cart and proceed through the **checkout** process.
      * Submit **reviews** for products and verify that they appear correctly on `reviews.php`.
      * Check your **order details** on `orders.php`.
      * Use the **admin panel** to add and delete products, ensuring product management works as expected.

-----
