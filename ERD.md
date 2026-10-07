# Entity Relationship Diagram (ERD)
## Smart School Management System

**Document Version:** 1.0
**Release Date:** October 2026
**Database:** MySQL 8.4
**Total Tables:** 16
**Total Relationships:** 24

---

## Table of Contents

1. [Database Overview](#1-database-overview)
2. [Design Principles](#2-design-principles)
3. [Entity List](#3-entity-list)
4. [Detailed Table Specifications](#4-detailed-table-specifications)
5. [Entity Relationships](#5-entity-relationships)
6. [Database Diagram (dbdiagram.io)](#6-database-diagram)
7. [Indexes Summary](#7-indexes-summary)
8. [Migration Order](#8-migration-order)
9. [Sample Data](#9-sample-data)

---

## 1. Database Overview

### 1.1 Purpose

The Smart School Management System (SSMS) database is designed to manage all school operations including students, teachers, classes, attendance, grades, fees, library, and communication. The database follows **Third Normal Form (3NF)** to minimize redundancy and ensure data integrity.

### 1.2 Database Engine

- **DBMS:** MySQL 8.4
- **Character Set:** utf8mb4
- **Collation:** utf8mb4_unicode_ci
- **Storage Engine:** InnoDB
- **Transaction Support:** Yes (ACID compliant)

### 1.3 Design Goals

1. **Data Integrity** — Foreign key constraints, unique constraints
2. **Performance** — Proper indexing, normalized tables
3. **Scalability** — Support up to 10,000+ students per school
4. **Security** — Multi-tenant isolation via `school_id`
5. **Maintainability** — Clear naming conventions, documented relationships

---

## 2. Design Principles

### 2.1 Naming Conventions

| Element | Convention | Example |
|---------|------------|---------|
| **Table Names** | Plural, snake_case | `students`, `book_loans` |
| **Column Names** | Singular, snake_case | `first_name`, `created_at` |
| **Primary Key** | `id` | Auto-increment bigint |
| **Foreign Key** | `{table_singular}_id` | `student_id`, `school_id` |
| **Timestamps** | `created_at`, `updated_at` | Laravel standard |
| **Soft Deletes** | `deleted_at` | Nullable timestamp |
| **Boolean** | `is_{adjective}` | `is_active`, `is_verified` |

### 2.2 Data Types

| Purpose | MySQL Type | Example |
|---------|-----------|---------|
| Primary Key | `BIGINT UNSIGNED AUTO_INCREMENT` | `id` |
| Foreign Key | `BIGINT UNSIGNED` | `school_id` |
| Short Text | `VARCHAR(255)` | `name`, `email` |
| Long Text | `TEXT` | `description`, `body` |
| Integer | `INT` | `grade_level`, `capacity` |
| Decimal | `DECIMAL(10,2)` | `amount`, `salary` |
| Date | `DATE` | `date_of_birth` |
| Time | `TIME` | `start_time` |
| DateTime | `TIMESTAMP` | `created_at` |
| Boolean | `TINYINT(1)` | `is_active` |
| Enum | `ENUM(...)` | `role`, `status` |
| JSON | `JSON` | `metadata` |

### 2.3 Multi-Tenancy Strategy

Every business table contains a `school_id` foreign key. This ensures:
- Data isolation between schools
- Efficient tenant-scoped queries
- Easy backup per school

### 2.4 Soft Deletes

Critical tables (schools, users, students, teachers) use soft deletes to preserve historical data.

---

## 3. Entity List

| # | Entity | Purpose | Records (Est.) |
|---|--------|---------|---------------|
| 1 | `schools` | School information | 1 – 1,000 |
| 2 | `users` | All system users | 1 – 100,000 |
| 3 | `students` | Student records | 1 – 50,000 |
| 4 | `teachers` | Teacher records | 1 – 5,000 |
| 5 | `parents` | Parent/guardian records | 1 – 50,000 |
| 6 | `classes` | Class definitions | 1 – 500 |
| 7 | `subjects` | Subject definitions | 1 – 100 |
| 8 | `attendance` | Attendance records | 1 – 1,000,000 |
| 9 | `marks` | Exam marks | 1 – 1,000,000 |
| 10 | `exams` | Exam definitions | 1 – 100 |
| 11 | `fees` | Fee definitions | 1 – 500,000 |
| 12 | `payments` | Payment transactions | 1 – 1,000,000 |
| 13 | `library_books` | Book catalog | 1 – 50,000 |
| 14 | `book_loans` | Book loans | 1 – 100,000 |
| 15 | `timetables` | Class schedules | 1 – 10,000 |
| 16 | `announcements` | Announcements | 1 – 10,000 |

---

## 4. Detailed Table Specifications

### 4.1 Table: `schools`

**Purpose:** Stores school information for each tenant.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | School name |
| `slug` | VARCHAR(255) | UNIQUE, NOT NULL | URL-friendly name |
| `logo_url` | VARCHAR(255) | NULL | School logo path |
| `currency` | VARCHAR(3) | DEFAULT 'ETB' | Currency code |
| `vat_rate` | DECIMAL(5,2) | DEFAULT 15.00 | VAT percentage |
| `address` | TEXT | NULL | Physical address |
| `phone` | VARCHAR(20) | NULL | Contact phone |
| `email` | VARCHAR(255) | NULL | Contact email |
| `is_active` | TINYINT(1) | DEFAULT 1 | Active status |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`slug`)

---

### 4.2 Table: `users`

**Purpose:** All system users (admin, teacher, student, parent, etc.).

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id, NULL | Tenant scope (NULL for super admin) |
| `name` | VARCHAR(255) | NOT NULL | Full name |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| `phone` | VARCHAR(20) | NULL | Phone number |
| `password` | VARCHAR(255) | NOT NULL | Bcrypt hash |
| `role` | ENUM('super_admin','admin','director','teacher','student','parent','accountant','librarian') | NOT NULL | User role |
| `is_active` | TINYINT(1) | DEFAULT 1 | Account status |
| `email_verified_at` | TIMESTAMP | NULL | Email verification |
| `remember_token` | VARCHAR(100) | NULL | Remember me token |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`email`)
- INDEX (`school_id`, `role`)
- INDEX (`school_id`, `is_active`)

**Cascade:** `ON DELETE CASCADE` from schools.

---

### 4.3 Table: `students`

**Purpose:** Student personal and academic records.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `user_id` | BIGINT UNSIGNED | FK → users.id, NULL | Linked user account |
| `student_id` | VARCHAR(50) | UNIQUE | School-issued ID (STU-2026-0001) |
| `first_name` | VARCHAR(100) | NOT NULL | First name |
| `last_name` | VARCHAR(100) | NOT NULL | Last name |
| `date_of_birth` | DATE | NOT NULL | Birth date |
| `gender` | ENUM('male','female') | NOT NULL | Gender |
| `address` | TEXT | NULL | Home address |
| `guardian_name` | VARCHAR(255) | NOT NULL | Guardian full name |
| `guardian_phone` | VARCHAR(20) | NOT NULL | Guardian phone |
| `grade_level` | INT | NOT NULL | Grade (1-12) |
| `section` | VARCHAR(10) | NULL | Section (A, B, C) |
| `enrollment_date` | DATE | NOT NULL | Enrollment date |
| `status` | ENUM('enrolled','active','transferred','graduated') | DEFAULT 'enrolled' | Lifecycle status |
| `photo_url` | VARCHAR(255) | NULL | Photo path |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`school_id`, `student_id`)
- INDEX (`school_id`, `grade_level`, `section`)
- INDEX (`guardian_phone`)

**Cascade:** `ON DELETE CASCADE` from schools.

---

### 4.4 Table: `teachers`

**Purpose:** Teacher records and assignments.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `user_id` | BIGINT UNSIGNED | FK → users.id, NULL | Linked user account |
| `employee_id` | VARCHAR(50) | UNIQUE | School-issued ID |
| `qualification` | VARCHAR(255) | NOT NULL | Degree/Diploma |
| `specialization` | VARCHAR(255) | NULL | Subject area |
| `hire_date` | DATE | NOT NULL | Hire date |
| `salary` | DECIMAL(10,2) | NULL | Monthly salary |
| `status` | ENUM('active','on_leave','terminated') | DEFAULT 'active' | Employment status |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`school_id`, `employee_id`)

---

### 4.5 Table: `parents`

**Purpose:** Parent/guardian records linked to students.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `user_id` | BIGINT UNSIGNED | FK → users.id, NULL | Linked user account |
| `phone` | VARCHAR(20) | NOT NULL | Primary phone |
| `relation` | ENUM('father','mother','guardian') | NOT NULL | Relationship |
| `occupation` | VARCHAR(255) | NULL | Job |
| `address` | TEXT | NULL | Home address |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- INDEX (`phone`)

---

### 4.6 Table: `classes`

**Purpose:** Class definitions (grade + section).

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `teacher_id` | BIGINT UNSIGNED | FK → teachers.id, NULL | Homeroom teacher |
| `name` | VARCHAR(100) | NOT NULL | Class name (e.g., "Grade 10A") |
| `grade_level` | INT | NOT NULL | Grade (1-12) |
| `section` | VARCHAR(10) | NOT NULL | Section (A, B, C) |
| `capacity` | INT | DEFAULT 40 | Max students |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`school_id`, `grade_level`, `section`)

---

### 4.7 Table: `subjects`

**Purpose:** Subject definitions per grade.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `name` | VARCHAR(100) | NOT NULL | Subject name |
| `code` | VARCHAR(20) | NULL | Subject code (MATH101) |
| `grade_level` | INT | NOT NULL | Grade (1-12) |
| `credit_hours` | INT | DEFAULT 1 | Credit hours |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`school_id`, `code`)

---

### 4.8 Table: `attendance`

**Purpose:** Daily student attendance records.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `student_id` | BIGINT UNSIGNED | FK → students.id | Student |
| `class_id` | BIGINT UNSIGNED | FK → classes.id | Class |
| `date` | DATE | NOT NULL | Attendance date |
| `status` | ENUM('present','absent','late','excused') | NOT NULL | Status |
| `remarks` | TEXT | NULL | Optional notes |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`student_id`, `class_id`, `date`)
- INDEX (`date`)
- INDEX (`status`)

**Cascade:** `ON DELETE CASCADE` from students.

---

### 4.9 Table: `marks`

**Purpose:** Exam marks per student, subject, exam.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `student_id` | BIGINT UNSIGNED | FK → students.id | Student |
| `subject_id` | BIGINT UNSIGNED | FK → subjects.id | Subject |
| `exam_id` | BIGINT UNSIGNED | FK → exams.id | Exam |
| `score` | DECIMAL(5,2) | NOT NULL | Score (0-100) |
| `grade` | VARCHAR(2) | NULL | A/B/C/D/F |
| `term` | VARCHAR(20) | NULL | Term (Term 1, Term 2) |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`student_id`, `subject_id`, `exam_id`)
- INDEX (`student_id`, `term`)

---

### 4.10 Table: `exams`

**Purpose:** Exam period definitions.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `name` | VARCHAR(100) | NOT NULL | Exam name (Midterm, Final) |
| `term` | VARCHAR(20) | NOT NULL | Term |
| `start_date` | DATE | NOT NULL | Start date |
| `end_date` | DATE | NOT NULL | End date |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- INDEX (`school_id`, `term`)

---

### 4.11 Table: `fees`

**Purpose:** Fee definitions per student.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `student_id` | BIGINT UNSIGNED | FK → students.id | Student |
| `fee_type` | ENUM('tuition','transport','cafeteria','library','uniform') | NOT NULL | Fee type |
| `amount` | DECIMAL(10,2) | NOT NULL | Amount (ETB) |
| `due_date` | DATE | NOT NULL | Due date |
| `status` | ENUM('pending','paid','overdue','partial') | DEFAULT 'pending' | Payment status |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- INDEX (`student_id`, `status`)
- INDEX (`due_date`)

---

### 4.12 Table: `payments`

**Purpose:** Payment transactions.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `fee_id` | BIGINT UNSIGNED | FK → fees.id | Related fee |
| `amount` | DECIMAL(10,2) | NOT NULL | Paid amount |
| `payment_method` | ENUM('cash','telebirr','cbe_birr','bank_transfer') | NOT NULL | Method |
| `transaction_ref` | VARCHAR(100) | UNIQUE | Reference number |
| `status` | ENUM('pending','completed','failed','refunded') | DEFAULT 'pending' | Payment status |
| `paid_at` | TIMESTAMP | NULL | Payment time |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`transaction_ref`)
- INDEX (`fee_id`, `status`)

