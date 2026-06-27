-- Wedding Shedding Database
-- Create a MySQL database, then import this file.

CREATE TABLE IF NOT EXISTS settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    media_type ENUM('photo','video','reel') NOT NULL,
    title VARCHAR(180) DEFAULT NULL,
    category VARCHAR(120) DEFAULT NULL,
    file_path VARCHAR(255) NOT NULL,
    thumbnail_path VARCHAR(255) DEFAULT NULL,
    alt_text VARCHAR(255) DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    email VARCHAR(180) DEFAULT NULL,
    event_date DATE DEFAULT NULL,
    message TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings (setting_key, setting_value) VALUES
('business_name', 'Wedding Shedding'),
('site_tagline', 'Premium Wedding Photography & Cinematic Films'),
('logo_path', 'assets/images/logo.svg'),
('hero_background_image', 'assets/images/hero-wedding-bg.jpg'),
('hero_background_video', ''),
('hero_heading', 'Professional Wedding Photography,\nCinematic Wedding Video &\nWedding Shedding Services'),
('hero_description', 'We provide professional wedding photography, pre-wedding shoots, candid photography, traditional photography, wedding videos, cinematic wedding films, drone shoots and wedding shedding services for weddings, engagements, receptions and family functions.'),
('whatsapp_number', '+91 7503550936'),
('whatsapp_link', 'https://wa.me/917503550936'),
('call_number', '+917503550936'),
('google_review_link', 'https://g.page/r/CaNUqaPpp9tuEBM/review'),
('contact_email', 'booking@weddingshedding.com'),
('contact_address', 'India'),
('map_embed', 'https://www.google.com/maps?q=Wedding%20Shedding&output=embed'),
('service_wedding_photography', 'assets/images/service-wedding-photography.svg'),
('service_pre_wedding_shoot', 'assets/images/service-pre-wedding-shoot.svg'),
('service_candid_photography', 'assets/images/service-candid-photography.svg'),
('service_traditional_photography', 'assets/images/service-traditional-photography.svg'),
('service_wedding_video', 'assets/images/service-wedding-video.svg'),
('service_cinematic_wedding_video', 'assets/images/service-cinematic-wedding-video.svg'),
('service_drone_shoot', 'assets/images/service-drone-shoot.svg'),
('service_wedding_shedding', 'assets/images/service-wedding-shedding.svg')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

INSERT INTO media (media_type, title, category, file_path, alt_text, sort_order) VALUES
('photo', 'Royal Wedding Moment', 'Wedding', 'assets/images/gallery-photo-1.svg', 'Luxury wedding photography moment', 1),
('photo', 'Pre Wedding Romance', 'Pre-Wedding', 'assets/images/gallery-photo-2.svg', 'Premium pre wedding photography', 2),
('photo', 'Candid Ceremony Smile', 'Candid', 'assets/images/gallery-photo-3.svg', 'Candid wedding photography', 3),
('video', 'Cinematic Wedding Film', 'Wedding Film', 'assets/videos/sample-video.mp4', 'Cinematic wedding video sample', 1),
('reel', 'Wedding Reel Highlight', 'Reels', 'assets/videos/sample-reel.mp4', 'Instagram style wedding reel', 1)
ON DUPLICATE KEY UPDATE title = VALUES(title);
