# API Contracts
## Smart School Management System

**Document Version:** 1.0
**Release Date:** October 2026
**Base URL:** `http://localhost:8000/api`
**Authentication:** Laravel Sanctum (Bearer Token)
**Format:** JSON (RFC 8259)
**Error Format:** RFC 7807 (Problem Details)
**API Version:** v1

---

## Table of Contents

1. [API Overview](#1-api-overview)
2. [Authentication Endpoints](#2-authentication-endpoints)
3. [User Management Endpoints](#3-user-management-endpoints)
4. [Student Endpoints](#4-student-endpoints)
5. [Teacher Endpoints](#5-teacher-endpoints)
6. [Parent Endpoints](#6-parent-endpoints)
7. [Class Endpoints](#7-class-endpoints)
8. [Subject Endpoints](#8-subject-endpoints)
9. [Attendance Endpoints](#9-attendance-endpoints)
10. [Exam Endpoints](#10-exam-endpoints)
11. [Marks Endpoints](#11-marks-endpoints)
12. [Fee Endpoints](#12-fee-endpoints)
13. [Payment Endpoints](#13-payment-endpoints)
14. [Library Endpoints](#14-library-endpoints)
15. [Timetable Endpoints](#15-timetable-endpoints)
16. [Announcement Endpoints](#16-announcement-endpoints)
17. [Report Endpoints](#17-report-endpoints)
18. [Dashboard Endpoints](#18-dashboard-endpoints)
19. [Common Response Codes](#19-common-response-codes)
20. [Pagination, Filtering & Sorting](#20-pagination-filtering--sorting)

---

## 1. API Overview

### 1.1 Base URL

```
Development:  http://localhost:8000/api
Production:   https://api.smart-school.et/api
```

### 1.2 Authentication

All protected endpoints require a Bearer token in the `Authorization` header:

```
Authorization: Bearer {token}
```

### 1.3 Request Headers

| Header | Value | Required |
|--------|-------|----------|
| `Accept` | `application/json` | Yes |
| `Content-Type` | `application/json` | Yes (for POST/PUT) |
| `Authorization` | `Bearer {token}` | Yes (protected) |

### 1.4 Standard Success Response

```json
{
  "success": true,
  "message": "Operation successful",
  "data": { }
}
```

### 1.5 Standard Error Response (RFC 7807)

```json
{
  "type": "https://api.smart-school.et/errors/validation",
  "title": "Validation Error",
  "status": 422,
  "detail": "The given data was invalid.",
  "instance": "/api/students",
  "errors": {
    "email": ["The email field is required."],
    "name": ["The name must be at least 3 characters."]
  }
}
```

### 1.6 Rate Limiting

- **Public endpoints:** 60 requests/minute per IP
- **Authenticated endpoints:** 120 requests/minute per user
- **Auth endpoints (login):** 5 attempts/minute per IP

**Headers returned:**

```
X-RateLimit-Limit: 120
X-RateLimit-Remaining: 115
Retry-After: 60
```

### 1.7 Pagination Format

```json
{
  "success": true,
  "data": [ ... ],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 250,
    "last_page": 17,
    "from": 1,
    "to": 15
  },
  "links": {
    "first": "/api/students?page=1",
    "prev": null,
    "next": "/api/students?page=2",
    "last": "/api/students?page=17"
  }
}
```

---

## 2. Authentication Endpoints

### 2.1 POST `/api/auth/login`

**Description:** Authenticate a user and return a bearer token.

**Access:** Public

**Request Body:**

```json
{
  "email": "admin@sunrise.et",
  "password": "SecurePass123!",
  "device_name": "web-browser"
}
```

**Validation Rules:**

| Field | Rules |
|-------|-------|
| email | required, email, exists:users,email |
| password | required, string, min:8 |
| device_name | optional, string, max:255 |

**Success Response (200):**

```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Abebe Kebede",
      "email": "admin@sunrise.et",
      "role": "admin",
      "school_id": 1
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz123456",
    "token_type": "Bearer",
    "expires_at": "2026-11-06T12:00:00Z"
  }
}
```

**Error Response (401):**

```json
{
  "success": false,
  "message": "Invalid credentials",
  "error": "AUTH_FAILED"
}
```

---

### 2.2 POST `/api/auth/logout`

**Description:** Revoke the current access token.

**Access:** Protected (`auth:sanctum`)

**Request Body:** None

**Success Response (200):**

```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

### 2.3 GET `/api/auth/me`

**Description:** Get the authenticated user's profile.

**Access:** Protected (`auth:sanctum`)

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Abebe Kebede",
    "email": "admin@sunrise.et",
    "phone": "+251911234567",
    "role": "admin",
    "school": {
      "id": 1,
      "name": "Sunrise Academy",
      "logo_url": "/storage/logos/sunrise.png"
    },
    "permissions": ["student.create", "student.edit", "fee.view"],
    "created_at": "2026-09-01T08:00:00Z"
  }
}
```

---

### 2.4 POST `/api/auth/forgot-password`

**Description:** Send a password reset link to the user's email.

**Access:** Public

**Request Body:**

```json
{
  "email": "admin@sunrise.et"
}
```

**Success Response (200):**

```json
{
  "success": true,
  "message": "Password reset link sent to your email"
}
```

---

### 2.5 POST `/api/auth/reset-password`

**Description:** Reset the user's password using the token from email.

**Access:** Public

**Request Body:**

```json
{
  "token": "abc123def456",
  "email": "admin@sunrise.et",
  "password": "NewSecurePass123!",
  "password_confirmation": "NewSecurePass123!"
}
```

**Success Response (200):**

```json
{
  "success": true,
  "message": "Password reset successfully"
}
```

---

## 3. User Management Endpoints

### 3.1 GET `/api/users`

**Description:** List all users in the authenticated user's school.

**Access:** Protected (`role:admin,director`)

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| role | string | Filter by role (admin, teacher, ...) |
| is_active | boolean | Filter by active status |
| search | string | Search by name or email |
| per_page | integer | Records per page (default: 15) |
| page | integer | Page number |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Abebe Kebede",
      "email": "admin@sunrise.et",
      "role": "admin",
      "is_active": true,
      "created_at": "2026-09-01T08:00:00Z"
    },
    {
      "id": 2,
      "name": "Sara Tesfaye",
      "email": "teacher@sunrise.et",
      "role": "teacher",
      "is_active": true,
      "created_at": "2026-09-02T08:00:00Z"
    }
  ],
  "meta": { }
}
```

---

### 3.2 POST `/api/users`

**Description:** Create a new user.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "name": "Yohannes Bekele",
  "email": "yohannes@sunrise.et",
  "password": "SecurePass123!",
  "phone": "+251922345678",
  "role": "teacher",
  "is_active": true
}
```

**Validation Rules:**

| Field | Rules |
|-------|-------|
| name | required, string, min:3, max:255 |
| email | required, email, unique:users,email |
| password | required, min:8, confirmed |
| role | required, in:admin,director,teacher,student,parent,accountant,librarian |
| phone | optional, string, max:20 |

**Success Response (201):**

```json
{
  "success": true,
  "message": "User created successfully",
  "data": {
    "id": 5,
    "name": "Yohannes Bekele",
    "email": "yohannes@sunrise.et",
    "role": "teacher",
    "is_active": true
  }
}
```

---

### 3.3 GET `/api/users/{id}`

**Description:** Get a specific user's details.

**Access:** Protected (`role:admin,director`)

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "id": 2,
    "name": "Sara Tesfaye",
    "email": "teacher@sunrise.et",
    "role": "teacher",
    "phone": "+251922345678",
    "is_active": true,
    "created_at": "2026-09-02T08:00:00Z"
  }
}
```

---

### 3.4 PUT `/api/users/{id}`

**Description:** Update a user's details.

**Access:** Protected (`role:admin`)

**Request Body:** Same as POST (all fields optional except email uniqueness)

**Success Response (200):**

```json
{
  "success": true,
  "message": "User updated successfully",
  "data": { }
}
```

---

### 3.5 DELETE `/api/users/{id}`

**Description:** Soft delete a user.

**Access:** Protected (`role:admin`)

**Success Response (200):**

```json
{
  "success": true,
  "message": "User deleted successfully"
}
```

---

## 4. Student Endpoints

### 4.1 GET `/api/students`

**Description:** List all students.

**Access:** Protected (`role:admin,director,teacher,accountant`)

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| grade_level | integer | Filter by grade (1-12) |
| section | string | Filter by section |
| status | string | enrolled, active, transferred, graduated |
| search | string | Search by name, student_id, or guardian_phone |
| per_page | integer | Records per page |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "student_id": "STU-2026-0001",
      "first_name": "Sara",
      "last_name": "Kebede",
      "gender": "female",
      "date_of_birth": "2010-05-15",
      "grade_level": 9,
      "section": "A",
      "status": "active",
      "guardian_name": "Abebe Kebede",
      "guardian_phone": "+251911234567",
      "photo_url": "/storage/students/1.jpg"
    }
  ],
  "meta": { }
}
```

---

### 4.2 POST `/api/students`

**Description:** Register a new student.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "first_name": "Sara",
  "last_name": "Kebede",
  "date_of_birth": "2010-05-15",
  "gender": "female",
  "address": "Addis Ababa, Bole",
  "guardian_name": "Abebe Kebede",
  "guardian_phone": "+251911234567",
  "grade_level": 9,
  "section": "A",
  "enrollment_date": "2026-09-01"
}
```

**Validation Rules:**

| Field | Rules |
|-------|-------|
| first_name | required, string, max:100 |
| last_name | required, string, max:100 |
| date_of_birth | required, date, before:today |
| gender | required, in:male,female |
| guardian_name | required, string, max:255 |
| guardian_phone | required, string, max:20 |
| grade_level | required, integer, between:1,12 |
| section | optional, string, max:10 |
| enrollment_date | required, date |

**Success Response (201):**

```json
{
  "success": true,
  "message": "Student registered successfully",
  "data": {
    "id": 1,
    "student_id": "STU-2026-0001",
    "first_name": "Sara",
    "last_name": "Kebede",
    "grade_level": 9,
    "section": "A"
  }
}
```

---

### 4.3 GET `/api/students/{id}`

**Description:** Get a specific student's details.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "student_id": "STU-2026-0001",
    "first_name": "Sara",
    "last_name": "Kebede",
    "date_of_birth": "2010-05-15",
    "gender": "female",
    "grade_level": 9,
    "section": "A",
    "status": "active",
    "guardian": {
      "name": "Abebe Kebede",
      "phone": "+251911234567"
    },
    "class": {
      "id": 1,
      "name": "Grade 9A"
    },
    "attendance_summary": {
      "present": 45,
      "absent": 3,
      "late": 2
    },
    "recent_marks": [
      {
        "subject": "Mathematics",
        "score": 95.5,
        "grade": "A"
      }
    ]
  }
}
```

---

### 4.4 PUT `/api/students/{id}`

**Description:** Update a student's details.

**Access:** Protected (`role:admin`)

**Request Body:** Same as POST

**Success Response (200):**

```json
{
  "success": true,
  "message": "Student updated successfully",
  "data": { }
}
```

---

### 4.5 DELETE `/api/students/{id}`

**Description:** Soft delete a student.

**Access:** Protected (`role:admin`)

**Success Response (200):**

```json
{
  "success": true,
  "message": "Student deleted successfully"
}
```

---

### 4.6 POST `/api/students/import`

**Description:** Bulk import students from Excel/CSV.

**Access:** Protected (`role:admin`)

**Request:** `multipart/form-data`

| Field | Type | Description |
|-------|------|-------------|
| file | file | Excel (.xlsx) or CSV (.csv) |

**Success Response (200):**

```json
{
  "success": true,
  "message": "50 students imported successfully",
  "data": {
    "imported": 50,
    "failed": 2,
    "errors": [
      { "row": 12, "error": "Invalid email format" }
    ]
  }
}
```

---

### 4.7 GET `/api/students/export`

**Description:** Export students list as Excel.

**Access:** Protected (`role:admin`)

**Query Parameters:** Same as GET /students

**Success Response:** Binary Excel file download

```
Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
Content-Disposition: attachment; filename="students-2026-10-07.xlsx"
```

---

## 5. Teacher Endpoints

### 5.1 GET `/api/teachers`

**Description:** List all teachers.

**Access:** Protected (`role:admin,director`)

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| status | string | active, on_leave, terminated |
| specialization | string | Filter by subject |
| search | string | Search by name or employee_id |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "employee_id": "TCH-2026-001",
      "name": "Sara Tesfaye",
      "qualification": "MSc Mathematics",
      "specialization": "Mathematics",
      "hire_date": "2020-09-01",
      "status": "active"
    }
  ]
}
```

---

### 5.2 POST `/api/teachers`

**Description:** Register a new teacher.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "name": "Yohannes Bekele",
  "email": "yohannes@sunrise.et",
  "password": "SecurePass123!",
  "phone": "+251922345678",
  "qualification": "BSc Physics",
  "specialization": "Physics",
  "hire_date": "2024-09-01",
  "salary": 15000.00
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Teacher registered successfully",
  "data": {
    "id": 5,
    "employee_id": "TCH-2026-005",
    "name": "Yohannes Bekele"
  }
}
```

---

### 5.3 GET `/api/teachers/{id}`

**Description:** Get a specific teacher's details.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "employee_id": "TCH-2026-001",
    "name": "Sara Tesfaye",
    "qualification": "MSc Mathematics",
    "specialization": "Mathematics",
    "classes": [
      { "id": 1, "name": "Grade 9A" },
      { "id": 2, "name": "Grade 10A" }
    ],
    "subjects": [
      { "id": 1, "name": "Mathematics" }
    ]
  }
}
```

---

### 5.4 PUT `/api/teachers/{id}`

**Description:** Update a teacher's details.

**Access:** Protected (`role:admin`)

**Success Response (200):**

```json
{
  "success": true,
  "message": "Teacher updated successfully"
}
```

---

### 5.5 DELETE `/api/teachers/{id}`

**Description:** Soft delete a teacher.

**Access:** Protected (`role:admin`)

**Success Response (200):**

```json
{
  "success": true,
  "message": "Teacher deleted successfully"
}
```

---

## 6. Parent Endpoints

### 6.1 GET `/api/parents`

**Description:** List all parents.

**Access:** Protected (`role:admin,director`)

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Abebe Kebede",
      "phone": "+251911234567",
      "relation": "father",
      "occupation": "Engineer",
      "children_count": 2
    }
  ]
}
```

---

### 6.2 POST `/api/parents`

**Description:** Register a new parent.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "name": "Abebe Kebede",
  "email": "abebe@example.et",
  "phone": "+251911234567",
  "relation": "father",
  "occupation": "Engineer",
  "address": "Addis Ababa"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Parent registered successfully",
  "data": {
    "id": 1,
    "name": "Abebe Kebede"
  }
}
```

---

### 6.3 GET `/api/parents/{id}/children`

**Description:** Get a parent's children.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "student_id": "STU-2026-0001",
      "first_name": "Sara",
      "last_name": "Kebede",
      "grade_level": 9,
      "section": "A"
    }
  ]
}
```

---

## 7. Class Endpoints

### 7.1 GET `/api/classes`

**Description:** List all classes.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Grade 9A",
      "grade_level": 9,
      "section": "A",
      "capacity": 40,
      "students_count": 35,
      "homeroom_teacher": "Sara Tesfaye"
    }
  ]
}
```

---

### 7.2 POST `/api/classes`

**Description:** Create a new class.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "name": "Grade 9A",
  "grade_level": 9,
  "section": "A",
  "capacity": 40,
  "teacher_id": 1
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Class created successfully",
  "data": { "id": 1, "name": "Grade 9A" }
}
```

---

### 7.3 GET `/api/classes/{id}/students`

**Description:** Get students in a class.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "student_id": "STU-2026-0001",
      "first_name": "Sara",
      "last_name": "Kebede"
    }
  ]
}
```

---

## 8. Subject Endpoints

### 8.1 GET `/api/subjects`

**Description:** List all subjects.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Mathematics",
      "code": "MATH101",
      "grade_level": 9,
      "credit_hours": 4
    }
  ]
}
```

---

### 8.2 POST `/api/subjects`

**Description:** Create a new subject.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "name": "Mathematics",
  "code": "MATH101",
  "grade_level": 9,
  "credit_hours": 4
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Subject created successfully"
}
```

---

## 9. Attendance Endpoints

### 9.1 GET `/api/attendance`

**Description:** List attendance records.

**Access:** Protected (`role:admin,teacher`)

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| class_id | integer | Filter by class |
| date | date | Filter by date (YYYY-MM-DD) |
| student_id | integer | Filter by student |
| status | string | present, absent, late, excused |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "student": {
        "id": 1,
        "name": "Sara Kebede"
      },
      "class": "Grade 9A",
      "date": "2026-10-07",
      "status": "present",
      "remarks": null
    }
  ]
}
```

---

### 9.2 POST `/api/attendance`

**Description:** Mark attendance (bulk or individual).

**Access:** Protected (`role:admin,teacher`)

**Request Body:**

```json
{
  "class_id": 1,
  "date": "2026-10-07",
  "records": [
    { "student_id": 1, "status": "present" },
    { "student_id": 2, "status": "absent", "remarks": "Sick" },
    { "student_id": 3, "status": "late" }
  ]
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Attendance marked for 3 students",
  "data": {
    "present": 1,
    "absent": 1,
    "late": 1,
    "sms_sent": 1
  }
}
```

---

### 9.3 GET `/api/attendance/summary`

**Description:** Get attendance summary for a class.

**Access:** Protected

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| class_id | integer | Required |
| month | string | YYYY-MM (default: current) |

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "class": "Grade 9A",
    "month": "2026-10",
    "total_days": 20,
    "students": [
      {
        "student_id": 1,
        "name": "Sara Kebede",
        "present": 18,
        "absent": 2,
        "late": 0,
        "excused": 0,
        "percentage": 90.0
      }
    ]
  }
}
```

---

## 10. Exam Endpoints

### 10.1 GET `/api/exams`

**Description:** List all exams.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Midterm Exam",
      "term": "Term 1",
      "start_date": "2026-10-15",
      "end_date": "2026-10-25",
      "status": "upcoming"
    }
  ]
}
```

