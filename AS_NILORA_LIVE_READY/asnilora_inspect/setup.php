<?php
require_once __DIR__.'/config.php';
$count=(int)$pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
if($count>0){exit('An admin account already exists. For safety, delete setup.php now.');}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$pass=$_POST['password']??'';
if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($pass)<12)$error='Enter a name, valid email and password of at least 12 characters.';
else{$s=$pdo->prepare("INSERT INTO admins(name,email,password_hash) VALUES(?,?,?)");$s->execute([$name,$email,password_hash($pass,PASSWORD_DEFAULT)]);echo 'Admin created. DELETE setup.php now, then sign in at <a href="'.e(url('admin/login.php')).'">Admin login</a>.';exit;}}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>AS NILORA Setup</title><link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>"></head><body><main class="section narrow"><h1>Create your store admin</h1><p>Use a strong password with at least 12 characters.</p><?php if($error): ?><p class="form-error"><?= e($error) ?></p><?php endif; ?><form method="post" class="checkout-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Your name<input name="name" required></label><label>Admin email<input name="email" type="email" required></label><label>Password<input name="password" type="password" minlength="12" required></label><button class="btn btn-gold">Create admin</button></form></main></body></html>
