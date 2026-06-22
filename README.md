# 🗣️ SpeakUp! — Speaking Question Card Game

A **colorful, aesthetic** English-speaking practice card game built with **Laravel 11**.
Pick a theme, choose your CEFR level (**A1 → B2**), draw question cards, and practice speaking aloud — solo, with a partner, or in class.

![Themes](https://img.shields.io/badge/themes-10-ec4899) ![Questions](https://img.shields.io/badge/questions-240-8b5cf6) ![Levels](https://img.shields.io/badge/levels-A1%E2%80%93B2-10b981) ![Laravel](https://img.shields.io/badge/Laravel-11-ff2d20) ![PHP](https://img.shields.io/badge/PHP-8.2+-777bb4)

---

## ✨ Features

- 🎨 **Colorful but aesthetic UI** — soft gradients, glassmorphism, smooth animations
- 🃏 **Card-flip game** — tap a card to reveal a sample answer, a tip, and useful vocabulary
- 🎯 **10 themes** — Daily Life, Travel, Food, Family, Work, Hobbies, Education, Technology, Health, Culture & Arts
- 📈 **4 CEFR levels per theme** — A1 (Beginner) → A2 (Elementary) → B1 (Intermediate) → B2 (Upper-Intermediate)
- ⏱️ **Built-in speaking timer** — auto-starts when you flip the card
- 🔀 **Shuffle, next/previous, mark-as-practiced** — full deck control
- ⌨️ **Keyboard shortcuts** — `←` `→` to navigate, `Space`/`Enter` to flip, `S` to shuffle
- 📊 **Progress tracking** — practiced cards are saved (session + server)
- 🧩 **Zero npm build** — uses the Tailwind Play CDN, so `composer install` is all you need
- 🗄️ **SQLite by default** — works out of the box; switch to MySQL anytime

---

## 🛠️ Tech Stack

| Layer       | Technology                                   |
|-------------|----------------------------------------------|
| Backend     | Laravel 11 (PHP 8.2+)                        |
| Database    | SQLite (default) or MySQL (Laragon)          |
| Templating  | Blade                                        |
| Styling     | Tailwind CSS (Play CDN) + custom CSS         |
| JavaScript  | Vanilla JS (no framework, no build step)     |
| Icons       | Lucide                                       |
| Fonts       | Baloo 2 (display) + Plus Jakarta Sans (body) |

---

## 📦 Requirements

To run this project locally you need:

- **PHP 8.2 or newer** (with extensions: `pdo_sqlite` or `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- **Composer** (PHP dependency manager)
- **[Laragon](https://laragon.org/download/)** (recommended) — bundles Apache/Nginx, PHP, MySQL, and Composer
- A browser 😄

> 💡 Laragon already ships with PHP, MySQL, and Composer, so it's the easiest way to get started on Windows.

---

## 🚀 Installation with Laragon (Windows)

This is the recommended setup. Laragon makes it trivially easy.

### 1. Install Laragon

Download **Laragon Full** from <https://laragon.org/download/> and install it.
The default install path is `C:\laragon`.

### 2. Clone the project into Laragon's `www` folder

Open a terminal (Laragon → *Terminal*, or any Git Bash / CMD) and run:

```bash
cd C:\laragon\www
git clone https://github.com/sandy12-cyber/jsclassgame.git
cd jsclassgame
```

> Laragon automatically maps any folder inside `www` to a local domain.
> After cloning, the app will be reachable at **<http://jsclassgame.test>** (Laragon auto-creates the `.test` domain via its built-in hosts trick).

### 3. Install PHP dependencies

```bash
composer install
```

> If `composer` is not in your PATH, use Laragon's terminal (it sets up PATH for you), or run `C:\laragon\bin\composer\composer.phar install`.

### 4. Create your environment file

```bash
cp .env.example .env
php artisan key:generate
```

This generates the application encryption key.

### 5. Choose your database

#### Option A — SQLite (zero config, recommended for quick start)

The `.env` ships with SQLite as the default. Just create the database file:

```bash
# On Windows / Laragon terminal:
touch database/database.sqlite
```

Or, manually create an empty file named `database.sqlite` inside the `database/` folder.

#### Option B — MySQL (Laragon's built-in MySQL)

Edit `.env` and set:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jsclassgame
DB_USERNAME=root
DB_PASSWORD=
```

Then create the database. You can do it from Laragon → *Database* (HeidiSQL),
or via command line:

```bash
mysql -u root -e "CREATE DATABASE jsclassgame CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

> Laragon's default MySQL credentials are `root` with an **empty** password.

### 6. Run migrations & seed the data

```bash
php artisan migrate --seed
```

This creates all tables and fills them with **10 themes** and **240 speaking questions** (6 per level × 4 levels × 10 themes).

### 7. Open it in your browser

- **Laragon pretty URL:** <http://jsclassgame.test>
- **Or via artisan serve:** `php artisan serve` → <http://localhost:8000>

You should see the colorful home page with all themes. 🎉

---

## 🖥️ Installation without Laragon (any OS)

If you're on macOS/Linux or prefer not to use Laragon:

```bash
# 1. Clone
git clone https://github.com/sandy12-cyber/jsclassgame.git
cd jsclassgame

# 2. Install dependencies
composer install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Database (SQLite is zero-config)
touch database/database.sqlite

# 5. Migrate & seed
php artisan migrate --seed

# 6. Serve
php artisan serve
# → open http://localhost:8000
```

---

## 🎮 How to Play

1. **Pick a theme** from the home page (e.g. ✈️ Travel & Adventure).
2. **Choose a level** — A1, A2, B1, or B2 — based on your confidence.
3. **Read the prompt aloud** and try to speak for the suggested time (shown on each card).
4. **Tap the card** to flip it and reveal:
   - a **sample answer**
   - a **tip** on how to approach the question
   - **useful vocabulary** chips
5. Use **Next / Previous / Shuffle** to navigate the deck.
6. Click **Mark practiced** to track which cards you've done (saved in your session).

### ⌨️ Keyboard shortcuts

| Key                 | Action            |
|---------------------|-------------------|
| `→` / `←`           | Next / Previous   |
| `Space` or `Enter`  | Flip the card     |
| `S`                 | Shuffle the deck  |

### 🏫 Using it in class

- Pair students up — one draws a card and answers, the other listens and asks a follow-up question.
- Use the built-in timer to challenge students to speak for the full duration.
- Flip the card to reveal the model answer, then have students improve on it.
- Shuffle for warm-ups, or go in order for structured practice.

---

## 📁 Project Structure

```
jsclassgame/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php      # Home + About pages
│   │   ├── ThemeController.php     # Theme detail (level picker)
│   │   └── GameController.php      # Card game + JSON API
│   └── Models/
│       ├── Theme.php
│       └── Question.php
├── database/
│   ├── migrations/                 # Schema (themes, questions, …)
│   └── seeders/
│       ├── data/
│       │   ├── themes.php          # 10 theme definitions
│       │   └── questions.php       # 240 speaking questions
│       ├── ThemeSeeder.php
│       └── QuestionSeeder.php
├── public/
│   ├── css/app.css                 # Custom styles + animations
│   └── js/game.js                  # Card game logic (vanilla JS)
├── resources/views/
│   ├── layouts/app.blade.php       # Main layout (Tailwind CDN)
│   ├── partials/                   # Header & footer
│   ├── home.blade.php              # Themes grid
│   ├── theme.blade.php             # Level picker
│   ├── game.blade.php              # The card game 🎴
│   └── about.blade.php             # How-to-play
├── routes/web.php
└── .env.example
```

---

## ✏️ Adding Your Own Questions

All questions live in a single readable file:

```
database/seeders/data/questions.php
```

The structure is:

```php
'theme-slug' => [
    'A1' => [
        [
            'What is your favourite food?',     // prompt
            'My favourite food is pizza…',       // sample answer
            'Use "My favourite food is…"',       // tip
            ['pizza', 'cheese', 'tomato'],       // vocabulary
        ],
        // …more A1 questions…
    ],
    'A2' => [ /* … */ ],
    'B1' => [ /* … */ ],
    'B2' => [ /* … */ ],
],
```

After editing, re-seed the database:

```bash
php artisan migrate:fresh --seed
```

> ⚠️ `migrate:fresh` drops all tables and re-creates them. Use plain `php artisan db:seed` if you only want to add data without resetting.

To add a **new theme**, edit `database/seeders/data/themes.php` and add an entry with a `slug`, `name`, `emoji`, `gradient` (Tailwind classes), `accent`, and `description`. Then add a matching `slug` key in `questions.php`.

---

## 🎨 Customizing the Look

- **Colors per theme:** edit the `gradient` field in `database/seeders/data/themes.php`
  (e.g. `from-rose-400 to-pink-500`). Use any Tailwind gradient classes.
- **Level colors:** defined inline in `resources/views/theme.blade.php` and `game.blade.php` (`$levelStyles` array).
- **Fonts:** swap the Google Fonts link in `resources/views/layouts/app.blade.php`.
- **Custom CSS:** `public/css/app.css`.
- **Game behavior:** `public/js/game.js`.

---

## 🔧 Common Commands

| Command                              | What it does                                  |
|--------------------------------------|-----------------------------------------------|
| `php artisan serve`                  | Start dev server on `localhost:8000`          |
| `php artisan migrate --seed`         | Create tables + fill with sample data         |
| `php artisan migrate:fresh --seed`   | Reset DB completely and re-seed               |
| `php artisan db:seed`                | Re-seed without dropping tables               |
| `php artisan route:list`             | List all routes                               |
| `php artisan tinker`                 | Interactive REPL for your app                 |
| `php artisan key:generate`           | Generate the APP_KEY                          |
| `php artisan optimize:clear`         | Clear all caches (config/route/view)          |
| `php artisan test`                   | Run the test suite                            |

---

## 🧯 Troubleshooting

**"No application encryption key has been specified."**
→ Run `php artisan key:generate`.

**Blank page / 500 error after cloning.**
→ Run `composer install` and `php artisan key:generate`. Check `storage/logs/laravel.log`.

**`SQLSTATE: no such table` errors.**
→ You forgot to migrate. Run `php artisan migrate --seed`.

**Database file not found (SQLite).**
→ Create the file: `touch database/database.sqlite` (or create an empty file manually).

**Permission denied on `storage/` or `bootstrap/cache/`.**
→ On macOS/Linux: `chmod -R 775 storage bootstrap/cache`.
→ On Laragon (Windows): usually not needed, but if it happens, right-click the folder → Properties → Security → grant full control to your user.

**Tailwind classes look unstyled.**
→ This project uses the **Tailwind Play CDN** which requires internet access on first load. Make sure you're online, or [self-host Tailwind](https://tailwindcss.com/docs/installation) if you need offline support.

**Changing `.env` doesn't take effect.**
→ Run `php artisan config:clear`.

**Laragon `.test` domain not resolving.**
→ Make sure Laragon is running and "Auto virtual hosts" is enabled in *Preferences → General*. Restart Laragon.

---

## ❓ FAQ

**Do I need Node.js / npm?**
No. Assets use the Tailwind Play CDN and vanilla JS. `composer install` is the only install step.

**Can I use this offline / in production?**
For production, replace the Tailwind CDN with a compiled build (see [Tailwind CLI](https://tailwindcss.com/docs/installation)) and run behind a real web server (Nginx/Apache). The CDN is great for learning and local dev.

**Is there authentication / user accounts?**
Not by default — progress is stored per-browser session to keep the app simple for classroom use. You can easily bolt on Laravel Breeze/Fortify if needed.

**Can I export questions or import from CSV?**
Not yet — questions are managed as PHP arrays for readability. A CSV importer would be a great first contribution! 😉