---

### 10.2 POST `/api/exams`

**Description:** Create a new exam.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "name": "Midterm Exam",
  "term": "Term 1",
  "start_date": "2026-10-15",
  "end_date": "2026-10-25"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Exam created successfully"
}
```

---

## 11. Marks Endpoints

### 11.1 GET `/api/marks`

**Description:** List marks.

**Access:** Protected

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| student_id | integer | Filter by student |
| subject_id | integer | Filter by subject |
| exam_id | integer | Filter by exam |
| term | string | Filter by term |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "student": "Sara Kebede",
      "subject": "Mathematics",
      "exam": "Midterm",
      "score": 95.5,
      "grade": "A",
      "term": "Term 1"
    }
  ]
}
```

---

### 11.2 POST `/api/marks`

**Description:** Enter marks (bulk).

**Access:** Protected (`role:admin,teacher`)

**Request Body:**

```json
{
  "subject_id": 1,
  "exam_id": 1,
  "term": "Term 1",
  "marks": [
    { "student_id": 1, "score": 95.5 },
    { "student_id": 2, "score": 87.0 },
    { "student_id": 3, "score": 72.5 }
  ]
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Marks saved for 3 students",
  "data": {
    "saved": 3,
    "grades": {
      "A": 1,
      "B": 1,
      "C": 1
    }
  }
}
```

