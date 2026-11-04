<?php
require_once __DIR__.'/config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$action=$_POST['action']??'';$id=(int)($_POST['id']??0);
 if($action==='remove'){unset($_SESSION['cart'][$id]);}
 if($action==='update'){foreach(($_POST['qty']??[]) as $pid=>$qty){$pid=(int)$pid;$qty=max(0,min(10,(int)$qty));if($qty===0)unset($_SESSION['cart'][$pid]);else $_SESSION['cart'][$pid]=$qty;}}
 redirect('cart.php');}
$items=[];$total=0;
foreach(($_SESSION['cart']??[]) as $id=>$qty){$s=$pdo->prepare("SELECT p.*,c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_active=1");$s->execute([(int)$id]);if($p=$s->fetch()){$p['qty']=(int)$qty;$p['line_total']=$p['price']*$qty;$items[]=$p;$total+=$p['line_total'];}}
$pageTitle='Your Bag';require __DIR__.'/includes/header.php';
?>
<section class="page-banner"><span class="eyebrow">YOUR SELECTION</span><h1>Your shopping bag.</h1></section><section class="section">
<?php if($items): ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><div class="cart-list"><?php foreach($items as $item): ?><div class="cart-row"><img src="<?= e(product_image($item['image'])) ?>" alt=""><div class="cart-product"><h3><?= e($item['name']) ?></h3><span><?= money($item['price']) ?> each</span></div><input type="number" name="qty[<?= (int)$item['id'] ?>]" value="<?= (int)$item['qty'] ?>" min="0" max="10"><strong><?= money($item['line_total']) ?></strong></div><?php endforeach; ?></div><div class="cart-bottom"><button class="btn btn-outline" name="action" value="update">Update bag</button><div class="cart-total"><span>Subtotal</span><strong><?= money($total) ?></strong></div></div></form><div class="checkout-actions"><a class="btn btn-gold" href="<?= e(url('checkout.php')) ?>">Continue to checkout</a><a class="text-link" href="<?= e(url('shop.php')) ?>">Continue shopping</a></div>
<?php else: ?><div class="empty-state"><h2>Your bag is waiting for something lovely.</h2><p>Explore the AS NILORA collection and add your favourites.</p><a class="btn btn-gold" href="<?= e(url('shop.php')) ?>">Explore the collection</a></div><?php endif; ?>
</section><?php require __DIR__.'/includes/footer.php'; ?>
