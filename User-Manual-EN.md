# 📖 User Manual
## Smart School Management System (SSMS)

**Version:** 1.0
**Release Date:** October 2026
**Language:** English

---

## 📋 Table of Contents

1. [Introduction](#1-introduction)
2. [System Requirements](#2-system-requirements)
3. [Getting Started](#3-getting-started)
4. [For Administrators](#4-for-administrators)
5. [For Teachers](#5-for-teachers)
6. [For Students](#6-for-students)
7. [For Parents](#7-for-parents)
8. [For Accountants](#8-for-accountants)
9. [For Librarians](#9-for-librarians)
10. [SMS Notifications](#10-sms-notifications)
11. [Troubleshooting](#11-troubleshooting)
12. [Support](#12-support)

---

## 1. Introduction

### 1.1 About This Manual

This manual explains how to use the Smart School Management System (SSMS). The system runs in any modern web browser (Chrome, Firefox, Edge) and works on desktop, tablet, and mobile devices.

### 1.2 What the System Does

- 🎓 Student registration and management
- 👨‍🏫 Teacher management
- 📅 Attendance tracking
- 📝 Exam and grade management
- 💰 Fee management
- 👨‍👩‍👧 Parent portal
- 📢 SMS notifications
- 📚 Library management
- 📊 Reports and analytics

### 1.3 User Roles

| Role | Description |
|------|-------------|
| **Super Admin** | Manages all schools (system owner) |
| **School Admin** | Manages a single school |
| **Director** | Views reports and analytics |
| **Teacher** | Manages grades and attendance |
| **Student** | Views own grades and schedule |
| **Parent** | Views child's progress and pays fees |
| **Accountant** | Manages fee payments |
| **Librarian** | Manages books and loans |

---

## 2. System Requirements

### 2.1 Hardware & Software

- ✅ Modern web browser (Chrome 100+, Firefox 100+, Edge 100+)
- ✅ Stable internet connection (minimum 1 Mbps)
- ✅ Minimum screen width: 320px (mobile)
- ✅ Recommended screen: 768px+ (tablet/desktop)

### 2.2 Best Practices

- ✅ Never share your password with anyone
- ✅ Always **Logout** after use
- ✅ Enter accurate information only
- ✅ Use correct phone format (+251911234567)

---

## 3. Getting Started

### 3.1 Access URL

**Production:** `https://ssms.yourschool.et`

**Development (local):** `http://localhost:5173`

### 3.2 How to Log In

1. Open your web browser
2. Enter the URL
3. Enter your **Email** and **Password**
4. Click **"Login"**

### 3.3 Login Example

```
Email: admin@sunrise.et
Password: ••••••••
```

### 3.4 Forgot Password

1. Click **"Forgot Password?"**
2. Enter your email address
3. Check your email inbox for a reset link
4. Click the link and set a new password

### 3.5 How to Log Out

Click your **name** in the top-right corner → select **"Logout"**

---

## 4. For Administrators

### 4.1 Dashboard

After login, you will see the **Dashboard** with:

- 👥 Total Students
- 👨‍🏫 Total Teachers
- 📚 Total Classes
- 📊 Today's Attendance
- 💰 Outstanding Fees
- 📢 Recent Announcements

### 4.2 Register a Student

1. Click **"Students"**
2. Click **"Add New Student"**
3. Fill in the fields:
   - Full Name (First + Last)
   - Date of Birth
   - Gender (Male/Female)
   - Guardian Name
   - Guardian Phone (+251911234567)
   - Grade Level (1-12)
   - Section (A, B, C)
4. Click **"Save"**
5. The system automatically generates a Student ID (e.g., STU-2026-0001)

### 4.3 Import Students from Excel

1. Click **"Students"** → **"Import"**
2. Select an Excel file (.xlsx) or CSV
3. Click **"Upload"**
4. The system shows success/failure count

**Excel File Format:**

| first_name | last_name | date_of_birth | gender | guardian_name | guardian_phone | grade_level | section |
|------------|-----------|---------------|--------|---------------|----------------|-------------|---------|
| Sara | Kebede | 2010-05-15 | female | Abebe Kebede | +251911234567 | 9 | A |

### 4.4 Add a Teacher

1. Click **"Teachers"**
2. Click **"Add New Teacher"**
3. Fill in:
   - Full Name
   - Email
   - Phone
   - Qualification (BSc, MSc, ...)
   - Specialization (Mathematics, Physics, ...)
   - Hire Date
4. Click **"Save"**
5. The system sends login credentials to the teacher's email

### 4.5 Create a Class

1. Click **"Classes"**
2. Click **"Create Class"**
3. Fill in:
   - Name (Grade 9A)
   - Grade (9)
   - Section (A)
   - Capacity (40)
   - Homeroom Teacher
4. Click **"Save"**

### 4.6 Configure Fees

1. Click **"Fees"**
2. Click **"New Fee"**
3. Select:
   - Student
   - Fee Type (Tuition, Transport, Cafeteria, ...)
   - Amount (5,000 ETB)
   - Due Date
4. Click **"Save"**

### 4.7 Send Announcements

1. Click **"Announcements"**
2. Click **"New Announcement"**
3. Fill in:
   - Title
   - Body
   - Audience (All, Teachers, Students, Parents)
4. Click **"Send"**
5. The system sends SMS + in-app notification

### 4.8 Generate Reports

1. Click **"Reports"**
2. Select report type:
   - Enrollment Statistics
   - Financial Report
   - Attendance Report
   - Grade Report
3. Select date range
4. Click **"Generate"** (PDF or Excel)

---

## 5. For Teachers

### 5.1 Login

Use your school email and password to log in.

### 5.2 Mark Attendance

1. Click **"Attendance"**
2. Select **Class** (Grade 9A)
3. Select **Date** (today)
4. For each student, mark:
   - ✅ Present
   - ❌ Absent
   - ⏰ Late
   - 📋 Excused
5. Click **"Save"**

**Note:** When a student is absent, the system automatically sends an SMS to the parent.

### 5.3 Enter Marks

1. Click **"Marks"**
2. Click **"New Marks Entry"**
3. Select:
   - Class (Grade 9A)
   - Subject (Mathematics)
   - Exam (Midterm)
   - Term (Term 1)
4. Enter scores for each student (0-100)
5. Click **"Save"**

**The system automatically assigns grades:**
- A: 90-100
- B: 80-89
- C: 70-79
- D: 60-69
- F: below 60

### 5.4 Generate Report Cards

1. Click **"Marks"** → **"Report Card"**
2. Select a student
3. Select a term
4. Click **"Generate"** (PDF)

### 5.5 View Schedule

1. Click **"Timetable"**
2. Click **"My Schedule"**
3. Your weekly schedule is displayed

### 5.6 View Class Roster

1. Click **"My Classes"**
2. Select a class
3. View the list of students
4. Click a student for details

---

## 6. For Students

### 6.1 Login

Use your school email and password to log in.

### 6.2 View Grades

1. Click **"My Grades"**
2. Select a term (Term 1)
3. View grades for all subjects
4. Click **"Report Card"** to download a PDF

### 6.3 View Timetable

1. Click **"Timetable"**
2. Your weekly schedule is displayed
3. Shows each subject's time and teacher

### 6.4 View Attendance

1. Click **"My Attendance"**
2. Monthly report is displayed
3. Shows days you were present

### 6.5 View Library Loans

1. Click **"Library"**
2. Click **"My Loans"**
3. View borrowed books and due dates

### 6.6 View Announcements

1. Click **"Announcements"**
2. View recent announcements

---

## 7. For Parents

### 7.1 Login

Log in using your **phone number**.

1. Enter your phone (+251911234567)
2. Enter the verification code sent via SMS
3. Click **"Verify"**

### 7.2 View Child's Grades

1. Click **"My Children"**
2. Select a child
3. Click **"Grades"**
4. View grades for all subjects

### 7.3 View Child's Attendance

1. Click **"My Children"** → select child
2. Click **"Attendance"**
3. View the monthly report

### 7.4 Pay Fees

1. Click **"Fees"**
2. Select an outstanding fee
3. Click **"Pay Now"**
4. Choose payment method:
   - **Telebirr** (mobile money)
   - **CBE Birr** (bank)
   - **Cash** (at school)
5. View receipt

### 7.5 View Announcements

1. Click **"Announcements"**
2. View messages from the school

### 7.6 SMS Notifications

As a parent, you will receive SMS for:

- 📅 Child's absence
- 📝 New grades
- 💰 Fee reminders
- 📢 Important announcements

---

## 8. For Accountants

### 8.1 Login

Use your school email and password to log in.

### 8.2 Record a Payment

1. Click **"Payments"**
2. Click **"New Payment"**
3. Select:
   - Student
   - Fee Type
   - Amount
4. Choose payment method:
   - **Cash**
   - **Telebirr**
   - **CBE Birr**
   - **Bank Transfer**
5. Click **"Save"**
6. Print receipt (PDF)

### 8.3 View Outstanding Fees

1. Click **"Fees"**
2. Filter by **"Status: Pending"** or **"Overdue"**
3. View all outstanding fees
4. Send reminders to parents

### 8.4 Daily Reconciliation

1. Click **"Reports"** → **"Daily Collection"**
2. Select today's date
3. View total collected by method
4. Print daily report

### 8.5 Monthly Financial Report

1. Click **"Reports"** → **"Financial Summary"**
2. Select month
3. View total billed, collected, outstanding
4. Export to Excel

---

## 9. For Librarians

### 9.1 Login

Use your school email and password to log in.

### 9.2 Add a Book

1. Click **"Library"** → **"Books"**
2. Click **"Add New Book"**
3. Fill in:
   - Title
   - Author
   - ISBN
   - Category
   - Total Copies
4. Click **"Save"**

### 9.3 Lend a Book

1. Click **"Library"** → **"Loans"**
2. Click **"New Loan"**
3. Select:
   - Student
   - Book
   - Due Date
4. Click **"Save"**

### 9.4 Return a Book

1. Click **"Library"** → **"Loans"**
2. Find the active loan
3. Click **"Return"**
4. If late, system calculates fine
5. Click **"Confirm"**

### 9.5 View Overdue Loans

1. Click **"Library"** → **"Loans"**
2. Filter by **"Status: Overdue"**
3. Send reminders to students

---

## 10. SMS Notifications

The system sends automatic SMS for:

| Event | Recipient | Message |
|-------|-----------|---------|
| Student absent | Parent | "Dear Parent, [Student] was absent on [Date]. - School" |
| New grades | Parent | "[Student]'s [Subject] grade: [Grade]. - School" |
| Fee reminder | Parent | "Fee of [Amount] ETB due on [Date]. - School" |
| Announcement | Audience | "[Title]: [Body]. - School" |
| Payment receipt | Parent | "Payment of [Amount] ETB received. Ref: [TXN]. - School" |

### 10.1 Opt-Out

Parents can opt out by contacting the school administrator.

---

## 11. Troubleshooting

### 11.1 Cannot Log In

**Problem:** Login fails with "Invalid credentials"

**Solution:**
- Check your email spelling
- Verify caps lock is off
- Try "Forgot Password"
- Contact your school admin

### 11.2 Page Not Loading

**Problem:** Blank page or error

**Solution:**
- Refresh the page (Ctrl+F5)
- Clear browser cache
- Try a different browser
- Check internet connection

### 11.3 SMS Not Received

**Problem:** SMS not delivered

**Solution:**
- Check phone number is correct in profile
- Wait up to 5 minutes
- Check phone signal
- Contact school admin

### 11.4 Data Not Saving

**Problem:** Click "Save" but nothing happens

**Solution:**
- Check all required fields are filled
- Verify internet connection
- Check for red error messages
- Try again after refresh

### 11.5 Slow Performance

**Problem:** System is slow

**Solution:**
- Check internet speed
- Close other browser tabs
- Use a modern browser
- Clear browser cache

---

## 12. Support

### 12.1 Contact Information

- 📧 **Email:** support@smart-school.et
- 📱 **Phone:** +251-XXX-XXXXXX
- 🌐 **Website:** https://smart-school.et
- 💬 **Live Chat:** Available Mon-Fri, 8:00-18:00 EAT

### 12.2 Response Time

| Priority | Response Time |
|----------|---------------|
| Critical (system down) | 1 hour |
| High (login issues) | 4 hours |
| Medium (data errors) | 24 hours |
| Low (questions) | 48 hours |

### 12.3 Documentation

- 📖 [SRS.md](./SRS.md) — Software Requirements
- 🗄️ [ERD.md](./ERD.md) — Database Design
- 🔌 [API-Contracts.md](./API-Contracts.md) — API Documentation
- 📘 [README.md](./README.md) — Project Overview

### 12.4 Training Videos

Video tutorials (Amharic + English) are available at:

`https://smart-school.et/tutorials`

### 12.5 Frequently Asked Questions

**Q: Can I use the system on my phone?**
A: Yes, the system is mobile-responsive and works on any smartphone.

**Q: What happens if I forget my password?**
A: Use "Forgot Password" on the login page, or contact your school admin.

**Q: Is my data secure?**
A: Yes, all data is encrypted and protected with role-based access control.

**Q: Can I export reports?**
A: Yes, most reports can be exported as PDF or Excel.

**Q: How do I change my password?**
A: Go to Profile → Settings → Change Password.

**Q: Can I access previous years' data?**
A: Yes, all historical data is retained (v1.0+).

**Q: What if I enter wrong data?**
A: You can edit most records. Contact admin for critical changes.

---

## Appendix A — Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| `Ctrl + S` | Save form |
| `Ctrl + P` | Print current page |
| `Ctrl + F` | Search on page |
| `Esc` | Close modal |
| `F5` | Refresh |

## Appendix B — Glossary

| Term | Definition |
|------|-----------|
| **SSMS** | Smart School Management System |
| **RBAC** | Role-Based Access Control |
| **SMS** | Short Message Service |
| **GPA** | Grade Point Average |
| **PDF** | Portable Document Format |
| **CSV** | Comma-Separated Values |
| **API** | Application Programming Interface |

---

**© 2026 Smart School Management System. All rights reserved.**

**Made with ❤️ in Ethiopia 🇪🇹**