<?php
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Lax']);
session_start();
$host='localhost'; $user='root'; $pass=''; $db='ceylon_tea';
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die('Database connection failed.');}
$conn->set_charset('utf8mb4');
function isLoggedIn(){return isset($_SESSION['user_id']);}
function isAdmin(){return isLoggedIn() && (($_SESSION['role'] ?? 'user')==='admin');}
function cartCount(){return isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;}
function requireLogin($return=''){if(!isLoggedIn()){ $url='login.php'; if($return!=='') $url.='?return='.urlencode($return); header('Location: '.$url); exit; }}
function requireAdmin(){if(!isAdmin()){header('Location: ../login.php?error=admin');exit;}}
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function csrf_token(){if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf'];}
function csrf_ok($token){return is_string($token)&&hash_equals($_SESSION['csrf']??'', $token);}
function encryptField($value){$key=hash('sha256', 'CEYLON_NOIR_PROFILE_KEY_2026', true);$iv=random_bytes(16);$tag='';$cipher=openssl_encrypt($value,'AES-256-CBC',$key,OPENSSL_RAW_DATA,$iv);return base64_encode($iv.$cipher);}
function decryptField($value){if(!$value)return ''; $raw=base64_decode($value,true);if($raw===false||strlen($raw)<17)return ''; $key=hash('sha256','CEYLON_NOIR_PROFILE_KEY_2026',true);return openssl_decrypt(substr($raw,16),'AES-256-CBC',$key,OPENSSL_RAW_DATA,substr($raw,0,16)) ?: '';}
?>
