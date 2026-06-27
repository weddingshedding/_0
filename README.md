# Wedding Shedding Website

Premium PHP/MySQL wedding photography website with hidden admin panel.

## Included

- Home, About, Services, Photo Gallery, Video Gallery, Reels, Contact
- Premium ivory, gold, maroon and blush design
- Homepage background image included by default
- Three.js particles / rose petals with GSAP scroll animation when CDN is available
- Hidden SONU admin access button, not shown in navbar
- Admin ID and password are not displayed on website pages
- Password field is hidden/dotted on login
- Admin credentials are stored as bcrypt hashes in `config.php`, not plain text
- Upload photos, videos and reels
- Delete/edit gallery media
- Change logo, homepage image/video, service images, homepage text and contact details
- Contact form, WhatsApp, call and Google review buttons
- MySQL database file included
- Local JSON fallback included, so the site opens even before database setup

## Upload Steps

1. Extract the ZIP.
2. Upload the `wedding-shedding` folder files to your PHP hosting `public_html` or website root.
3. Open the website in browser.
4. The homepage will work immediately with default background and fallback data.

## MySQL Setup for Final Hosting

1. Create a MySQL database from your hosting panel.
2. Open phpMyAdmin.
3. Import `database.sql`.
4. Open `config.php`.
5. Update these values:

```php
const DB_HOST = 'localhost';
const DB_NAME = 'your_database_name';
const DB_USER = 'your_database_user';
const DB_PASS = 'your_database_password';
```

After MySQL is connected, admin uploads and contact messages will save into MySQL and upload folders.

## Hidden Admin

- Admin is not visible in navbar.
- `/admin/index.php` intentionally shows private/404 page.
- Use the small hidden SONU circle on the website to open login.
- Login details are intentionally not written here.

## Important Folders

- `uploads/photos/` for uploaded photos
- `uploads/videos/` for uploaded videos
- `uploads/reels/` for uploaded reels
- `uploads/logo/` for logo uploads
- `uploads/backgrounds/` for homepage background image/video
- `uploads/services/` for service images
- `data/site-data.json` for fallback data before MySQL setup

## If Background Does Not Show

The default background file is included at:

`assets/images/hero-wedding-bg.jpg`

If you change the background from admin, make sure `uploads/backgrounds/` has write permission. On many hosting panels, folders should be `755` and files `644`.

## Requirements

- PHP 8+
- MySQL 5.7+ or MariaDB
- Apache/LiteSpeed hosting
- File upload enabled in PHP

