<?php
require_once 'db.php';
session_start();
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = $_POST['email']; $pass = $_POST['password'];
    $stmt = $conn->prepare("SELECT id,password FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if($r && password_verify($pass, $r['password'])){
        $_SESSION['user_id'] = $r['id'];
        header('Location: index.php'); exit;
    } else $err='Invalid credentials';
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="container">
  <div class="header"><div class="logo">MyShop</div><div class="nav"><a href="index.php">Home</a></div></div>
  <h3>Login</h3>
  <?php if($err) echo '<div class="alert">'.htmlspecialchars($err).'</div>'; ?>
  <form method="post">
    <div class="form-row"><label>Email</label><br><input type="email" name="email" required></div>
    <div class="form-row"><label>Password</label><br><input type="password" name="password" required></div>
    <div class="form-row"><button class="btn" type="submit">Login</button></div>
  </form>
</div>
</body></html>
