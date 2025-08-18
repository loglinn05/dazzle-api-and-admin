# [Dazzle](https://github.com/loglinn05/dazzle) Admin Panel

## Overview

This is the admin panel for [**Dazzle**](https://github.com/loglinn05/dazzle), a clothing store. It allows administrators to manage products, product attributes,
orders, and users efficiently.

## Features

- Product and attribute management
- Order tracking and management
- Dashboard with analytics and easy-to-read sales charts

## Admin Panel User Accounts

1. 👤 **Amy**:
    - 📧 E-mail: amy@gmail.com
    - 🔑 Password: 12345678
    - 🛡️ Role: Super Admin
    - 🔐 Can:
        - view permissions
        - create permissions
        - update permissions
        - delete permissions
        - view roles
        - create roles
        - update roles
        - delete roles
        - view users
        - create users
        - update users
        - assign roles to users
        - delete users
        - view products and product features
        - create products and product features
        - update products and product features
        - delete products and product features
        - view orders
        - update orders
        - delete orders
2. 👤 **Lina**:
    - 📧 E-mail: lina@yahoo.com
    - 🔑 Password: abcd
    - 🛡️ Role: Admin
    - 🔐 Can:
        - view users
        - create users
        - update users
        - delete users
        - view products and product features
        - create products and product features
        - update products and product features
        - delete products and product features
        - view orders
        - update orders
        - delete orders
3. 👤 **Eve**:
    - 📧 E-mail: eve@example.com
    - 🔑 Password: qwerty
    - 🛡️ Role: Staff
    - 🔐 Can:
        - view users
        - update users
        - view products and product features
        - create products and product features
        - update products and product features
        - delete products and product features
        - view orders
        - update orders
4. 👤 **Anna**:
    - 📧 E-mail: anna@gmail.com
    - 🔑 Password: uiop
    - 🛡️ Role: Customer
    - 🔐 Can't access the admin panel.

## Launch Guide

### Prerequisites

- Node.js (v18.3 or higher)
- npm
- PHP 8.2 or newer
- MySQL

### Installation

1. Clone the repository:
    ```bash
    git clone git@github.com:loglinn05/dazzle-api-and-admin.git
    cd dazzle-api-and-admin
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Configure environment variables:
    - Copy `.env.example` content to `.env`.
    - Set `STRIPE_KEY` and `STRIPE_SECRET` to your Stripe public and secret keys respectively.
    - Run
      ```bash
      php artisan key:generate
      ```

4. Run database migrations:
    ```bash
    php artisan migrate
    ```

### Running the Admin Panel

Start the development server:

```bash
php artisan serve
npm run dev
```

The admin panel will be available at [http://localhost:8000](http://localhost:8000).
