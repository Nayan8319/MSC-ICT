<?php
require_once '../db.php';
session_start();
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $u = $_POST['username']; $p = $_POST['password'];
    $stmt = $conn->prepare("SELECT id,password FROM admins WHERE username=? LIMIT 1");
    $stmt->bind_param('s',$u);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    
    if($r && (md5($p) === $r['password'] || password_verify($p, $r['password']))){
        $_SESSION['admin_id'] = $r['id'];
        header('Location: dashboard.php'); exit;
    } else $err='Invalid admin credentials';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Login</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="container">
  <h3>Admin Login</h3>
  <?php if($err) echo '<div class="alert">'.htmlspecialchars($err).'</div>'; ?>
  <form method="post">
    <div class="form-row"><label>Username</label><br><input type="text" name="username" required></div>
    <div class="form-row"><label>Password</label><br><input type="password" name="password" required></div>
    <div class="form-row"><button class="btn" type="submit">Login</button></div>
  </form>
</div>
</body></html>
