<?php

require_once ('Controller/Controller.php');
require_once ('Controller/SantoController.php');
require_once ('Model/Santo.php');
require_once ('Model/Dao.php');

/* Iniciando o sistema através da View listarSantos */
	$start = new SantoController();
	$start->listarSantos();
?>
