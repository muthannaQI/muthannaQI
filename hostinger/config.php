<?php
/**
 * ═══════════════════════════════════════════
 *  Bina App — إعدادات قاعدة البيانات
 *  plantaslb.com | Hostinger Shared Hosting
 * ═══════════════════════════════════════════
 * ⚠️  عدّل هذه القيم من لوحة hPanel في Hostinger
 *     Databases → MySQL Databases
 */

define('DB_HOST',    'localhost');
define('DB_NAME',    'u123456789_bina');   // ← اسم قاعدة البيانات
define('DB_USER',    'u123456789_bina');   // ← اسم المستخدم
define('DB_PASS',    'YOUR_STRONG_PASS');  // ← كلمة المرور
define('DB_CHARSET', 'utf8mb4');

/**
 * مفتاح سري لتشفير الجلسات — غيّره لسلسلة عشوائية طويلة
 * يمكن توليده من: https://www.random.org/strings/
 */
define('APP_SECRET', 'CHANGE_THIS_SECRET_KEY_32CHARS_MIN');

/**
 * عنوان التطبيق (بدون / في النهاية)
 * مثال: https://plantaslb.com  أو  https://plantaslb.com/bina
 */
define('APP_URL', 'https://plantaslb.com');