---

### 11.3 GET `/api/marks/report-card/{student_id}`

**Description:** Get report card data (returns JSON or PDF).

**Access:** Protected

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| term | string | Term 1, Term 2 |
| format | string | json or pdf (default: json) |

**Success Response (200) — JSON:**

```json
{
  "success": true,
  "data": {
    "student": {
      "id": 1,
      "student_id": "STU-2026-0001",
      "name": "Sara Kebede",
      "grade_level": 9,
      "section": "A"
    },
    "term": "Term 1",
    "subjects": [
      { "name": "Mathematics", "score": 95.5, "grade": "A" },
      { "name": "Physics", "score": 87.0, "grade": "B" },
      { "name": "English", "score": 72.5, "grade": "C" }
    ],
    "total": 255.0,
    "average": 85.0,
    "gpa": 3.33,
    "rank": 5,
    "class_size": 35
  }
}
```

**Success Response (200) — PDF:**

```
Content-Type: application/pdf
Content-Disposition: attachment; filename="report-card-STU-2026-0001.pdf"
```

---

## 12. Fee Endpoints

### 12.1 GET `/api/fees`

**Description:** List all fees.

**Access:** Protected (`role:admin,accountant`)

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| student_id | integer | Filter by student |
| status | string | pending, paid, overdue, partial |
| fee_type | string | tuition, transport, cafeteria |
| due_before | date | Filter by due date |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "student": "Sara Kebede",
      "fee_type": "tuition",
      "amount": 5000.00,
      "due_date": "2026-10-15",
      "status": "pending",
      "paid_amount": 0
    }
  ]
}
```

---

### 12.2 POST `/api/fees`

**Description:** Create a new fee.

**Access:** Protected (`role:admin,accountant`)

**Request Body:**

```json
{
  "student_id": 1,
  "fee_type": "tuition",
  "amount": 5000.00,
  "due_date": "2026-10-15"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Fee created successfully"
}
```

---

### 12.3 POST `/api/fees/bulk`

**Description:** Create fees for multiple students.

**Access:** Protected (`role:admin,accountant`)

**Request Body:**

```json
{
  "grade_level": 9,
  "section": "A",
  "fee_type": "tuition",
  "amount": 5000.00,
  "due_date": "2026-10-15"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Fees created for 35 students",
  "data": {
    "created": 35,
    "total_amount": 175000.00
  }
}
```

---

## 13. Payment Endpoints

### 13.1 GET `/api/payments`

**Description:** List all payments.

**Access:** Protected (`role:admin,accountant`)

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "fee_id": 1,
      "student": "Sara Kebede",
      "amount": 5000.00,
      "payment_method": "telebirr",
      "transaction_ref": "TXN-2026-001",
      "status": "completed",
      "paid_at": "2026-10-07T10:30:00Z"
    }
  ]
}
```

