<?php
ini_set('max_execution_time',1330360);
ini_set('memory_limit', '3000M');
include("config.php");

$db1 = $_POST["db_namero"];

$db = mysql_connect($host,$user,$pw);
mysql_select_db($db1,$db);

?>

<table width=760 cellspacing=5 cellpadding=5 border=1 bordercolor="#EFEFEF">
<TR>
<TD colspan=4>
Database <b>&quot;<?php echo $db1; ?></b>&quot;
</TD>
</TR>
<TR>
<TD width=370 colspan=2>
Repairing...
</TD>
<TD width=370 colspan=2>
Optimizing...
</TD>
</TR>

<?php
$tbl_array = array(); $c = 0;
$result2 = mysql_list_tables($db1);
for($x=0; $x<mysql_num_rows($result2); $x++) 
{ 	
 $tabelle = mysql_tablename($result2,$x);
// echo $tabelle."<BR>";
?>

<TR>
<TD width=300>
<?php echo $tabelle; ?>
</TD>
<TD align=center width=70>
<?php
$sql = "REPAIR TABLE `".$tabelle."`";
$result = mysql_query($sql,$db); 
if (!$result)
{
 print mysql_error();
} 
else
{
 echo "Status <font color=red><b>OK</b></font>";
}
?>
</TD>
<TD width=300>
<?php echo $tabelle; ?>
</TD>
<TD align=center width=70>
<?php
$sql = "OPTIMIZE TABLE `".$tabelle."`";
$result = mysql_query($sql,$db); 
if (!$result)
{
 print mysql_error();
} 
else
{
 echo "Status <font color=red><b>OK</b></font>";
}
?>
<?php
$sql = "analyze TABLE `".$tabelle."`";
$result = mysql_query($sql,$db); 
if (!$result)
{
 print mysql_error();
} 
else
{
 echo "Status analyze <font color=red><b>OK</b></font>";
}
}
?>
</TD>
</TR>
</TABLE>

