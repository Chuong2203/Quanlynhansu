<?php require_once('Connections/Myconnection.php'); ?>
<?php
$ma_nv = $_GET['catID'];
$id = $_GET['tomID'];
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
  $updateSQL = sprintf("UPDATE tlb_hopdong SET ma_nhan_vien=%s, so_quyet_dinh=%s, tu_ngay=%s, den_ngay=%s, loai_hop_dong=%s, ghi_chu=%s WHERE id=%s",
                       GetSQLValueString($_POST['ma_nhan_vien'], "text"),
                       GetSQLValueString($_POST['so_quyet_dinh'], "text"),
                       GetSQLValueString($_POST['tu_ngay'], "date"),
                       GetSQLValueString($_POST['den_ngay'], "date"),
                       GetSQLValueString($_POST['loai_hop_dong'], "int"),
                       GetSQLValueString($_POST['ghi_chu'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($Myconnection, $database_Myconnection);
  $Result1 = mysqli_query($Myconnection, $updateSQL);

  $updateGoTo = "them_moi_hop_dong.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  sprintf("Location: %s", $updateGoTo);
}

mysqli_select_db($Myconnection, $database_Myconnection);
$query_RCHopdong_DS = "SELECT * FROM tlb_hopdong where ma_nhan_vien = '$ma_nv'";
$RCHopdong_DS = mysqli_query($Myconnection, $query_RCHopdong_DS);
$row_RCHopdong_DS = mysqli_fetch_assoc($RCHopdong_DS);
$totalRows_RCHopdong_DS = mysqli_num_rows($RCHopdong_DS);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<body text="#000000" link="#CC0000" vlink="#0000CC" alink="#000099">
<table class="row6" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20%"><a href="index.php?require=them_moi_quan_he_gia_dinh.php&catID=<?php echo $ma_nv; ?>&title=Quan h??? gia ????nh">Quan h??? gia ????nh</a></td>
          <td width="20%" align="center"><a href="index.php?require=them_moi_qua_trinh_cong_tac.php&catID=<?php echo $ma_nv; ?>&title=Qu?? tr??nh c??ng t??c">Qu?? tr??nh c??ng t??c</a></td>
          <td width="19%" align="center"><a href="index.php?require=them_moi_qua_trinh_luong.php&catID=<?php echo $ma_nv; ?>&title=Qu?? tr??nh l????ng">Qu?? tr??nh l????ng</a></td>
          <td width="20%" align="center"><a href="index.php?require=them_moi_hop_dong.php&catID=<?php echo $ma_nv; ?>&title=H???p ?????ng">H???p ?????ng</a></td>
          <td width="20%" align="center"><a href="index.php?require=them_moi_bao_hiem.php&catID=<?php echo $ma_nv; ?>&title=B???o hi???m">B???o hi???m</a></td>
        </tr>
      </table>
<table class="row2" width="800" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <th width="150">S??? Q??</th>
    <th width="80">T??? ng??y</th>
    <th width="100">?????n ng??y</th>
    <th width="120">Lo???i h???p ?????ng</th>
    <th width="200">Ghi ch??</th>
    <th colspan="3">&nbsp;</th>
  </tr>
    <?php do { ?>
      <tr>
        <td class="row1"><?php echo $row_RCHopdong_DS['so_quyet_dinh']; ?></td>
        <td class="row1"><?php echo $row_RCHopdong_DS['tu_ngay']; ?></td>
        <td class="row1"><?php echo $row_RCHopdong_DS['den_ngay']; ?></td>
        <td class="row1"><?php 
	if ($row_RCHopdong_DS['loai_hop_dong']==0)
	{
		echo "Kh??ng th???i h???n"; 
	}
	else
	{
		echo $row_RCHopdong_DS['loai_hop_dong'];
		echo " N??m";
	}
	?></td>
        <td class="row1"><?php echo $row_RCHopdong_DS['ghi_chu']; ?></td>
        <td class="row1"><a href="index.php?require=them_moi_hop_dong.php&catID=<?php echo $ma_nv; ?>&title=Th??m m???i qu?? tr??nh c??ng t??c">Th??m</a></td>
        <td class="row1"><a href="index.php?require=cap_nhat_hop_dong.php&catID=<?php echo $ma_nv; ?>&tomID=<?php echo $row_RCHopdong_DS['id']; ?>&title=C???p nh???t h???p ?????ng">S???a</a></td>
        <td class="row1">Xo??</td>
      </tr>
      <?php } while ($row_RCHopdong_DS = mysqli_fetch_assoc($RCHopdong_DS)); ?>
</table>
<?php
mysqli_free_result($RCHopdong_DS);
?>
<p></p>
<?php
mysqli_select_db($Myconnection, $database_Myconnection);
$query_RCHopdong_CN = "SELECT * FROM tlb_hopdong where ma_nhan_vien = '$ma_nv' and id = $id";
$RCHopdong_CN = mysqli_query($Myconnection, $query_RCHopdong_CN);
$row_RCHopdong_CN = mysqli_fetch_assoc($RCHopdong_CN);
$totalRows_RCHopdong_CN = mysqli_num_rows($RCHopdong_CN);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
 <table class="row2" width="800" align="center" cellpadding="3" cellspacing="3" bgcolor="#66CCFF">
    <tr valign="baseline">
      <td width="135" align="right" nowrap="nowrap">M?? nh??n vi??n:</td>
      <td width="240"><input type="text" name="ma_nhan_vien" value="<?php echo htmlentities($row_RCHopdong_CN['ma_nhan_vien'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td width="79">T??? ng??y:</td>
      <td width="305"><input type="text" name="tu_ngay" value="<?php echo htmlentities($row_RCHopdong_CN['tu_ngay'], ENT_COMPAT, 'utf-8'); ?>" size="25" />
      (yyyy/mm/dd)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">S??? quy???t ?????nh:</td>
      <td><input type="text" name="so_quyet_dinh" value="<?php echo htmlentities($row_RCHopdong_CN['so_quyet_dinh'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>?????n ng??y:</td>
      <td><input type="text" name="den_ngay" value="<?php echo htmlentities($row_RCHopdong_CN['den_ngay'], ENT_COMPAT, 'utf-8'); ?>" size="25" />
      (yyyy/mm/dd)</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Lo???i h???p ?????ng:</td>
      <td><select name="loai_hop_dong">
      <option selected="selected" value="<?php echo $row_RCHopdong_CN['loai_hop_dong']?>">
	  <?php 
	  if ($row_RCHopdong_CN['loai_hop_dong']==0)
	  	{
			echo "Kh??ng th???i h???n";
		}
		else
		{
			echo $row_RCHopdong_CN['loai_hop_dong'];
			echo " N??m";
		}
	  ?>
      </option>  
        <option value="0" >Kh??ng th???i h???n</option>
        <option value="1" >1 N??m</option>
        <option value="2" >2 N??m</option>
        <option value="3" >3 N??m</option>
        <option value="4" >4 N??m</option>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ghi ch??:</td>
      <td colspan="3"><input type="text" name="ghi_chu" value="<?php echo htmlentities($row_RCHopdong_CN['ghi_chu'], ENT_COMPAT, 'utf-8'); ?>" size="87" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" nowrap="nowrap"><input type="submit" value=":|: C???p nh???t :|:" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_RCHopdong_CN['id']; ?>" />
</form>
<?php
mysqli_free_result($RCHopdong_CN);
?>
<p></p>
</body>
</html>