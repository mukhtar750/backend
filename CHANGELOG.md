# Change Log

This log details the modifications made to the Laravel backend to integrate with a React frontend.

## 2024-07-30

### 1. CORS Configuration (`config/cors.php`)

*   Enabled CORS by setting `supports_credentials` to `true`.
*   Configured `allowed_origins` to `['https://aryaas.netlify.app']` to allow requests from your React frontend.
*   Ensured correct placement and removed duplicate entries for `allowed_origins`, `supports_credentials`, `exposed_headers`, and `max_age` to maintain a clean and functional configuration.

### 2. Environment Variables (`.env`)

*   Created the `.env` file by copying content from `.env.example`.
*   Updated `SESSION_DOMAIN` to `.onrender.com`.
*   Updated `SANCTUM_STATEFUL_DOMAINS` to `aryaas.netlify.app`.
*   Applied the full `.env` content provided by you, including `APP_KEY`, `DB_DATABASE`, and other configurations.

### 3. API Routes (`routes/api.php`)

*   Created `routes/api.php` (as it was missing).
*   Added a test route `Route::get('/test', function () { return response()->json(['message' => 'API test route working!']); });`.
*   Added `use App\Http\Controllers\AuthController;` import.
*   Implemented login route: `Route::post('/login', [AuthController::class, 'login']);`.
*   Implemented user route: `Route::middleware('auth:sanctum')->get('/user', function (Request $request) { return $request->user(); });`.

### 4. Authentication Controller (`app/Http/Controllers/AuthController.php`)

*   Created `app/Http/Controllers/AuthController.php` (as it was missing).
*   Implemented the `login` method to handle user authentication.

### 5. Frontend Asset Removal (`resources/views/landing.blade.php`)

*   Commented out the `@vite` directive to prevent the loading of frontend assets (CSS/JS) from the Blade view, as the backend is serving as an API.

### 6. Root Route Update (`routes/web.php`)

*   Modified the root route (`/`) to return a simple JSON message `{"message": "Backend is running"}` instead of a Blade view, which is appropriate for an API-only backend.

## [Unreleased] - 2024-06-28

### Added
- **Multi-Role Registration System** for Arya Women Nigeria (AWN):
  - Added migration to extend `users` table with `role`, `is_approved`, and role-specific fields (Investor, BDSP, Entrepreneur).
  - Updated `User` model `$fillable` to include all new fields.
  - Created `InvestorRegisterController`, `BDSPRegisterController`, and `EntrepreneurRegisterController` for role-based registration.
  - Added `InvestorRegisterRequest`, `BDSPRegisterRequest`, and `EntrepreneurRegisterRequest` for clean validation.
  - Added role-specific registration Blade views:
    - `register-investor.blade.php`
    - `register-bdsp.blade.php`
    - `register-entrepreneur.blade.php`
  - Added role selector page: `register-role.blade.php` (modern, mobile-friendly, Bootstrap card/buttons).
  - Added role-specific dashboards:
    - `dashboard/investor.blade.php`
    - `dashboard/bdsp.blade.php`
    - `dashboard/entrepreneur.blade.php`
  - Updated `routes/web.php` with:
    - Role selector and registration routes
    - Role-based dashboard routes

- **Homepage Redesign**:
  - Created a modern, responsive homepage: `home.blade.php`.
  - Added header and footer partials:
    - `layouts/partials/header.blade.php`
    - `layouts/partials/footer.blade.php`
  - Homepage features:
    - Hero section with tagline and CTA
    - Role-based cards for registration
    - How It Works section
    - Testimonials section
    - Footer with contact info, social icons, and newsletter signup

### Changed
- Updated `layouts/app.blade.php` to use `@yield('content')` for main content area.
- Modularized layout using Blade partials for header and footer.
- Migrated from a single users table with all role-specific fields to a scalable, normalized structure using separate profile tables:
  - `investor_profiles` for investor-specific fields
  - `bdsp_profiles` for BDSP-specific fields
  - `entrepreneur_profiles` for entrepreneur-specific fields
- Updated migrations to create these new tables, each with a `user_id` foreign key and relevant fields.
- (Planned) Registration logic and models will be updated to use these profile tables for better maintainability and future growth.

### Notes
- All new views use Bootstrap 5 and Bootstrap Icons for a modern, mobile-friendly UI.
- All navigation uses `route()` helpers for maintainability.
- Placeholder content and dummy routes are used where appropriate.

