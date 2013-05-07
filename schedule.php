<html>
<head>
	<title>Расписание занятий</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div align='center'><font size='5'><b>Расписание занятий</b></font></div>
	<br><br>
<?php
	include('dbconnect.php');
	
	$query = "SELECT tt_name, full_name, day_of_week, start_time, end_time, gym_number FROM schedule
		JOIN type_of_training ON schedule.tt_id = type_of_training.id
		JOIN trainer ON schedule.trainer_id = trainer.id
		JOIN gym ON schedule.gym_id = gym.id";
	
	if (isset($_POST["criteria"]))
	{
		$criteriaInput = explode("-", $_POST["criteria"]);
		$training = $criteriaInput[0];
		$trainer = $criteriaInput[1];
		$query = $query . " WHERE tt_name LIKE '%" . $training . "%' AND full_name LIKE '%" . $trainer . "%' ORDER BY tt_name, full_name";
	}
	else
	{
		$training = "не выбрано. (По умолчанию выводятся все занятия)";
		$trainer = "не выбран. (По умолчанию выводятся все тренеры)";
	}
	
	$result = mysql_query($query) or die("Ошибка!" . mysql_error());
	$column_num = mysql_num_fields($result);
	$row_num = mysql_num_rows($result);
	$col_names = array("ЗАНЯТИЕ", "ТРЕНЕР", "ДЕНЬ НЕДЕЛИ", "НАЧАЛО", "ОКОНЧАНИЕ", "ЗАЛ");
	
	if ($row_num == 0)
		echo "<b>Пока данный тренер не проводит никаких занятий</b><br></br>";
	else
	{
		echo "ФИО тренера: " . $trainer . "<br>";
		echo "Название занятия: " . $training . "<br><br>";
		echo "<table width='100%' border='1' cellspacing='0'>";
		echo "<tr align='center' valign='middle'>";
		
		for($i = 0; $i < $column_num; $i++)
		{
			echo "<th>" . $col_names[$i] . "</th>";
		}
		
		echo "</tr>";
		
		while ($row = mysql_fetch_assoc($result))
		{
			echo "<tr align='center' valign='middle'>";	
		
			for ($i = 0; $i < $column_num; $i++)
			{
				echo "<td>";
				switch($i)
				{
					case 0:
						echo $row["tt_name"];
						break;
					case 1:
						echo $row["full_name"];
						break;
					case 2:
						echo $row["day_of_week"];
						break;
					case 3:
						echo $row["start_time"];
						break;
					case 4:
						echo $row["end_time"];
						break;
					case 5:
						echo $row["gym_number"];
						break;
				}
				echo "</td>";
			}
			echo "</tr>";
		}
	}

	echo "</table>";
	echo "<br>" . "<a href='practise.html'>Вернуться на главную страницу</a>";
	
	mysql_free_result($result);
	mysql_close($connection);
?>
</body>
</html>