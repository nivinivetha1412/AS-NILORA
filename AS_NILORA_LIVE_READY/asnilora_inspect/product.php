<?php
require_once __DIR__ . '/config.php';
$id=(int)($_GET['id']??0);$stmt=$pdo->prepare("SELECT p.*,c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_active=1");$stmt->execute([$id]);$p=$stmt->fetch();
if(!$p){http_response_code(404);$pageTitle='Product not found';require __DIR__.'/includes/header.php';echo '<section class="empty-state"><h1>Piece not found</h1><a href="'.e(url('shop.php')).'">Back to shop</a></section>';require __DIR__.'/includes/footer.php';exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$qty=max(1,min(10,(int)($_POST['quantity']??1)));if($p['stock']>0){$_SESSION['cart'][$id]=min(10,($_SESSION['cart'][$id]??0)+$qty);$_SESSION['flash']='Added to your bag.';}else{$_SESSION['flash']='This product is currently out of stock.';}redirect('product.php?id='.$id);}
$pageTitle=$p['name'];require __DIR__.'/includes/header.php';
?>
<div class="section product-detail"><div class="detail-image"><img src="<?= e(product_image($p['image'])) ?>" alt="<?= e($p['name']) ?>"></div><div class="detail-copy"><span class="eyebrow"><?= e($p['category_name']) ?></span><h1><?= e($p['name']) ?></h1><div class="detail-price"><?= money($p['price']) ?></div><p><?= nl2br(e($p['description'] ?: 'A lovely addition to your AS NILORA collection.')) ?></p><p class="stock-note"><?= $p['stock']>0 ? '✓ In stock · '.$p['stock'].' available' : 'Currently out of stock' ?></p>
<form method="post" class="buy-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Quantity <input type="number" name="quantity" value="1" min="1" max="10"></label><button class="btn btn-gold" <?= $p['stock']<1?'disabled':'' ?>>Add to bag</button></form>
<a class="btn btn-outline whatsapp-btn" target="_blank" rel="noopener" href="https://wa.me/<?= e(WHATSAPP_NUMBER) ?>?text=<?= rawurlencode('Hi AS NILORA! I am interested in '.$p['name'].' ('.money($p['price']).'). Is it available?') ?>">Ask / order on WhatsApp</a><p class="muted small">Product colours and availability can be confirmed with us on WhatsApp.</p></div></div>
<?php require __DIR__.'/includes/footer.php'; ?>
