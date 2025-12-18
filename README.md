# 🏢 HR Management System

A comprehensive Human Resources Management System built with PHP, MySQL, and Bootstrap 5. Streamline your HR operations with modern web technologies and intuitive design.

![HR Management System](https://img.shields.io/badge/PHP-8%2B-blue) ![MySQL](https://img.shields.io/badge/MySQL-8.0-orange) ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple) ![License](https://img.shields.io/badge/License-MIT-green)

## ✨ Features

### 👥 **Employee Management**
- Complete employee CRUD operations
- Employee directory with search functionality
- Personal profile management
- Department-wise organization
- Employee status tracking (Active, Probation, Inactive)

### 🔐 **Role-Based Access Control**
- 8 predefined organizational roles
- 38 granular permissions across modules
- Secure authentication system
- Session management

### 💰 **Payroll Management**
- Automated payroll calculation
- Salary slip generation (PDF)
- Bulk payroll processing
- Allowances and deductions management
- Monthly payroll reports

### 📋 **Employee Onboarding**
- Structured onboarding workflows
- Task management system
- Document upload and verification
- Progress tracking with completion percentages
- 30-60-90 day review cycles

### 🕒 **Attendance Tracking**
- Real-time check-in/check-out system
- Monthly attendance statistics
- Attendance management for HR
- Comprehensive reporting

### 🏖️ **Leave Management**
- Leave application system
- Approval workflow for managers
- Leave balance tracking
- Multiple leave types support

### 📊 **Reports & Analytics**
- Interactive dashboards with Chart.js
- Employee reports with filtering
- Payroll summaries
- Department-wise analytics
- Export capabilities

### ⚙️ **Administration**
- User management system
- Role and permission management
- System settings and preferences
- Audit logging

## 🚀 Quick Start

### Prerequisites
- PHP 8.0 or higher
- MySQL 8.0 or higher
- Apache/Nginx web server
- Composer (optional)

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/hr-management-system.git
cd hr-management-system
```

2. **Database Setup**
```bash
# Create database
mysql -u root -p
CREATE DATABASE hr_system;
USE hr_system;

# Import database schema
SOURCE sql/hr_system.sql;
SOURCE sql/roles_permissions.sql;
SOURCE sql/demo_users.sql;
```

3. **Configuration**
```php
// config/database.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'hr_system');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

4. **Web Server Setup**
- Point your web server to the project directory
- Ensure `mod_rewrite` is enabled for Apache
- Set appropriate file permissions

5. **Access the System**
```
http://localhost/hr-system/
```

## 🔑 Demo Accounts

| Role | Username | Password | Access Level |
|------|----------|----------|--------------|
| Super Admin | `super_admin` | `1234` | Full System Access |
| HR Director | `hr_director` | `1234` | HR Operations |
| HR Manager | `hr_manager` | `1234` | Employee Management |
| Payroll Manager | `payroll_manager` | `1234` | Payroll Operations |
| Recruitment Manager | `recruitment_manager` | `1234` | Hiring & Onboarding |
| Attendance Manager | `attendance_manager` | `1234` | Attendance Tracking |
| Department Manager | `department_manager` | `1234` | Department Operations |
| Employee | `employee` | `1234` | Self-Service Portal |

## 🛠️ Technology Stack

- **Backend**: PHP 8+ (OOP)
- **Database**: MySQL 8.0 with PDO
- **Frontend**: Bootstrap 5.3, HTML5, CSS3
- **JavaScript**: Vanilla JS, Chart.js, DataTables
- **Icons**: Font Awesome 6
- **Notifications**: SweetAlert2
- **File Upload**: Dropzone.js

## 📁 Project Structure

```
hr-system/
├── classes/           # PHP Classes (Auth, Database, Employee, etc.)
├── config/           # Configuration files
├── includes/         # Common includes (header, footer, sidebar)
├── modules/          # Feature modules
│   ├── admin/        # User & role management
│   ├── employees/    # Employee management
│   ├── attendance/   # Attendance tracking
│   ├── leaves/       # Leave management
│   ├── onboarding/   # Employee onboarding
│   ├── payroll/      # Payroll processing
│   └── reports/      # Analytics & reports
├── sql/              # Database schemas and sample data
├── assets/           # Static assets (CSS, JS, images)
└── uploads/          # File uploads directory
```

## 🔒 Security Features

- **SQL Injection Prevention**: PDO prepared statements
- **XSS Protection**: Input sanitization and output encoding
- **Password Security**: Bcrypt hashing
- **Session Management**: Secure session handling
- **File Upload Validation**: Type and size restrictions
- **Role-Based Access**: Granular permission system

## 📱 Responsive Design

- Mobile-first approach with Bootstrap 5
- Responsive tables with DataTables
- Touch-friendly interface
- Cross-browser compatibility

## 🎨 UI/UX Features

- Modern gradient design
- Interactive charts and graphs
- Real-time notifications
- Intuitive navigation with dropdown menus
- Dark mode support
- Loading states and animations

## 🔧 Customization

### Adding New Modules
1. Create module directory in `modules/`
2. Follow existing module structure
3. Add navigation links in `includes/sidebar.php`
4. Define permissions in database

### Theming
- Modify CSS variables in `includes/header.php`
- Update color schemes and gradients
- Customize Bootstrap components

## 📊 Database Schema

The system uses a normalized MySQL database with 15+ tables:
- `users` - System users and authentication
- `employees` - Employee information
- `departments` - Organizational structure
- `roles` & `permissions` - Access control
- `payroll` - Salary and compensation
- `attendance` - Time tracking
- `leave_applications` - Leave management
- `onboarding_processes` - Employee onboarding

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- 📧 Email: support@hrmanagement.com
- 📖 Documentation: [Wiki](https://github.com/yourusername/hr-management-system/wiki)
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/hr-management-system/issues)

## 👨‍💻 Developer

**Muhammad Rafique** - Full Stack Developer

- 🌐 **Portfolio**: [mr-software.online](https://mr-software.online/)
- 💼 **LinkedIn**: [Muhammad Rafique](https://www.linkedin.com/in/muhammad-rafique-944b05159)
- 🐙 **GitHub**: [@Muhammad9985](https://github.com/Muhammad9985)

## 🙏 Acknowledgments

- Bootstrap team for the amazing CSS framework
- Chart.js for beautiful charts
- Font Awesome for comprehensive icons
- SweetAlert2 for elegant notifications

---

⭐ **Star this repository if you find it helpful!**

Made with ❤️ for modern HR management