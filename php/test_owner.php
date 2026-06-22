<?php

session_start();

echo "<h1>";
echo $_SESSION['user_id'];
echo "</h1>";

echo "<h2>";
echo $_SESSION['role'];
echo "</h2>";

?>