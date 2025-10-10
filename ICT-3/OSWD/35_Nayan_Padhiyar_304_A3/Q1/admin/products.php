<?php
require_once '../db.php';
require_once '../functions.php';
session_start();
if(!isset($_SESSION['admin_id'])) header('Location: login.php');

$action = $_GET['action'] ?? '';
if($action=='add' && $_SERVER['REQUEST_METHOD']=='POST'){
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $cat = intval($_POST['category_id']);
    $imgname = null;
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $up = $_FILES['image'];
        $ext = pathinfo($up['name'], PATHINFO_EXTENSION);
        $imgname = time().'_'.mt_rand(1000,9999).'.'.$ext;
        move_uploaded_file($up['tmp_name'], __DIR__.'/../uploads/'.$imgname);
        // resize
        resize_image(__DIR__.'/../uploads/'.$imgname, __DIR__.'/../uploads/'.$imgname, 600, 400);
    }
    $stmt = $conn->prepare("INSERT INTO products (category_id,name,description,price,image) VALUES (?,?,?,?,?)");
    $stmt->bind_param('issds',$cat,$name,$desc,$price,$imgname);
    $stmt->execute();
    header('Location: products.php');
    exit;
}
if($action=='delete'){
    $id = intval($_GET['id']);
    $r = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
    if($r && $r['image'] && file_exists(__DIR__.'/../uploads/'.$r['image'])) unlink(__DIR__.'/../uploads/'.$r['image']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header('Location: products.php');
    exit;
}

$cats = $conn->query("SELECT * FROM categories ORDER BY name");
$products = $conn->query("SELECT p.*, c.name as category FROM products p JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Manage Products</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="container admin-panel">
  <div class="sidebar"><a href="dashboard.php" class="btn">Dashboard</a></div>
  <div class="content">
    <h3>Products</h3>
    <form method="post" action="products.php?action=add" enctype="multipart/form-data">
      <div class="form-row"><label>Name</label><br><input type="text" name="name" required></div>
      <div class="form-row"><label>Category</label><br><select name="category_id" required><?php while($c=$cats->fetch_assoc()){ echo '<option value="'.$c['id'].'">'.htmlspecialchars($c['name']).'</option>'; } ?></select></div>
      <div class="form-row"><label>Price</label><br><input type="text" name="price" required></div>
      <div class="form-row"><label>Image</label><br><input type="file" name="image" accept="image/*"></div>
      <div class="form-row"><label>Description</label><br><textarea name="description"></textarea></div>
      <div class="form-row"><button class="btn" type="submit">Add Product</button></div>
    </form>

    <h4>Existing</h4>
    <table cellpadding="8">
      <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Action</th></tr>
    <?php while($p=$products->fetch_assoc()): $img = $p['image'] ? '../uploads/'.$p['image'] : '../assets/no-image.png'; ?>
      <tr>
        <td><?=$p['id']?></td>
        <td><img src="<?= $img ?>" style="height:60px"></td>
        <td><?=htmlspecialchars($p['name'])?></td>
        <td><?=htmlspecialchars($p['category'])?></td>
        <td><?=number_format($p['price'],2)?></td>
        <td><a href="products.php?action=delete&id=<?=$p['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
      </tr>
    <?php endwhile; ?>
    </table>
  </div>
</div>
</body></html>
