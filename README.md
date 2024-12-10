# E-Commerce Project

This is an e-commerce application designed to help users browse products, add them to a cart, and make transactions. The application also includes an admin panel for managing products, categories, and processing orders.

## Features

- **Customer Features:**
  - View and browse products.
  - Add products to the shopping cart.
  - Checkout and complete purchases.
  - Manage account (login/logout).
  - view transaction history.
  - view transaction receipt.
  
- **Admin Features:**
  - Manage product listings (add, update, delete).
  - Manage product categories.
  - manage transaction history.
  
## Technologies Used

- **Frontend:** 
  - HTML, CSS, Bootstrap
  
- **Backend:**
  - PHP for server-side processing.
  - MySQL for database management.
  
- **Database Structure:**
  - `admin`: Manages admin credentials.
  - `category`: Stores product categories.
  - `customer`: Stores customer information.
  - `login`: User login credentials.
  - `product`: Stores product details such as name, description, price, and stock.
  - `cart`: Temporary storage for customers' selected products.
  - `cart_items`: Tracks products and quantities in the cart.
  - `transaction`: Stores transaction details such as transaction date, customer, and total amount.
  - `transaction_detail`: Details of each item in a transaction.

## Setup Instructions

1. Clone this repository to your local machine:
   ```bash
   git clone https://github.com/Maevex/DB-Ecommerce.git
