<?php
	$hostname = "localhost:3306";
	$user = "root";
	$password = "root";
	$dbname = "fitness";
	
	$connection = mysql_connect($hostname, $user, $password) or die("Ошибка! Не удалось установить соединение с сервером.");
	mysql_select_db($dbname, $connection) or die("Ошибка! Не удалось выбрать базу данных.");
	
	mysql_query("SET character_set_client='utf8'");
	mysql_query("SET character_set_results='utf8'");
	mysql_query("SET collation_connection='utf8_general_ci'");
?>