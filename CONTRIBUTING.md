# 🤝 Contributing to Smart School Management System

First off, thank you for considering contributing to SSMS! 🎉

---

## 📋 Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [How Can I Contribute?](#how-can-i-contribute)
3. [Development Setup](#development-setup)
4. [Style Guidelines](#style-guidelines)
5. [Commit Guidelines](#commit-guidelines)
6. [Pull Request Process](#pull-request-process)

---

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code. Please report unacceptable behavior to info@smart-school.et.

### Our Standards

- ✅ Using welcoming and inclusive language
- ✅ Being respectful of differing viewpoints
- ✅ Gracefully accepting constructive criticism
- ✅ Focusing on what is best for the community
- ✅ Showing empathy towards other community members

---

## How Can I Contribute?

### 🐛 Reporting Bugs

Before creating bug reports, please check existing issues. When you create a bug report, please include:

- **Description:** Clear description of the bug
- **Steps to Reproduce:** Step-by-step instructions
- **Expected Behavior:** What you expected
- **Actual Behavior:** What actually happened
- **Screenshots:** If applicable
- **Environment:** OS, browser, PHP version, etc.

### 💡 Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- **Title:** Clear and descriptive
- **Description:** Detailed explanation
- **Use Case:** Why this would be useful
- **Examples:** If applicable

### 📝 Improving Documentation

Documentation improvements are always welcome! This includes:

- Fixing typos
- Clarifying confusing sections
- Adding examples
- Translating to other languages

### 💻 Code Contributions

See [Development Setup](#development-setup) below.

---

## Development Setup

### Prerequisites

- PHP 8.3+
- Composer 2.x
- Node.js 20+
- npm 10+
- MySQL 8.0+
- Git

### Setup Steps

1. **Fork the repository**
   ```bash
   # Click "Fork" on GitHub
   ```

2. **Clone your fork**
   ```bash
   git clone https://github.com/YOUR_USERNAME/smart-school-management-system.git
   cd smart-school-management-system
   ```

3. **Add upstream remote**
   ```bash
   git remote add upstream https://github.com/your-org/smart-school-management-system.git
   ```

4. **Backend setup**
   ```bash
   cd backend
   composer install
   cp .env.example .env
   php artisan key:generate
   # Configure .env with your database
   php artisan migrate
   php artisan db:seed
   ```

5. **Frontend setup**
   ```bash
   cd ../frontend
   npm install
   ```

6. **Run servers**
   ```bash
   # Terminal 1 - Backend
   cd backend && php artisan serve
   
   # Terminal 2 - Frontend
   cd frontend && npm run dev
   ```

---

## Style Guidelines

### PHP (Backend)

- Follow **PSR-12** standards
- Use **Laravel Pint** for auto-formatting
  ```bash
  cd backend
  ./vendor/bin/pint
  ```
- Use **Type declarations** where possible
- Write **docblocks** for complex methods

**Example:**
```php
<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Student;

/**
 * Service for managing students.
 */
class StudentService
{
    /**
     * Register a new student.
     */
    public function register(array $data): Student
    {
        return Student::create($data);
    }
}
```

### JavaScript / TypeScript (Frontend)

- Follow **ESLint** rules
- Use **Prettier** for formatting
  ```bash
  cd frontend
  npm run lint
  npm run format
  ```
- Use **TypeScript** strict mode
- Prefer **Composition API** in Vue 3

**Example:**
```vue
<script setup lang="ts">
import { ref, computed } from 'vue'

interface Props {
  title: string
}

const props = defineProps<Props>()
const count = ref(0)
const doubled = computed(() => count.value * 2)
</script>

<template>
  <div>{{ title }}: {{ doubled }}</div>
</template>
```

### Vue 3

- Use **`<script setup>`** syntax
- Follow **Vue 3 Style Guide**
- Use **Composition API**
- Component names in **PascalCase**

### Markdown

- Use **ATX headings** (`#`, `##`, `###`)
- Add **blank lines** around code blocks
- Use **fenced code blocks** with language

---

## Commit Guidelines

We follow **Conventional Commits** specification.

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

| Type | Description |
|------|-------------|
| **feat** | New feature |
| **fix** | Bug fix |
| **docs** | Documentation only |
| **style** | Formatting, no code change |
| **refactor** | Code refactoring |
| **perf** | Performance improvement |
| **test** | Adding tests |
| **chore** | Build process, dependencies |

### Examples

```bash
# Feature
git commit -m "feat(students): add bulk import from Excel"

# Bug fix
git commit -m "fix(attendance): correct date format in report"

# Documentation
git commit -m "docs(readme): update installation steps"

# Refactor
git commit -m "refactor(auth): extract login logic to service"
```

---

## Pull Request Process

### 1. Create a Branch

```bash
git checkout -b feature/your-feature-name
# or
git checkout -b fix/your-bug-fix
```

### 2. Make Your Changes

- Write clean, well-documented code
- Add tests where appropriate
- Update documentation if needed

### 3. Run Tests

```bash
# Backend
cd backend && php artisan test

# Frontend
cd frontend && npm run test
```

### 4. Run Linters

```bash
# Backend
cd backend && ./vendor/bin/pint

# Frontend
cd frontend && npm run lint
```

### 5. Commit Your Changes

```bash
git add .
git commit -m "feat(module): description of change"
```

### 6. Push to Your Fork

```bash
git push origin feature/your-feature-name
```

### 7. Open a Pull Request

- Go to GitHub
- Click **"New Pull Request"**
- Select your branch
- Fill in the PR template
- Submit

### 8. PR Review

- Maintainers will review your PR
- Address any feedback
- Once approved, your PR will be merged

---

## 🎯 Good First Issues

Looking for a place to start? Check issues labeled:
- `good first issue`
- `help wanted`
- `documentation`

---

## 📞 Questions?

- 📧 Email: dev@smart-school.et
- 💬 GitHub Discussions: [link]
- 🐛 GitHub Issues: [link]

---

**Thank you for contributing! 🙏**

**Made with ❤️ in Ethiopia 🇪🇹**