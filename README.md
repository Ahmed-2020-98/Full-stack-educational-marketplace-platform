# EduMarket - Educational Marketplace Platform

A full-stack educational marketplace where instructors can create and sell courses, students can browse and purchase them, and admins manage the entire platform.

## Tech Stack

| Layer          | Technology                            |
| -------------- | ------------------------------------- |
| Frontend       | Next.js 14 (App Router) + TypeScript  |
| Styling        | Tailwind CSS (Dark / Light mode)      |
| Backend        | Laravel 12 (API-only)                 |
| Database       | MySQL                                 |
| Authentication | Laravel Sanctum (Token-based)         |
| Authorization  | Spatie Laravel Permission             |

## Roles

| Role       | Access                                                        |
| ---------- | ------------------------------------------------------------- |
| Admin      | Manage users, categories, courses, view revenue and reports   |
| Instructor | Create/edit/delete courses & lessons, track students/earnings |
| Student    | Browse, purchase, enroll, watch lessons, track progress       |

---

## Project Structure

```
CoreSystem/
├── backend/          # Laravel API
│   ├── app/
│   │   ├── Enums/            # UserStatus, CourseLevel, CourseStatus, OrderStatus, PaymentStatus
│   │   ├── Http/
│   │   │   ├── Controllers/Api/V1/
│   │   │   │   ├── Auth/     # Register, Login, Profile
│   │   │   │   ├── Admin/    # Users, Categories, Courses, Revenue
│   │   │   │   ├── Instructor/ # Courses, Lessons, Enrollments, Earnings
│   │   │   │   └── Student/  # Courses, Orders, Payments, Progress
│   │   │   ├── Requests/     # Form Request validation (Auth, Admin, Instructor, Student)
│   │   │   └── Resources/    # API Resources (User, Course, Category, Lesson, Order, etc.)
│   │   ├── Models/           # User, Category, Course, Lesson, Order, Payment, Enrollment, LessonProgress
│   │   ├── Services/         # Business logic layer (Auth, Course, Lesson, Order, Payment, etc.)
│   │   ├── Policies/         # Authorization policies
│   │   └── Traits/           # ApiResponse trait (standardized JSON)
│   ├── database/
│   │   ├── migrations/       # All table schemas
│   │   └── seeders/          # Roles, Admin user, Categories
│   └── routes/
│       └── api.php           # Versioned under /api/v1
│
└── frontend/         # Next.js 14
    └── src/
        ├── app/
        │   ├── (public)/         # Landing, Courses browse
        │   ├── (auth)/           # Login, Register
        │   └── (dashboard)/      # Admin, Instructor, Student dashboards
        ├── modules/
        │   ├── auth/             # components, hooks, services, types
        │   ├── courses/
        │   ├── admin/
        │   ├── instructor/
        │   └── student/
        ├── shared/
        │   ├── components/ui/    # Button, Input, Select, Card, Modal, Table, Pagination, Badge, Spinner
        │   ├── components/layout/# DashboardLayout, Sidebar, Header, PublicHeader, Footer, ThemeToggle
        │   ├── providers/        # AuthProvider, ThemeProvider, ToastProvider
        │   ├── hooks/            # useDebounce
        │   └── lib/              # axios instance, constants, utils
        ├── middleware.ts         # Route protection (role-based)
        └── types/                # Global shared TypeScript types
```

---

## Database Schema

```
users            ──< courses          (instructor creates courses)
users            ──< enrollments      (student enrolls)
users            ──< orders           (student purchases)
users            ──< payments         (student pays)
categories       ──< courses
courses          ──< lessons
courses          ──< enrollments
courses          ──< orders
orders           ──  payments         (1-to-1)
orders           ──  enrollments      (1-to-1)
enrollments      ──< lesson_progress
lessons          ──< lesson_progress
```

### Tables