---

### 4.13 Table: `library_books`

**Purpose:** Book catalog.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `title` | VARCHAR(255) | NOT NULL | Book title |
| `author` | VARCHAR(255) | NOT NULL | Author name |
| `isbn` | VARCHAR(20) | UNIQUE | ISBN number |
| `category` | VARCHAR(100) | NULL | Category |
| `total_copies` | INT | DEFAULT 1 | Total copies |
| `available_copies` | INT | DEFAULT 1 | Available copies |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- UNIQUE (`isbn`)
- INDEX (`school_id`, `category`)

---

### 4.14 Table: `book_loans`

**Purpose:** Book loan records.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `student_id` | BIGINT UNSIGNED | FK → students.id | Student |
| `book_id` | BIGINT UNSIGNED | FK → library_books.id | Book |
| `borrowed_at` | DATE | NOT NULL | Borrow date |
| `due_date` | DATE | NOT NULL | Due date |
| `returned_at` | DATE | NULL | Return date |
| `fine_amount` | DECIMAL(10,2) | DEFAULT 0 | Fine for late return |
| `status` | ENUM('borrowed','returned','overdue') | DEFAULT 'borrowed' | Status |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- INDEX (`student_id`, `status`)
- INDEX (`book_id`)

---

### 4.15 Table: `timetables`

