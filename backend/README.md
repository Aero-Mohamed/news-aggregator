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

## 🚀 Getting Started

Follow these steps to build and run the Laravel API using Docker.

### ⚙️ Prerequisites

Make sure you have the following installed on your system:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Docker Compose (comes with Docker Desktop)
- Linux/macOS/WSL recommended (or Git Bash on Windows)

## 🛠️ Installation Instructions

### 1️⃣ Start and Build Containers

```bash
docker-compose up -d --build
```
This builds the Docker containers and starts the Laravel app, MySQL, Redis, and Nginx services.

### 2️⃣ Enter the Laravel Continer
```bash
docker exec -it news_aggregator bash
```
This command opens an interactive terminal session inside the Laravel PHP container (called news_aggregator).

### 3️⃣ Run the Init Script
```bash
./init.sh
```

---

## 🛡️Code Quality
- Static Code Analysis (PHP Stan + LaraStan) - Testing for potential errors.
    - `./vendor/bin/phpstan analyse`
- Php Code Sniffer - Testing for Common Standard for code writing style (PSR-12).
    - Detect Problems `./vendor/bin/phpcs --standard=PSR12 app`
    - Fix Problems `./vendor/bin/phpcbf --standard=PSR12 app`

---
