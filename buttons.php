<?php 
	include "BaseVar.php";
	$name_table = $_POST['pic'];
	$zapros = "SELECT * from :name_table";
	$stm = $name_table->prepare($zapros)
	$stm -> bindValue (':name_table', $name_table);
	$stm -> execute();
	vivod($bd, $zapros, $name_table); 	// Функция библиотеки TableT
	
?>
