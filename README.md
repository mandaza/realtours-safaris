# RealTours - October CMS Project

<p align="center">
    <img src="https://github.com/octobercms/october/blob/develop/themes/demo/assets/images/favicon.png?raw=true" alt="October" width="25%" height="25%" />
</p>

## About RealTours

RealTours is a real estate tour management system built on [October CMS](https://octobercms.com), a Content Management System (CMS) and web platform whose sole purpose is to make your development workflow simple again.

This project provides a comprehensive solution for managing real estate tours, bookings, and property management through an intuitive web interface.

## Project Features

- **Real Estate Tour Management**: Organize and schedule property tours
- **Booking System**: Handle tour reservations and confirmations
- **Property Management**: Manage property listings and details
- **User Management**: Handle user accounts and permissions
- **Modern UI/UX**: Clean, responsive design for optimal user experience

## Technology Stack

- **Backend**: October CMS (Laravel-based)
- **Frontend**: Modern HTML/CSS/JavaScript
- **Database**: MySQL/PostgreSQL
- **Additional**: Twilio integration for communications

## Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL/PostgreSQL database
- Web server (Apache/Nginx)

### Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd realtours
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your database and API credentials
   ```

4. **Install October CMS**
   ```bash
   php artisan october:install
   ```

5. **Build assets**
   ```bash
   npm run dev
   ```

## Development Workflow

This project uses a clean branch strategy for development:

- **main**: Production-ready code
- **clean-branch**: Development branch for new features
- **feature branches**: Individual feature development

## Contributing

Please follow the coding standards:

* [PSR 4 Coding Standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* [PSR 2 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
* [PSR 1 Coding Standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)

## Security

Please review [our security policy](https://github.com/octobercms/october/security/policy) on how to report security vulnerabilities.

## License

The October CMS platform is licensed software, see [End User License Agreement](./LICENSE.md) (EULA) for more details.

---

*Built with ❤️ using October CMS*
