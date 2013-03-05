<?php

/*
 * ARQUIVO:             logoff.php
 * AUTOR:               Daniel Falcao
 * DATA:                12/Jul/2006
 * DESCRICAO:           Executa o logoff do sistema
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

//Start and destroy the session:
sessionStart();
sessionDisconnect();

//Volta para a tela de autenticacao:
//$destino = "Location: ".PATH."index.php";
//header($destino);
//exit();

include("index.php");

?>