**Purpose:** Weekly class schedules.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `class_id` | BIGINT UNSIGNED | FK → classes.id | Class |
| `subject_id` | BIGINT UNSIGNED | FK → subjects.id | Subject |
| `teacher_id` | BIGINT UNSIGNED | FK → teachers.id | Teacher |
| `day_of_week` | ENUM('monday','tuesday','wednesday','thursday','friday','saturday') | NOT NULL | Day |
| `start_time` | TIME | NOT NULL | Start time |
| `end_time` | TIME | NOT NULL | End time |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- INDEX (`class_id`, `day_of_week`)

---

### 4.16 Table: `announcements`

**Purpose:** School announcements.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Unique identifier |
| `school_id` | BIGINT UNSIGNED | FK → schools.id | Tenant scope |
| `title` | VARCHAR(255) | NOT NULL | Title |
| `body` | TEXT | NOT NULL | Content |
| `audience` | ENUM('all','teachers','students','parents') | DEFAULT 'all' | Target audience |
| `published_at` | TIMESTAMP | NULL | Publish time |
| `created_at` | TIMESTAMP | NULL | Creation time |
| `updated_at` | TIMESTAMP | NULL | Update time |

**Indexes:**
- PRIMARY (`id`)
- INDEX (`school_id`, `audience`)

