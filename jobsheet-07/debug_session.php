<?php
session_start();
echo "<h3>Isi Data Session Saat Ini:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>