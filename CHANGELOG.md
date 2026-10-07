# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Added
- Nothing yet

### Changed
- Nothing yet

### Deprecated
- Nothing yet

### Removed
- Nothing yet

### Fixed
- Nothing yet

### Security
- Nothing yet

---

## [1.0.0] - 2026-10-07

### Added

#### Documentation
- ✅ `SRS.md` — Software Requirements Specification (IEEE 830 compliant)
- ✅ `ERD.md` — Entity Relationship Diagram (16 tables, 26 relationships)
- ✅ `API-Contracts.md` — 60 REST API endpoints documented
- ✅ `README.md` — Complete project overview
- ✅ `User-Manual-EN.md` — English user manual
- ✅ `User-Manual-AM.md` — Amharic user manual
- ✅ `CONTRIBUTING.md` — Contribution guide
- ✅ `CHANGELOG.md` — Version history
- ✅ `LICENSE` — MIT License

#### Configuration
- ✅ `.gitignore` — Git ignore rules
- ✅ `.gitattributes` — Git attributes for line endings
- ✅ `.vscode/settings.json` — VS Code settings
- ✅ `.vscode/extensions.json` — Recommended extensions
- ✅ `.vscode/launch.json` — Debug configurations
- ✅ `.vscode/tasks.json` — Quick tasks

#### Project Structure
- ✅ `backend/` — Laravel 13 API (initialized)
- ✅ `frontend/` — Vue 3 SPA (initialized)
- ✅ `diagrams/` — Architecture diagrams (placeholder)
- ✅ `.vscode/` — VS Code configuration

#### Dependencies Installed
- ✅ Laravel 13.34 (framework)
- ✅ Laravel Sanctum 4.3 (authentication)
- ✅ Spatie Permission 8.3 (RBAC)
- ✅ DomPDF 3.1 (PDF generation)
- ✅ Maatwebsite Excel 4.0 (Excel import/export)

### Database
- ✅ MySQL database `smart_school_db` created
- ✅ User `school_user` created with privileges

### Known Issues
- None

---

## [0.1.0] - 2026-10-01

### Added
- Initial project structure
- Development environment setup
- Git repository initialization
- Documentation skeleton

---

## Version History Summary

| Version | Date | Status | Notes |
|---------|------|--------|-------|
| 1.0.0 | 2026-10-07 | Development | Documentation complete |
| 0.1.0 | 2026-10-01 | Development | Project initialized |

---

## Upcoming Releases

### v1.1.0 (Planned — November 2026)
- SMS integration (AfroMessage)
- Telebirr payment gateway
- Report card generation (PDF)
- Parent mobile app (React Native)

### v1.2.0 (Planned — December 2026)
- Email notifications
- Advanced analytics
- Library fine automation
- Attendance SMS alerts

### v2.0.0 (Planned — 2027)
- Multi-language support (Amharic, Oromo, Tigrinya)
- Mobile apps (iOS, Android)
- AI-powered analytics
- Offline mode support

---

## Release Notes Format

Each release follows this format:

```markdown
## [X.Y.Z] - YYYY-MM-DD

### Added
- New features

### Changed
- Changes in existing functionality

### Deprecated
- Soon-to-be removed features

### Removed
- Removed features

### Fixed
- Bug fixes

### Security
- Security improvements
```

---

## How to Update This File

When making a Pull Request:

1. Add your changes under `## [Unreleased]`
2. Use the appropriate category (Added, Changed, Fixed, etc.)
3. Keep entries concise
4. Reference issue numbers when applicable

**Example:**
```markdown
### Added
- Student bulk import feature (#123)
- SMS notification for absences (#124)
```

---

**© 2026 Smart School Management System. All rights reserved.**