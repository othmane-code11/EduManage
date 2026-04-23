## 🏫 Project Summary: EduManage

**EduManage** is a comprehensive, web-based School Management System built on **Laravel 10**. It centralizes administrative tasks, academic tracking, and student monitoring within a secure, modern, and responsive environment.

### 🛠 Technical Architecture
* **Framework:** Laravel 10 (utilizing MVC and Service Layer patterns).
* **Authentication:** Laravel Breeze with a customized **Multi-Role** system.
* **Database:** MySQL (Structured with One-to-Many and Many-to-Many Eloquent relationships).
* **Frontend:** Tailwind CSS for a mobile-first UI and Blade Components for reusability.
* **Security:** Custom **Role-Based Access Control (RBAC)** via Middleware to isolate Admin, Teacher, and Student data.

---

### 📋 Key Features by Role

| Role | Primary Responsibilities |
| :--- | :--- |
| **Admin** | User Management (CRUD), Class/Grade creation, Timetable scheduling, and system-wide analytics. |
| **Teacher** | Digital attendance marking, Gradebook management, and course material uploads (PDF/Video). |
| **Student** | Accessing personal grades, viewing attendance history, checking schedules, and downloading resources. |

---

### 🗄️ Database Logic
The system is built on a robust relational schema:
* **Users:** Stores identity and the `role` attribute.
* **Grades/Classes:** Links students to specific academic levels.
* **Timetables:** Maps subjects to specific days, times, and teachers.
* **Attendances:** Logs daily presence/absence records for every student.
* **Materials:** Manages storage paths for pedagogical files.

---

### 🚀 Core Strengths
1.  **Clean Architecture:** Implementation of "Thin Controllers" ensures the code is maintainable and easily testable.
2.  **Granular Security:** Unauthorized access attempts are automatically blocked at the routing level.
3.  **Tailored UX:** Each user sees a unique dashboard designed specifically for their daily tasks, reducing clutter.

---

### ⚙️ Quick Start
1.  **Backend:** Run `composer install` followed by `php artisan migrate --seed`.
2.  **Frontend:** Run `npm install` and `npm run build`.
3.  **Launch:** Execute `php artisan serve`.

This project serves as a production-ready foundation that can be expanded with modules such as fee management, exam scheduling, or real-time notifications.
