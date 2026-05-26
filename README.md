# LunaCycle (Core PHP Menstrual Tracker)

Production-style menstrual cycle tracking web app using **Core PHP 8+, MySQL, PDO, Tailwind CSS, Vanilla JS, Chart.js**.

## Features
- Secure auth: register/login/logout, password hashing, forgot password token reset flow.
- Private period tracking per user: period dates, notes, symptoms, severity.
- Prediction engine: average cycle length, period duration, next period, fertile window, ovulation prediction.
- Alerts architecture: dashboard reminders, browser notification ready, cron email/SMS/WhatsApp hook.
- Analytics dashboard with chart and cycle insight flags (irregularity detection).
- AI health insight messages and emergency suggestion points.
- Anonymous forum skeleton + admin panel skeleton.
- Multi-language starter (EN/AR/FR/HI).
- PWA starter (manifest + service worker).

## Setup
1. Create DB and import schema:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
2. Edit `config/config.php` for DB and integration keys.
3. Serve via Apache/Nginx or PHP built-in server:
   ```bash
   php -S localhost:8000
   ```
4. Open `http://localhost:8000`.

## Folder Structure
See required structure:
- `assets/`, `config/`, `database/`, `includes/`, `auth/`, `dashboard/`, `periods/`, `reminders/`, `analysis/`, `api/`, `uploads/`

## Security Controls
- Prepared statements everywhere (PDO)
- Password hashing with `password_hash()`
- Session-based authentication and ID regeneration
- CSRF token generation/validation
- Output escaping helper for XSS protection
- Access control by `user_id` ownership checks

## Suggested Enhancements
- PHPMailer + SMTP for reliable email.
- Twilio API + WhatsApp Cloud API for live messaging.
- PDF exports (Dompdf).
- Calendar heatmap and advanced trend charts.
- AI chatbot FAQ module.

## Sample Test Data
Add users via registration and periods from dashboard.
