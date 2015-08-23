<?php require_once('Connections/pricefind.php'); ?>
<?php
$colname_rsdetail = "-1";
if (isset($_GET['id'])) {
  $colname_rsdetail = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_pricefind, $pricefind);
$query_rsdetail = sprintf("SELECT * FROM webprice WHERE id = %s", $colname_rsdetail);
$rsdetail = mysql_query($query_rsdetail, $pricefind) or die(mysql_error());
$row_rsdetail = mysql_fetch_assoc($rsdetail);
$totalRows_rsdetail = mysql_num_rows($rsdetail);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格详情查询</title>
</head>

<body>
<table width="652" border="1">
  <tr>
    <th width="73" scope="col">主键ID</th>
    <th width="149" scope="col">名称</th>
    <th width="162" scope="col">数量</th>
    <th width="147" scope="col">价格</th>
    <th width="87" scope="col">编辑</th>
  </tr>
  <tr>
    <td><?php echo $row_rsdetail['id']; ?></td>
    <td><?php echo $row_rsdetail['product_name']; ?></td>
    <td><?php echo $row_rsdetail['product_number']; ?></td>
    <td><?php echo $row_rsdetail['product_price']; ?></td>
    <td><a href="update.php?id=<?php echo $row_rsdetail['id']; ?>">修改</a>/<a href="delete.php?id=<?php echo $row_rsdetail['id']; ?>">删除</a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsdetail);
?>
