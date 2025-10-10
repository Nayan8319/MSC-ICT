<?php
require_once '../db.php';
session_start();
if(!isset($_SESSION['admin_id'])) header('Location: login.php');
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="container admin-panel">
  <div class="sidebar">
    <h4>Admin</h4>
    <div class="admin-links">
      <a href="categories.php" class="btn">Categories</a><br><br>
      <a href="products.php" class="btn">Products</a><br><br>
      <a href="logout.php" class="btn">Logout</a>
    </div>
  </div>
  <div class="content">
    <h3>Dashboard</h3>
    <p>Use the sidebar to manage categories and products.</p>
  </div>
</div>
</body></html>
