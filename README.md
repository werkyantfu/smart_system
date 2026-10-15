# Smart School Management System

Complete school management system for Ethiopian schools.

## Quick Start

### Backend Setup
- cd backend
- composer install
- cp .env.example .env
- php artisan key:generate
- touch database/database.sqlite
- php artisan migrate --seed
- php artisan serve

### Frontend Setup
- cd frontend
- npm install
- npm run dev

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13 |
| Language | PHP 8.5 |
| Frontend | Vue 3.5 |
| State | Pinia 4 |
| Styling | Tailwind CSS 4 |
| Build | Vite 8 |
| Auth | Laravel Sanctum |
| RBAC | Spatie Permission |

## Features

- 8 Roles
- 36 Permissions
- Role-Based Access Control
- Student Management
- Teacher Management
- Class Management
- Subject Management
- Attendance Tracking
- Marks Management
- Fees and Payments
- Library Management
- Announcements
- Reports

## Test Users

Password: password

| Role | Email |
|------|-------|
| Super Admin | super@ssms.et |
| Admin | admin@sunrise.et |
| Teacher | teacher@sunrise.et |
| Student | student@sunrise.et |

## License

MIT License
