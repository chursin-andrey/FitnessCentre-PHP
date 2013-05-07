<html>
<head>
	<title>Специальности тренеров</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div align='center'>
	<font size='5'>
		<b>Специальности тренеров</b>
	</font>
	</div>
	<br>
	
	<?php
	include('dbconnect.php');
	$query = "SELECT tt_name FROM type_of_training";
	$result = mysql_query($query) or die ("Ошибка!" . mysql_error());
	$col_names = array("ЗАНЯТИЕ", "ТРЕНЕРЫ");
	echo "<table width='100%' border='1' cellspacing='0'>";
	echo "<tr align='center' valign='middle'>";
	
	for($i = 0; $i<2; $i++)
	{
		echo "<th>".$col_names[$i]."</th>";
	}
	
	echo "</tr>";
	
	while ($row = mysql_fetch_assoc($result))
	{
		echo "<tr align='center' valign='middle'>";	
		for ($i = 0; $i<2; $i++)
		{
			echo "<td>";
			switch($i)
			{
				case 0:
					echo $row["tt_name"];		
					break;
				case 1:
					$query2 = "SELECT full_name, tt_name FROM trainer_spec
 					 JOIN trainer ON trainer_spec.trainer_id = trainer.id
 					 JOIN type_of_training ON type_of_training.id = trainer_spec.tt_id
 					 WHERE tt_name LIKE '%" . $row["tt_name"] ."%'";
					$result2 = mysql_query($query2) or die(mysql_error());
					while ($row2 = mysql_fetch_assoc($result2))
					{
						if ($row["tt_name"] == $row2["tt_name"])
						{
							echo $row2["full_name"];
							echo "<br>";
						}						
					}	
					break;
			}
			echo "</td>";	
		}
		echo "</tr>";
	}
	
	echo "</table>";
	echo "<br>" . "<a href='practise.html'>Вернуться на главную страницу</a>";
	
	mysql_free_result($result);
	mysql_close($connection);
	?>
</body>
</html>