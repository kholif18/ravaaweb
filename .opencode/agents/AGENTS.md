# RavaaWeb OpenCode Agent

## Project Overview
- **Type**: Full‑stack web application built with **Laravel** (PHP).
- **Backend**: Laravel 13; routes in `routes/web.php`, controllers in `app/Http/Controllers`.
- **Database**: MariaDB via Docker (`mariadb-db-1`). Models in `app/Models`.
- **Frontend**: Custom CSS Glassmorphism (`public/frontend/css/app.css`), vanilla JS (`public/frontend/js/app.js`), Blade templates.
- **Admin**: Custom CSS Glassmorphism (`public/admin/css/admin-glass.css`), vanilla JS (`public/admin/js/app.js`), Blade templates.

## Agent Configuration
- **Root Path**: `.` (project root).
- **Supported Languages**: PHP, Blade, JavaScript, CSS, HTML.
- **Key Scripts**:
  - **Run inside Docker**: `docker exec RavaaWeb php artisan <command>`
  - **View Cache Clear**: `docker exec RavaaWeb php artisan view:clear`
  - **Route List**: `docker exec RavaaWeb php artisan route:list`
  - **Migrations**: `docker exec RavaaWeb php artisan migrate`
  - **Seed**: `docker exec RavaaWeb php artisan db:seed`
  - **Full Reset**: `docker exec RavaaWeb php artisan migrate:fresh --seed`

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
5. **Validate** – Run `docker exec RavaaWeb php artisan view:clear` after Blade changes, then curl the URL.
6. **Commit (if requested)** – Stage only changed files, create concise commit message.

## Architecture Notes
- **Frontend CSS**: `public/frontend/css/app.css` — macOS Glassmorphism design system
- **Admin CSS**: `public/admin/css/admin-glass.css` — macOS Glassmorphism design system (admin)
- **Frontend JS**: `public/frontend/js/app.js` — vanilla JS (mobile menu, gallery, tabs)
- **Admin JS**: `public/admin/js/app.js` — vanilla JS (Ravaa.toast, Ravaa.confirm, dropdowns)
- **No CSS framework** (no Bootstrap CSS, no Tailwind) — pure custom CSS
- **Bootstrap JS** only for modal/dropdown in admin
- **Icons**: Bootstrap Icons via CDN, Font Awesome 6 via CDN
- **Font**: Inter via Google Fonts
- **Views**: `resources/views/frontend/` — 7 pages + layouts/partials
- **Admin Views**: `resources/views/admin/` — dashboard, categories, tags, media, products
- **Components**: `resources/views/components/` — pagination, media-picker
- **Controllers**: FrontendController, Admin/AuthController, Admin/CategoryController, Admin/TagController, Admin/MediaController, Admin/ProductController
- **Toast/Confirm**: Use `Ravaa.toast()` and `Ravaa.confirm()` — never native `alert()` or `confirm()`
- **Docker Container**: `RavaaWeb`
