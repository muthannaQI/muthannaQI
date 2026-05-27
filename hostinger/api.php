<?php
/**
 * ═══════════════════════════════════════════════════
 *  Bina App — API Backend  v5.4
 *  plantaslb.com | Hostinger + MySQL
 * ═══════════════════════════════════════════════════
 */
declare(strict_types=1);

// ── Session ────────────────────────────────────────
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
// دعم Hostinger reverse proxy: يفحص كلا المتغيرين
$isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
if ($isHttps) {
    ini_set('session.cookie_secure', '1');
}
session_start();

require_once __DIR__ . '/config.php';

// ── Headers ────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Cache-Control: no-store');

// ── Helpers ────────────────────────────────────────
function out(array $data): void {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function fail(string $msg = 'error', int $code = 200): void {
    http_response_code($code);
    out(['ok' => false, 'error' => $msg]);
}
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}
function authUser(): ?string  { return $_SESSION['bina_user'] ?? null; }
function authRole(): ?string  { return $_SESSION['bina_role'] ?? null; }
function requireAuth(): void  { if (!authUser()) fail('unauthorized', 401); }
function requireAdmin(): void { requireAuth(); if (authRole() !== 'admin') fail('forbidden', 403); }

// ── Route ──────────────────────────────────────────
$action = trim($_GET['action'] ?? '');
$body   = (array)(json_decode(file_get_contents('php://input'), true) ?? []);

