<?php
$url = "http://localhost:3000/categories/";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f8f8f8;
        }
        h2 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 70%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Category List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
        </tr>
        <?php if (!empty($data) && is_array($data)) : ?>
            <?php foreach ($data as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['_id']); ?></td>
                    <td><?php echo htmlspecialchars($category['cname']); ?></td>
                    <td><?php echo htmlspecialchars($category['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No categories found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
