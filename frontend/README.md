
# 📰 News Aggregator – Frontend (Next.js)

This is the **frontend** of the News Aggregator case study project, built using **React**, **Next.js (App Router)**, and **Redux**. The application fetches articles from multiple sources via a Laravel API backend, allowing users to view and filter news articles by category and source.

---

## 🚀 Features Implemented

- ✅ Article listing basic filtration on the homepage  
- ✅ User Authentication 
- ✅ Redux store for global state management  
- ✅ Structured file architecture for scalability  
- ✅ API service layer for backend communication  
- ✅ Clean UI with [shadcn/ui](https://ui.shadcn.com) components  
- ✅ Type-safe data structures  
- ✅ Responsive layout with reusable components

---

## ⚠️ Known Limitations & Incomplete Features

> The following features are in progress and not yet available in this version:

- ❌ **Personalized feed**:  
  Backend is ready, but integration with the frontend is not yet implemented.

- ❌ **Edit user preferences (categories, sources, authors)**:  
  The UI is partially designed and present, but backend connectivity is still pending.

- ❌ **Docker**:  
  This project is currently **not Dockerized**. You must run it manually via `npm` or `yarn`.

---

## 🧠 Tech Stack

- **React** + **Next.js** (App Router)
- **Redux Toolkit** for state management
- **TypeScript** for type safety
- **Tailwind CSS** via shadcn/ui
- **Axios** for backend communication
- **ESLint**, **Prettier** for code formatting
- **GitHub Actions** for CI
---

## Getting Started

First, run the development server:

```bash
npm run dev
# or
yarn dev
# or
pnpm dev
# or
bun dev
```

### 🔧 To Do (Next Steps)

- [ ] Integrate personalized feed from backend
- [ ] Fetch and update user news preferences
- [ ] Dockerize the frontend for consistent deployments
- [ ] Add unit and integration tests
- [ ] Improve error handling and fallback UI  


