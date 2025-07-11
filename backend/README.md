# 🧠 News Aggregator API – Laravel Backend

This is the backend API of the **News Aggregator App**, built with Laravel. It handles authentication, user preferences, article storage, personalization logic, and integration with external news sources like NewsAPI, The Guardian, and New York Times.

---

## 📦 Features

- 🔐 JWT-based authentication (Laravel Passport)
- 📥 Scheduled article fetching from:
    - NewsAPI.org
    - The Guardian API
    - New York Times API
- 🧠 Personalized feeds based on selected categories, sources, and authors
- 🔎 Advanced search and filtering (by keyword, category, date, source)
- 🧪 Fully testable with PHPUnit

---

## ⚙️ Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel 12
- Redis

---

## 🛡️Code Quality
- Static Code Analysis (PHP Stan + LaraStan) - Testing for potential errors.
    - `./vendor/bin/phpstan analyse`
- Php Code Sniffer - Testing for Common Standard for code writing style (PSR-12).
    - Detect Problems `./vendor/bin/phpcs --standard=PSR12 app`
    - Fix Problems `./vendor/bin/phpcbf --standard=PSR12 app`

---
