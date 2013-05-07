<html>
<head>
	<title>Добавление записей</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<?php
	$dbtable;
	$tablename;
	$added_row_count;
	$myfunc = "print_form";
	function print_form($table)
	{
		echo "<form name='form_add' action='' method='POST'>";
		switch (strtolower($table))
		{
			case "trainer":
				echo "<p><label for='name'>Имя: </label><input type='text' name='name' id='name' /><br>";
				echo "<p><label for='surname'>Фамилия: </label><input type='text' name='surname' id='surname' /><br>";
				echo "<p><label for='patronymic'>Отчество: </label><input type='text' name='patronymic' id='patronymic' /><br>";
				echo "<p>Пол: ";
				echo "<input type='radio' name='sex' value='Мужской' id='rb1'/><label>Мужской</label>";	
				echo "<input type='radio' name='sex' value='Женский' id='rb2'/><label>Женский</label>";
				echo "<p><input type='submit' name='add' value='Добавить тренера'/>";
				break;
			case "type_of_training":
				echo "<p><label for='training'>Название занятия: </label><input type='text' name='training' id='training' /><br>";
				echo "<p>Длительность: ";
				echo "<select name='durhours' id='hours'>";
				echo "<option selected value='0'>0</option>";
				echo "<option value='1'>1</option>";
				echo "<option value='2'>2</option>";
				echo "<option value='3'>3</option>";
				echo "</select>";
				echo "<label for='hours'> час </label>";
				echo "<select name='durminutes' id='minutes'>";
				echo "<option selected value='0'>0</option>";
				echo "<option value='15'>15</option>";
				echo "<option value='30'>30</option>";
				echo "<option value='45'>45</option>";
				echo "</select>";
				echo "<label for='minutes'> мин </label>";
				echo "<p><input type='submit' name='add' value='Добавить занятие'/>";
				break;
			case "trainer_spec":
				echo "Выберите из списка тренера и затем специальность, которую хотите ему присвоить.";
				echo "<p><label for='full_name'>Тренер: </label>";
				echo "<select name='trainer' id='full_name'>";
				echo "<option disabled selected value='default'>Выберите тренера</option>";					
				$query = "SELECT `id`, `full_name` FROM `trainer` ORDER BY `full_name`";
				include('dbconnect.php');
				$result = mysql_query($query);
				while ($row = mysql_fetch_array($result))
				{
					echo "<option value='".$row['id']."-".$row['full_name']."'>".$row['full_name']."</option>";
				}
				echo "</select>";
				echo "<p><label for='tt_name'>Специальность: </label>";
				echo "<select name='spec' id='tt_name'>";
				echo "<option disabled selected value='default'>Выберите специальность</option>";
				$query = "SELECT `id`, `tt_name` FROM `type_of_training` ORDER BY `tt_name`";
				$result = mysql_query($query);
				while ($row = mysql_fetch_array($result))
				{
					echo "<option value='".$row['id']."-".$row['tt_name']."'>".$row['tt_name']."</option>";
				}
				echo "</select>";
				mysql_free_result($result);
				mysql_close($connection);
				echo "<p><input type='submit' name='add' value='Добавить специальность'/>";
				break;
			/*
			case "gym":
				echo "<p><label for='gym'>Номер зала: </label>";
				echo "<select name='gym' id='gym'>";
				echo "<option value='101'>101</option>";
				echo "<option value='102'>102</option>";
				echo "<option value='103'>103</option>";
				echo "<option value='104'>104</option>";
				echo "<option value='105'>105</option>";
				echo "<option value='106'>106</option>";
				echo "<option value='107'>107</option>";
				echo "<option value='108'>108</option>";
				echo "<option value='109'>109</option>";
				echo "<option value='110'>110</option>";
				echo "<option value='201'>201</option>";
				echo "<option value='202'>202</option>";
				echo "<option value='203'>203</option>";
				echo "<option value='204'>204</option>";
				echo "<option value='205'>205</option>";
				echo "<option value='206'>206</option>";
				echo "<option value='207'>207</option>";
				echo "<option value='208'>208</option>";
				echo "<option value='301'>301</option>";
				echo "<option value='302'>302</option>";
				echo "<option value='303'>303</option>";
				echo "<option value='304'>304</option>";
				echo "<option value='305'>305</option>";
				echo "<option value='306'>306</option>";
				echo "</select><br>";
				echo "<label for='cover'> Покрытие </label>";
				echo "<select name='cover' id='cover'>";
				echo "<option selected value='0'>0</option>";
				echo "<option value='15'>15</option>";
				echo "<option value='30'>30</option>";
				echo "<option value='45'>45</option>";
				echo "</select>";
				echo "<p><input type='submit' name='add' value='Добавить зал'/>";
				break;
			*/
		}
		echo "</form>";
	}
	
	if (isset($_POST['add']))
	{
		$submitVal = explode(" ", $_POST['add']);
		$GLOBALS['tablename'] = $submitVal[1];
		switch($GLOBALS['tablename'])
		{
			case "тренера":
				$GLOBALS['dbtable'] = "trainer";
				$name = trim($_POST['name'], " ");
				$surname = trim($_POST['surname'], " ");
				$patronymic = trim($_POST['patronymic'], " ");
				$sex = $_POST['sex'];
				$full_name = $surname . " " . $name . " " . $patronymic;
				$query = "INSERT INTO `trainer` (`full_name`, `sex`)
				 VALUES('".$full_name."', '". $sex."')";
				include('dbconnect.php');
				$result = mysql_query($query) or die("Ошибка!" .mysql_error());
				if ($result)
				{
					echo "Тренер " . $full_name . " добавлен(а) в базу данных.";
				}
				break;
			case "специальность":
				$GLOBALS['dbtable'] = "trainer_spec";
				$trainer_input = explode("-", $_POST['trainer']);
				$trainer_id = $trainer_input[0];
				$spec_input = explode("-", $_POST['spec']);
				$spec_id = $spec_input[0];
				$query = "INSERT INTO `trainer_spec` (`trainer_id`, `tt_id`)
				 VALUES(".$trainer_id.", ".$spec_id.")";
				include('dbconnect.php');
				$result = mysql_query($query);
				if ($result)
				{
					echo "Специальность по " . $spec_input[1] . "(у) для тренера " . $trainer_input[1]. " добавлена в базу данных.";
				}
				break; 
			case "занятие":
				$GLOBALS['dbtable'] = "type_of_training";
				$tt_name = trim($_POST['training']);
				$hours = $_POST['durhours'];
				$mins = $_POST['durminutes'];
				$duration = 0;
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
				$query = "INSERT INTO `type_of_training` (`tt_name`, `duration`)
				 VALUES('".$tt_name."', '". $duration."')";
				include('dbconnect.php');
				$result = mysql_query($query);
				if ($result)
				{
					echo "Занятие по " . $tt_name . "(е/у) добавлено в базу данных.";
				}
				break;
		}
		mysql_close($connection);
	}
	
	if (isset($_POST['continue']))
	{ 
		$tableInput = explode('-', $_POST['db_table']);
		$GLOBALS['dbtable'] = $tableInput[0];
		$GLOBALS['tablename'] = $tableInput[1];		
		echo "<h2>Добавление новой записи в таблицу ".$GLOBALS['tablename']."</h2>";
		$myfunc($dbtable);
	}
	else
	{
	?>
	<p><h2>Выбор таблицы для добавления новой записи.</h2>
	Для того, чтобы вставить новую запись в таблицу БД, выберите название таблицы из списка.</p>
	<form action="" method="POST">
		<select name="db_table">
			<?php
			include("dbconnect.php");
			$result = mysql_list_tables($dbname);
			if (!$result)
			{
        		echo "DB Error, could not list tables\n";
        		echo "MySQL Error: " . mysql_error();
        		exit;
    		}
			while ($row = mysql_fetch_row($result))
			{
				switch(strtolower($row[0]))
				{
					case "trainer":
						echo "<option value='trainer-ТРЕНЕРЫ'>ТРЕНЕРЫ</option>";
						$GLOBALS['dbtable'] = "trainer";
						break;
					case "type_of_training":
						echo "<option value='type_of_training-ЗАНЯТИЯ'>ЗАНЯТИЯ</option>";
						$GLOBALS['dbtable'] = "type_of_training";	
						break;
					case "trainer_spec":
						echo "<option value='trainer_spec-СПЕЦИАЛЬНОСТИ ТРЕНЕРОВ'>СПЕЦИАЛЬНОСТИ ТРЕНЕРОВ</option>";
						$GLOBALS['dbtable'] = "trainer_spec";
						break;
					/*
					case "gym":
						echo "<option value='gym-ЗАЛЫ'>ЗАЛЫ</option>";
						$GLOBALS['dbtable'] = "gym";
						break;
					*/
					case "schedule":
						echo "<option value='schedule-РАСПИСАНИЕ ЗАНЯТИЙ'>РАСПИСАНИЕ ЗАНЯТИЙ</option>";
						$GLOBALS['dbtable'] = "schedule";
						break;
				}
			}
			mysql_free_result($result);
			mysql_close($connection);
			?>			
		</select>
		<input type="submit" name="continue" value="Продолжить"/>
		</p>
		<br>
		<a href="practise.html">Вернуться на главную страницу</a>
	</form>
	<?php
	}
	?>	
</body>
</html>