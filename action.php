<html>
<?php
	$dbtable;
	$id;
	$myfunc = "print_form";
	function print_form($table)
	{
		switch(strtolower($table))
		{
			case "trainer":
				include('dbconnect.php');
				$sql = "SELECT `id`, `full_name`, `sex` FROM `trainer` WHERE `id`=".$GLOBALS['id'];
				$result = mysql_query($sql) or die ("Ошибка!" . mysql_error());;
				echo "<form name='form_edit' action='trainers.php' method='POST'>";
				
				while($row = mysql_fetch_array($result))
				{
					echo "<input type='hidden' name='id' value='".$row["id"]."'";
					$full_name = explode(' ', $row["full_name"]);
					$surname = $full_name[0];
					$name = $full_name[1];
					$patronymic = $full_name[2];
					echo "<label for='name'>Имя: </label><input type='text' name='name' id='name' value='".$name."' /";
					echo "<br>";
					echo "<p>";
					echo "<label for='surname'>Фамилия: </label>";
					echo "<input type='text' name='surname' id='surname' value='".$surname."' />";
					echo "<br>";
					echo "<p>";
					echo "<label for='patronymic'>Отчество: </label>";
					echo "<input type='text' name='patronymic' id='patronymic' value='".$patronymic."' />";
					echo "<br>";
					echo "<p>Пол: ";
					if ($row["sex"] == "Мужской")
					{
						echo "<input type='radio' name='sex' value='Мужской' id='rb1' checked/><label>Мужской</label>";
						echo "<input type='radio' name='sex' value='Женский' id='rb2'/><label>Женский</label>";
					}
					else
					{
						echo "<input type='radio' name='sex' value='Мужской' id='rb1' /><label>Мужской</label>";
						echo "<input type='radio' name='sex' value='Женский' id='rb2' checked /><label>Женский</label>";
					}	
					echo "<p><input type='submit' name='apply' value='Применить'/>";
				}
				echo "</form>";
				break;
			case "training":
				include('dbconnect.php');
				$sql = "SELECT `id`, `tt_name`, `duration` FROM `type_of_training` WHERE `id`=".$GLOBALS['id'];
				$result = mysql_query($sql) or die ("Ошибка!" . mysql_error());;
				echo "<form name='form_edit' action='trainings.php' method='POST'>";
				
				while($row = mysql_fetch_array($result))
				{	
					echo "<input type='hidden' name='id' value='".$row["id"]."'";
					echo "<label for='training'>Название занятия: </label>";
					echo "<input type='text' name='training' value='". $row["tt_name"]."' /><br>";
					echo "<p>Длительность: ";
					echo "<select name='durhours' id='hours'>";
					$data = explode(".", $row["duration"]);
					$hours = $data[0];
					switch($hours)
					{
						case 0:
							echo "<option selected value='0'>0</option>";
							echo "<option value='1'>1</option>";
							echo "<option value='2'>2</option>";
							echo "<option value='3'>3</option>";
							break;
						case 1:
							echo "<option value='0'>0</option>";
							echo "<option selected value='1'>1</option>";
							echo "<option value='2'>2</option>";
							echo "<option value='3'>3</option>";
							break;
						case 2:
							echo "<option value='0'>0</option>";
							echo "<option value='1'>1</option>";
							echo "<option selected value='2'>2</option>";
							echo "<option value='3'>3</option>";
							break;
						case 3:
							echo "<option value='0'>0</option>";
							echo "<option value='1'>1</option>";
							echo "<option value='2'>2</option>";
							echo "<option selected value='3'>3</option>";
							break;
					}				
					echo "</select>";
					echo "<label for='hours'> час </label>";
				
					$minutes = $data[1];
					echo "<select name='durminutes' id='minutes'>";
					
					if ($minutes == 0)
					{
						echo "<option selected value='0'>0</option>";
						echo "<option value='15'>15</option>";
						echo "<option value='30'>30</option>";
						echo "<option value='45'>45</option>";
					}
					
					else
					{
						switch(60*($minutes/100))
						{
							case 15:
								echo "<option value='0'>0</option>";
								echo "<option selected value='15'>15</option>";
								echo "<option value='30'>30</option>";
								echo "<option value='45'>45</option>";
								break;
							case 30:
								echo "<option value='0'>0</option>";
								echo "<option value='15'>15</option>";
								echo "<option selected value='30'>30</option>";
								echo "<option value='45'>45</option>";
								break;
							case 45:
								echo "<option value='0'>0</option>";
								echo "<option value='15'>15</option>";
								echo "<option value='30'>30</option>";
								echo "<option selected value='45'>45</option>";
								break;
						}
					}
					
					echo "</select>";
					echo "<label for='minutes'> мин </label>";
					echo "<p><input type='submit' name='apply' value='Применить' />";
				}
				break;
			
		}
		
		mysql_close($connection);
	}
	
	if (isset($_POST["edit"]))
	{
		echo "<head>";
		echo "<title>Редактирование записи о тренере</title>";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		echo "</head>";
		echo "<body>";
		
		$data = explode('-', $_POST["id"]);
		$dbtable = $data[0];
		$id = $data[1];
		switch ($dbtable)
		{
			case "trainer":
				echo "<h2>Редактирование записи таблицы ТРЕНЕРЫ</h2>";
				$myfunc($dbtable);
				break;
			case "training":
				echo "<h2>Редактирование записи таблицы ЗАНЯТИЯ</h2>";
				$myfunc($dbtable);
				break;
		}
		echo "</body>";
	}
	else
	{
		if (isset($_POST["delete"]))
		{
			$data = explode('-', $_POST["id"]);
			$dbtable = $data[0];
			$id = $data[1];
			
			switch ($dbtable)
			{
				case "trainer":
					include('dbconnect.php');
					$sql = "SELECT `id`, `full_name`, `sex` FROM `trainer` WHERE `id`=".$id;
					$result = mysql_query($sql) or die ("Ошибка!" . mysql_error());;
					while($row = mysql_fetch_array($result))
					{
						echo "<form action='trainers.php' name='form_confirm' method='post'>";
						echo "Вы уверены, что хотите удалить запись о тренере ". $row["full_name"]."?";
						echo "<input type='hidden' name='full_name' value='".$row["full_name"]."' />";
						echo "<input type='hidden' name='id' value='".$row["id"]."'/>";
						echo "<input type='submit' name='confirm' value='Да' />";
						echo "<input type='submit' name='no_confirm' value='Нет' />";
						echo "</form>";
					}
					break;
				case "training":
					include('dbconnect.php');
					$sql = "SELECT `id`, `tt_name`, `duration` FROM `type_of_training` WHERE `id`=".$id;
					$result = mysql_query($sql) or die ("Ошибка!" . mysql_error());;
					while($row = mysql_fetch_array($result))
					{
						echo "<form action='trainings.php' name='form_confirm' method='post'>";
						echo "Вы уверены, что хотите удалить запись о занятии ". $row["tt_name"]."?";
						echo "<input type='hidden' name='tt_name' value='".$row["tt_name"]."' />";
						echo "<input type='hidden' name='id' value='".$row["id"]."'/>";
						echo "<input type='submit' name='confirm' value='Да' />";
						echo "<input type='submit' name='no_confirm' value='Нет' />";
						echo "</form>";
					}
					break;		
			}
			echo "</body>";
		}
	}
	
?>

<html>