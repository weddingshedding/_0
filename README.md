# Wedding Shedding - Premium Wedding Photography Website

A complete PHP 8+ and MySQL premium wedding photography website with a hidden admin panel, photo gallery, video gallery, reels, contact form, 3D homepage effects, GSAP animations and responsive luxury design.

## Included Features

- Home, About, Services, Photo Gallery, Video Gallery, Reels and Contact pages
- Hidden admin panel through the small floating `SONU` button
- Admin login
  - Username: `7503550936`
  - Password: `Anubha@2255`
- Upload photos, videos and reels
- Delete photos, videos and reels
- Change website logo
- Change homepage background image
- Change homepage background video
- Change service images
- Manage homepage text
- Manage contact details
- Contact form saves messages into MySQL
- Floating WhatsApp, call and Google review buttons
- Three.js rose petals and golden particles
- GSAP animations, ScrollTrigger, smooth hover effects and lightbox viewer
- Mobile responsive design
- SEO metadata and JSON-LD schema

## Not Included

This website does not include stage decoration, mandap decoration, lighting decoration or decoration packages.

## Folder Structure

```text
/
index.php
about.php
services.php
gallery.php
videos.php
reels.php
contact.php
config.php
database.sql
README.md
.htaccess
admin/
uploads/
assets/
  css/
  js/
  images/
  videos/
fonts/
```

## Installation on PHP Hosting

1. Upload all files and folders to your hosting `public_html` or website root.
2. Create a MySQL database from your hosting control panel.
3. Import `database.sql` into your database using phpMyAdmin.
4. Open `config.php` and update:

```php
const DB_HOST = 'localhost';
const DB_NAME = 'your_database_name';
const DB_USER = 'your_database_user';
const DB_PASS = 'your_database_password';
```

5. Make sure these folders are writable by PHP:

```text
uploads/photos
uploads/videos
uploads/reels
uploads/logo
uploads/backgrounds
uploads/services
```

6. Open your website domain in the browser.
7. To access admin, click the tiny floating `SONU` button at the bottom-left.

## Admin Usage

After login, you can:

- Upload gallery photos
- Upload video gallery files
- Upload portrait reels
- Delete uploaded media
- Update logo
- Update homepage image/video
- Update service images
- Edit homepage text
- Edit contact details and map URL
- View latest contact form messages

## Contact Details Already Added

- Business Name: Wedding Shedding
- WhatsApp Number: +91 7503550936
- WhatsApp Link: https://wa.me/917503550936
- Google Review: https://g.page/r/CaNUqaPpp9tuEBM/review

## Recommended Hosting

Use PHP 8.0 or newer with MySQL/MariaDB. Shared PHP hosting works. For large wedding videos, increase hosting upload limits:

```ini
upload_max_filesize = 200M
post_max_size = 220M
max_execution_time = 300
```

## Security Notes

- Change the admin password in `config.php` after first deployment.
- Keep regular backups of the database and `uploads/` folder.
- Use HTTPS/SSL on the final domain.
- Do not keep `database.sql` publicly accessible after installation. The included `.htaccess` blocks direct access on Apache hosting.

## CDN Libraries Used

- Three.js
- GSAP
- GSAP ScrollTrigger
- Google Fonts

These are loaded from CDN for fast setup. You can download and host them locally if your client requires offline assets.
