<?php
declare(strict_types=1);

// AS NILORA configuration. For live hosting, set these as hosting environment
// variables or create config.local.php (never commit that file to GitHub).
$localConfig = __DIR__ . '/config.local.php';
if (is_file($localConfig)) {
    require $localConfig; // May define ASN_* constants below.
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $isHttps,
        'samesite' => 'Lax',
    ]);
    session_start();
}

define('STORE_NAME', 'AS NILORA');
define('STORE_TAGLINE', 'Elegance in Every Detail.');
define('WHATSAPP_NUMBER', getenv('ASN_WHATSAPP_NUMBER') ?: '919000000000'); // Replace with your WhatsApp number, country code + digits.
define('STORE_EMAIL', getenv('ASN_STORE_EMAIL') ?: 'hello@asnilora.in');
define('CURRENCY', '₹');

// Leave ASN_BASE_URL empty when the site is installed at the domain root.
// Example subfolder: /as-nilora
$baseUrl = getenv('ASN_BASE_URL');
if ($baseUrl === false) {
    $baseUrl = '';
}
define('BASE_URL', rtrim($baseUrl, '/'));

$dbHost = getenv('ASN_DB_HOST') ?: 'localhost';
$dbName = getenv('ASN_DB_NAME') ?: 'as_nilora';
$dbUser = getenv('ASN_DB_USER') ?: 'root';
$dbPass = getenv('ASN_DB_PASS') ?: '';

try {
    $pdo = new PDO(
        'mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8mb4',
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log('AS NILORA database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('AS NILORA is not connected to its database yet. Please check the hosting database settings.');
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
function money($amount): string {
    return CURRENCY . number_format((float)$amount, 2);
}
function url(string $path = ''): string {
    return BASE_URL . ($path !== '' ? '/' . ltrim($path, '/') : '');
}
function redirect(string $path): never {
    header('Location: ' . url($path));
    exit;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sent = $_POST['csrf'] ?? '';
        if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
            http_response_code(419);
            exit('Session expired. Refresh the page and try again.');
        }
    }
}
function cart_count(): int {
    return array_sum($_SESSION['cart'] ?? []);
}
function cart_total(PDO $pdo): float {
    $total = 0;
    foreach (($_SESSION['cart'] ?? []) as $id => $qty) {
        $stmt = $pdo->prepare('SELECT price FROM products WHERE id=? AND is_active=1');
        $stmt->execute([(int)$id]);
        $p = $stmt->fetch();
        if ($p) $total += (float)$p['price'] * (int)$qty;
    }
    return $total;
}
function product_image(?string $image): string {
    return $image ? url('uploads/' . rawurlencode($image)) : url('assets/images/product-placeholder.svg');
}
