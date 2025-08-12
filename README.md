# RIASEC Interest Exploration Tool

**EDUCATIONAL TOOL ONLY - NOT FOR PROFESSIONAL ASSESSMENT**

A modern, full-stack Laravel application for educational exploration of the RIASEC (Holland Code) interest model. This platform provides users with an interactive learning experience about interest types across six domains: Realistic, Investigative, Artistic, Social, Enterprising, and Conventional. **This is strictly an educational tool and should not be used for career counseling or professional assessment purposes.**

## 🚀 **Status: Educational Learning Tool**

This application is a complete educational tool for learning about the RIASEC model. **It is not intended for professional use, career counseling, or psychological assessment.**

## 🎯 **Key Features**

### **User Experience**
- **User Account System**: Registration, login, and personal dashboards for tracking progress
- **Assessment History**: Complete history of all attempts with results and dates
- **Interactive Vue.js Questionnaire**: Modern, responsive interface with real-time progress tracking
- **Auto-Save Functionality**: Responses saved automatically as users progress
- **Session Management**: 24-hour session timeout with UUID-based tracking
- **Mobile Responsive**: Optimized for desktop, tablet, and mobile devices
- **Accessibility**: Full functionality with graceful fallback for JavaScript-disabled browsers
- **Professional UI**: Clean, intuitive design with loading states and user feedback
- **Guest Access**: Full functionality available without registration for one-time users

### **Educational Learning Features**  
- **RIASEC Model Learning**: Educational exploration of Holland's interest framework
- **Domain-Based Learning**: Questions mapped to six interest domains (R-I-A-S-E-C) for educational purposes
- **Educational Results**: Generates three-letter codes for learning purposes only (e.g., ASE, IRC)
- **Learning Feedback**: Educational information about interest types and their characteristics
- **Complete Educational Coverage**: 18 learning templates covering all domain-role combinations

### **Technical Excellence**
- **RESTful API**: Clean endpoints for questionnaire data and response handling
- **Comprehensive Error Handling**: User-friendly 404, 500, session timeout, and validation pages
- **Input Validation**: Strong typing, CSRF protection, and data integrity checks
- **Progressive Enhancement**: Works with and without JavaScript
- **Performance Optimized**: Efficient database queries and optimized asset delivery

### **Administrative Tools**
- **Role-Based Access Control**: Admin and user roles with appropriate permissions
- **Filament Admin Panel**: Full content management system (admin-only access)
- **Question Management**: Create, edit, and organize assessment questions
- **Response Set Configuration**: Flexible answer options (Likert scales, etc.)
- **Feedback Template Editor**: Customize feedback messages for each domain and role
- **User Management**: View and manage user accounts and assessment attempts
- **Assessment Analytics**: Track completion rates and response patterns

## 🛠 **Tech Stack**

### **Backend**
- **Laravel 12** - Modern PHP framework with robust features
- **MySQL/SQLite** - Reliable database with comprehensive migrations
- **Laravel Sail** - Docker-based development environment

### **Frontend**
- **Vue.js 3** - Reactive, component-based user interface
- **Tailwind CSS** - Utility-first styling framework
- **Vite** - Fast build tool and hot module replacement

### **Infrastructure**
- **Docker** - Containerized development and deployment
- **Filament v3** - Admin panel and content management
- **Laravel Sanctum** - API authentication (ready for future expansion)

---

## 📋 **System Requirements**

### **Development Environment**
- Unix-based system (Linux, macOS, WSL2)
- Docker & Docker Compose
- Git

### **Production Environment**
- PHP 8.2+
- Node.js 18+
- MySQL 8.0+ or SQLite
- Web server (Apache/Nginx)

### **Optional**
- Laravel Sail alias for simplified commands
- Redis for caching and sessions (production recommended)

---

## 🚀 **Quick Start**

### **Development Setup**

```bash
# 1. Clone the repository
git clone <repository-url>
cd int-inv

# 2. Copy and configure environment
cp .env.example .env

# 3. Start Docker environment
./vendor/bin/sail up -d

# 4. Install dependencies
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# 5. Setup application
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

# 6. Build frontend assets
./vendor/bin/sail npm run build

# 7. Access the application
# Frontend: http://localhost
# Admin Panel: http://localhost/admin
```

### **Production Deployment**

```bash
# 1. Install dependencies
composer install --optimize-autoloader --no-dev
npm install

# 2. Configure environment
cp .env.example .env
# Edit .env with production database and app settings

# 3. Setup database
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

# 4. Build production assets
npm run build

# 5. Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🎮 **User Guide**

### **Getting Started**

#### **For New Users**
1. **Register**: Create a free account at `/register` to track your assessment history
2. **Login**: Sign in at `/login` with your credentials
3. **Dashboard**: Access your personal dashboard at `/dashboard`

#### **For Guest Users**
- Take assessments immediately without registration
- Results are accessible via direct links but not saved to an account

### **Taking an Assessment**

1. **Start**: Visit the homepage and click "Start Assessment"
2. **Complete**: Answer all questions across multiple pages (auto-saved)
3. **Results**: View your personalized RIASEC code and feedback
4. **History**: Authenticated users can view all past results in their dashboard
5. **Retake**: Option to take the assessment again for comparison

### **Assessment Flow**
```
Homepage (/) 
    ↓ Register/Login or Continue as Guest
    ↓ Click "Start Assessment"
Questionnaire Start (/questionnaire/1/start)
    ↓ Creates attempt & redirects
Interactive Questionnaire (/questionnaire/attempt/{id})
    ↓ Complete all questions
Results & Feedback (/feedback/{id})
    ↓ View RIASEC code & personalized feedback
    ↓ Authenticated users: Return to Dashboard
