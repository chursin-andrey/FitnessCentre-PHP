<html>
<head>
	<title>Поиск занятий</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<p><b>Для того, чтобы просмотреть расписание для конкретного занятия и тренера, выберите ФИО тренера из списка.</b></p>
	<form action="schedule.php" method="post">
		<select name="criteria">
			<option disabled selected>Выберите тренера</option>
			<?php
				include("dbconnect.php");
				$query = "SELECT tt_name FROM type_of_training ORDER BY tt_name";
				$result = mysql_query($query) or die("Error: ".mysql_error());
				while($row = mysql_fetch_row($result))
				{
					echo "<optgroup label='" . $row[0] . "'>" . $row[0];
					$subquery = "SELECT tt_name, full_name FROM trainer_spec
				 	 JOIN type_of_training ON trainer_spec.tt_id = type_of_training.id
				 	 JOIN trainer ON trainer_spec.trainer_id = trainer.id
				 	 WHERE tt_name LIKE '%" . $row[0] . "%' ORDER BY tt_name, full_name";
					$subresult = mysql_query($subquery);
					while($subrow = mysql_fetch_array($subresult))
					{
						echo "<option value='" . $row[0] . "-" . $subrow["full_name"] . "'/>" . $subrow["full_name"] . "</option>";
					}
					echo "</optgroup>";
				}
				mysql_free_result($result);
				mysql_close($connection);
			?>
			</optgroup>
		</select>	
		<input type='submit' name='view' value='Просмотр'/></p>
	</form>	
</body>
</html>