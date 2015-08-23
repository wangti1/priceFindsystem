<?php require_once('Connections/pricefind.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE webprice SET product_name=%s, product_number=%s, product_price=%s WHERE id=%s",
                       GetSQLValueString($_POST['product_name'], "text"),
                       GetSQLValueString($_POST['product_number'], "int"),
                       GetSQLValueString($_POST['product_price'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_pricefind, $pricefind);
  $Result1 = mysql_query($updateSQL, $pricefind) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsupdate = "-1";
if (isset($_GET['id'])) {
  $colname_rsupdate = $_GET['id'];
}
mysql_select_db($database_pricefind, $pricefind);
$query_rsupdate = sprintf("SELECT * FROM webprice WHERE id = %s", GetSQLValueString($colname_rsupdate, "int"));
$rsupdate = mysql_query($query_rsupdate, $pricefind) or die(mysql_error());
$row_rsupdate = mysql_fetch_assoc($rsupdate);
$totalRows_rsupdate = mysql_num_rows($rsupdate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格更新</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>
    <label for="id">ID:</label>
    <input name="id" type="text" id="id" value="<?php echo $row_rsupdate['id']; ?>" readonly="readonly" />
  </p>
  <p>
    <label for="product_name">商品名称：</label>
    <input name="product_name" type="text" id="product_name" value="<?php echo $row_rsupdate['product_name']; ?>" />
  </p>
  <p>
    <label for="product_number">商品数量：</label>
    <input name="product_number" type="text" id="product_number" value="<?php echo $row_rsupdate['product_number']; ?>" />
  </p>
  <p>
    <label for="product_price">商品价格：</label>
    <input name="product_price" type="text" id="product_price" value="<?php echo $row_rsupdate['product_price']; ?>" />
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="提交" />
    <input type="reset" name="reset" id="reset" value="重置" />
  </p>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsupdate);
?>
