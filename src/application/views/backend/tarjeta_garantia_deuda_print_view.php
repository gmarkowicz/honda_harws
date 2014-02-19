
<table class="tabla">

<?php
if(isset($headers))
{
	echo "<tr>\n";
	foreach ($headers as $campo):
		echo "<th>" . $campo . "</th>";
	endforeach;
	echo "</tr>\n";
}

if(isset($data))
{
	
	foreach ($data as $row):
		echo "<tr>\n";
		foreach ($row as $campo):
			echo "<td>" . $campo . "</td>";
		endforeach;
		echo "</tr>\n";
	endforeach;
	
}




?>

</table>