---

### 13.2 POST `/api/payments`

**Description:** Record a payment.

**Access:** Protected (`role:admin,accountant,parent`)

**Request Body:**

```json
{
  "fee_id": 1,
  "amount": 5000.00,
  "payment_method": "telebirr",
  "transaction_ref": "TXN-2026-001"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Payment recorded successfully",
  "data": {
    "id": 1,
    "receipt_url": "/storage/receipts/1.pdf"
  }
}
```

---

### 13.3 POST `/api/payments/telebirr/initialize`

**Description:** Initialize a Telebirr payment.

**Access:** Protected

**Request Body:**

```json
{
  "fee_id": 1,
  "phone": "+251911234567"
}
```

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "checkout_url": "https://telebirr.et/pay/abc123",
    "transaction_ref": "TXN-2026-001"
  }
}
```

---

### 13.4 POST `/api/payments/webhook/telebirr`

**Description:** Webhook for Telebirr payment notifications.

**Access:** Public (signature verified)

**Success Response (200):**

```json
{
  "success": true
}
```

---

### 13.5 GET `/api/payments/{id}/receipt`

**Description:** Download payment receipt (PDF).

**Access:** Protected

**Success Response (200):**

```
Content-Type: application/pdf
Content-Disposition: attachment; filename="receipt-TXN-2026-001.pdf"
```

---

## 14. Library Endpoints

### 14.1 GET `/api/library/books`

**Description:** List all books.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Mathematics for Grade 9",
      "author": "Ministry of Education",
      "isbn": "978-99944-0-001-1",
      "category": "Textbook",
      "total_copies": 50,
      "available_copies": 45
    }
  ]
}
```