---

## 5. Entity Relationships

### 5.1 Complete Relationship List (24 relationships)

| # | Parent | Child | Type | Foreign Key | Cascade |
|---|--------|-------|------|-------------|---------|
| 1 | schools | users | 1:N | users.school_id | CASCADE |
| 2 | schools | students | 1:N | students.school_id | CASCADE |
| 3 | schools | teachers | 1:N | teachers.school_id | CASCADE |
| 4 | schools | parents | 1:N | parents.school_id | CASCADE |
| 5 | schools | classes | 1:N | classes.school_id | CASCADE |
| 6 | schools | subjects | 1:N | subjects.school_id | CASCADE |
| 7 | schools | exams | 1:N | exams.school_id | CASCADE |
| 8 | schools | fees | 1:N | fees.school_id | CASCADE |
| 9 | schools | library_books | 1:N | library_books.school_id | CASCADE |
| 10 | schools | announcements | 1:N | announcements.school_id | CASCADE |
| 11 | users | students | 1:1 | students.user_id | SET NULL |
| 12 | users | teachers | 1:1 | teachers.user_id | SET NULL |
| 13 | users | parents | 1:1 | parents.user_id | SET NULL |
| 14 | teachers | classes | 1:N | classes.teacher_id | SET NULL |
| 15 | students | attendance | 1:N | attendance.student_id | CASCADE |
| 16 | classes | attendance | 1:N | attendance.class_id | CASCADE |
| 17 | students | marks | 1:N | marks.student_id | CASCADE |
| 18 | subjects | marks | 1:N | marks.subject_id | CASCADE |
| 19 | exams | marks | 1:N | marks.exam_id | CASCADE |
| 20 | students | fees | 1:N | fees.student_id | CASCADE |
| 21 | fees | payments | 1:N | payments.fee_id | CASCADE |
| 22 | students | book_loans | 1:N | book_loans.student_id | CASCADE |
| 23 | library_books | book_loans | 1:N | book_loans.book_id | CASCADE |
| 24 | classes | timetables | 1:N | timetables.class_id | CASCADE |
| 25 | subjects | timetables | 1:N | timetables.subject_id | CASCADE |
| 26 | teachers | timetables | 1:N | timetables.teacher_id | CASCADE |

