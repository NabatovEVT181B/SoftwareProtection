<?php 
    include "BaseVar.php";
	//СЧИТЫВАНИЕ ИЗ ФАЙЛА
	$peredac = htmlentities(file_get_contents("tanos.txt"));
	$ter = $_POST['picd'];


	//ПОЛУЧЕНИЕ НАЗВАНИЯ АТРИБУТА
	$res = $bd->query("select * from $peredac");
	for ($i = 0; $i< $res->columnCount(); $i++)
	{
		$col = $res->getColumnMeta($i);
	    $colums[]=$col['name'];
	}
	//ПОЛУЧЕИЕ СТРОКИ С ID
	$we = "SELECT * from :peredac where id = :ter";
	$stm = $db->prepare($we);
	$stm->bindValue(':peredac',$peredac);
	$stm->bindValue(':ter', $ter);
	$stm->execute();
	$date = $stm->fetchall;	
	$res = $bd->query($we);
	$date = $res->fetchall(PDO::FETCH_ASSOC);
	$qer = "";
	foreach($date as $a => $items)
	{
		$i=0;
		foreach($items as $s)
		{
			$qer=$qer.$colums[$i].": ".$s.", ";
			$i++;
		}
	} 
	// ТРИГГЕР 
	$droptr = "DROP TRIGGER IF EXISTS `1$peredac`;";
	$bd->query($droptr);
	$trigD = "CREATE TRIGGER `1$peredac` AFTER DELETE ON `$peredac` FOR EACH ROW 
				BEGIN
					INSERT INTO log (Информация) values ('DELETE: ($qer) из таблицы $peredac');
				END";
	$bd->query($trigD);

	// УДАЛЕНИЕ ЗАПИСИ 
	$zap = "delete from `$peredac` where id = $ter";
	$bd->query($zap);
	$zapros = "SELECT * from $peredac";	
	vivod($bd, $zapros, $peredac); 	// Функция библиотеки TableT

?>