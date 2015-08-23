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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM webprice WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_pricefind, $pricefind);
  $Result1 = mysql_query($deleteSQL, $pricefind) or die(mysql_error());

  $deleteGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_rsdelete = "-1";
if (isset($_GET['id'])) {
  $colname_rsdelete = $_GET['id'];
}
mysql_select_db($database_pricefind, $pricefind);
$query_rsdelete = sprintf("SELECT * FROM webprice WHERE id = %s", GetSQLValueString($colname_rsdelete, "int"));
$rsdelete = mysql_query($query_rsdelete, $pricefind) or die(mysql_error());
$row_rsdelete = mysql_fetch_assoc($rsdelete);
$totalRows_rsdelete = mysql_num_rows($rsdelete);
?>
<form id="form1" name="form1" method="post" action="">
  <table width="616" border="1">
    <tr>
      <td>ID</td>
      <td>名称</td>
      <td>数量</td>
      <td>价格</td>
    </tr>
    <tr>
      <td><label for="id"></label>
      <input name="id" type="text" id="id" value="<?php echo $row_rsdelete['id']; ?>" readonly="readonly" /></td>
      <td><label for="product_name"></label>
      <input name="product_name" type="text" id="product_name" value="<?php echo $row_rsdelete['product_name']; ?>" /></td>
      <td><label for="product_number"></label>
      <input name="product_number" type="text" id="product_number" value="<?php echo $row_rsdelete['product_number']; ?>" /></td>
      <td><label for="product_price"></label>
      <input name="product_price" type="text" id="product_price" value="<?php echo $row_rsdelete['product_price']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="提交" />
      <input type="reset" name="reset" id="reset" value="重置" /></td>
    </tr>
  </table>
</form>
<?php
mysql_free_result($rsdelete);
?>