### 5.2 Relationship Types Explained

**One-to-Many (1:N)**
- One parent record has many child records
- Example: One school has many students

**One-to-One (1:1)**
- One parent record has one child record
- Example: One user has one student profile

**Many-to-Many (N:N)**
- Not used directly; resolved via pivot tables (e.g., `timetables` joins classes+subjects+teachers)

---

## 6. Database Diagram (dbdiagram.io)

**Paste this code at https://dbdiagram.io to visualize the ERD:**

```sql
Table schools {
  id bigint [pk, increment]
  name varchar(255)
  slug varchar(255) [unique]
  logo_url varchar(255)
  currency varchar(3) [default: 'ETB']
  vat_rate decimal(5,2) [default: 15.00]
  address text
  phone varchar(20)
  email varchar(255)
  is_active boolean [default: true]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table users {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  name varchar(255)
  email varchar(255) [unique]
  phone varchar(20)
  password varchar(255)
  role enum('super_admin','admin','director','teacher','student','parent','accountant','librarian')
  is_active boolean [default: true]
  email_verified_at timestamp
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table students {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  user_id bigint [ref: > users.id]
  student_id varchar(50) [unique]
  first_name varchar(100)
  last_name varchar(100)
  date_of_birth date
  gender enum('male','female')
  address text
  guardian_name varchar(255)
  guardian_phone varchar(20)
  grade_level int
  section varchar(10)
  enrollment_date date
  status enum('enrolled','active','transferred','graduated')
  photo_url varchar(255)
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table teachers {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  user_id bigint [ref: > users.id]
  employee_id varchar(50) [unique]
  qualification varchar(255)
  specialization varchar(255)
  hire_date date
  salary decimal(10,2)
  status enum('active','on_leave','terminated')
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table parents {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  user_id bigint [ref: > users.id]
  phone varchar(20)
  relation enum('father','mother','guardian')
  occupation varchar(255)
  address text
  created_at timestamp
  updated_at timestamp
}

Table classes {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  teacher_id bigint [ref: > teachers.id]
  name varchar(100)
  grade_level int
  section varchar(10)
  capacity int [default: 40]
  created_at timestamp
  updated_at timestamp
}

Table subjects {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  name varchar(100)
  code varchar(20)
  grade_level int
  credit_hours int [default: 1]
  created_at timestamp
  updated_at timestamp
}

Table attendance {
  id bigint [pk, increment]
  student_id bigint [ref: > students.id]
  class_id bigint [ref: > classes.id]
  date date
  status enum('present','absent','late','excused')
  remarks text
  created_at timestamp
  updated_at timestamp
}

Table marks {
  id bigint [pk, increment]
  student_id bigint [ref: > students.id]
  subject_id bigint [ref: > subjects.id]
  exam_id bigint [ref: > exams.id]
  score decimal(5,2)
  grade varchar(2)
  term varchar(20)
  created_at timestamp
  updated_at timestamp
}

Table exams {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  name varchar(100)
  term varchar(20)
  start_date date
  end_date date
  created_at timestamp
  updated_at timestamp
}

Table fees {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  student_id bigint [ref: > students.id]
  fee_type enum('tuition','transport','cafeteria','library','uniform')
  amount decimal(10,2)
  due_date date
  status enum('pending','paid','overdue','partial')
  created_at timestamp
  updated_at timestamp
}

Table payments {
  id bigint [pk, increment]
  fee_id bigint [ref: > fees.id]
  amount decimal(10,2)
  payment_method enum('cash','telebirr','cbe_birr','bank_transfer')
  transaction_ref varchar(100) [unique]
  status enum('pending','completed','failed','refunded')
  paid_at timestamp
  created_at timestamp
  updated_at timestamp
}

Table library_books {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  title varchar(255)
  author varchar(255)
  isbn varchar(20) [unique]
  category varchar(100)
  total_copies int [default: 1]
  available_copies int [default: 1]
  created_at timestamp
  updated_at timestamp
}

Table book_loans {
  id bigint [pk, increment]
  student_id bigint [ref: > students.id]
  book_id bigint [ref: > library_books.id]
  borrowed_at date
  due_date date
  returned_at date
  fine_amount decimal(10,2) [default: 0]
  status enum('borrowed','returned','overdue')
  created_at timestamp
  updated_at timestamp
}

Table timetables {
  id bigint [pk, increment]
  class_id bigint [ref: > classes.id]
  subject_id bigint [ref: > subjects.id]
  teacher_id bigint [ref: > teachers.id]
  day_of_week enum('monday','tuesday','wednesday','thursday','friday','saturday')
  start_time time
  end_time time
  created_at timestamp
  updated_at timestamp
}

Table announcements {
  id bigint [pk, increment]
  school_id bigint [ref: > schools.id]
  title varchar(255)
  body text
  audience enum('all','teachers','students','parents')
  published_at timestamp
  created_at timestamp
  updated_at timestamp
}
```

