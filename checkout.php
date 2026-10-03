<?php
require "config.php";

if (!isLoggedIn()) { header("Location: login.php"); exit; }
if (empty($_SESSION["cart"])) { header("Location: cart.php"); exit; }

$user=currentUser();
if(!$user){
    session_unset(); session_destroy();
    header('Location: login.php?error=session'); exit;
}

$error = "";
$shipping = decryptField($user['shipping_address'] ?? '');
$billing = decryptField($user['billing_address'] ?? '');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!csrf_ok($_POST['csrf'] ?? '')) {
        $error='Security check failed. Please refresh and try again.';
    } else {
        $address = trim($_POST["address"] ?? "");
        $billingAddress = trim($_POST["billing_address"] ?? "");
        $city = trim($_POST["city"] ?? "");
        $phone = trim($_POST["phone"] ?? "");
        $paymentMethod = $_POST["payment_method"] ?? "Cash on Delivery";

        if ($address === "" || $billingAddress === "" || $city === "" || $phone === "") {
            $error = "Please fill in all checkout fields.";
        } elseif (!preg_match('/^[0-9+()\-\s]{7,20}$/', $phone)) {
            $error = "Please enter a valid phone number.";
        } elseif (!in_array($paymentMethod,['Cash on Delivery','PayHere Sandbox'],true)) {
            $error = "Please select a valid payment method.";
        } else {
            $total = 0;
            $items = [];
            $itemNames = [];

            foreach ($_SESSION["cart"] as $pid => $qty) {
                $pid=(int)$pid; $qty=(int)$qty;
                if($qty<1) continue;
                $stmt=$conn->prepare("SELECT id,name,price,stock FROM products WHERE id=? LIMIT 1");
                $stmt->bind_param("i",$pid); $stmt->execute();
                $p=$stmt->get_result()->fetch_assoc();
                if(!$p) continue;
                if($qty>(int)$p['stock']) { $error='One or more products do not have enough stock.'; break; }
                $subtotal=(float)$p['price']*$qty;
                $total+=$subtotal;
                $items[]=[$p['id'],$qty,$p['price']];
                $itemNames[]=$p['name'].' x'.$qty;
            }

            if($error===''){
                $userId=(int)$user['id'];
                /* This prevents the foreign-key error caused by stale/deleted sessions. */
                $verify=$conn->prepare('SELECT id FROM users WHERE id=? LIMIT 1');
                $verify->bind_param('i',$userId); $verify->execute();
                if($verify->get_result()->num_rows===0){
                    session_unset(); session_destroy();
                    header('Location: login.php?error=session'); exit;
                }

                $status='Pending';
                $paymentStatus='Pending';
                $paymentReference=null;
                $orderPaymentMethod=$paymentMethod==='PayHere Sandbox'?'PayHere Sandbox':'Cash on Delivery';

                $stmt=$conn->prepare('INSERT INTO orders(user_id,customer_name,email,total,address,billing_address,city,phone,status,payment_method,payment_status,payment_reference) VALUES(?,?,?,?,?,?,?,? ,?,?,?,?,?)');
                $stmt->bind_param('issdssssssss',$userId,$user['name'],$user['email'],$total,$address,$billingAddress,$city,$phone,$status,$orderPaymentMethod,$paymentStatus,$paymentReference);
                if(!$stmt->execute()){
                    $error='Could not create the order. Please try again.';
                } else {
                    $orderId=$conn->insert_id;
                    $itemStmt=$conn->prepare('INSERT INTO order_items(order_id,product_id,quantity,unit_price) VALUES(?,?,?,?)');
                    foreach($items as [$pid,$qty,$price]){
                        $itemStmt->bind_param('iiid',$orderId,$pid,$qty,$price);
                        $itemStmt->execute();
                    }

                    if($paymentMethod==='PayHere Sandbox'){
                        $_SESSION['pending_payhere_order']=[
                            'order_id'=>$orderId,
                            'customer_name'=>$user['name'],
                            'email'=>$user['email'],
                            'phone'=>$phone,
                            'address'=>$address,
                            'billing_address'=>$billingAddress,
                            'city'=>$city,
                            'total'=>$total,
                            'items'=>$itemNames
                        ];
                        header('Location: payment.php'); exit;
                    }

                    $_SESSION['cart']=[];
                    header('Location: order_success.php?id='.$orderId); exit;
                }
            }
        }
    }
}

$pageTitle="Checkout | Ceylon Tea";
require "header.php";
?>
<section class="form-section">
<div class="form-card" style="max-width:720px">
<div class="gold-kicker">WEEK 07 · SECURE CHECKOUT</div>
<h1>Checkout</h1>
<?php if ($error): ?><div class="alert"><?php echo e($error); ?></div><?php endif; ?>
<form method="post">
<input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
<label>Customer Name</label>
<input value="<?php echo e($user['name']); ?>" disabled>
<label>Email</label>
<input value="<?php echo e($user['email']); ?>" disabled>
<label>Phone Number</label>
<input type="tel" name="phone" value="<?php echo e($user['phone'] ?? ''); ?>" required>

<h3 style="margin-top:22px">Shipping Details</h3>
<label>Shipping Address</label>
<textarea name="address" rows="4" required><?php echo e($shipping); ?></textarea>
<label>City</label>
<input name="city" value="" placeholder="e.g. Matara" required>

<h3 style="margin-top:22px">Billing Details</h3>
<label>Billing Address</label>
<textarea name="billing_address" rows="4" required><?php echo e($billing); ?></textarea>

<label>Payment Method</label>
<select name="payment_method" style="width:100%;padding:11px;border:1px solid #ccc4b5;border-radius:5px;font-size:14px;background:#fffdf8" required>
<option value="Cash on Delivery">Cash on Delivery</option>
<option value="PayHere Sandbox">PayHere Sandbox — Online Payment</option>
</select>
<div class="payment-note" style="margin-top:12px;padding:12px;border:1px solid rgba(199,163,74,.35);background:#f7efdc;border-radius:6px;font-size:12px;color:#6b5a38">
<strong>PayHere Sandbox:</strong> selecting this option sends the order to the PayHere test gateway. Your website does not collect or store card numbers.
</div>
<button class="btn" type="submit">PAY NOW / PLACE ORDER</button>
</form>
</div>
</section>
<?php require "footer.php"; ?>
