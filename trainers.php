<html>
<head>
	<title>Список тренеров</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div align='center'>
		<font size='5'><b>Тренеры</b></font><br>
	</div>
	
<?php
	
	if (isset($_POST['apply']))
	{
		$surname = trim($_POST['surname'], " ");
		$name = trim($_POST['name'], " ");
		$patronymic = trim($_POST['patronymic'], " ");
		$full_name = $surname." ".$name." ".$patronymic;
		$sex = $_POST['sex'];
		$sql = "UPDATE `trainer` SET `full_name`='".$full_name."', `sex`='".$sex."'
		 WHERE `id`=".$_POST['id'];
		include('dbconnect.php');
		$result = mysql_query($sql) or die("Ошибка!" .mysql_error());
		if ($result)
		{
			echo "<p>";
			echo "Данные о тренере ". $full_name. " успешно изменены!";
			echo "<br>";	
		}
		mysql_close($connection);		
	}
	
	if (isset($_POST['confirm']))
	{
		$sql = "DELETE FROM `trainer` WHERE `id`=".$_POST['id'];
		include('dbconnect.php');
		$result = mysql_query($sql);
		if ($result)
		{
			echo "<p>";
			echo "Данные о тренере ".$_POST['full_name']." удалены!";
			echo "<br>";	
		}
		
		mysql_close($connection);
	}
	
	include('dbconnect.php');
	$query = "SELECT `id`, `full_name`, `sex` FROM `trainer` ORDER BY `full_name`";
	$result = mysql_query($query) or die ("Ошибка!" . mysql_error());
	$col_num = mysql_num_fields($result);
	$col_names = array("№", "ТРЕНЕР", "ПОЛ", "ДЕЙСТВИЯ");
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
					echo $row["full_name"];
					break;
				case 2:
					echo $row["sex"];
					break;
				case 3:
					echo "<form action='action.php' method='post'>";
					echo "<input type='hidden' name='id' value='trainer-".$row["id"]."' />";
					echo "<input type='submit' name='edit' value='Редактировать' />";
					echo "<input type='submit' name='delete' value='Удалить' />";
					echo "</form>";
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