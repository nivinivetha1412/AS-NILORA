<?php
require_once __DIR__.'/config.php';
$slug=trim($_GET['slug']??'');
$stmt=$pdo->prepare("SELECT * FROM categories WHERE slug=? AND is_active=1");$stmt->execute([$slug]);$category=$stmt->fetch();
if(!$category){http_response_code(404);$pageTitle='Category not found';require __DIR__.'/includes/header.php';echo '<section class="empty-state"><h1>Category not found</h1><a href="'.e(url('shop.php')).'">Back to shop</a></section>';require __DIR__.'/includes/footer.php';exit;}
$stmt=$pdo->prepare("SELECT p.*,c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.category_id=? AND p.is_active=1 ORDER BY p.created_at DESC");$stmt->execute([$category['id']]);$products=$stmt->fetchAll();
$pageTitle=$category['name'];require __DIR__.'/includes/header.php';
?>
<section class="page-banner"><span class="eyebrow">AS NILORA COLLECTION</span><h1><?= e($category['name']) ?></h1><p><?= e($category['description'] ?: 'Explore the collection.') ?></p></section>
<section class="section"><div class="section-heading"><div><span class="eyebrow"><?= count($products) ?> PIECES</span><h2><?= e($category['name']) ?> collection</h2></div><a class="text-link" href="<?= e(url('shop.php')) ?>">All products ↗</a></div>
<?php if($products): ?><div class="product-grid"><?php foreach($products as $p) require __DIR__.'/includes/product-card.php'; ?></div><?php else: ?><div class="empty-state"><h3>New pieces are on their way.</h3><p>There are no products in this category yet. Please check back soon.</p></div><?php endif; ?></section>
<?php require __DIR__.'/includes/footer.php'; ?>