---

### 14.2 POST `/api/library/books`

**Description:** Add a new book.

**Access:** Protected (`role:admin,librarian`)

**Request Body:**

```json{
  "title": "Mathematics for Grade 9",
  "author": "Ministry of Education",
  "isbn": "978-99944-0-001-1",
  "category": "Textbook",
  "total_copies": 50
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Book added successfully"
}
```

---

### 14.3 POST `/api/library/loans`

**Description:** Borrow a book.

**Access:** Protected (`role:admin,librarian`)

**Request Body:**

```json
{
  "student_id": 1,
  "book_id": 1,
  "due_date": "2026-10-21"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Book borrowed successfully",
  "data": {
    "id": 1,
    "borrowed_at": "2026-10-07",
    "due_date": "2026-10-21"
  }
}
```

---

### 14.4 PUT `/api/library/loans/{id}/return`

**Description:** Return a book.

**Access:** Protected (`role:admin,librarian`)

**Success Response (200):**

```json
{
  "success": true,
  "message": "Book returned successfully",
  "data": {
    "returned_at": "2026-10-07",
    "fine_amount": 0
  }
}
```

---

## 15. Timetable Endpoints

### 15.1 GET `/api/timetables`

**Description:** Get timetable for a class or teacher.

**Access:** Protected

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| class_id | integer | Filter by class |
| teacher_id | integer | Filter by teacher |
| day | string | monday, tuesday, ... |

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "class": "Grade 9A",
    "schedule": {
      "monday": [
        {
          "period": 1,
          "time": "08:00-08:45",
          "subject": "Mathematics",
          "teacher": "Sara Tesfaye"
        },
        {
          "period": 2,
          "time": "08:45-09:30",
          "subject": "Physics",
          "teacher": "Yohannes Bekele"
        }
      ],
      "tuesday": [ ]
    }
  }
}
```

---

### 15.2 POST `/api/timetables`

**Description:** Create a timetable entry.

**Access:** Protected (`role:admin`)

**Request Body:**

```json
{
  "class_id": 1,
  "subject_id": 1,
  "teacher_id": 1,
  "day_of_week": "monday",
  "start_time": "08:00",
  "end_time": "08:45"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Timetable entry created"
}
```

---

## 16. Announcement Endpoints

### 16.1 GET `/api/announcements`

**Description:** List announcements.

**Access:** Protected

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| audience | string | all, teachers, students, parents |

**Success Response (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Parent-Teacher Meeting",
      "body": "Meeting scheduled for October 15...",
      "audience": "parents",
      "published_at": "2026-10-07T08:00:00Z"
    }
  ]
}
```