| Table             | Key Columns                                                         |
| ----------------- | ------------------------------------------------------------------- |
| `users`           | name, email, password, avatar, bio, status (active/inactive/pending)|
| `categories`      | name, slug, description, is_active                                  |
| `courses`         | instructor_id, category_id, title, slug, price, thumbnail, level, status |
| `lessons`         | course_id, title, video_url (YouTube/Vimeo), sort_order, is_free_preview |
| `orders`          | user_id, course_id, order_number, amount, status                    |
| `payments`        | order_id, user_id, transaction_id, amount, payment_method (mock), status |
| `enrollments`     | user_id, course_id, order_id, progress_percentage, completed_at     |
| `lesson_progress` | enrollment_id, lesson_id, is_completed, completed_at                |

---

## API Endpoints

All routes are prefixed with `/api/v1`.

### Public

| Method | Endpoint     | Description       |
| ------ | ------------ | ----------------- |
| POST   | `/register`  | Create account    |
| POST   | `/login`     | Authenticate user |

### Authenticated (Bearer token)

| Method | Endpoint   | Description      |
| ------ | ---------- | ---------------- |
| GET    | `/profile` | Get current user |
| POST   | `/logout`  | Revoke token     |

### Admin (`/admin/*`), Instructor (`/instructor/*`), Student (`/student/*`)

Role-gated route groups -- to be populated as features are implemented.

### API Response Format

```json
// Success
{
  "success": true,
  "message": "Courses retrieved successfully",
  "data": { ... },
  "meta": { "current_page": 1, "last_page": 5, "per_page": 15, "total": 72 }
}

// Error
{
  "success": false,
  "message": "Validation failed",
  "errors": { "email": ["The email field is required."] }
}
```

---

## Architecture Rules

- **Controllers** handle HTTP requests only -- no business logic.
- **Services** contain all business logic.
- **Form Requests** handle validation.
- **API Resources** handle response transformation.
- **Policies** handle authorization.
- Feature-based module structure on the frontend.

---

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8+

### Backend Setup

```bash
cd backend

# Configure database
# Edit .env and set DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Run migrations and seed data
php artisan migrate --seed

# Start the server
php artisan serve
# Runs at http://localhost:8000
```

**Default admin account:** `admin@edumarket.com` / `password`

### Frontend Setup

```bash
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev
# Runs at http://localhost:3000
```

### Environment Variables

#### Backend (`.env`)

| Variable                    | Default               | Description           |
| --------------------------- | --------------------- | --------------------- |
| `DB_CONNECTION`             | `mysql`               | Database driver       |
| `DB_DATABASE`               | `edu_marketplace`     | Database name         |
| `DB_USERNAME`               | `root`                | Database user         |
| `DB_PASSWORD`               |                       | Database password     |
| `SANCTUM_STATEFUL_DOMAINS`  | `localhost:3000`      | Frontend domain       |

#### Frontend (`.env.local`)

| Variable                | Default                          | Description      |
| ----------------------- | -------------------------------- | ---------------- |
| `NEXT_PUBLIC_API_URL`   | `http://localhost:8000/api/v1`   | Backend API URL  |

---

## Seeded Data

| Seeder             | Data                                                                                         |
| ------------------ | -------------------------------------------------------------------------------------------- |
| `RoleSeeder`       | admin, instructor, student                                                                   |
| `AdminUserSeeder`  | Admin user (admin@edumarket.com)                                                             |
| `CategorySeeder`   | Web Dev, Mobile Dev, Data Science, ML, DevOps, UI/UX, Cybersecurity, Cloud, Blockchain, Game Dev |

---

## Features Status

| Feature             | Backend | Frontend |
| ------------------- | :-----: | :------: |
| Authentication      |   Done  |   Done   |
| Role-based routing  |   Done  |   Done   |
| Admin Dashboard     | Scaffold| Scaffold |
| Instructor Panel    | Scaffold| Scaffold |
| Student Dashboard   | Scaffold| Scaffold |
| Course CRUD         | Pending | Pending  |
| Lesson Management   | Pending | Pending  |
| Payment (Mock)      | Pending | Pending  |
| Enrollment          | Pending | Pending  |
| Progress Tracking   | Pending | Pending  |
| Search & Filter     | Pending | Pending  |
