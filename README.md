
# 📰 News Aggregator App

A full-stack news aggregator web application built with **Laravel (API backend)** and **Next.js (React frontend)**. This project was developed as a technical case study to demonstrate my full-stack development skills, API integration, personalization features, and clean architecture.

---

## 🚀 Features

- 🔐 User authentication & registration
- 🔍 Article search by keyword
- 🗂️ Filtering by source, category, and date
- 🧠 Personalized news feed (user-selected preferences)
- ⏱️ Periodic article fetching from external APIs
- ⚙️ Modern stack with RESTful backend and React frontend

---

## 🧱 Tech Stack

| Layer        | Stack                                             |
|--------------|---------------------------------------------------|
| Frontend     | React (Next.js)                                   |
| Backend      | Laravel, Laravel Passport (API auth), MySQL       |
| Integrations | NewsAPI.org, The Guardian API, New York Times API |
| Tools        | Laravel Scheduler, Queues, Redis                  |

---

## Git Workflow

This project follows the **Git Flow** branching model.

### Branch Structure

- `main` – Stable, production-ready code
- `develop` – Active development branch
- `feature/*` – Feature branches
- `release/*` – Pre-release staging branches
- `bugfix/*` – Small isolated fixes
- `hotfix/*` – Emergency fixes for `main`
- `support/*` – Support branches for old releases
- Versions – `v1.0.0`, `v1.1.0`, etc.

### Git Flow Commands Used

This repo uses [Git Flow](https://nvie.com/posts/a-successful-git-branching-model/) via the CLI tool:

---

## License

This project is licensed under the MIT License – see the [LICENSE](./LICENSE) file for details.