### Fixed
- Replaced the <x-auth-validation-errors> Blade component with the standard Laravel error display block in all role-based registration views (`register-investor.blade.php`, `register-bdsp.blade.php`, and `register-entrepreneur.blade.php`).
- This resolves the "Unable to locate a class or view for component [auth-validation-errors]" error and ensures validation errors are displayed properly.

### Changed
- Ran `npm run dev` to compile assets and apply styling.
- Fixed styling issue by updating `tailwind.config.js` for content paths and `vite.config.js` for `outDir`, ensuring correct compilation and serving of assets with Tailwind CSS styling on the dashboard after restarting `npm run dev`.
- Updated `resources/views/dashboard/investor.blade.php` to reflect the new investor dashboard design, including changes to stats cards, investment opportunities, and opportunities by sector sections.

- **Updated `AuthController.php`**: Modified the `login` method to redirect users to role-based dashboards (investor, bdsp, entrepreneur) after successful login.

- **Updated `investor.blade.php`**: Replaced the basic welcome message with a comprehensive investor dashboard layout, including sections for welcome, investor dashboard stats (Startup Profiles, Pitch Events, Success Stories, Profile Views), investment opportunities with filtering options, and startup cards.

- **Updated `dashboard.blade.php`**: Transformed into an investors dashboard, including relevant statistics (Startup Profiles, Pitch Events, Success Stories, Profile Views), quick actions (Browse Startups, Upcoming Pitches), sections for investment opportunities with filtering options (Sector, Stage), and upcoming pitch events, all styled with the `magenta` color.

- **Updated `content_management.blade.php`**: Implemented a content management system with features for creating, editing, and publishing articles, news, and updates, styled with the `magenta` color.

- **Updated `analytics.blade.php`**: Developed an analytics dashboard to display key metrics and insights related to platform usage, user engagement, and content performance, styled with the `magenta` color.

- **Updated `pitch_events.blade.php`**: Created a dedicated section for managing and displaying pitch events, including event details, registration forms, and participant lists, styled with the `magenta` color.

- **Updated `mentorship.blade.php`**: Designed a mentorship platform to connect entrepreneurs with experienced mentors, featuring mentor profiles, booking systems, and feedback mechanisms, styled with the `magenta` color.

- **Updated `training_programs.blade.php`**: Developed a module for managing and delivering training programs and workshops, including course outlines, schedules, and progress tracking, styled with the `magenta` color.

- **Color Scheme Update**: Changed the primary color scheme to `magenta` across various dashboard elements for a consistent and vibrant look.

- Created an `AdminUserSeeder` to easily seed an admin user for testing and management purposes.
- Documented the admin login process:
  - Admin login URL: `/login`
  - Admin dashboard URL: `/admin/users`
- Admin credentials (default for local/dev):
  - Email: `admin@example.com`
  - Password: `password`

### Added
- Entrepreneur Dashboard: Modular, professional UI with program journey, mentorship booking, training calendar, feedback modal, and messaging (direct & group).
- Entrepreneur Messaging: Added group chat (Hub) page at /dashboard/entrepreneur-hub, with sidebar dropdown for Messages (Direct & Hub).
- Sidebar: All main sections now have clear navigation; Messages uses Alpine.js dropdown for Direct and Hub chat.
- Alpine.js: Now included in entrepreneur layout for dropdowns and interactivity.

### Changed
- Cleaned up and modularized all dashboard sections for maintainability and scalability.
- Improved sidebar navigation and UX for entrepreneurs.

## 2024-07-12

### Added
- **Universal Messaging System**:
  - Implemented a robust, role-aware messaging system accessible at `/messages` for all user types (Admin, Investor, BDSP, Entrepreneur, Mentor, Mentee).
  - Created `conversations` and `messages` tables with migrations, supporting direct messaging, file uploads, and read/unread status.
  - Developed `Conversation` and `Message` models with helper methods for role-based access and message management.
  - Built a professional messaging UI (`resources/views/messages/index.blade.php` and `show.blade.php`) with conversation lists, unread badges, and a modern compose modal (file upload supported).
  - Added AJAX-powered message sending and real-time badge updates.

- **Role-Based Messaging Permissions**:
  - Each user can only message users allowed by business rules (e.g., investors can only message admin, BDSP can message entrepreneurs and admin, etc.), enforced in the `User` model and controller logic.

