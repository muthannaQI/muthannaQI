<?php
/**
 * ═══════════════════════════════════════════════════════
 *  Bina App — مُثبِّت قاعدة البيانات
 *  plantaslb.com | Hostinger
 * ═══════════════════════════════════════════════════════
 *  ⚠️  احذف هذا الملف فور انتهاء التثبيت!
 */
require_once __DIR__ . '/config.php';

$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->exec('USE `' . DB_NAME . '`');

        $tables = <<<SQL

        /* ── المستخدمون ── */
        CREATE TABLE IF NOT EXISTS bina_users (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            username   VARCHAR(100) NOT NULL UNIQUE,
            password   VARCHAR(255) NOT NULL,
            role       ENUM('admin','user') NOT NULL DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        /* ── الأعمال ── */
        CREATE TABLE IF NOT EXISTS bina_jobs (
            id          VARCHAR(60)  NOT NULL PRIMARY KEY,
            worker      VARCHAR(200) NOT NULL,
            work        VARCHAR(200) NOT NULL,
            date        DATE         NOT NULL,
            time        VARCHAR(10)  DEFAULT '',
            unit_type   VARCHAR(50)  DEFAULT 'مربع',
            unit_price  DECIMAL(12,4) DEFAULT 0,
            length      DECIMAL(12,4) DEFAULT 0,
            width       DECIMAL(12,4) DEFAULT 0,
            void_length DECIMAL(12,4) DEFAULT 0,
            void_width  DECIMAL(12,4) DEFAULT 0,
            half_void   TINYINT(1)   DEFAULT 0,
            double_work TINYINT(1)   DEFAULT 0,
            note        TEXT,
            entered_by  VARCHAR(100) DEFAULT '',
            created_at  TIMESTAMP   DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_worker (worker),
            INDEX idx_date   (date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        /* ── الدفعات ── */
        CREATE TABLE IF NOT EXISTS bina_payments (
            id         VARCHAR(60)   NOT NULL PRIMARY KEY,
            worker     VARCHAR(200)  NOT NULL,
            date       DATE          NOT NULL,
            time       VARCHAR(10)   DEFAULT '',
            amount     DECIMAL(12,2) NOT NULL DEFAULT 0,
            note       TEXT,
            entered_by VARCHAR(100)  DEFAULT '',
            created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_worker (worker),
            INDEX idx_date   (date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        /* ── سجل الحركات ── */
        CREATE TABLE IF NOT EXISTS bina_activity (
            id         VARCHAR(60)   NOT NULL PRIMARY KEY,
            type       VARCHAR(50)   DEFAULT '',
            worker     VARCHAR(200)  DEFAULT '',
            detail     TEXT,
            amount     DECIMAL(12,2) DEFAULT 0,
            ts         DATETIME      DEFAULT CURRENT_TIMESTAMP,
            entered_by VARCHAR(100)  DEFAULT '',
            created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_ts (ts)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        /* ── النسخ الاحتياطية ── */
        CREATE TABLE IF NOT EXISTS bina_backups (
            id           INT AUTO_INCREMENT PRIMARY KEY,
            backup_key   VARCHAR(60)  NOT NULL UNIQUE,
            ts           DATETIME     DEFAULT CURRENT_TIMESTAMP,
            trigger_type VARCHAR(50)  DEFAULT 'manual',
            data         LONGTEXT,
            size         INT          DEFAULT 0,
            created_at   TIMESTAMP   DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_ts (ts)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        /* ── الإعدادات ── */
        CREATE TABLE IF NOT EXISTS bina_settings (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            key_name   VARCHAR(100) NOT NULL UNIQUE,
            value      TEXT,
            updated_at TIMESTAMP   DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SQL;

        foreach (array_filter(array_map('trim', explode(';', $tables))) as $sql) {
            if ($sql) $pdo->exec($sql);
        }

        $success = true;

    } catch (PDOException $e) {
        $errors[] = 'خطأ في قاعدة البيانات: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>تثبيت Bina App</title>
<style>
  body { font-family: Tahoma, Arial, sans-serif; background: #f5f7f3; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
  .box { background: #fff; border: 1px solid #d8ded7; border-radius: 12px; padding: 36px 32px; width: min(480px, 94vw); box-shadow: 0 14px 34px rgba(0,0,0,.08); }
  h1 { margin: 0 0 6px; font-size: 22px; }
  p  { color: #68736d; font-size: 13px; margin: 0 0 24px; }
  .info { background: #e9f1ed; border: 1px solid #c8d8d1; border-radius: 8px; padding: 14px 16px; margin-bottom: 20px; font-size: 13px; }
  .info li { margin: 5px 0; }
  .error { background: #fdecea; border: 1px solid #f4b8b5; border-radius: 8px; padding: 12px 16px; color: #b74f47; font-size: 13px; margin-bottom: 16px; }
  .success { background: #e9f1ed; border: 1px solid #a3c4b7; border-radius: 8px; padding: 14px 16px; color: #17564b; margin-bottom: 16px; }
  button { min-height: 44px; width: 100%; background: #227467; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: inherit; }
  button:hover { background: #17564b; }
  .warn { color: #b74f47; font-weight: 700; margin-top: 16px; font-size: 13px; }
</style>
</head>
<body>
<div class="box">
  <h1>⚙️ تثبيت Bina App</h1>
  <p>سيتم إنشاء جداول قاعدة البيانات على <b><?= htmlspecialchars(DB_HOST) ?></b></p>

  <?php if ($errors): ?>
    <div class="error">
      <?php foreach ($errors as $e): ?><div>❌ <?= $e ?></div><?php endforeach ?>
    </div>
  <?php elseif ($success): ?>
    <div class="success">
      ✅ تم إنشاء جداول قاعدة البيانات بنجاح!<br><br>
      <b>الخطوة التالية:</b>
      <ol style="margin:8px 0 0;padding-right:18px;font-size:13px">
        <li>احذف ملف <code>install.php</code> فوراً</li>
        <li>افتح <a href="index.php">index.php</a> وسجّل حساب المدير</li>
      </ol>
    </div>
    <p class="warn">⚠️ احذف هذا الملف الآن لأسباب أمنية!</p>
  <?php else: ?>
    <div class="info">
      <b>الجداول التي سيتم إنشاؤها:</b>
      <ul style="margin:6px 0 0;padding-right:18px">
        <li>bina_users — المستخدمون</li>
        <li>bina_jobs — الأعمال</li>
        <li>bina_payments — الدفعات</li>
        <li>bina_activity — سجل الحركات</li>
        <li>bina_backups — النسخ الاحتياطية</li>
        <li>bina_settings — الإعدادات</li>
      </ul>
    </div>
    <form method="post">
      <button type="submit">🚀 تثبيت قاعدة البيانات</button>
    </form>
    <p class="warn" style="text-align:center">⚠️ احذف هذا الملف بعد التثبيت مباشرة!</p>
  <?php endif ?>
</div>
</body>
</html>
