<html>
<head>
	<title>Список занятий</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div align='center'>
	<font size='5'>
		<b>Список занятий</b>
	</font>
	</div>
	<br>
<?php
	if (isset($_POST['apply']))
	{
		$tt_name = trim($_POST['training']);
		$hours = $_POST['durhours'];
		$mins = $_POST['durminutes'];$duration = 0;
		switch ($hours)
		{	
			case 1:
				switch ($mins)
				{
					case 0:
						$duration = 1.0;
						break;
					case 15:
						$duration = 1.25;
						break;
					case 30:
						$duration = 1.50;
						break;
					case 45:
						$duration = 1.75;
						break;
				}
				break;
			case 2:
				switch($mins)
				{
					case 0:
						$duration = 2.0;
						break;
					case 15:
						$duration = 2.25;
						break;
					case 30:
						$duration = 2.50;
						break;
					case 45:
						$duration = 2.75;
						break;
				}
				break;
			case 3:
				switch($mins)
				{
					case 0:
						$duration = 3.0;
						break;
					case 15:
						$duration = 3.25;
						break;
					case 30:
						$duration = 3.50;
						break;
					case 45:
						$duration = 3.75;
						break;
				}
				break;
		}
		$sql = "UPDATE `type_of_training` SET `tt_name`='".$tt_name."', `duration`='".$duration."'
		 WHERE `id`=".$_POST['id'];
		include('dbconnect.php');
		$result = mysql_query($sql) or die("Ошибка!" .mysql_error());
		if ($result)
		{
			echo "<p>";
			echo "Данные для занятия ". $tt_name. " успешно изменены!";
			echo "<br>";	
		}
		mysql_close($connection);
	}
	
	if (isset($_POST['confirm']))
	{
		$sql = "DELETE FROM `type_of_training` WHERE `id`=".$_POST['id'];
		include('dbconnect.php');
		$result = mysql_query($sql);
		if ($result)
		{
			echo "<p>";
			echo "Данные о занятии ".$_POST['tt_name']." удалены!";
			echo "<br>";	
		}
		mysql_close($connection);
	}
	
	
	include('dbconnect.php');
	$query = "SELECT `id`, `tt_name`, `duration` FROM `type_of_training`";
	$result = mysql_query($query) or die ("Ошибка!" . mysql_error());
	$col_num = mysql_num_fields($result);
	$col_names = array("№", "ЗАНЯТИЕ", "ДЛИТЕЛЬНОСТЬ", "ДЕЙСТВИЯ");
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
					echo $row["tt_name"];
					break;
				case 2:
					$data = explode(".", $row["duration"]);
					$hours = $data[0];
					$minutes = 60*($data[1]/100);
					if ($minutes != 0)
						echo $hours." час(а) ".$minutes." минут";				
					else
						echo $hours." час(а)";
					break;
				case 3:
					echo "<form action='action.php' method='post'>";
					echo "<input type='hidden' name='id' value='training-".$row["id"]."' />";
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