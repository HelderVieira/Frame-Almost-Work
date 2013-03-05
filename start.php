<?php

/*
 * ARQUIVO:             start.php
 * AUTOR:               Daniel Falcao
 * DATA:                13/07/2006
 * DESCRICAO:           Executa o login no sistema
 */

//Globals and enviroment support:
include_once("conf/globais.php");

//General function support:
include_once("lib/lib.controls.php");
include_once("lib/lib.database.php");
include_once("lib/lib.pagination.php");
include_once("lib/lib.session.php");
include_once("lib/lib.templating.php");
include_once("lib/lib.validation.php");
include_once("lib/lib.convertion.php");

//Authorization:
sessionConnect();

include("main.php");
exit();

?>