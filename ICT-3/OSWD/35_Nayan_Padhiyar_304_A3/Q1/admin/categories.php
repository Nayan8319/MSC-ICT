<?php
require_once '../db.php';
session_start();
if(!isset($_SESSION['admin_id'])) header('Location: login.php');

$action = $_GET['action'] ?? '';
if($action=='add' && $_SERVER['REQUEST_METHOD']=='POST'){
    $name = trim($_POST['name']);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/','-', $name));
    $stmt = $conn->prepare("INSERT INTO categories (name,slug) VALUES (?,?)");
    $stmt->bind_param('ss',$name,$slug);
    $stmt->execute();
    header('Location: categories.php');
    exit;
}
if($action=='delete'){
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM categories WHERE id=$id");
    header('Location: categories.php');
    exit;
}
$cats = $conn->query("SELECT * FROM categories ORDER BY name");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage Categories</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="container admin-panel">
  <div class="sidebar">
    <a href="dashboard.php" class="btn">Dashboard</a>
  </div>
  <div class="content">
    <h3>Categories</h3>
    <form method="post" action="categories.php?action=add">
      <div class="form-row"><input type="text" name="name" placeholder="Category name" required></div>
      <div class="form-row"><button class="btn" type="submit">Add Category</button></div>
    </form>
    <h4>Existing</h4>
    <table cellpadding="6">
    <?php while($c=$cats->fetch_assoc()): ?>
      <tr><td><?=htmlspecialchars($c['name'])?></td><td><a href="categories.php?action=delete&id=<?=$c['id']?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
    <?php endwhile; ?>
    </table>
  </div>
</div>
</body></html>
