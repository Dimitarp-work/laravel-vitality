#  Playful Penguins Vitality Project

## Overview

The **Playful Penguins Vitality Project** is a comprehensive Laravel-based web application aimed at enhancing employee wellness and motivation within **Syntess Software**. The application encourages health tracking, goal-setting, gamification, and personalized content.

---

##  Table of Contents

- [Introduction](#-introduction)
- [Key Features](#-key-features)
- [Technologies](#-technologies)
- [Installation & Setup](#-installation--setup)
- [Usage](#-usage)
- [Stakeholders](#-stakeholders)
- [Validation Methods](#-validation-methods)
- [Implemented User Stories](#-implemented-user-stories)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

##  Introduction

Founded in 1987, **Syntess Software** specializes in ERP and mobile software solutions.  
The **Vitality Project** encourages healthier lifestyles through personalized wellness tracking and engagement.

---

##  Key Features

-  **User Authentication**: Secure Laravel-based login system.
-  **Employee Dashboard**: Wellness tracking, journaling, goal-setting, and challenges.
-  **HR Content Management**: Publish wellness content and review anonymized engagement.
-  **Gamification**: XP points, badges, leaderboards, with optional engagement.
-  **Personalization**: Custom themes, banners, avatars.
-  **Notifications**: Tailored email and in-app reminders.

---

##  Technologies

- Laravel 10
- Laravel Sail (Docker)
- Tailwind CSS
- Vue.js (optional)

---

##  Installation & Setup

### Prerequisites

- [Docker](https://www.docker.com/)
- [Git](https://git-scm.com/)

### Clone Repository

```bash
git clone <repository-url>
cd playful-penguins-vitality-project
```

### Setup with Laravel Sail

```bash
cp .env.example .env
./vendor/bin/sail up -d
```

### Install Dependencies

```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

### Generate App Key & Migrate Database

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### Compile Frontend Assets

```bash
./vendor/bin/sail npm run build
```

---

##  Usage

**Employees:** Daily check-ins, challenges, gamification, profile customization.  
**HR:** Content management, analytics of employee engagement.

---

##  Stakeholders

- **Primary:** Employees, HR
- **Secondary:** Project Manager, Management, IT Team

---

##  Validation Methods

- **Interviews:** Detailed user insights
- **Focus Groups:** Design feedback and improvements
- **Surveys:** Post-testing quantitative and qualitative feedback

---

##  Implemented User Stories

-  Emoji Mood Tracking  
-  Wellness Articles  
-  Interactive Challenges  
-  XP & Leaderboards  
-  Profile Customization  
-  Journaling and Reflections  
-  Custom Notifications  

---

##  Contributing

1. Fork the repo
2. Create your feature branch  
   ```bash
   git checkout -b feature/NewFeature
   ```
3. Commit your changes  
   ```bash
   git commit -m 'Add some NewFeature'
   ```
4. Push to the branch  
   ```bash
   git push origin feature/NewFeature
   ```
5. Open a Pull Request

---

##  License

Licensed under the **MIT License** – see [LICENSE.md](LICENSE.md) for details.

---

##  Contact

- **Dimitar Parvanov** (Developer)  
- **Gabriel Chitarliev** (Developer)  
- **Ivayla Ilieva** (Developer)  
- **Serghei Barhatov** (Onsite Customer)  
- **Marcell Nemes** (Developer)  
- **Jakub Holík** (Team Coach)

---

> 🌟 Supporting wellness, boosting motivation – **Playful Penguins Vitality Project** 🌟
