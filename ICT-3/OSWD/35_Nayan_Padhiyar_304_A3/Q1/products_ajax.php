<?php
require_once 'db.php';
$cat = intval($_GET['cat'] ?? 0);
$page = max(1, intval($_GET['page'] ?? 1));
$per = 6;
$offset = ($page-1)*$per;

$totalRes = $conn->prepare("SELECT COUNT(*) as c FROM products WHERE category_id=?");
$totalRes->bind_param('i',$cat);
$totalRes->execute();
$tr = $totalRes->get_result()->fetch_assoc();
$total = $tr['c'];
$pages = max(1, ceil($total/$per));

$stmt = $conn->prepare("SELECT * FROM products WHERE category_id=? ORDER BY id DESC LIMIT ?,?");
$stmt->bind_param('iii',$cat,$offset,$per);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows==0){
    echo '<p class="alert">No products in this category.</p>';
    exit;
}
echo '<div class="grid">';
while($p = $res->fetch_assoc()){
    $img = $p['image'] ? 'uploads/'.htmlspecialchars($p['image']) : 'assets/no-image.png';
    echo '<div class="card"><img src="'. $img .'" alt=""><h4>'.htmlspecialchars($p['name']).'</h4><p>Rs '.number_format($p['price'],2).'</p></div>';
}
echo '</div>';
// pagination controls
echo '<div class="pagination">';
for($i=1;$i<=$pages;$i++){
    $active = $i==$page ? 'style="font-weight:bold;"' : '';
    echo "<a href=\"javascript:void(0)\" onclick=\"loadProducts($cat,$i)\" $active>$i</a> ";
}
echo '</div>';
?>