---

### 16.2 POST `/api/announcements`

**Description:** Create an announcement.

**Access:** Protected (`role:admin,director`)

**Request Body:**

```json
{
  "title": "Parent-Teacher Meeting",
  "body": "Meeting scheduled for October 15...",
  "audience": "parents"
}
```

**Success Response (201):**

```json
{
  "success": true,
  "message": "Announcement created",
  "data": {
    "id": 1,
    "sms_sent": 120
  }
}
```

---

## 17. Report Endpoints

### 17.1 GET `/api/reports/enrollment`

**Description:** Enrollment statistics.

**Access:** Protected (`role:admin,director`)

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "total_students": 500,
    "by_gender": {
      "male": 260,
      "female": 240
    },
    "by_grade": {
      "9": 120,
      "10": 130,
      "11": 125,
      "12": 125
    },
    "by_section": {
      "A": 250,
      "B": 250
    }
  }
}
```

---

### 17.2 GET `/api/reports/financial`

**Description:** Financial summary.

**Access:** Protected (`role:admin,accountant`)

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| from | date | Start date |
| to | date | End date |

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "period": "2026-09-01 to 2026-10-07",
    "total_billed": 500000.00,
    "total_collected": 350000.00,
    "total_outstanding": 150000.00,
    "by_method": {
      "cash": 50000,
      "telebirr": 200000,
      "cbe_birr": 100000
    }
  }
}
```

