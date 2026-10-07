# 🎓 Smart School Management System (SSMS)

ስማርት ትምህርት ቤት ማኔጅመንት ሲስተም — የትምህርት ቤቶችን ሥራ በዲጂታል መንገድ ለማስተዳደር የተዘጋጀ ዘመናዊ ሲስተም።

A modern, web-based school management system for private and public schools in Ethiopia. Built with **Laravel 13** + **Vue 3** + **MySQL**.

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Architecture](#-architecture)
- [Folder Structure](#-folder-structure)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [API Documentation](#-api-documentation)
- [Database Schema](#-database-schema)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

## 🎯 Overview

The **Smart School Management System (SSMS)** is an enterprise-grade platform designed to digitize and automate school operations. It handles everything from student registration to fee collection, attendance tracking to grade management, with SMS notifications and parent portals.

### 🎯 Purpose

- 📚 **Digitize** all school administrative work
- ⏱️ **Save time** with automated workflows
- 📊 **Provide insights** through analytics and reports
- 📱 **Enable communication** between school, teachers, and parents
- 🔒 **Ensure security** with role-based access control

### 🎯 Target Users

- 🏫 Private schools
- 🏛️ Public schools
- 🎓 Kindergartens, Primary, Secondary, Preparatory
- 📚 Tutorial centers

---

## ✨ Features

### 🎓 Student Management
- ✅ Student registration with unique ID generation (STU-2026-0001)
- ✅ Bulk import from Excel/CSV
- ✅ Student lifecycle tracking (enrolled → active → transferred → graduated)
- ✅ ID card generation (PDF)
- ✅ Photo upload and management

### 👨‍🏫 Teacher Management
- ✅ Teacher registration with qualifications
- ✅ Subject and class assignments
- ✅ Workload tracking
- ✅ Performance evaluation
- ✅ Salary management (private schools)

### 📅 Attendance Management
- ✅ Daily attendance tracking
- ✅ Period-based attendance
- ✅ Bulk marking
- ✅ Automatic SMS notifications to parents
- ✅ Monthly attendance reports
- ✅ Absence justification tracking

### 📝 Examination & Grade Management
- ✅ Ethiopian grading system (A: 90-100, B: 80-89, C: 70-79, D: 60-69, F: <60)
- ✅ Multiple exam types (quiz, midterm, final, assignment)
- ✅ Automatic GPA calculation
- ✅ Class rank computation
- ✅ Report card generation (PDF)
- ✅ Term and annual results

### 💰 Fee Management
- ✅ Flexible fee structures (tuition, transport, cafeteria, library, uniform)
- ✅ Monthly / quarterly / annual payment options
- ✅ Online payment (Telebirr, CBE Birr)
- ✅ Cash payment recording
- ✅ Receipt generation (PDF)
- ✅ Automatic SMS reminders for overdue fees
- ✅ Discount and scholarship management
- ✅ Outstanding balance reports

### 👨‍👩‍👧 Parent Portal
- ✅ Secure parent login (phone-based)
- ✅ View child's grades, attendance, schedule
- ✅ Pay fees online
- ✅ Receive SMS/email notifications
- ✅ View announcements

### 📢 Communication Module
- ✅ SMS notifications (AfroMessage, Ethio Telecom)
- ✅ Email notifications
- ✅ Bulk SMS sending
- ✅ Targeted announcements (all, teachers, students, parents)
- ✅ Message templates

### 📚 Library Management
- ✅ Book catalog with ISBN, author, category
- ✅ Borrow/return tracking
- ✅ Due date notifications
- ✅ Fine calculation for late returns
- ✅ Search and filter
- ✅ Stock management

### 📅 Timetable Management
- ✅ Weekly class schedules
- ✅ Period assignment to subjects and teachers
- ✅ Conflict detection
- ✅ Student and teacher view

### 📊 Reports & Analytics
- ✅ Enrollment statistics (by grade, gender, section)
- ✅ Performance trends
- ✅ Financial summaries
- ✅ Attendance reports
- ✅ Export to Excel/PDF
- ✅ Interactive dashboards with charts

---

## 🛠️ Tech Stack

### Backend
| Technology | Version | Purpose |
|-----------|---------|---------|
| **PHP** | 8.3+ | Server-side language |
| **Laravel** | 13.x | Web framework |
| **Laravel Sanctum** | 4.x | API authentication |
| **Spatie Permission** | 8.x | Role-based access control |
| **DomPDF** | 3.x | PDF generation |
| **Maatwebsite Excel** | 4.x | Excel import/export |
| **MySQL** | 8.4 | Database |
| **Redis** | 7.x | Cache & queue |

### Frontend
| Technology | Version | Purpose |
|-----------|---------|---------|
| **Vue.js** | 3.5+ | JavaScript framework |
| **TypeScript** | 5.x | Type safety |
| **Vite** | 8.x | Build tool |
| **Tailwind CSS** | 4.x | Styling |
| **Pinia** | 2.x | State management |
| **Vue Router** | 4.x | Routing |
| **Axios** | 1.x | HTTP client |
| **Chart.js** | 4.x | Charts |

### Integrations
- **Telebirr** — Mobile money payment
- **CBE Birr** — Bank payment
- **AfroMessage** — SMS gateway
- **SMTP** — Email service

### DevOps
- **Git** — Version control
- **GitHub** — Code hosting
- **Nginx / Apache** — Web server
- **Docker** — Containerization (optional)
- **Ubuntu** 22.04+ / 24.04 LTS

---

## 🏗️ Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────┐
│              CLIENT APPLICATIONS                     │
│  [Admin] [Teacher] [Student] [Parent]               │
└──────────────────────┬──────────────────────────────┘
                       │ HTTPS / JSON API
                       ▼
┌─────────────────────────────────────────────────────┐
│           LARAVEL 13 API GATEWAY                     │
│  [Auth] [RBAC] [Rate Limiter] [CORS/CSRF]           │
└──────────────────────┬──────────────────────────────┘
                       │
        ┌──────────────┼──────────────┐
        ▼              ▼              ▼
  ┌──────────┐  ┌──────────┐  ┌──────────────┐
  │ Business │  │ Workers  │  │  External    │
  │ Services │  │ (Queue)  │  │  Services    │
  └────┬─────┘  └────┬─────┘  └──────┬───────┘
       │             │                │
       └─────────────┼────────────────┘
                     ▼
        ┌──────────────────────────┐
        │   MySQL + Redis          │
        └──────────────────────────┘
```

### Detailed Architecture

See [SRS.md](./SRS.md) Section 2.2 for full architecture diagrams.

---

## 📁 Folder Structure

```
smart-school-management-system/
│
├── 📁 backend/                     ← Laravel 13 API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/    ← API Controllers
│   │   │   ├── Middleware/         ← Auth, RBAC, Tenant
│   │   │   └── Requests/           ← Validation
│   │   ├── Models/                 ← Eloquent Models
│   │   ├── Services/               ← Business Logic
│   │   └── Jobs/                   ← Queue Jobs
│   ├── database/
│   │   ├── migrations/             ← 16 Migrations
│   │   ├── seeders/                ← 7 Seeders
│   │   └── factories/              ← Test Factories
│   ├── routes/
│   │   └── api.php                 ← API Routes
│   ├── config/                     ← Configuration
│   ├── tests/                      ← PHPUnit Tests
│   ├── .env                        ← Environment
│   └── composer.json
│
├── 📁 frontend/                    ← Vue 3 SPA
│   ├── src/
│   │   ├── components/             ← Reusable Components
│   │   ├── views/                  ← Pages
│   │   ├── stores/                 ← Pinia Stores
│   │   ├── services/               ← API Services
│   │   ├── router/                 ← Vue Router
│   │   ├── composables/            ← Composables
│   │   ├── assets/                 ← Images, Fonts
│   │   ├── App.vue
│   │   └── main.ts
│   ├── public/
│   ├── vite.config.ts
│   └── package.json
│
├── 📁 diagrams/                    ← Architecture Diagrams
│   ├── architecture.png
│   ├── erd-diagram.png
│   ├── use-case.png
│   └── gantt-chart.png
│
├── 📁 .vscode/                     ← VS Code Settings
│
├── 📄 SRS.md                       ← Software Requirements
├── 📄 ERD.md                       ← Database Design
├── 📄 API-Contracts.md             ← API Documentation
├── 📄 README.md                    ← This file
├── 📄 User-Manual-AM.md            ← የተጠቃሚ መመሪያ (አማርኛ)
├── 📄 User-Manual-EN.md            ← User Manual (English)
├── 📄 CHANGELOG.md                 ← Version History
├── 📄 CONTRIBUTING.md              ← Contribution Guide
├── 📄 LICENSE                      ← MIT License
├── 📄 .gitignore
└── 📄 .gitattributes
```

---

## 🚀 Installation

### Prerequisites

- **PHP** 8.3 or higher
- **Composer** 2.x
- **Node.js** 20.x or higher
- **npm** 10.x or higher
- **MySQL** 8.0 or higher
- **Git**
- **curl**

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-org/smart-school-management-system.git
cd smart-school-management-system
```

### Step 2: Backend Setup

```bash
cd backend

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env with your database credentials
nano .env
```

**Required `.env` settings:**

```env
APP_NAME="Smart School Management"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_school_db
DB_USERNAME=school_user
DB_PASSWORD=YourStrongPassword

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost

# SMS (optional)
AFROMESSAGE_API_KEY=your_api_key
AFROMESSAGE_SENDER=YourSchool

# Payment (optional)
TELEBIRR_APP_ID=your_app_id
TELEBIRR_APP_KEY=your_app_key
```

### Step 3: Database Setup

```bash
# Create database and user in MySQL
sudo mysql

CREATE DATABASE smart_school_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'school_user'@'localhost' IDENTIFIED BY 'YourStrongPassword';
GRANT ALL PRIVILEGES ON smart_school_db.* TO 'school_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations
php artisan migrate

# Seed initial data (roles, permissions, admin user)
php artisan db:seed
```

### Step 4: Frontend Setup

```bash
cd ../frontend

# Install Node dependencies
npm install

# Install additional packages
npm install tailwindcss @tailwindcss/vite axios pinia vue-router lucide-vue-next
```

### Step 5: Start the Servers

**Terminal 1 — Backend:**

```bash
cd backend
php artisan serve
# → http://localhost:8000
```

**Terminal 2 — Frontend:**

```bash
cd frontend
npm run dev
# → http://localhost:5173
```

### Step 6: Access the Application

- **Frontend:** http://localhost:5173
- **Backend API:** http://localhost:8000/api
- **Default Admin:**
  - Email: `admin@sunrise.et`
  - Password: `password`

⚠️ **Change the default password immediately after first login!**

---

## ⚙️ Configuration

### Default Users (after seeding)

| Role | Email | Password |
|------|-------|----------|
| **Super Admin** | super@ssms.et | password |
| **School Admin** | admin@sunrise.et | password |
| **Director** | director@sunrise.et | password |
| **Teacher** | teacher@sunrise.et | password |
| **Student** | student@sunrise.et | password |
| **Parent** | parent@sunrise.et | password |
| **Accountant** | accountant@sunrise.et | password |
| **Librarian** | librarian@sunrise.et | password |

### Environment Variables

See `backend/.env.example` for all available options.

### Queue Configuration

For production, use a queue worker:

```bash
php artisan queue:work --daemon
```

Or use Supervisor for process management.

---

## 📖 Usage

### Admin Dashboard

1. **Login** at http://localhost:5173/login
2. **Register Students** → Students → Add Student
3. **Manage Teachers** → Teachers → Add Teacher
4. **Set Up Classes** → Classes → Create Class
5. **Configure Fees** → Fees → Create Fee Structure
6. **View Reports** → Reports → Select Report Type

### Teacher Portal

1. **Login** as teacher
2. **Mark Attendance** → Attendance → Select Class → Mark
3. **Enter Marks** → Marks → Select Subject & Exam → Enter Scores
4. **View Schedule** → Timetable → My Schedule

### Parent Portal

1. **Login** as parent (phone-based)
2. **View Child's Grades** → Grades
3. **Pay Fees** → Fees → Pay Now
4. **View Announcements** → Announcements

### Student Portal

1. **Login** as student
2. **View Grades** → Grades
3. **View Timetable** → Schedule
4. **View Library Loans** → Library

---

## 📚 API Documentation

Full API documentation is available in [API-Contracts.md](./API-Contracts.md).

### Quick Reference

| Base URL | `http://localhost:8000/api` |
|----------|----------------------------|
| **Auth** | Bearer Token (Sanctum) |
| **Format** | JSON |
| **Rate Limit** | 60 req/min (public), 120 req/min (auth) |

### Example Request

```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "admin@sunrise.et",
    "password": "password"
  }'

# Get students (with token)
curl -X GET http://localhost:8000/api/students \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### 60 API Endpoints

- **Authentication** (5 endpoints)
- **User Management** (5 endpoints)
- **Students** (7 endpoints)
- **Teachers** (5 endpoints)
- **Parents** (3 endpoints)
- **Classes** (3 endpoints)
- **Subjects** (2 endpoints)
- **Attendance** (3 endpoints)
- **Exams** (2 endpoints)
- **Marks** (3 endpoints)
- **Fees** (3 endpoints)
- **Payments** (5 endpoints)
- **Library** (4 endpoints)
- **Timetables** (2 endpoints)
- **Announcements** (2 endpoints)
- **Reports** (3 endpoints)
- **Dashboard** (3 endpoints)

---

## 🗄️ Database Schema

**Database Name:** `smart_school_db`
**Total Tables:** 16
**Total Relationships:** 24

### Core Tables

| # | Table | Purpose |
|---|-------|---------|
| 1 | `schools` | School information |
| 2 | `users` | All system users |
| 3 | `students` | Student records |
| 4 | `teachers` | Teacher records |
| 5 | `parents` | Parent/guardian records |
| 6 | `classes` | Class definitions |
| 7 | `subjects` | Subject definitions |
| 8 | `attendance` | Attendance records |
| 9 | `marks` | Exam marks |
| 10 | `exams` | Exam definitions |
| 11 | `fees` | Fee definitions |
| 12 | `payments` | Payment transactions |
| 13 | `library_books` | Book catalog |
| 14 | `book_loans` | Book loans |
| 15 | `timetables` | Class schedules |
| 16 | `announcements` | School announcements |

**Full schema:** [ERD.md](./ERD.md)

---

## 🧪 Testing

### Backend Tests (PHPUnit)

```bash
cd backend

# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### Frontend Tests (Vitest)

```bash
cd frontend

# Run tests
npm run test

# Run with UI
npm run test:ui

# Coverage
npm run test:coverage
```

### Test Coverage Goal

- **Backend:** ≥ 70%
- **Frontend:** ≥ 60%

---

## 🚀 Deployment

### Production Build

```bash
# Backend
cd backend
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Frontend
cd ../frontend
npm run build
# Output in dist/
```

### Server Configuration (Nginx)

```nginx
server {
    listen 80;
    server_name ssms.yourschool.et;
    root /var/www/ssms/frontend/dist;
    index index.html;

    # Frontend SPA
    location / {
        try_files $uri $uri/ /index.html;
    }

    # Backend API
    location /api {
        alias /var/www/ssms/backend/public;
        try_files $uri @laravel;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $request_filename;
            include fastcgi_params;
        }
    }

    location @laravel {
        rewrite /api/(.*)$ /index.php?/$1 last;
    }
}
```

### Docker (Optional)

```bash
docker-compose up -d
```

---

## 🤝 Contributing

We welcome contributions! See [CONTRIBUTING.md](./CONTRIBUTING.md) for details.

### Quick Steps

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Code Style

- **PHP:** PSR-12 (enforced by Laravel Pint)
- **JavaScript/TypeScript:** ESLint + Prettier
- **Vue:** Vue 3 Style Guide

---

## 📄 License

This project is licensed under the **MIT License** — see [LICENSE](./LICENSE) for details.

---

## 📞 Contact

- 📧 **Email:** info@smart-school.et
- 📱 **Phone:** +251-xxxxxxx
- 🌐 **Website:** https://smart-school.et
- 🐙 **GitHub:** https://github.com/your-org/smart-school-management-system

---

## 🙏 Acknowledgments

- **Laravel** community
- **Vue.js** community
- **Ethiopian Ministry of Education** for curriculum standards
- All contributors and testers

---

## 📊 Project Status

| Component | Status |
|-----------|--------|
| **Documentation** | ✅ Complete |
| **Backend API** | 🟡 In Progress |
| **Frontend SPA** | 🟡 In Progress |
| **Database** | ✅ Designed |
| **Testing** | ⏳ Pending |
| **Deployment** | ⏳ Pending |

---

## 🗺️ Roadmap

### v1.0 (Current)
- ✅ Core documentation
- ✅ Database design
- ✅ API contracts
- 🟡 Backend API development
- 🟡 Frontend development

### v1.1 (Next)
- ⏳ SMS integration
- ⏳ Telebirr payment
- ⏳ Report cards (PDF)
- ⏳ Parent mobile app

### v2.0 (Future)
- ⏳ Multi-language (Amharic)
- ⏳ Mobile apps (iOS/Android)
- ⏳ AI-powered analytics
- ⏳ Offline mode

---

**© 2026 Smart School Management System. All rights reserved.**

**Made with ❤️ in Ethiopia 🇪🇹**