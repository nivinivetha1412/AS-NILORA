<?php
require_once __DIR__ . '/config.php';
$q = trim($_GET['q'] ?? '');
$sql = "SELECT p.*,c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.is_active=1";
$args=[];
if ($q !== '') { $sql .= " AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)"; $like='%'.$q.'%'; $args=[$like,$like,$like]; }
$sql .= " ORDER BY p.created_at DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($args); $products=$stmt->fetchAll();
$pageTitle='Shop'; require __DIR__.'/includes/header.php';
?>
<section class="page-banner"><span class="eyebrow">THE COLLECTION</span><h1>Find your favourite piece.</h1><p>Beautiful details, chosen for every version of you.</p></section>
<section class="section"><div class="section-heading"><div><span class="eyebrow"><?= count($products) ?> PIECES</span><h2><?= $q ? 'Search results' : 'All products' ?></h2></div></div>
<?php if($products): ?><div class="product-grid"><?php foreach($products as $p) require __DIR__.'/includes/product-card.php'; ?></div><?php else: ?><div class="empty-state"><h3>No pieces found just yet.</h3><p>Try another search, or browse our categories.</p><a class="btn btn-outline" href="<?= e(url('shop.php')) ?>">View all products</a></div><?php endif; ?>
</section><?php require __DIR__.'/includes/footer.php'; ?>
