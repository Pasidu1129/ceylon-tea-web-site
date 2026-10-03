<?php
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Lax']);
session_start();

$host='localhost'; $user='root'; $pass=''; $db='ceylon_tea';
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die('Database connection failed.');}
$conn->set_charset('utf8mb4');

/* =========================================================
   PAYHERE SANDBOX CONFIGURATION - WEEK 07
   Replace the two placeholders with your own Sandbox values.
   Add localhost as a Domain in PayHere Integrations.
   ========================================================= */
const PAYHERE_SANDBOX_URL = 'https://sandbox.payhere.lk/pay/checkout';
const PAYHERE_MERCHANT_ID = 'YOUR_SANDBOX_MERCHANT_ID';
const PAYHERE_MERCHANT_SECRET = 'YOUR_SANDBOX_MERCHANT_SECRET';
const PAYHERE_BASE_URL = 'http://localhost/Ceylon_Tea_Website';
/* notify_url must be publicly reachable for PayHere callbacks.
   Replace this with your public HTTPS URL when testing notifications. */
const PAYHERE_NOTIFY_URL = 'https://YOUR-PUBLIC-DOMAIN/payhere_notify.php';

function isLoggedIn(){return isset($_SESSION['user_id']);}
function isAdmin(){return isLoggedIn() && (($_SESSION['role'] ?? 'user')==='admin');}
function cartCount(){return isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;}
function requireLogin($return=''){if(!isLoggedIn()){ $url='login.php'; if($return!=='') $url.='?return='.urlencode($return); header('Location: '.$url); exit; }}
function requireAdmin(){if(!isAdmin()){header('Location: ../login.php?error=admin');exit;}}
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function csrf_token(){if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf'];}
function csrf_ok($token){return is_string($token)&&hash_equals($_SESSION['csrf']??'', $token);}
function encryptField($value){$key=hash('sha256', 'CEYLON_NOIR_PROFILE_KEY_2026', true);$iv=random_bytes(16);$cipher=openssl_encrypt($value,'AES-256-CBC',$key,OPENSSL_RAW_DATA,$iv);return base64_encode($iv.$cipher);}
function decryptField($value){if(!$value)return ''; $raw=base64_decode($value,true);if($raw===false||strlen($raw)<17)return ''; $key=hash('sha256','CEYLON_NOIR_PROFILE_KEY_2026',true);return openssl_decrypt(substr($raw,16),'AES-256-CBC',$key,OPENSSL_RAW_DATA,substr($raw,0,16)) ?: '';}
function currentUser(){
    global $conn;
    if(!isLoggedIn()) return null;
    $uid=(int)$_SESSION['user_id'];
    $q=$conn->prepare('SELECT id,name,email,role,phone,shipping_address,billing_address FROM users WHERE id=? LIMIT 1');
    $q->bind_param('i',$uid); $q->execute();
    return $q->get_result()->fetch_assoc() ?: null;
}
function splitCustomerName($name){
    $name=trim((string)$name);
    $parts=preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
    if(!$parts) return ['Customer',''];
    $first=array_shift($parts);
    return [$first, implode(' ', $parts)];
}
function payhereConfigured(){
    return PAYHERE_MERCHANT_ID !== 'YOUR_SANDBOX_MERCHANT_ID' && PAYHERE_MERCHANT_SECRET !== 'YOUR_SANDBOX_MERCHANT_SECRET';
}
function payhereHash($merchantId,$orderId,$amount,$currency,$merchantSecret){
    $formatted=number_format((float)$amount,2,'.','');
    $hashedSecret=strtoupper(md5($merchantSecret));
    return strtoupper(md5($merchantId.$orderId.$formatted.$currency.$hashedSecret));
}
?>