---

## 7. Indexes Summary

| # | Table | Index | Type | Purpose |
|---|-------|-------|------|---------|
| 1 | users | email | Unique | Login |
| 2 | users | (school_id, role) | Composite | Role filtering |
| 3 | students | student_id | Unique | Student lookup |
| 4 | students | (school_id, grade_level, section) | Composite | Class roster |
| 5 | students | guardian_phone | Index | Parent lookup |
| 6 | attendance | (student_id, class_id, date) | Unique | Prevent duplicates |
| 7 | attendance | date | Index | Daily reports |
| 8 | marks | (student_id, subject_id, exam_id) | Unique | Prevent duplicates |
| 9 | marks | (student_id, term) | Composite | Report cards |
| 10 | fees | (student_id, status) | Composite | Outstanding |
| 11 | payments | transaction_ref | Unique | Payment lookup |
| 12 | library_books | isbn | Unique | Book lookup |
| 13 | book_loans | (student_id, status) | Composite | Active loans |
| 14 | announcements | (school_id, audience) | Composite | Announcement filtering |

---

## 8. Migration Order

**Migrations must run in this order due to foreign key dependencies:**

```
1.  create_schools_table
2.  create_users_table
3.  create_teachers_table          (depends: schools, users)
4.  create_students_table          (depends: schools, users)
5.  create_parents_table           (depends: schools, users)
6.  create_classes_table           (depends: schools, teachers)
7.  create_subjects_table          (depends: schools)
8.  create_exams_table             (depends: schools)
9.  create_attendance_table        (depends: students, classes)
10. create_marks_table             (depends: students, subjects, exams)
11. create_fees_table              (depends: schools, students)
12. create_payments_table          (depends: fees)
13. create_library_books_table     (depends: schools)
14. create_book_loans_table        (depends: students, library_books)
15. create_timetables_table        (depends: classes, subjects, teachers)
16. create_announcements_table     (depends: schools)
```

---

## 9. Sample Data

### 9.1 Sample School

```sql
INSERT INTO schools (id, name, slug, currency, vat_rate, is_active)
VALUES (1, 'Sunrise Academy', 'sunrise-academy', 'ETB', 15.00, 1);
```

### 9.2 Sample User (Admin)

```sql
INSERT INTO users (id, school_id, name, email, password, role, is_active)
VALUES (1, 1, 'Abebe Kebede', 'admin@sunrise.et', '$2y$10$...', 'admin', 1);
```

### 9.3 Sample Student

```sql
INSERT INTO students (id, school_id, student_id, first_name, last_name, date_of_birth, gender, grade_level, section, guardian_name, guardian_phone, enrollment_date)
VALUES (1, 1, 'STU-2026-0001', 'Sara', 'Kebede', '2010-05-15', 'female', 9, 'A', 'Abebe Kebede', '+251911234567', '2026-09-01');
```

### 9.4 Sample Class

```sql
INSERT INTO classes (id, school_id, teacher_id, name, grade_level, section, capacity)
VALUES (1, 1, 1, 'Grade 9A', 9, 'A', 40);
```

### 9.5 Sample Subject

```sql
INSERT INTO subjects (id, school_id, name, code, grade_level, credit_hours)
VALUES (1, 1, 'Mathematics', 'MATH101', 9, 4);
```

### 9.6 Sample Attendance

```sql
INSERT INTO attendance (student_id, class_id, date, status)
VALUES (1, 1, '2026-10-07', 'present');
```

### 9.7 Sample Mark

```sql
INSERT INTO marks (student_id, subject_id, exam_id, score, grade, term)
VALUES (1, 1, 1, 95.50, 'A', 'Term 1');
```

---

**© 2026 Smart School Management System. All rights reserved.**