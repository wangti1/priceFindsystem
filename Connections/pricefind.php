<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_pricefind = "localhost";
$database_pricefind = "price_find";
$username_pricefind = "root";
$password_pricefind = "";
$pricefind = mysql_pconnect($hostname_pricefind, $username_pricefind, $password_pricefind) or trigger_error(mysql_error(),E_USER_ERROR); 
?>