Dashboard (/dashboard) - View assessment history
```

### **Admin Panel Access**

**Default Accounts:**
- **Admin**: `admin@example.com` / `password` (Full admin access)
- **Test User**: `user@example.com` / `password` (Regular user account)
- **Legacy Admin**: `test@example.com` / `password` (Admin access)

**Admin Features:**
- **Questionnaires**: Manage assessment instruments
- **Questions**: Add/edit questions and link to domains
- **Domains**: Manage the six RIASEC personality types
- **Response Sets**: Configure answer options (Likert scales, etc.)
- **Feedback Templates**: Customize feedback for each domain and role
- **View Attempts**: Monitor assessment completion and analytics

---

## 🔧 **Technical Documentation**

### **Database Structure**

```
questionnaires (1) ──→ questions (6) ──→ domains (6 RIASEC types)
                        ↓
attempts (UUID sessions) ──→ responses ──→ response_options
                        ↓
                   completed_attempts ──→ results_service ──→ feedback
```

### **API Endpoints**

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/` | Homepage with assessment introduction |
| `GET` | `/questionnaire/{id}/start` | Start new assessment attempt |
| `GET` | `/questionnaire/attempt/{id}` | Interactive questionnaire interface |
| `POST` | `/questionnaire/attempt/{id}/complete` | Complete assessment |
| `GET` | `/feedback/{attempt}` | View results and feedback |
| `GET` | `/api/questionnaire` | Get questionnaire data (JSON) |
| `POST` | `/api/save-response` | Save individual response (AJAX) |

### **Key Components**

| Component | Purpose |
|-----------|---------|
| **QuestionnaireAttemptController** | Manages assessment sessions and completion |
| **ResponseController** | Handles individual response saving via API |
| **FeedbackController** | Displays results and personalized feedback |
| **ResultsService** | Calculates RIASEC codes and domain scores |
| **Vue Components** | Interactive frontend (Questionnaire.vue, QuestionnaireQuestion.vue) |

### **Session Management**
- **UUID-based sessions**: Unique identifier for each attempt
- **24-hour expiry**: Automatic session timeout for security
- **Auto-save**: Responses saved in real-time via AJAX
- **Completion tracking**: Prevents modification after completion

---

## 🗃 **Database Content**

The application comes pre-seeded with:
- **1 Complete Learning Tool**: RIASEC Interest Exploration Tool
- **6 Assessment Questions**: Mapped to different RIASEC domains
- **6 RIASEC Domains**: R (Realistic), I (Investigative), A (Artistic), S (Social), E (Enterprising), C (Conventional)
- **5 Response Options**: 5-point Likert scale (Strongly Disagree → Strongly Agree)
- **18 Feedback Templates**: Complete coverage (6 domains × 3 roles: primary, supporting, modulating)

---

## 🔍 **Troubleshooting**

### **Common Issues**

**Frontend not loading:**
```bash
# Rebuild assets
./vendor/bin/sail npm run build
# Check browser console for JavaScript errors
```

**Database connection errors:**
```bash
# Reset database
./vendor/bin/sail artisan migrate:fresh --seed
```

**Session/CSRF token issues:**
```bash
# Clear application cache
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
```

**Assets not found (404 errors):**
```bash
# Ensure assets are built
./vendor/bin/sail npm run build
# Check public/build directory exists
```

### **Error Pages**
The application includes custom error pages for:
- **404**: Page not found with assessment restart options
- **500**: Server errors with reload functionality  
- **Session Expired**: 24-hour timeout with fresh start option
- **Validation Errors**: User-friendly form validation messages

---

## 🚀 **Future Enhancements**

### **Immediate Opportunities**
- **Email Results**: Send RIASEC code and feedback via email
- **Export Options**: PDF generation for results and certificates
- **Profile Management**: Enhanced user profile settings and preferences
- **Assessment Comparison**: Compare results across multiple assessment attempts

### **Advanced Features**
- **Multiple Questionnaires**: Support for different assessment types
- **Custom Domains**: Organization-specific branding and domains
- **Analytics Dashboard**: Comprehensive reporting and insights
- **API Integration**: REST API for third-party integrations
- **Multi-language Support**: Internationalization for global use

### **Scalability Enhancements**
- **Redis Caching**: Improved performance for high-traffic scenarios
- **Queue System**: Background processing for large-scale deployments
- **CDN Integration**: Asset delivery optimization
- **Advanced Security**: Rate limiting, audit trails, and enhanced validation

---

## 📊 **Project Statistics**

- **Lines of Code**: ~15,000+ (PHP, JavaScript, Vue, CSS)
- **Database Tables**: 12 core tables with relationships
- **Vue Components**: 3 interactive components
- **API Endpoints**: 7 user-facing routes + admin routes
- **Test Coverage**: Full end-to-end validation
- **Error Handling**: 4 custom error pages + comprehensive validation

---

## 🤝 **Contributing**

This is a production-ready MVP. For enhancements:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Run tests (`./vendor/bin/sail artisan test`)
4. Commit changes (`git commit -m 'Add new feature'`)
5. Push to branch (`git push origin feature/new-feature`)
6. Open a Pull Request

---

## 📄 **License**

This project is open source. See the LICENSE file for details.

---

## 🙏 **Acknowledgments**

- **John Holland** - Creator of the RIASEC career interest model
- **Laravel Community** - Framework and ecosystem
- **Filament** - Admin panel solution
- **Vue.js Team** - Frontend framework
- **Tailwind CSS** - Styling framework

---

## 📞 **Support**

For questions, issues, or enhancements:
- Check the troubleshooting section above
- Review error logs in `storage/logs/`
- Ensure all dependencies are properly installed
- Verify database seeding completed successfully

**This application is production-ready and fully functional.** 🎉
