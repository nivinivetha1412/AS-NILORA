<?php $pageTitle = $pageTitle ?? 'Shop'; ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | <?= STORE_NAME ?></title><meta name="description" content="Discover elegant jewellery and accessories at AS NILORA.">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>"></head><body>
<div class="announcement">A LITTLE EXTRA ELEGANCE, EVERY DAY · WELCOME TO AS NILORA</div>
<header class="site-header"><a class="logo" href="<?= e(url()) ?>"><img src="<?= e(url('assets/images/logo.png')) ?>" onerror="this.style.display='none'" alt=""><span>AS <b>NILORA</b><small>JEWELLERY & ACCESSORIES</small></span></a>
<nav class="main-nav"><a href="<?= e(url()) ?>">Home</a><a href="<?= e(url('shop.php')) ?>">Shop</a><a href="<?= e(url('about.php')) ?>">Our Story</a><a href="<?= e(url('contact.php')) ?>">Contact</a></nav>
<div class="header-actions"><form class="search-form" action="<?= e(url('shop.php')) ?>"><input name="q" placeholder="Search pieces..." aria-label="Search products"><button aria-label="Search">⌕</button></form><a class="cart-link" href="<?= e(url('cart.php')) ?>">Bag <span><?= cart_count() ?></span></a><button class="menu-toggle" aria-label="Open menu">☰</button></div></header>
<main>
