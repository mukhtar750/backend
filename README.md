# AWN Portal - Project Phase Checklist

## PHASE 1: Project Foundation
- [x] Laravel installation
- [x] Git repo (GitHub/Bitbucket)
- [x] .env file and database connection

## PHASE 2: Basic Auth Setup
- [x] Install Laravel Breeze or Laravel UI
- [x] Confirm working login/registration

## PHASE 3: Multi-Role Architecture
- [ ] Modify users table or create related profile tables
- [x] Add role column (e.g., enum or string)
- [ ] Optional: investor_profiles, bdsp_profiles, entrepreneur_profiles tables
- [x] Run php artisan migrate

## PHASE 4: Registration Flow
- [x] Create 3 separate registration views: /register/investor, /register/bdsp, /register/entrepreneur
- [x] Add basic validation & error display

## PHASE 5: Role Assignment Logic
- [ ] In each controller/store method, assign the correct role
- [ ] Optional: Use Laravel Policies or Gates for access control

## PHASE 6: Homepage & Navigation Flow
- [ ] Modern, professional landing page
- [x] Button: "Who Are You?" → leads to role selection
- [x] "I am an Investor / BDSP / Entrepreneur" → respective form

## PHASE 7: Routing & Controllers
- [x] Setup all routes in web.php (with naming conventions)
- [ ] Route middleware for role-specific redirection after login

## PHASE 8: Dashboard for Each Role
- [x] Create 3 dashboard pages: dashboard-investor.blade.php, dashboard-bdsp.blade.php, dashboard-entrepreneur.blade.php
- [ ] Route users based on role after login

## PHASE 9: Admin Panel (Optional but Recommended)
- [ ] User management (view/edit/deactivate)
- [ ] Statistics: number of each role registered
- [ ] Role switcher or impersonation (if needed)

## PHASE 10: Features & Enhancements
- [ ] After registration, redirect to "Complete Profile" (different fields per role)
- [ ] Use forms + validation for profile completion
- [ ] Laravel notifications (e.g., successful registration)
- [ ] Admin alert on new user registration
- [ ] Enable email verification
- [ ] Set up email template branding

## PHASE 11: Deployment & Optimization
- [ ] Choose host: Shared hosting / VPS / Laravel Forge / Render / Vercel (frontend only)
- [ ] Set up .env and database on production
- [ ] Migrate & seed initial data
- [ ] Use Laravel Mix/Vite for assets
- [ ] Minify CSS/JS
- [ ] Enable caching

---

### Tools & Best Practices
- Use Git and create branches per feature
- Keep README.md updated
- Follow MVC structure
- Use Laravel's built-in validation, middleware, and Auth guards

### Suggested Timeline (if solo developer)
| Phase                | Duration   | Status |
|----------------------|------------|--------|
| Foundation           | 1 day      | ✅     |
| Multi-role Setup     | 2–3 days   | ⏳     |
| Homepage & Flow      | 2 days     | ⏳     |
| Dashboards           | 2 days     | ⏳     |
| Admin Panel          | 3 days     | ⏳     |
| Profile & Email Features | 2–3 days | ⏳     |
| Deployment & Testing | 1–2 days   | ⏳     |

---

# AWN Portal

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