- **Navigation/Sidebar Integration**:
  - Added or updated "Messages" links/buttons in all dashboards and sidebars (Admin, Investor, BDSP, Entrepreneur, Mentor, Mentee) to point to the universal messaging system.
  - Removed all static/demo chat pages in favor of the real system.

- **UI/UX Improvements**:
  - Consistent, mobile-friendly messaging experience for all roles.
  - Compose modal with file upload, loading states, and error handling.
  - Digital signatures and progress tracking planned for future mentorship forms integration.

### Changed
- Refactored all role dashboards and layouts to ensure a single, professional messaging experience for every user type.
- Updated routes and permissions to centralize all messaging logic and UI.

### Fixed
- Resolved issues with Alpine.js modals by switching to reliable vanilla JS for compose modal.
- Fixed navigation inconsistencies and ensured all users have access to the messaging system from their main dashboard/sidebar.

## 2024-07-22

### Added
- **Mentorship Forms Feature**: Implemented a comprehensive system for managing mentorship forms, including user submissions and admin reviews.
  - **Files Created/Updated**:
    - `routes/web.php`: Added new admin routes for mentorship forms management.
    - `app/Http/Controllers/MentorshipFormController.php`: Implemented controller logic for user-facing and admin functionalities.
    - `resources/views/admin/mentorship/forms/admin_dashboard.blade.php`: Admin dashboard view for submission overview.
    - `resources/views/admin/mentorship/forms/list_submissions.blade.php`: View to list all submissions for administrators.
    - `resources/views/admin/mentorship/forms/show_submission.blade.php`: Detailed submission view for administrators.
    - `resources/views/admin/mentorship/forms/review_submission.blade.php`: Admin interface for reviewing and approving/rejecting submissions.
    - `resources/views/admin/partials/sidebar.blade.php`: New admin sidebar partial with a "Mentorship Forms" link.
    - `resources/views/layouts/admin.blade.php`: Rewrote admin layout to include new sidebar, header, and footer partials.
    - `resources/views/admin/partials/header.blade.php`: Header partial for admin layout.
    - `resources/views/admin/partials/footer.blade.php`: Footer partial for admin layout.

  - **Features Implemented**:
    - **Admin Dashboard**: Overview of submissions, quick access to forms awaiting review.
    - **Submission Listing**: Comprehensive list of all mentorship form submissions for admins.
    - **Detailed Submission View**: Admins can view full details of any submitted form, including uploaded files.
    - **Submission Review System**: Admins can review, approve, reject, and add comments to submissions.
    - **Submission Download**: Functionality to download submitted files or a summary of the submission.
    - **User-facing Form Management**: Users can create, view, edit, and submit mentorship forms with various field types and file uploads.

## [Unreleased]
- Fixed a Laravel error ('Illegal offset type') by removing a duplicate Route::view('/dashboard/entrepreneur', ...) in routes/web.php. Only the Route::get version that passes $pairings to the view is now used.
- **Entrepreneur Training Calendar Enhancements** (`resources/views/dashboard/entrepreneur-calendar.blade.php`):
  - Updated the training calendar to display upcoming training sessions with clear stats and tabbed navigation (Upcoming, Registered, Completed).
  - Added logic to show a prominent "Register" button for unregistered sessions and a "Join Session" button (with meeting link) for registered users.
  - Integrated registration form submission and conditional button display based on user registration status and meeting link availability.
  - Improved UI/UX: modern card design, grouped action buttons, and consistent color scheme for primary actions.
  - Ensured only registered users see the "Join Session" button when a meeting link is available; otherwise, a disabled "No Link Yet" button is shown.
  - Enhanced stats row and tabbed interface for a professional, user-friendly experience.

- **Admin User Management Enhancements** (`AdminController`, `resources/views/admin/edit-user.blade.php`, `UserUpdatedNotification.php`):
  - Implemented full-featured Edit User functionality for admins: update name, email, phone, role, status, and all role-specific fields.
  - Added a professional edit form with validation and support for all user types (entrepreneur, BDSP, investor, etc.).
  - Admins can now change user roles and approval status directly from the UI.
  - When a user's profile is updated, they are automatically notified (email + in-app) with a summary of the changes for transparency and security.
  - This completes the 'Full control: user management' milestone for the admin panel.