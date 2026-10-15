# API Contracts

Version: v1
Base URL: http://localhost:8000/api
Auth: Bearer token

## Endpoints

### Authentication
- POST /auth/login
- POST /auth/register
- GET /auth/me
- POST /auth/logout

### Dashboard
- GET /dashboard

### Students
- GET /students
- POST /students
- GET /students/{id}
- PUT /students/{id}
- DELETE /students/{id}

### Teachers
- GET /teachers
- POST /teachers
- GET /teachers/{id}
- PUT /teachers/{id}
- DELETE /teachers/{id}

### Classes
- GET /classes
- POST /classes
- PUT /classes/{id}
- DELETE /classes/{id}

### Subjects
- GET /subjects
- POST /subjects

### Attendance
- GET /attendance
- POST /attendance

### Marks
- GET /marks
- POST /marks

### Fees
- GET /fees
- POST /fees

### Payments
- GET /payments
- POST /payments

### Announcements
- GET /announcements
- POST /announcements

### Reports
- GET /reports/dashboard
- GET /reports/students
- GET /reports/fees

### Library
- GET /library/books
- POST /library/books
- GET /library/loans
- POST /library/borrow
- POST /library/return/{id}

### Users
- GET /users
- POST /users
- GET /users/{id}
- PUT /users/{id}
- DELETE /users/{id}

### Schools
- GET /schools
- POST /schools

## Test Users

Password: password

| Role | Email |
|------|-------|
| Super Admin | super@ssms.et |
| Admin | admin@sunrise.et |
| Teacher | teacher@sunrise.et |
| Student | student@sunrise.et |

## Status Codes

- 200 OK
- 201 Created
- 401 Unauthorized
- 403 Forbidden
- 404 Not Found
- 422 Validation Error
- 500 Server Error

Copyright 2026
