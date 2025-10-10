<?php
require_once 'db.php';
session_start();
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $captcha = $_POST['captcha'] ?? '';
    if(!isset($_SESSION['captcha']) || $captcha != $_SESSION['captcha']) $err = 'Invalid CAPTCHA';
    else {
        if($name==''||$email==''||$pass=='') $err='Please fill all fields';
        else {
            $h = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->bind_param('sss',$name,$email,$h);
            if($stmt->execute()){
                header('Location: login.php');
                exit;
            } else $err='Failed to register - maybe email exists';
        }
    }
}
$val1 = rand(1,9); $val2 = rand(1,9);
$_SESSION['captcha'] = $val1 + $val2;
?>
<!doctype html><html><head><meta charset="utf-8"><title>Register</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="container">
  <div class="header"><div class="logo">MyShop</div><div class="nav"><a href="index.php">Home</a></div></div>
  <h3>Register</h3>
  <?php if($err) echo '<div class="alert">'.htmlspecialchars($err).'</div>'; ?>
  <form method="post">
    <div class="form-row"><label>Name</label><br><input type="text" name="name" required></div>
    <div class="form-row"><label>Email</label><br><input type="email" name="email" required></div>
    <div class="form-row"><label>Password</label><br><input type="password" name="password" required></div>
    <div class="form-row"><label>What is <?= $val1 ?> + <?= $val2 ?> ? (CAPTCHA)</label><br><input type="text" name="captcha" required></div>
    <div class="form-row"><button class="btn" type="submit">Register</button></div>
  </form>
</div>
</body></html>
