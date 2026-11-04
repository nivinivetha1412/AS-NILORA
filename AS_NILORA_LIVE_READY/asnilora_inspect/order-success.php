<?php
require_once __DIR__.'/config.php';$order=$_SESSION['last_order']??null;if(!$order)redirect('shop.php');$pageTitle='Order received';require __DIR__.'/includes/header.php';
?>
<section class="empty-state success-state"><span class="success-mark">✓</span><span class="eyebrow">THANK YOU</span><h1>Your order is received.</h1><p>Thank you, <?= e($order['name']) ?>. Your order number is <strong><?= e($order['number']) ?></strong>.</p><p>Our team will contact you at <?= e($order['phone']) ?> to confirm delivery.</p><a class="btn btn-gold" href="<?= e(url('shop.php')) ?>">Continue shopping</a></section>
<?php unset($_SESSION['last_order']);require __DIR__.'/includes/footer.php'; ?>
