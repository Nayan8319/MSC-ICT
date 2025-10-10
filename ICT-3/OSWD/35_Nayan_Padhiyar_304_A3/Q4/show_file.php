<?php
$dir = "uploads"; 

if (is_dir($dir)) {
    $files = scandir($dir);

    echo "<h3>Files in '$dir' directory:</h3>";
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
} else {
    echo "❌ Directory does not exist.";
}
?>
