# CodeIgniter Facility Booking System - Deployment Guide

## Prerequisites
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server with mod_rewrite enabled
- Composer

## Deployment Steps

### 1. Upload Files
Upload all files to your web hosting root directory or subdirectory.

### 2. Environment Configuration
Copy `.env` file and configure the following:

```env
CI_ENVIRONMENT = production
app.baseURL = 'https://yourdomain.com/'  # Replace with your actual domain
app.indexPage = ''

# Database Configuration
database.default.DBDriver = MySQLi
database.default.hostname = localhost  # Your database host
database.default.username = your_db_username
database.default.password = your_db_password
database.default.database = your_db_name
database.default.DBDebug = false
```

### 3. Database Setup
1. Create a MySQL database on your hosting
2. Import the database schema (run migrations):
   ```bash
   php spark migrate
   ```
3. Optionally, run seeders for initial data:
   ```bash
   php spark db:seed
   ```

### 4. File Permissions
Set proper permissions for the `writable` folder:
```bash
chmod -R 755 writable/
chmod -R 777 writable/cache/
chmod -R 777 writable/logs/
chmod -R 777 writable/session/
chmod -R 777 writable/uploads/
```

### 5. URL Rewriting
Ensure your web server supports `.htaccess` files or configure URL rewriting manually.

### 6. Admin Setup
After deployment, create an admin user by running:
```bash
php spark create:admin
```

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check file permissions on `writable/` folder
   - Ensure PHP version is 8.1+
   - Check `.env` configuration

2. **Database Connection Error**
   - Verify database credentials in `.env`
   - Ensure database exists and user has proper permissions
   - Check if MySQL server is running

3. **Page Not Found (404)**
   - Ensure mod_rewrite is enabled
   - Check `.htaccess` file is uploaded
   - Verify `app.baseURL` is correct

4. **App Folder Exposed**
   - The `app/` folder should be protected by `.htaccess`
   - If accessible, check server configuration

### Security Checklist
- [ ] Change default database credentials
- [ ] Set `CI_ENVIRONMENT = production`
- [ ] Disable debug mode (`database.default.DBDebug = false`)
- [ ] Set strong admin password
- [ ] Keep CodeIgniter and dependencies updated
- [ ] Regular backup of database and files

## Features
- User registration and authentication
- Role-based access control (Admin, Manager, User)
- Facility management
- Booking system
- Agency management
- Dynamic facility categories with custom fields

## Support
For issues, check the CodeIgniter documentation or community forums.