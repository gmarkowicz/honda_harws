<html>
<head>
<title>DB Backup</title>
</head>

<body bgcolor="#DDDDDD">
<CENTER>
<BR>

<?php
include("config.php");
mysql_connect($host, $user, $pw);
$result_handle = mysql_list_dbs () or die ("mysql_list_dbs() failed with this error message: '" . mysql_error () . "'");
$number_rows = mysql_num_rows ($result_handle);
$repopt = @$_POST['repopt'];
$sicher = @$_POST['sicher'];
?>
<form name="frepopt" action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
<input type="hidden" name="repopt" value="1">
<select name="db_namero">
<?php
for ($oindex=0; $oindex < $number_rows; ++$oindex)
{
 $v_option = mysql_result ($result_handle, $oindex, 0);
?>
 <option value="<? echo $v_option; ?>"><? echo $v_option; ?></option>
<?php
}
?>
</select>
<input type="submit" name="submit" value="Repair / Optimize Tables" style="width: 200px;">
</form>
<?php
if($repopt)
{
//  echo "repopt";
 include('syrepopt.php');
 $repopt="";
}
?>
<BR>
<HR>
<BR>
<?php
//mysql_connect($host, $user, $pw);
//$result_handle = mysql_list_dbs () or die ("mysql_list_dbs() failed with this error message: '" . mysql_error () . "'");
//$number_rows = mysql_num_rows ($result_handle);
?>
<form name="fsicher" action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
<input type="hidden" name="sicher" value="1">
<select name="db_namesi">
<?php
for ($oindex=0; $oindex < $number_rows; ++$oindex)
{
 $v_option = mysql_result ($result_handle, $oindex, 0);
?>
 <option value="<? echo $v_option; ?>"><? echo $v_option; ?></option>
<?php
}
?>
</select>
<input type="submit" name="submit" value="Backup Database" style="width: 200px;">
</form>
<?php
if($sicher)
{
//  echo "sicher";
 include('sysicher.php');
 $sicher="";
}
?>
<BR>
</CENTER>
</body>
</html>