---

### 17.3 GET `/api/reports/attendance`

**Description:** Attendance report.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "class": "Grade 9A",
    "period": "2026-10",
    "average_attendance": 92.5,
    "top_attendees": [ ],
    "low_attendees": [ ]
  }
}
```

---

## 18. Dashboard Endpoints

### 18.1 GET `/api/dashboard/stats`

**Description:** Get dashboard statistics.

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "total_students": 500,
    "total_teachers": 25,
    "total_classes": 12,
    "today_attendance": {
      "present": 470,
      "absent": 30
    },
    "pending_fees": 150000.00,
    "library_books_out": 45,
    "recent_announcements": 3
  }
}
```

---

### 18.2 GET `/api/dashboard/charts/attendance`

**Description:** Attendance chart data (last 30 days).

**Access:** Protected

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "labels": ["2026-09-08", "2026-09-09", ...],
    "datasets": [
      {
        "label": "Present",
        "data": [470, 465, ...]
      },
      {
        "label": "Absent",
        "data": [30, 35, ...]
      }
    ]
  }
}
```

---

### 18.3 GET `/api/dashboard/charts/financial`

**Description:** Financial chart data.

**Access:** Protected (`role:admin,accountant`)

**Success Response (200):**

```json
{
  "success": true,
  "data": {
    "labels": ["Sep", "Oct"],
    "datasets": [
      {
        "label": "Collected",
        "data": [200000, 150000]
      },
      {
        "label": "Outstanding",
        "data": [100000, 50000]
      }
    ]
  }
}
```

---

## 19. Common Response Codes

| Code | Meaning | Usage |
|------|---------|-------|
| **200** | OK | Successful GET, PUT |
| **201** | Created | Successful POST |
| **204** | No Content | Successful DELETE (no body) |
| **400** | Bad Request | Malformed request |
| **401** | Unauthorized | Missing/invalid token |
| **403** | Forbidden | Insufficient permissions |
| **404** | Not Found | Resource not found |
| **422** | Unprocessable Entity | Validation failed |
| **429** | Too Many Requests | Rate limit exceeded |
| **500** | Internal Server Error | Server error |

---

## 20. Pagination, Filtering & Sorting

### 20.1 Pagination

**Query Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| page | integer | 1 | Page number |
| per_page | integer | 15 | Records per page (max: 100) |

**Example:**

```
GET /api/students?page=2&per_page=25
```

### 20.2 Filtering

Multiple filters can be combined:

```
GET /api/students?grade_level=9&section=A&status=active
```

### 20.3 Sorting

**Query Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| sort_by | string | created_at | Column name |
| sort_order | string | desc | asc or desc |

**Example:**

```
GET /api/students?sort_by=first_name&sort_order=asc
```

### 20.4 Searching

**Query Parameter:** `search`

```
GET /api/students?search=Sara
```

Searches across multiple fields (name, student_id, guardian_phone).

### 20.5 Date Range

**Query Parameters:** `from`, `to`

```
GET /api/attendance?from=2026-10-01&to=2026-10-07
```

### 20.6 Including Relationships

**Query Parameter:** `include`

```
GET /api/students?include=class,attendance,marks
```

**Supported includes per endpoint:**

| Endpoint | Includes |
|----------|----------|
| /students | class, attendance, marks, fees, parent |
| /teachers | classes, subjects, timetables |
| /classes | students, teacher, timetables |
| /fees | student, payments |

---

## Appendix A — Endpoint Summary

| # | Method | Endpoint | Access |
|---|--------|----------|--------|
| 1 | POST | /api/auth/login | Public |
| 2 | POST | /api/auth/logout | Protected |
| 3 | GET | /api/auth/me | Protected |
| 4 | POST | /api/auth/forgot-password | Public |
| 5 | POST | /api/auth/reset-password | Public |
| 6 | GET | /api/users | Admin |
| 7 | POST | /api/users | Admin |
| 8 | GET | /api/users/{id} | Admin |
| 9 | PUT | /api/users/{id} | Admin |
| 10 | DELETE | /api/users/{id} | Admin |
| 11 | GET | /api/students | Protected |
| 12 | POST | /api/students | Admin |
| 13 | GET | /api/students/{id} | Protected |
| 14 | PUT | /api/students/{id} | Admin |
| 15 | DELETE | /api/students/{id} | Admin |
| 16 | POST | /api/students/import | Admin |
| 17 | GET | /api/students/export | Admin |
| 18 | GET | /api/teachers | Admin |
| 19 | POST | /api/teachers | Admin |
| 20 | GET | /api/teachers/{id} | Protected |
| 21 | PUT | /api/teachers/{id} | Admin |
| 22 | DELETE | /api/teachers/{id} | Admin |
| 23 | GET | /api/parents | Admin |
| 24 | POST | /api/parents | Admin |
| 25 | GET | /api/parents/{id}/children | Protected |
| 26 | GET | /api/classes | Protected |
| 27 | POST | /api/classes | Admin |
| 28 | GET | /api/classes/{id}/students | Protected |
| 29 | GET | /api/subjects | Protected |
| 30 | POST | /api/subjects | Admin |
| 31 | GET | /api/attendance | Protected |
| 32 | POST | /api/attendance | Teacher/Admin |
| 33 | GET | /api/attendance/summary | Protected |
| 34 | GET | /api/exams | Protected |
| 35 | POST | /api/exams | Admin |
| 36 | GET | /api/marks | Protected |
| 37 | POST | /api/marks | Teacher/Admin |
| 38 | GET | /api/marks/report-card/{id} | Protected |
| 39 | GET | /api/fees | Admin/Accountant |
| 40 | POST | /api/fees | Admin/Accountant |
| 41 | POST | /api/fees/bulk | Admin/Accountant |
| 42 | GET | /api/payments | Admin/Accountant |
| 43 | POST | /api/payments | Protected |
| 44 | POST | /api/payments/telebirr/initialize | Protected |
| 45 | POST | /api/payments/webhook/telebirr | Public |
| 46 | GET | /api/payments/{id}/receipt | Protected |
| 47 | GET | /api/library/books | Protected |
| 48 | POST | /api/library/books | Librarian/Admin |
| 49 | POST | /api/library/loans | Librarian/Admin |
| 50 | PUT | /api/library/loans/{id}/return | Librarian/Admin |
| 51 | GET | /api/timetables | Protected |
| 52 | POST | /api/timetables | Admin |
| 53 | GET | /api/announcements | Protected |
| 54 | POST | /api/announcements | Admin/Director |
| 55 | GET | /api/reports/enrollment | Admin/Director |
| 56 | GET | /api/reports/financial | Admin/Accountant |
| 57 | GET | /api/reports/attendance | Protected |
| 58 | GET | /api/dashboard/stats | Protected |
| 59 | GET | /api/dashboard/charts/attendance | Protected |
| 60 | GET | /api/dashboard/charts/financial | Admin/Accountant |

**Total Endpoints:** 60

---

**© 2026 Smart School Management System. All rights reserved.**