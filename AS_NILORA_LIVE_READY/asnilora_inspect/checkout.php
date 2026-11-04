<?php
require_once __DIR__ . '/config.php';
$items=[];$total=0;
foreach(($_SESSION['cart']??[]) as $id=>$qty){$s=$pdo->prepare("SELECT * FROM products WHERE id=? AND is_active=1");$s->execute([(int)$id]);if($p=$s->fetch()){$p['qty']=(int)$qty;$items[]=$p;$total+=(float)$p['price']*(int)$qty;}}
if(!$items){redirect('cart.php');}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();
$name=trim($_POST['name']??'');$phone=trim($_POST['phone']??'');$email=trim($_POST['email']??'');$address=trim($_POST['address']??'');$notes=trim($_POST['notes']??'');$method=$_POST['payment_method']??'COD';
if($name===''||$phone===''||$address==='')$error='Please fill in your name, phone number and delivery address.';
elseif(!in_array($method,['COD','WHATSAPP'],true))$error='Please choose a valid order method.';
else{
 try{$pdo->beginTransaction();$number='ASN'.date('ymd').strtoupper(bin2hex(random_bytes(3)));
 $s=$pdo->prepare("INSERT INTO orders(order_number,customer_name,phone,email,address,notes,payment_method,total) VALUES(?,?,?,?,?,?,?,?)");$s->execute([$number,$name,$phone,$email,$address,$notes,$method,$total]);$orderId=(int)$pdo->lastInsertId();
 $it=$pdo->prepare("INSERT INTO order_items(order_id,product_id,product_name,unit_price,quantity) VALUES(?,?,?,?,?)");
 foreach($items as $p){$it->execute([$orderId,$p['id'],$p['name'],$p['price'],$p['qty']]);}
 $pdo->commit();$_SESSION['last_order']=['number'=>$number,'name'=>$name,'phone'=>$phone,'address'=>$address,'total'=>$total,'items'=>$items];unset($_SESSION['cart']);
 if($method==='WHATSAPP'){$lines=["Hello AS NILORA, I would like to confirm my order ".$number,"Name: ".$name,"Phone: ".$phone,"Address: ".$address,"Items:"];foreach($items as $p)$lines[]=$p['name'].' x '.$p['qty'].' - '.money($p['price']*$p['qty']);$lines[]='Total: '.money($total);header('Location: https://wa.me/'.WHATSAPP_NUMBER.'?text='.rawurlencode(implode("\n",$lines)));exit;}
 redirect('order-success.php');
 }catch(Throwable $ex){if($pdo->inTransaction())$pdo->rollBack();$error='We could not place your order. Please try again or contact us on WhatsApp.';}
}}
$pageTitle='Checkout';require __DIR__.'/includes/header.php';
?>
<section class="page-banner"><span class="eyebrow">ALMOST YOURS</span><h1>Complete your order.</h1></section><section class="section checkout-layout"><form method="post" class="checkout-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><?php if($error): ?><p class="form-error"><?= e($error) ?></p><?php endif; ?><h2>Delivery details</h2><label>Full name *<input required name="name" value="<?= e($_POST['name']??'') ?>"></label><label>Phone number *<input required name="phone" type="tel" value="<?= e($_POST['phone']??'') ?>"></label><label>Email (optional)<input name="email" type="email" value="<?= e($_POST['email']??'') ?>"></label><label>Full delivery address *<textarea required name="address" rows="4"><?= e($_POST['address']??'') ?></textarea></label><label>Order notes (optional)<textarea name="notes" rows="2"><?= e($_POST['notes']??'') ?></textarea></label><h2>How would you like to order?</h2><label class="radio-line"><input type="radio" name="payment_method" value="COD" checked> Cash on Delivery (payment collected on delivery)</label><label class="radio-line"><input type="radio" name="payment_method" value="WHATSAPP"> Confirm order through WhatsApp</label><p class="muted small">Online card/UPI payments will be enabled after your payment gateway account is configured. Never share your UPI PIN or OTP with anyone.</p><button class="btn btn-gold">Place order</button></form><aside class="order-summary"><h2>Your order</h2><?php foreach($items as $p): ?><div class="summary-line"><span><?= e($p['name']) ?> × <?= (int)$p['qty'] ?></span><strong><?= money($p['price']*$p['qty']) ?></strong></div><?php endforeach; ?><div class="summary-line summary-total"><span>Total</span><strong><?= money($total) ?></strong></div></aside></section>
<?php require __DIR__.'/includes/footer.php'; ?>
