<?php
require_once __DIR__ . '/config.php';
$cats = $pdo->query("SELECT * FROM categories WHERE is_active=1 ORDER BY id")->fetchAll();
$stmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 ORDER BY p.is_featured DESC,p.created_at DESC LIMIT 8");
$products = $stmt->fetchAll();
$pageTitle = 'Home';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
 <div class="hero-copy">
  <span class="eyebrow">THE AS NILORA COLLECTION</span>
  <h1>Little details.<br><em>Lasting elegance.</em></h1>
  <p>Discover jewellery and accessories that make every day feel a little more special.</p>
  <a class="btn btn-gold" href="<?= e(url('shop.php')) ?>">Shop the collection</a>
 </div>
 <div class="hero-art"><div class="hero-orbit"></div><div class="hero-caption">A touch of<br><strong>golden grace</strong></div></div>
</section>
<section class="section">
 <div class="section-heading"><div><span class="eyebrow">CURATED FOR YOU</span><h2>Shop by category</h2></div><a class="text-link" href="<?= e(url('shop.php')) ?>">View all products ↗</a></div>
 <div class="category-grid">
 <?php foreach ($cats as $cat): ?>
  <a class="category-card" href="<?= e(url('category.php?slug=' . urlencode($cat['slug']))) ?>">
   <div class="category-art"><span><?= e(strtoupper(substr($cat['name'],0,1))) ?></span></div>
   <div class="category-info"><h3><?= e($cat['name']) ?></h3><span>Explore collection ↗</span></div>
  </a>
 <?php endforeach; ?>
 </div>
</section>
<section class="section soft-section">
 <div class="section-heading"><div><span class="eyebrow">HANDPICKED FAVOURITES</span><h2>Featured pieces</h2></div><a class="text-link" href="<?= e(url('shop.php')) ?>">Shop all ↗</a></div>
 <?php if ($products): ?><div class="product-grid"><?php foreach ($products as $p): require __DIR__ . '/includes/product-card.php'; endforeach; ?></div>
 <?php else: ?><div class="empty-state"><h3>Your collection starts here.</h3><p>Products added from the admin dashboard will appear here.</p></div><?php endif; ?>
</section>
<section class="brand-note"><span class="eyebrow">AS NILORA</span><h2>Beauty in the details.</h2><p>Thoughtfully chosen pieces for your everyday moments and unforgettable occasions.</p></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
