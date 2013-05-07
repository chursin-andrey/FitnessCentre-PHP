<html>
<head>
	<title>Список залов</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div align='center'>
	<font size='5'>
		<b>Список залов</b>
	</font>
	</div>
	<br>
	<?php
	include('dbconnect.php');
	$query = "SELECT `id`, `gym_number`, `area`, `cover`, `cond_availab`, `capacity`  FROM `gym`";
	$result = mysql_query($query) or die ("Ошибка!" . mysql_error());
	$col_num = mysql_num_fields($result);
	$col_names = array("№", "НОМЕР ЗАЛА", "ПЛОЩАДЬ (кв. м)", "ПОКРЫТИЕ", "НАЛИЧИЕ КОНДИЦИОНЕРА", "ВМЕСТИМОСТЬ (человек)", "ДЕЙСТВИЯ");
	echo "<table width='100%' border='1' cellspacing='0'>";
	echo "<tr align='center' valign='middle'>";
	
	for($i = 0; $i < $col_num+1; $i++)
	{
		echo "<th>".$col_names[$i]."</th>";
	}
	echo "</tr>";
	
	$index = 0;
	while ($row = mysql_fetch_assoc($result))
	{
		echo "<tr align='center' valign='middle'>";	
		for ($i = 0; $i < $col_num+1; $i++)
		{
			echo "<td>";
			switch($i)
			{
				case 0:
					echo ++$index;
					break;
				case 1:
					echo $row["gym_number"];
					break;
				case 2:
					echo $row["area"];
					break;
				case 3:
					echo $row["cover"];
					break;
				case 4:
					echo $row["cond_availab"];
					break;
				case 5:
					echo $row["capacity"];
					break;
				case 6:
					echo "<form action='action.php' method='post'>";
					echo "<input type='hidden' name='id' value='gyms-".$row["id"]."' />";
					echo "<input type='submit' name='edit' value='Редактировать' />";
					echo "</form>";
					break;
			}
			echo "</td>";
		}
		echo "</tr>";
	}
	
	echo "</table>";
	echo "<br></br><a href='practise.html'>Вернуться на главную страницу</a>";
	
	mysql_free_result($result);
	mysql_close($connection);
	?>
</body>
</html>