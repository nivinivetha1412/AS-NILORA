<?php
require_once __DIR__ . '/../config.php';
function admin_required(): void { if(empty($_SESSION['admin_id'])) redirect('admin/login.php'); }
