# NHPC Blog CMS

A role-based Content Management System for blogging, built with **CodeIgniter 4** and **MySQL**, featuring an admin approval workflow and AI-assisted comment moderation.

The platform supports three roles — **Viewer**, **Author**, and **Admin** — with authors submitting posts for review, admins moderating content and users, and an Ollama-powered local LLM screening comments before they go live.

---

## Features

### For Viewers
- Browse published blogs with pagination ("load more" infinite scroll)
- Search blogs by title/content with live autocomplete suggestions
- Filter blogs by category
- Like / unlike posts
- Comment on posts — comments are automatically screened by a local AI model before being saved

### For Authors
- Rich-text blog authoring with CKEditor 5, including inline image uploads
- Submit posts for admin approval (new posts start as "pending")
- Author dashboard listing all of their own submitted posts
- View rejected posts along with the admin's written review
- Edit and resubmit rejected posts for another round of review

### For Admins
- Review and approve/reject pending blog posts, with a written rejection reason sent back to the author
- View all approved, pending, and rejected blogs
- Manage users: view all registered users, block/remove accounts
- **New admin signups require approval from an existing admin** before they can log in
- Analytics dashboard: total blogs, and user counts broken down by role (admin/author/viewer)

### AI Comment Moderation
Every comment is passed to a local **Ollama** instance (`phi` model) before being stored. The model is prompted to classify the comment as `GOOD` or `BAD`; inappropriate comments are blocked at submission time rather than relying on manual moderation.

---

## Tech Stack

| Layer            | Technology                                   |
|-------------------|-----------------------------------------------|
| Backend framework | PHP 8.1+, CodeIgniter 4 (MVC)                 |
| Database          | MySQL (MySQLi driver)                         |
| Auth              | Session-based authentication, role middleware |
| Rich text editor  | CKEditor 5                                    |
| Icons             | Font Awesome 6.4              |
| AI moderation     | Ollama (local LLM, `phi` model) via REST call |

---

## Roles at a Glance

| Role    | Can do                                                                 | Requires approval? |
|---------|-------------------------------------------------------------------------|---------------------|
| Viewer  | Browse, search, like, comment                                          | No (auto-approved)  |
| Author  | Everything a Viewer can, plus create/edit/resubmit blog posts          | No (auto-approved)  |
| Admin   | Everything above, plus approve/reject posts, manage users, view analytics | Yes — approved by an existing admin |

---

## Database Schema (Core Tables)

- **users** — `username`, `email`, `password`, `role`, `is_approved`, `created_at`
- **blogs** — `title`, `content`, `author_id`, `image`, `category`, `is_approved`, `admin_review`, `created_at`
- **categories** — `category_name`
- **comments** — `blog_id`, `user_id`, `comment`
- **likes** — `blog_id`, `user_id`

`is_approved` on `blogs` uses `1` (approved), `0` (pending), `-1` (rejected). The same convention is used on `users.is_approved` for admin approval and for blocking users.

---

## Project Structure
```
app/
├── Controllers/
│   ├── AuthController.php       # Login, register, logout
│   ├── Blogcontroller.php       # Blog CRUD, likes, comments, search
│   ├── AdminController.php      # Blog/user moderation
│   ├── ProfileController.php
│   ├── Admin/
│   │   ├── Dashboard.php
│   │   └── Analytics.php
│   └── Author/
│       └── Dashboard.php
├── Models/                      # UserModel, BlogModel, CategoryModel, CommentModel, LikeModel
├── Libraries/
│   └── AIModerator.php          # Ollama-based comment moderation
└── Views/                       # Blog, auth, admin, author templates
```

---

## Setup & Installation

### Prerequisites
- PHP 8.1+
- Composer
- MySQL
- (Optional, for AI moderation) [Ollama](https://ollama.com) running locally with the `phi` model pulled: `ollama pull phi`

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/ChauhanShiv17/NHPC.git
cd NHPC

# 2. Install dependencies
composer install

# 3. Configure environment
cp env .env
# then edit .env and set:
#   database.default.hostname = localhost
#   database.default.database = nhpc_blog
#   database.default.username = <your_db_user>
#   database.default.password = <your_db_password>
#   database.default.DBDriver = MySQLi

# 4. Create the database and import schema
mysql -u root -p -e "CREATE DATABASE nhpc_blog"
mysql -u root -p nhpc_blog < schema.sql   # see note below

# 5. Serve the app
php spark serve
```

The app will be available at `http://localhost:8080`.

> **Note:** This repo doesn't currently include CI4 migration files or a `schema.sql` dump, so the database structure above needs to be created manually or exported from a working instance. Adding a proper migration/seed setup is on the improvements list.

---

## Known Limitations / Next Steps

- Passwords are currently hashed with MD5 — should be migrated to `password_hash()` (bcrypt/argon2).
- `.env` is committed to the repo; it should be gitignored with an `.env.example` kept instead.
- No database migrations — schema isn't reproducible from the repo alone yet.
- AI moderation depends on a local Ollama instance; no fallback moderation strategy if Ollama is unavailable.

---

## License

MIT
