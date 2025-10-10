<?php
require_once 'db.php';
$cats = $conn->query("SELECT * FROM categories ORDER BY name");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Shopping - Home</title>
<link rel="stylesheet" href="assets/style.css">
<script>
function loadProducts(catId, page=1) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET','products_ajax.php?cat='+catId+'&page='+page);
    xhr.onload = function(){
        if(xhr.status===200) document.getElementById('products').innerHTML = xhr.responseText;
    };
    xhr.send();
}
</script>
</head>
<body>
<div class="container">
  <div class="header">
    <div class="logo">MyShop</div>
    <div class="nav">
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
      <a href="admin/login.php">Admin</a>
    </div>
  </div>

  <h3>Categories</h3>
  <div class="categories">
    <?php while($c = $cats->fetch_assoc()): ?>
      <a href="javascript:void(0)" onclick="loadProducts(<?= $c['id'] ?>,1)" class="btn"><?= htmlspecialchars($c['name']) ?></a>
    <?php endwhile; ?>
  </div>

  <div id="products">
    <p>Select a category to load products (AJAX + pagination).</p>
  </div>

  
</div>
</body>
</html>
