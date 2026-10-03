<?php
/* PayHere server-to-server notification endpoint.
   IMPORTANT: PayHere requires notify_url to be publicly accessible.
   Do not treat a payment as successful without verifying md5sig. */
require 'config.php';

$merchantId=$_POST['merchant_id'] ?? '';
$orderId=$_POST['order_id'] ?? '';
$amount=$_POST['payhere_amount'] ?? '';
$currency=$_POST['payhere_currency'] ?? '';
$statusCode=$_POST['status_code'] ?? '';
$md5sig=$_POST['md5sig'] ?? '';

if($merchantId===''||$orderId===''||$amount===''||$currency===''||$statusCode===''||$md5sig===''){http_response_code(400);exit('Missing payment notification fields.');}
if($merchantId!==PAYHERE_MERCHANT_ID){http_response_code(403);exit('Invalid merchant.');}

$localSig=strtoupper(md5($merchantId.$orderId.$amount.$currency.$statusCode.strtoupper(md5(PAYHERE_MERCHANT_SECRET))));
if(!hash_equals($localSig,strtoupper($md5sig))){http_response_code(403);exit('Invalid signature.');}

$orderIdInt=(int)$orderId;
$amountFloat=(float)$amount;

$q=$conn->prepare('SELECT total FROM orders WHERE id=? LIMIT 1');
$q->bind_param('i',$orderIdInt); $q->execute(); $order=$q->get_result()->fetch_assoc();
if(!$order){http_response_code(404);exit('Order not found.');}
if(abs((float)$order['total']-$amountFloat)>0.009){http_response_code(400);exit('Amount mismatch.');}

$paymentMethod=$_POST['method'] ?? 'PayHere';
if($statusCode==='2'){
    $status='Processing'; $paymentStatus='Paid';
} elseif($statusCode==='0'){
    $status='Pending'; $paymentStatus='Pending';
} else {
    $status='Cancelled'; $paymentStatus='Failed';
}
$reference=$_POST['payment_id'] ?? null;

$u=$conn->prepare('UPDATE orders SET status=?,payment_status=?,payment_method=?,payment_reference=? WHERE id=?');
$u->bind_param('ssssi',$status,$paymentStatus,$paymentMethod,$reference,$orderIdInt); $u->execute();

http_response_code(200);
echo 'OK';
?>