try {
    switch ($action) {

        // ── Auth ──────────────────────────────────

        case 'getSession':
            $u = authUser();
            out($u ? ['ok' => true, 'user' => $u, 'role' => authRole()] : ['ok' => false]);

        case 'getAuthStatus':
            $n = (int) db()->query('SELECT COUNT(*) FROM bina_users')->fetchColumn();
            out(['ok' => true, 'hasUsers' => $n > 0]);

        case 'bootstrapAdmin':
            $u = trim($body['user'] ?? '');
            $p = $body['pass'] ?? '';
            if (!$u || strlen($p) < 4) fail('invalid_input');
            $n = (int) db()->query('SELECT COUNT(*) FROM bina_users')->fetchColumn();
            if ($n > 0) fail('already_bootstrapped');
            $stmt = db()->prepare('INSERT INTO bina_users (username, password, role) VALUES (?, ?, ?)');
            $stmt->execute([$u, password_hash($p, PASSWORD_DEFAULT), 'admin']);
            session_regenerate_id(true); // منع session fixation
            $_SESSION['bina_user'] = $u;
            $_SESSION['bina_role'] = 'admin';
            out(['ok' => true, 'user' => $u, 'role' => 'admin']);

        case 'login':
            $u = trim($body['user'] ?? '');
            $p = $body['pass'] ?? '';
            if (!$u || !$p) fail('missing_fields');
            $stmt = db()->prepare('SELECT username, password, role FROM bina_users WHERE username = ?');
            $stmt->execute([$u]);
            $row = $stmt->fetch();
            if (!$row || !password_verify($p, $row['password'])) fail('invalid_credentials');
            session_regenerate_id(true);
            $_SESSION['bina_user'] = $row['username'];
            $_SESSION['bina_role'] = $row['role'];
            out(['ok' => true, 'user' => $row['username'], 'role' => $row['role']]);

        case 'logout':
            session_destroy();
            out(['ok' => true]);

        // ── Users ─────────────────────────────────

        case 'getUsers':
            requireAdmin();
            $rows = db()->query('SELECT username AS user, role FROM bina_users ORDER BY id')->fetchAll();
            out(['ok' => true, 'users' => $rows]);

        case 'createUser':
            requireAdmin();
            $u = trim($body['user'] ?? '');
            $p = $body['pass'] ?? '';
            $r = in_array($body['role'] ?? '', ['admin','user']) ? $body['role'] : 'user';
            if (!$u || strlen($p) < 4) fail('invalid_input');
            $stmt = db()->prepare('INSERT INTO bina_users (username, password, role) VALUES (?, ?, ?)');
            $stmt->execute([$u, password_hash($p, PASSWORD_DEFAULT), $r]);
            out(['ok' => true]);

        case 'deleteUser':
            requireAdmin();
            $u = trim($body['user'] ?? '');
            if (!$u || $u === authUser()) fail('cannot_delete_self');
            db()->prepare('DELETE FROM bina_users WHERE username = ?')->execute([$u]);
            out(['ok' => true]);

        case 'setUserPassword':
            requireAdmin();
            $u = trim($body['user'] ?? '');
            $p = $body['pass'] ?? '';
            if (!$u || strlen($p) < 4) fail('invalid_input');
            db()->prepare('UPDATE bina_users SET password = ? WHERE username = ?')
                ->execute([password_hash($p, PASSWORD_DEFAULT), $u]);
            out(['ok' => true]);

        case 'changePassword':
            requireAuth();
            $cur = $body['curPass'] ?? '';
            $new = $body['newPass'] ?? '';
            if (!$cur || strlen($new) < 4) fail('invalid_input');
            $stmt = db()->prepare('SELECT password FROM bina_users WHERE username = ?');
            $stmt->execute([authUser()]);
            $row = $stmt->fetch();
            if (!$row || !password_verify($cur, $row['password'])) fail('wrong_password');
            db()->prepare('UPDATE bina_users SET password = ? WHERE username = ?')
                ->execute([password_hash($new, PASSWORD_DEFAULT), authUser()]);
            out(['ok' => true]);

        // ── State ─────────────────────────────────

        case 'getState':
            requireAuth();
            $jobs = db()->query(
                'SELECT id, worker, work, date, time,
                        unit_type AS unitType, unit_price AS unitPrice,
                        length, width, void_length AS voidLength, void_width AS voidWidth,
                        half_void AS halfVoid, double_work AS doubleWork,
                        note, entered_by AS enteredBy
                 FROM bina_jobs ORDER BY date DESC, created_at DESC'
            )->fetchAll();
            $payments = db()->query(
                'SELECT id, worker, date, time, amount, note, entered_by AS enteredBy
                 FROM bina_payments ORDER BY date DESC, created_at DESC'
            )->fetchAll();
            $activity = db()->query(
                'SELECT id, type, worker, detail, amount, ts, entered_by AS enteredBy
                 FROM bina_activity ORDER BY ts DESC LIMIT 500'
            )->fetchAll();
            // Cast numerics / booleans
            foreach ($jobs as &$j) {
                $j['unitPrice']  = (float)$j['unitPrice'];
                $j['length']     = (float)$j['length'];
                $j['width']      = (float)$j['width'];
                $j['voidLength'] = (float)$j['voidLength'];
                $j['voidWidth']  = (float)$j['voidWidth'];
                $j['halfVoid']   = (bool)(int)$j['halfVoid'];
                $j['doubleWork'] = (bool)(int)$j['doubleWork'];
            } unset($j);
            foreach ($payments as &$p) { $p['amount'] = (float)$p['amount']; } unset($p);
            foreach ($activity as &$a) { $a['amount'] = (float)$a['amount']; } unset($a);
            out(['ok' => true, 'jobs' => $jobs, 'payments' => $payments, 'activityLog' => $activity]);

        case 'saveState':
            requireAuth();
            $jobs     = $body['jobs']        ?? [];
            $payments = $body['payments']     ?? [];
            $activity = $body['activityLog']  ?? [];
            try {
                db()->beginTransaction();
                // Jobs
                db()->exec('DELETE FROM bina_jobs');
                if ($jobs) {
                    $stmt = db()->prepare(
                        'INSERT INTO bina_jobs
                         (id,worker,work,date,time,unit_type,unit_price,length,width,
                          void_length,void_width,half_void,double_work,note,entered_by)
                         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
                    );
                    foreach ($jobs as $j) {
                        $stmt->execute([
                            $j['id'] ?? '', $j['worker'] ?? '', $j['work'] ?? '',
                            $j['date'] ?? date('Y-m-d'), $j['time'] ?? '',
                            $j['unitType'] ?? 'مربع', (float)($j['unitPrice'] ?? 0),
                            (float)($j['length'] ?? 0), (float)($j['width'] ?? 0),
                            (float)($j['voidLength'] ?? 0), (float)($j['voidWidth'] ?? 0),
                            (int)($j['halfVoid'] ?? 0), (int)($j['doubleWork'] ?? 0),
                            $j['note'] ?? '', $j['enteredBy'] ?? ''
                        ]);
                    }
                }
                // Payments
                db()->exec('DELETE FROM bina_payments');
                if ($payments) {
                    $stmt = db()->prepare(
                        'INSERT INTO bina_payments (id,worker,date,time,amount,note,entered_by)
                         VALUES (?,?,?,?,?,?,?)'
                    );
                    foreach ($payments as $p) {
                        $stmt->execute([
                            $p['id'] ?? '', $p['worker'] ?? '',
                            $p['date'] ?? date('Y-m-d'), $p['time'] ?? '',
                            (float)($p['amount'] ?? 0), $p['note'] ?? '', $p['enteredBy'] ?? ''
                        ]);
                    }
                }
                // Activity
                db()->exec('DELETE FROM bina_activity');
                if ($activity) {
                    $stmt = db()->prepare(
                        'INSERT INTO bina_activity (id,type,worker,detail,amount,ts,entered_by)
                         VALUES (?,?,?,?,?,?,?)'
                    );
                    foreach (array_slice($activity, 0, 500) as $a) {
                        $stmt->execute([
                            $a['id'] ?? '', $a['type'] ?? '', $a['worker'] ?? '',
                            $a['detail'] ?? '', (float)($a['amount'] ?? 0),
                            isset($a['ts']) ? date('Y-m-d H:i:s', strtotime($a['ts'])) : date('Y-m-d H:i:s'),
                            $a['enteredBy'] ?? ''
                        ]);
                    }
                }
                db()->commit();
                out(['ok' => true]);
            } catch (PDOException $txErr) {
                if (db()->inTransaction()) db()->rollBack();
                error_log('[Bina] saveState rollback: ' . $txErr->getMessage());
                fail('save_failed');
            }

        // ── Contact ───────────────────────────────

        case 'getContact':
            requireAuth();
            $rows = db()->query(
                'SELECT key_name, value FROM bina_settings WHERE key_name IN ("whatsapp","email")'
            )->fetchAll();
            $c = ['whatsapp' => '', 'email' => ''];
            foreach ($rows as $r) $c[$r['key_name']] = $r['value'];
            out(['ok' => true, 'contact' => $c]);

        case 'saveContact':
            requireAdmin();
            $w = trim($body['whatsapp'] ?? '');
            $e = trim($body['email']    ?? '');
            $stmt = db()->prepare(
                'INSERT INTO bina_settings (key_name, value) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE value = VALUES(value)'
            );
            $stmt->execute(['whatsapp', $w]);
            $stmt->execute(['email', $e]);
            out(['ok' => true]);

        // ── Backups ───────────────────────────────

        case 'createBackup':
            requireAuth();
            $trigger = trim($body['trigger'] ?? 'manual');
            $jobs     = db()->query('SELECT * FROM bina_jobs')->fetchAll();
            $payments = db()->query('SELECT * FROM bina_payments')->fetchAll();
            $activity = db()->query('SELECT * FROM bina_activity ORDER BY ts DESC LIMIT 500')->fetchAll();
            $json     = json_encode(
                ['jobs' => $jobs, 'payments' => $payments, 'activityLog' => $activity],
                JSON_UNESCAPED_UNICODE
            );
            $key  = 'bk_' . date('YmdHis') . '_' . substr(bin2hex(random_bytes(3)), 0, 6);
            $stmt = db()->prepare(
                'INSERT INTO bina_backups (backup_key, ts, trigger_type, data, size)
                 VALUES (?, NOW(), ?, ?, ?)'
            );
            $stmt->execute([$key, $trigger, $json, strlen($json)]);
            // احتفظ بآخر 50 نسخة فقط
            $ids = db()->query('SELECT id FROM bina_backups ORDER BY created_at DESC LIMIT 50')
                        ->fetchAll(PDO::FETCH_COLUMN);
            if ($ids) {
                $ph = implode(',', array_fill(0, count($ids), '?'));
                db()->prepare("DELETE FROM bina_backups WHERE id NOT IN ($ph)")->execute($ids);
            }
            out(['ok' => true, 'key' => $key]);

        case 'listBackups':
            requireAuth();
            $rows = db()->query(
                'SELECT backup_key AS `key`,
                        DATE_FORMAT(ts, "%Y-%m-%dT%TZ") AS ts,
                        trigger_type AS `trigger`, size
                 FROM bina_backups ORDER BY created_at DESC LIMIT 50'
            )->fetchAll();
            // الـ JS يتوقع مصفوفة مباشرة: if (Array.isArray(d))
            echo json_encode($rows, JSON_UNESCAPED_UNICODE);
            exit;

        case 'restoreBackup':
            requireAdmin();
            $key = trim($body['key'] ?? '');
            if (!$key) fail('missing_key');
            $stmt = db()->prepare('SELECT data FROM bina_backups WHERE backup_key = ?');
            $stmt->execute([$key]);
            $row = $stmt->fetch();
            if (!$row) fail('not_found');
            // تحقق من صحة JSON قبل الإرسال
            $decoded = json_decode($row['data'], true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($decoded['jobs'])) {
                fail('backup_data_corrupted');
            }
            echo $row['data'];
            exit;

        case 'deleteBackup':
            requireAdmin();
            $key = trim($body['key'] ?? '');
            if (!$key) fail('missing_key');
            db()->prepare('DELETE FROM bina_backups WHERE backup_key = ?')->execute([$key]);
            out(['ok' => true]);

        default:
            fail('unknown_action', 404);
    }

} catch (PDOException $e) {
    error_log('[Bina API] DB Error: ' . $e->getMessage());
    fail('database_error');
} catch (Exception $e) {
    error_log('[Bina API] Error: ' . $e->getMessage());
    fail('server_error');
}
