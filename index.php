<?php require_once('Connections/pricefind.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsdbprice = 3;
$pageNum_rsdbprice = 0;
if (isset($_GET['pageNum_rsdbprice'])) {
  $pageNum_rsdbprice = $_GET['pageNum_rsdbprice'];
}
$startRow_rsdbprice = $pageNum_rsdbprice * $maxRows_rsdbprice;

mysql_select_db($database_pricefind, $pricefind);
$query_rsdbprice = "SELECT * FROM webprice";
$query_limit_rsdbprice = sprintf("%s LIMIT %d, %d", $query_rsdbprice, $startRow_rsdbprice, $maxRows_rsdbprice);
$rsdbprice = mysql_query($query_limit_rsdbprice, $pricefind) or die(mysql_error());
$row_rsdbprice = mysql_fetch_assoc($rsdbprice);

if (isset($_GET['totalRows_rsdbprice'])) {
  $totalRows_rsdbprice = $_GET['totalRows_rsdbprice'];
} else {
  $all_rsdbprice = mysql_query($query_rsdbprice);
  $totalRows_rsdbprice = mysql_num_rows($all_rsdbprice);
}
$totalPages_rsdbprice = ceil($totalRows_rsdbprice/$maxRows_rsdbprice)-1;

$queryString_rsdbprice = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsdbprice") == false && 
        stristr($param, "totalRows_rsdbprice") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsdbprice = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsdbprice = sprintf("&totalRows_rsdbprice=%d%s", $totalRows_rsdbprice, $queryString_rsdbprice);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格查询系统</title>
<style type="text/css">
<!--
body,td,th {
	font-family: 新宋体;
}
-->
</style></head>

<body>
<table width="703" height="151" border="1">
  <caption>
  价格查询
  </caption>
  
  <tr>
    <th width="112" scope="col">主键id</th>
    <th width="217" scope="col">商品名称</th>
    <th width="138" scope="col">商品数量</th>
    <th width="208" scope="col">商品价格</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?id=<?php echo $row_rsdbprice['id']; ?>"><?php echo $row_rsdbprice['id']; ?> </a></td>
      <td><?php echo $row_rsdbprice['product_name']; ?></td>
      <td><?php echo $row_rsdbprice['product_number']; ?></td>
      <td><?php echo $row_rsdbprice['product_price']; ?></td>
    </tr>
    <?php } while ($row_rsdbprice = mysql_fetch_assoc($rsdbprice)); ?>
  <tr>
    <td>
      <?php if ($pageNum_rsdbprice > 0) { // Show if not first page ?>
        [第一页]
  <?php } // Show if not first page ?>    </td>
    <td><?php if ($pageNum_rsdbprice > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsdbprice=%d%s", $currentPage, max(0, $pageNum_rsdbprice - 1), $queryString_rsdbprice); ?>">[上一页]</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsdbprice < $totalPages_rsdbprice) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsdbprice=%d%s", $currentPage, min($totalPages_rsdbprice, $pageNum_rsdbprice + 1), $queryString_rsdbprice); ?>">[下一页]</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_rsdbprice < $totalPages_rsdbprice) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsdbprice=%d%s", $currentPage, $totalPages_rsdbprice, $queryString_rsdbprice); ?>">[最后一页]</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<p>共有<?php echo $totalRows_rsdbprice ?> 记录，目前查询<?php echo ($startRow_rsdbprice + 1) ?>至<?php echo min($startRow_rsdbprice + $maxRows_rsdbprice, $totalRows_rsdbprice) ?>记录</p>
</body>
</html>
<?php
mysql_free_result($rsdbprice);
?>
