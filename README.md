# Pedidos Forma de Amor - Laravel E-commerce Platform

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [Architecture](#architecture)
- [Security Features](#security-features)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

Modern e-commerce platform built with Laravel 12, migrated from legacy PHP codebase. Features secure authentication, product management, shopping cart, multiple payment gateways (PayPal, Stripe, PIX), and comprehensive admin panel.

**🐳 Fully Dockerized** - Ready to run with a single command using Docker and Docker Compose. No need to install PHP, MySQL, or other dependencies locally.

### Why This Migration?

The previous codebase had critical issues:
- ❌ **MD5 password hashing** (broken since 2004)
- ❌ **No architecture pattern** (spaghetti code)
- ❌ **SQL injection vulnerabilities**
- ❌ **No modern security practices**

This Laravel migration provides:
- ✅ **bcrypt password hashing** (industry standard)
- ✅ **MVC architecture** (maintainable & scalable)
- ✅ **Eloquent ORM** (SQL injection protected)
- ✅ **CSRF protection** (built-in)
- ✅ **Modern PHP 8.3** features

## ✨ Features

### Customer Features
- 🔐 **Secure Authentication** (Laravel Breeze with bcrypt)
- 🛍️ **Product Browsing** (3-level category hierarchy)
- 🔍 **Advanced Search & Filters**
- 🛒 **Shopping Cart** (session-based)
- 💳 **Multiple Payment Options** (PayPal, Stripe, PIX, Bank Transfer)
- 📦 **Order Tracking**
- ⭐ **Product Reviews & Ratings**
- 👤 **Profile Management** (billing/shipping addresses)

### Admin Features
- 📊 **Dashboard** (sales analytics, order stats)
- 🏪 **Product Management** (CRUD operations)
- 📁 **Category Management** (3-level hierarchy)
- 👥 **Customer Management**
- 📦 **Order Management** (status updates, shipping)
- 💰 **Payment Tracking**
- 🎨 **Settings** (site configuration, SEO)
- 📱 **Responsive Admin Panel** (Filament)

### Technical Features
- 🚀 **Laravel 12** (latest features)
- 🗄️ **Eloquent ORM** (type-safe queries)
- 🔒 **Security Best Practices** (CSRF, XSS protection)
- 📧 **Email Notifications** (order confirmations)
- 🖼️ **Image Uploads** (multiple product photos)
- 🌍 **Internationalization Ready** (pt_BR locale)
- 📱 **Responsive Design** (mobile-first)
- ⚡ **Optimized Performance** (caching, eager loading)

## 📦 Requirements

### Docker Setup (Recommended)
- Docker Engine >= 20.10
- Docker Compose >= 2.0

### Manual Setup
- PHP >= 8.3
- Composer 2.x
- MySQL >= 8.0 or MariaDB >= 10.5
- Node.js >= 20.19 (for asset compilation)
- NPM >= 10.x

## 🚀 Installation

### Docker Setup (Recommended)

The easiest way to get started is using Docker:

```bash
# 1. Clone the repository
git clone https://github.com/your-repo/pedidosformadeamor-laravel.git
cd pedidosformadeamor-laravel

# 2. Run the setup script
chmod +x setup-docker.sh
./setup-docker.sh
```

The script will:
- Start Docker containers (Laravel, Nginx, MySQL)
- Run migrations
- Seed the database with test data
- Create storage link
- Clear cache

**Access the application:**
- Frontend: http://localhost:8001
- Admin Panel: http://localhost:8001/admin

**Default Credentials:**
- Customer: `customer@test.com` / `password`
- Admin: `admin@admin.com` / `password`

**Useful Docker Commands:**
```bash
docker compose logs -f        # View logs
docker compose down           # Stop containers
docker compose restart        # Restart containers
docker compose exec laravel.test bash  # Enter container
```

### Manual Setup (Without Docker)

If you prefer to install manually:

#### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/pedidosformadeamor-laravel.git
cd pedidosformadeamor-laravel
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

#### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed initial data (optional)
php artisan db:seed
php artisan db:seed --class=AdminSeeder
```

#### 5. Storage Link

```bash
# Create symbolic link for storage
php artisan storage:link
```

#### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

#### 7. Serve Application

```bash
# Development server
php artisan serve

# Visit: http://localhost:8000
```

## 🗄️ Database Schema

### Core Tables

#### Products & Categories
- `top_categories` - Top level (Men, Women, Kids)
- `mid_categories` - Mid level (Accessories, Shoes)
- `end_categories` - Final level (Boots, Sneakers)
- `products` - Product information
- `product_photos` - Additional product images
- `product_color` - Product colors (pivot)
- `product_size` - Product sizes (pivot)
- `colors` - Available colors
- `sizes` - Available sizes

#### Orders & Payments
- `customers` - Customer accounts
- `orders` - Order information
- `order_items` - Products in orders
- `payments` - Payment transactions

#### Configuration
- `settings` - Site configuration
- `sliders` - Homepage carousel
- `faqs` - Frequently asked questions
- `customer_messages` - Support tickets

### Entity Relationships

```
Category (Top)
  └── MidCategory
        └── EndCategory
              └── Product
                    ├── Colors (M2M)
                    ├── Sizes (M2M)
                    ├── Photos (1:M)
                    └── Ratings (1:M)

Customer
  ├── Orders (1:M)
  │     └── OrderItems (1:M)
  ├── Payments (1:M)
  └── Messages (1:M)
```

## 🏗️ Architecture

### MVC Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       └── OrderController.php
│   └── Middleware/
│       ├── CustomerAuth.php
│       └── AdminAuth.php
├── Models/
│   ├── Product.php
│   ├── Customer.php
│   ├── Order.php
│   └── Payment.php
└── Services/
    ├── CartService.php
    ├── PaymentService.php
    └── OrderService.php
```

### Design Patterns Used

- **Repository Pattern** (for complex queries)
- **Service Layer** (business logic separation)
- **Observer Pattern** (for order events)
- **Factory Pattern** (for payment gateways)
- **Singleton Pattern** (for cart management)

## 🔒 Security Features

### Authentication
- **bcrypt** password hashing (12 rounds)
- **Email verification** required
- **Remember me** functionality
- **Password reset** via email token

### Protection Against
- ✅ **SQL Injection** (Eloquent ORM)
- ✅ **CSRF Attacks** (Laravel middleware)
- ✅ **XSS Attacks** (Blade auto-escaping)
- ✅ **Mass Assignment** (fillable/guarded properties)
- ✅ **Brute Force** (rate limiting)

### Secure Payment Handling
- Never store full credit card numbers
- PCI DSS compliant integration
- Encrypted gateway communication
- Transaction verification

## 📚 API Documentation

### Product Endpoints

```http
GET    /api/products              # List products
GET    /api/products/{id}         # Show product
POST   /api/products              # Create product (admin)
PUT    /api/products/{id}         # Update product (admin)
DELETE /api/products/{id}         # Delete product (admin)
```

### Cart Endpoints

```http
POST   /api/cart/add              # Add to cart
PUT    /api/cart/update/{id}      # Update quantity
DELETE /api/cart/remove/{id}      # Remove item
GET    /api/cart                  # View cart
```

### Order Endpoints

```http
POST   /api/checkout              # Process checkout
GET    /api/orders                # List orders
GET    /api/orders/{id}           # Show order
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# With coverage
php artisan test --coverage
```

### Test Structure

```
tests/
├── Feature/
│   ├── ProductTest.php
│   ├── CartTest.php
│   ├── CheckoutTest.php
│   └── Admin/
│       └── ProductManagementTest.php
└── Unit/
    ├── ProductModelTest.php
    ├── CartServiceTest.php
    └── PaymentServiceTest.php
```

## 🚢 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Configure HTTPS/SSL
- [ ] Set up cron jobs for scheduled tasks
- [ ] Configure queue workers
- [ ] Set up monitoring (Laravel Telescope)

### Server Requirements

**Minimum:**
- 2 CPU cores
- 2GB RAM
- 20GB storage
- PHP 8.3 with required extensions

**Recommended:**
- 4+ CPU cores
- 4GB+ RAM
- SSD storage
- Redis for caching/sessions
- Supervisor for queue workers

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Coding Standards
- Follow PSR-12 coding standard
- Write comprehensive tests
- Document all public methods
- Use type hints (PHP 8.3 features)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework - https://laravel.com
- Filament Admin Panel - https://filamentphp.com
- Stripe API - https://stripe.com/docs/api
- PayPal API - https://developer.paypal.com
