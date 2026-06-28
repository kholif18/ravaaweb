# RavaaWeb OpenCode Agent

## Project Overview
- **Type**: Full‑stack web application built with **Laravel** (PHP).
- **Backend**: Laravel 11; routes in `routes/web.php`, controllers in `app/Http/Controllers`.
- **Database**: MySQL via Docker (`postgres:18-alpine`). Models in `app/Models`.
- **Frontend**: Custom CSS Glassmorphism (`public/frontend/css/app.css`), vanilla JS (`public/frontend/js/app.js`), Blade templates.

## Agent Configuration
- **Root Path**: `.` (project root).
- **Supported Languages**: PHP, Blade, JavaScript, CSS, HTML.
- **Key Scripts**:
  - **Run inside Docker**: `docker exec f3dd6e5d80bd php artisan <command>`
  - **View Cache Clear**: `docker exec f3dd6e5d80bd php artisan view:clear`
  - **Route List**: `docker exec f3dd6e5d80bd php artisan route:list`
  - **Migrations**: `docker exec f3dd6e5d80bd php artisan migrate`
  - **Seed**: `docker exec f3dd6e5d80bd php artisan db:seed`
  - **Full Reset**: `docker exec f3dd6e5d80bd php artisan migrate:fresh --seed`

## Tools Available to the Agent
- `bash` – execute shell commands (setup, test, build, serve, etc.).
- `read` – read source files, configuration, or test files.
- `write` – write new files when explicitly requested.
- `edit` – edit existing files safely.
- `glob` – locate files by pattern.
- `grep` – search file contents for symbols, classes, routes, etc.

## Usage Guidelines for the Agent
1. **Identify the Context** – Determine whether the request involves PHP (backend) or Blade/CSS/JS (frontend).
2. **Locate Code** – Use `glob` and `grep` to find relevant definitions.
3. **Read and Analyze** – Read the file to understand existing implementation.
4. **Apply Changes** – Use `edit` or `write` to modify code.
5. **Validate** – Run `docker exec f3dd6e5d80bd php artisan view:clear` after Blade changes, then curl the URL.
6. **Commit (if requested)** – Stage only changed files, create concise commit message.

## Architecture Notes
- **Frontend CSS**: `public/frontend/css/app.css` — macOS Glassmorphism design system (~1400 lines)
- **Frontend JS**: `public/frontend/js/app.js` — vanilla JS (~100 lines)
- **No CSS framework** (no Bootstrap, no Tailwind) — pure custom CSS
- **Icons**: Font Awesome 6 via CDN
- **Font**: Inter via Google Fonts
- **Views**: `resources/views/frontend/` — 7 pages + layouts/partials
- **Admin**: `resources/views/admin/` — dashboard + categories CRUD
- **Controllers**: `FrontendController` (dummy data), `Admin/AuthController`, `Admin/CategoryController`
