# ✨ User Management System (UMS) ✨

<div align="center">

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3-38B2AC?logo=tailwind-css)](https://tailwindcss.com)
[![Spatie Permission](https://img.shields.io/badge/Spatie-Permission-orange)](https://github.com/spatie/laravel-permission)
[![Laravel Passport](https://img.shields.io/badge/Laravel-Passport-red)](https://laravel.com/docs/11.x/passport)

</div>

🔐 A Laravel-based User Management System with role-based access control, supplier and customer management, and data visualization. 📊

<div align="center">
    <p>📸 Add your application screenshots here</p>
    <img src="screenshots/dashboard-placeholder.png" alt="Dashboard Screenshot Placeholder" width="80%">
</div>

## 📑 Table of Contents
- [📝 Description](#-description)
- [🚀 Features](#-features)
- [📸 Screenshots](#-screenshots)
- [📋 Prerequisites](#-prerequisites)
- [🛠️ Installation](#️-installation)
- [🖥️ Usage](#-usage)
- [📊 Project Structure](#-project-structure)
- [👥 Role-Based Access](#-role-based-access)
- [📱 API Routes](#-api-routes)
- [🌐 Technologies Used](#-technologies-used)
- [📄 License](#-license)

## 📝 Description

The User Management System (UMS) is a web application built with Laravel that provides user, supplier, and customer management with role-based access control. The system includes dashboards with analytics, data visualization, and basic reporting capabilities.

🎓 This system was developed as part of a university project to demonstrate a complete Laravel application with role-based permissions, database relationships, and interactive dashboards.

## 🚀 Features

### 🔐 Authentication & Authorization
- 🔑 Login system with OTP verification
- 👮‍♀️ Role-based access control using Spatie Permissions
- 📝 User registration with form validation
- 🔒 Session management and security

### 👤 User Management
- ✏️ Create, read, update, and delete users
- 👨‍💼 User profile management
- 🎭 Role and permission assignment
- 📊 Export users data in CSV, Excel, and PDF formats
- 🔍 Advanced user filtering and searching

### 🏭 Supplier Management
- 📋 Complete CRUD operations for suppliers
- 📦 Supplier information tracking
- 📜 Contract management
- 📈 Basic supplier analytics
- 🌟 Supplier performance metrics

### 🧑‍🤝‍🧑 Customer Management
- 💼 Customer database management
- 📂 Customer information tracking
- 📊 Customer analytics
- 🗺️ Location-based customer distribution

### 📊 Dashboards
- 👑 Admin dashboard with system metrics
- 🏭 Supplier dashboard with relevant KPIs
- 🧑‍🤝‍🧑 Customer dashboard with activity tracking
- 📈 Data visualization charts
- 🔍 Interactive data filtering

### 📝 Activity Logging
- 👀 User action tracking
- 📜 Activity history
- 🔍 Audit trails for compliance
- 🔐 Security monitoring

## 📸 Screenshots

<div align="center">
  <p><strong>👑 Admin Dashboard</strong></p>
  <p><em>Add screenshot here</em></p>
  <br><br>
  
  <p><strong>👤 User Management</strong></p>
  <p><em>Add screenshot here</em></p>
  <br><br>
  
  <p><strong>🏭 Supplier Dashboard</strong></p>
  <p><em>Add screenshot here</em></p>
  <br><br>
  
  <p><strong>🧑‍🤝‍🧑 Customer Analytics</strong></p>
  <p><em>Add screenshot here</em></p>
</div>

## 📋 Prerequisites

- 🐘 PHP >= 8.2
- 🎼 Composer
- 🗄️ MySQL or compatible database
- 🟢 Node.js and NPM
- 🔄 Git (optional, for cloning the repository)

## 🛠️ Installation

1. **📥 Clone the repository**

```bash
git clone https://github.com/yourusername/user-management-system.git
cd user-management-system
```

2. **🔽 Install PHP dependencies**

```bash
composer install
```

3. **📦 Install JS dependencies**

```bash
npm install
```

4. **⚙️ Set up environment file**

```bash
cp .env.example .env
php artisan key:generate
```

5. **🗄️ Configure database in .env file**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ums_db
DB_USERNAME=root
DB_PASSWORD=
```

6. **🚀 Run migrations and seed the database**

```bash
php artisan migrate --seed
```

7. **🔑 Generate Passport encryption keys**

```bash
php artisan passport:install
```

8. **🏗️ Build frontend assets**

```bash
npm run dev
```

9. **🚀 Start the development server**

```bash
php artisan serve
```

## 🖥️ Usage

### 🔐 Default Login Credentials

After installation and seeding the database, you can log in with these default credentials:

- **👑 Admin User**:
  - 📧 Email: admin@example.com
  - 🔑 Password: password

- **👤 Regular User**:
  - 📧 Email: user@example.com
  - 🔑 Password: password

### 🧭 Basic Navigation

1. **🏠 Dashboard**: After login, you're directed to the main dashboard showing key metrics
2. **👤 User Management**: Manage users from the sidebar menu
3. **🏭 Supplier Management**: Add and manage suppliers
4. **🧑‍🤝‍🧑 Customer Management**: Track customer information and analytics
5. **⚙️ Settings**: Configure roles and permissions (admin only)

## 📊 Project Structure

### 📁 Folder Structure

```
user-management-system/
├── app/                          # Application code
│   ├── Http/
│   │   ├── Controllers/          # All controllers
│   │   ├── Middleware/           # Request middleware
│   │   └── Requests/             # Form requests
│   ├── Models/                   # Eloquent models
│   └── Exports/                  # Export classes
├── config/                       # Configuration files
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── public/                       # Publicly accessible files
├── resources/
│   ├── js/                       # JavaScript files
│   ├── css/                      # CSS files
│   └── views/                    # Blade templates
├── routes/                       # Route definitions
│   ├── web.php                   # Web routes
│   └── api.php                   # API routes
└── storage/                      # Application storage
```

### 🧩 Key Components

- **🎮 Controllers**: Located in `app/Http/Controllers`
  - `🔐 AuthController`: Handles login, registration, and authentication
  - `📊 DashboardController`: Dashboard analytics
  - `👤 UserController`: User management
  - `🏭 SupplierController`: Supplier CRUD operations
  - `🧑‍🤝‍🧑 CustomerController`: Customer CRUD operations
  - `📈 ChartController`: Data visualization endpoints
  - `🎭 RoleController`: Role management
  - `👮‍♀️ UserRoleController`: User-role assignments

- **📚 Models**: Located in `app/Models`
  - `👤 User`: User model with role relationships
  - `🏭 Supplier`: Supplier data model
  - `🧑‍🤝‍🧑 Customer`: Customer data model
  - `📝 Activity`: Activity logging model
  - `🌍 State` & `🏙️ City`: Location models

- **👁️ Views**: Located in `resources/views`
  - Dashboard views
  - User, supplier, and customer management forms
  - Charts and visualizations

- **🔀 Routes**: Located in `routes/`
  - `web.php`: Web interface routes
  - `api.php`: API endpoints

## 👥 Role-Based Access

The system implements the following roles:

- **👑 Admin**: Full system access
- **👨‍💼 Customer Manager**: Manages customers
- **🏭 Supplier Manager**: Manages suppliers
- **👤 Regular User**: Basic read access

### 🔑 Permission Groups

- **👤 User Management**: create-users, read-users, update-users, delete-users
- **🏭 Supplier Management**: create-suppliers, read-suppliers, update-suppliers, delete-suppliers
- **🧑‍🤝‍🧑 Customer Management**: create-customers, read-customers, update-customers, delete-customers

### 📋 Role-Permission Matrix

| Permission | 👑 Admin | 👨‍💼 Customer Manager | 🏭 Supplier Manager | 👤 Regular User |
|------------|-------|------------------|------------------|--------------|
| create-users | ✅ | ❌ | ❌ | ❌ |
| read-users | ✅ | ✅ | ✅ | ✅ |
| update-users | ✅ | ❌ | ❌ | ❌ |
| delete-users | ✅ | ❌ | ❌ | ❌ |
| create-suppliers | ✅ | ❌ | ✅ | ❌ |
| read-suppliers | ✅ | ❌ | ✅ | ✅ |
| update-suppliers | ✅ | ❌ | ✅ | ❌ |
| delete-suppliers | ✅ | ❌ | ✅ | ❌ |
| create-customers | ✅ | ✅ | ❌ | ❌ |
| read-customers | ✅ | ✅ | ❌ | ✅ |
| update-customers | ✅ | ✅ | ❌ | ❌ |
| delete-customers | ✅ | ✅ | ❌ | ❌ |

## 📱 API Routes

The system provides API endpoints for integration with other applications:

### 🔐 Authentication
- `POST /api/login` - Get access token
- `POST /api/register` - Register new user
- `POST /api/logout` - Invalidate token

### 👤 Users
- `GET /api/users` - List all users
- `POST /api/users` - Create new user
- `GET /api/users/{id}` - Get user details
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

### 🏭 Suppliers
- `GET /api/suppliers` - List all suppliers
- `POST /api/suppliers` - Create new supplier
- `GET /api/suppliers/{id}` - Get supplier details
- `PUT /api/suppliers/{id}` - Update supplier
- `DELETE /api/suppliers/{id}` - Delete supplier

### 🧑‍🤝‍🧑 Customers
- `GET /api/customers` - List all customers
- `POST /api/customers` - Create new customer
- `GET /api/customers/{id}` - Get customer details
- `PUT /api/customers/{id}` - Update customer
- `DELETE /api/customers/{id}` - Delete customer

## 🌐 Technologies Used

- **⚙️ Backend**: 
  - 🔧 Laravel 11 framework
  - 🐘 PHP 8.2+
  - 🗄️ MySQL/MariaDB

- **🔐 Authentication**: 
  - 🔑 Laravel Passport
  - 🔢 OTP verification

- **👮‍♀️ Authorization**: 
  - 🔒 Spatie Laravel Permission

- **🎨 Frontend**: 
  - 📄 Blade templating
  - 🎭 TailwindCSS
  - 🔄 Basic JavaScript
  - 📊 Chart.js for visualizations

- **📊 Export & Reporting**:
  - 📑 DOMPDF (PDF generation)
  - 📊 Laravel Excel
  - 📋 CSV export

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. ⚖️
