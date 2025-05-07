# User Management System (UMS)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3-38B2AC?logo=tailwind-css)](https://tailwindcss.com)

> A comprehensive User Management System built with Laravel, featuring role-based access control, user administration, supplier and customer management, data visualization, and reporting capabilities.

<div align="center">
  <img src="screenshots/dashboard.png" alt="Dashboard Screenshot" width="80%">
</div>

## 📑 Table of Contents
- [Description](#-description)
- [Features](#-features)
- [Screenshots](#-screenshots)
- [Prerequisites](#-prerequisites)
- [System Requirements](#-system-requirements)
- [Installation](#️-installation)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [Role-Based Access](#-role-based-access)
- [API Support](#-api-support)
- [Technologies Used](#-technologies-used)
- [Documentation](#-documentation)
- [Roadmap](#-roadmap)
- [FAQ](#-faq)
- [Known Issues](#-known-issues)
- [License](#-license)
- [Contributing](#-contributing)
- [Author](#-author)
- [Acknowledgments](#-acknowledgments)

## 📝 Description

### What it does
The User Management System (UMS) is an enterprise-grade application that provides a complete framework for managing users, suppliers, and customers. It features role-based access control, comprehensive dashboards, data visualization, and reporting capabilities.

### Problem it solves
Traditional user management systems often lack flexibility, comprehensive reporting, and intuitive interfaces. UMS addresses these challenges by offering:
- Granular permission control for different user roles
- Comprehensive analytics dashboards for data-driven decisions
- Integrated supplier and customer management
- Detailed activity logging for compliance and security

### Who it's for
- **Business Administrators** needing to manage users across an organization
- **IT Managers** responsible for user access and permissions
- **Supply Chain Managers** tracking supplier information and performance
- **Customer Relationship Teams** maintaining customer data and activities

## 🚀 Features

### Authentication & Authorization
- **Secure Login with OTP Verification**: Two-factor authentication with email-based OTP for enhanced security
- **Role-based Access Control**: Granular permissions management using Spatie Permissions package
- **User Registration**: Comprehensive registration form with validation and verification
- **Session Management**: Secure session handling with timeout and device tracking

### User Management
- **Complete CRUD Operations**: 
  - User creation with role assignment
  - Detailed user profiles with comprehensive information
  - Bulk and individual user updates
  - Soft deletion with restoration capability
- **Advanced User Filtering**: Search and filter users by multiple criteria
- **Role and Permission Assignment**: Granular control over user capabilities
- **Multi-format Export**: Export user data in CSV, Excel, and PDF formats with custom field selection

### Supplier Management
- **Supplier Database**: 
  - Complete supplier information management
  - Company profiles with multiple contacts
  - Document attachment capability
  - Contract management
- **Performance Metrics**: Track supplier reliability, delivery times, and quality metrics
- **Contract Tracking**: Monitor contract status, expiration dates, and renewal workflows
- **Analytics Dashboard**: Visual representation of supplier performance and distribution

### Customer Management
- **Customer Profiles**: 
  - Comprehensive customer information database
  - Purchase history and preferences
  - Communication logs
  - Support ticket integration
- **Customer Segmentation**: Group customers by demographics, behavior, and value
- **Growth Analytics**: Track customer acquisition, retention, and churn rates
- **Activity Monitoring**: Log and analyze customer interactions and engagement

### Dashboards
- **Role-specific Dashboards**: 
  - Admin dashboard with system-wide analytics
  - Manager dashboard with team performance metrics
  - User dashboard with personal productivity indicators
  - Supplier and customer-specific views
- **Real-time Updates**: Live data refreshing for critical metrics
- **Customizable Widgets**: Personalized dashboard layout with draggable components
- **Interactive Filters**: Date range and parameter filtering for all analytics

### Data Visualization
- **Geographic Distribution**: Interactive maps showing user, supplier, and customer locations
- **Trend Analysis**: Time-series charts for growth metrics and performance indicators
- **Comparative Analytics**: Side-by-side comparisons of performance metrics
- **Export Capabilities**: Download charts and visualizations in multiple formats

### Activity Logging
- **Comprehensive Audit Trail**: Complete record of all system activities with timestamps
- **User Action History**: Detailed logs of individual user actions
- **Security Monitoring**: Flagging of suspicious activities and access attempts
- **Filtering and Reporting**: Advanced filtering and report generation from activity logs

### Reporting System
- **Scheduled Reports**: Automated generation and delivery of reports
- **Custom Report Builder**: Intuitive interface for creating custom reports
- **Multiple Export Formats**: Generate reports in PDF, Excel, and CSV formats
- **Interactive Data Tables**: Sortable and filterable data in all reports

### Security Features
- **Advanced Password Policies**: Configurable password requirements and expiration
- **IP Restriction**: Optional IP-based access controls
- **Activity Monitoring**: Real-time tracking of login attempts and suspicious activities
- **Data Encryption**: Encryption of sensitive data in transit and at rest

## 📸 Screenshots

<div align="center">
  <p><strong>Admin Dashboard</strong></p>
  <img src="screenshots/admin-dashboard.png" alt="Admin Dashboard" width="80%">
  <br><br>
  
  <p><strong>User Management</strong></p>
  <img src="screenshots/user-management.png" alt="User Management" width="80%">
  <br><br>
  
  <p><strong>Supplier Dashboard</strong></p>
  <img src="screenshots/supplier-dashboard.png" alt="Supplier Dashboard" width="80%">
  <br><br>
  
  <p><strong>Customer Analytics</strong></p>
  <img src="screenshots/customer-analytics.png" alt="Customer Analytics" width="80%">
  <br><br>
  
  <p><strong>Data Visualization</strong></p>
  <img src="screenshots/data-visualization.png" alt="Data Visualization" width="80%">
</div>

> **Note**: For a live demo of the system, visit: [UMS Demo Site](https://ums-demo.example.com)

## 📋 Prerequisites

- PHP >= 8.2
- Composer
- MySQL or compatible database
- Node.js and NPM
- Git

## 💻 System Requirements

### Minimum Requirements
- **Server**: 1 CPU core, 2GB RAM
- **Storage**: 5GB free space
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **Web Server**: Nginx 1.18+ or Apache 2.4+
- **PHP**: 8.2+

### Recommended Requirements
- **Server**: 2+ CPU cores, 4GB+ RAM
- **Storage**: 10GB+ free space
- **Database**: MySQL 8.0+ / MariaDB 10.5+
- **Web Server**: Nginx 1.20+ with PHP-FPM
- **PHP**: 8.2+ with OPcache enabled

### Supported Browsers
- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)

## 🛠️ Installation

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/user-management-system.git
cd user-management-system
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JS dependencies**

```bash
npm install
```

4. **Set up environment file**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database in .env file**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ums_db
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run migrations and seed the database**

```bash
php artisan migrate --seed
```

7. **Generate Passport encryption keys**

```bash
php artisan passport:install
```

8. **Build frontend assets**

```bash
npm run dev
```

9. **Start the development server**

```bash
php artisan serve
```

10. **Access the application**

Open [http://localhost:8000](http://localhost:8000) in your browser

## 🖥️ Usage

### Default Login Credentials

After installation, you can log in with the following default credentials:

- **Admin User**:
  - Email: admin@example.com
  - Password: password123

- **Regular User**:
  - Email: user@example.com
  - Password: password123

### Basic Navigation

1. **Dashboard**: The main landing page after login shows key metrics and recent activities
2. **User Management**: Access from the sidebar to create, view, edit, and delete users
3. **Supplier Management**: Add new suppliers, view supplier details, and track performance
4. **Customer Management**: Manage customer information and view analytics
5. **Reports**: Generate and export reports in various formats
6. **Settings**: Configure system settings and manage roles/permissions

### Sample Commands

```bash
# Generate a new user
php artisan ums:create-user

# Generate sample data for testing
php artisan ums:seed-test-data

# Clear all application cache
php artisan ums:clear-cache
```

## 📊 Project Structure

- **Controllers**: Located in `app/Http/Controllers`
  - `AuthController`: Handles login, registration, and authentication
  - `DashboardController`: Main dashboard analytics
  - `UserController`: User management
  - `SupplierController`: Supplier CRUD operations
  - `CustomerController`: Customer CRUD operations
  - `ChartController`: Data visualization endpoints
  - `RoleController`: Role management
  - `UserRoleController`: User-role assignments
  - `UserExportController`: Export functionality

- **Models**: Located in `app/Models`
  - `User`: User model with role relationships
  - `Supplier`: Supplier data model
  - `Customer`: Customer data model
  - `Activity`: Activity logging model
  - `State` & `City`: Location models

- **Views**: Located in `resources/views`
  - Main layouts and components
  - Dashboard views
  - Management forms
  - Reports and charts
  - Authentication templates

- **Routes**: Located in `routes/`
  - `web.php`: Web interface routes
  - `api.php`: API endpoints
  - `console.php`: Custom Artisan commands

- **Middleware**: Located in `app/Http/Middleware`
  - Role and permission verification
  - Authentication checks
  - Request validations

- **Database**: Located in `database/`
  - Migrations for all tables
  - Seeders for initial data
  - Factories for testing

## 👥 Role-Based Access

The system implements the following roles with granular permissions:

- **Admin**: 
  - Full system access
  - User, role, and permission management
  - System configuration
  - Access to all reports and analytics

- **Manager**: 
  - User, supplier, and customer management access
  - Report generation
  - Limited system configuration
  - Team management

- **User**: 
  - Limited access based on assigned permissions
  - Self-profile management
  - Task-specific access

- **Supplier**: 
  - Supplier-specific dashboard
  - Profile management
  - Contract viewing
  - Performance metrics

- **Customer**: 
  - Customer-specific dashboard
  - Profile management
  - Order history
  - Support access

### Permission Groups

- **User Management**: create-users, read-users, update-users, delete-users
- **Supplier Management**: create-suppliers, read-suppliers, update-suppliers, delete-suppliers
- **Customer Management**: create-customers, read-customers, update-customers, delete-customers
- **Report Access**: view-reports, export-reports, create-reports
- **System Configuration**: manage-roles, manage-permissions, system-settings

## 📱 API Support

The system includes Laravel Passport for API authentication, enabling:

- **Mobile Application Integration**: 
  - Secure OAuth2 authentication
  - Token-based API access
  - Mobile-specific endpoints

- **Third-party Service Integration**: 
  - Webhook support
  - OAuth2 client credentials flow
  - API rate limiting and security

- **API Token Management**:
  - Personal access tokens
  - Client credentials
  - Authorization code grant
  - Token scoping and expiration

- **Comprehensive API Documentation**:
  - Swagger/OpenAPI documentation
  - Interactive API testing console
  - Sample code snippets

## 🌐 Technologies Used

- **Backend**: 
  - Laravel 11 framework
  - PHP 8.2+
  - MySQL/MariaDB

- **Authentication**: 
  - Laravel Passport (OAuth2)
  - JWT for API access
  - OTP verification system

- **Authorization**: 
  - Spatie Laravel Permission
  - Policy-based access control
  - Role management

- **Frontend**: 
  - Blade templating engine
  - TailwindCSS for styling
  - Alpine.js for interactivity
  - Responsive design

- **Charts & Visualization**:
  - JavaScript charting libraries (Chart.js)
  - Interactive data tables
  - SVG maps for geographical data

- **Export & Reporting**:
  - DOMPDF for PDF generation
  - Laravel Excel for spreadsheet exports
  - CSV export functionality

- **Development Tools**:
  - Laravel Telescope for debugging
  - Composer for dependency management
  - Laravel Pint for code styling

## 📖 Documentation

Comprehensive documentation is available to help you get the most out of the User Management System:

- **[User Guide](docs/user-guide.md)**: End-user documentation for daily operations
- **[Administrator Guide](docs/admin-guide.md)**: System administration and configuration
- **[Developer Documentation](docs/developer-guide.md)**: API references and extension guidelines
- **[Deployment Guide](docs/deployment.md)**: Production deployment best practices

### Quick Start Guides

- **[For Administrators](docs/quickstart-admin.md)**
- **[For Managers](docs/quickstart-manager.md)**
- **[For Suppliers](docs/quickstart-supplier.md)**
- **[For Customers](docs/quickstart-customer.md)**

## 🗓️ Roadmap

- **Upcoming in v1.2**:
  - Advanced reporting engine
  - Dashboard customization options
  - Multi-language support
  - Dark mode UI

- **Planned for v1.3**:
  - Mobile application
  - Integrated messaging system
  - Advanced analytics with AI predictions
  - Calendar integration

- **Future Considerations**:
  - Blockchain integration for secure transactions
  - Expanded third-party integrations
  - Machine learning for customer insights
  - Voice interface capabilities


## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Workflow

1. Check the [Issues](https://github.com/yourusername/user-management-system/issues) page for open tasks
2. Comment on an issue you'd like to work on
3. Follow coding standards and write tests
4. Submit a PR with a detailed description of changes

## 👨‍💻 Author

**Your Name**  
- Email: your.email@example.com
- GitHub: [YourGitHubUsername](https://github.com/yourusername)
- LinkedIn: [Your LinkedIn](https://linkedin.com/in/yourusername)
- Portfolio: [Your Website](https://yourwebsite.com)

## 🙏 Acknowledgments

- [Laravel Team](https://laravel.com/) for the amazing framework
- [Spatie](https://spatie.be/) for the Laravel Permission package
- [TailwindCSS](https://tailwindcss.com/) for the utility-first CSS framework
- [Chart.js](https://www.chartjs.org/) for beautiful chart components
- All open-source contributors whose packages made this project possible







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
