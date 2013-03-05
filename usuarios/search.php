<?php

/*
 * ARQUIVO:             search.php
 * AUTOR:               Daniel Falcao
 * DATA:                22/Out/2006
 * DESCRICAO:           Tela de busca por dados de usuário
 */

//Globals and enviroment support:
include_once("../conf/globais.php");

//General function support:
include_once("../lib/lib.controls.php");
include_once("../lib/lib.database.php");
include_once("../lib/lib.pagination.php");
include_once("../lib/lib.session.php");
include_once("../lib/lib.templating.php");
include_once("../lib/lib.validation.php");
include_once("../lib/lib.convertion.php");

//Authorization:
//sessionConnect();
sessionAuth(array(ADMIN));

//Specific support:
$tpl["cssArea"]             = controlsCssArea($tpl["css"]);

//Titulo da pagina:
$tpl["titleArea"]           = "MPPB";

//Usuario nao logado no sistema:
$tpl["userArea"] = controlsUser(sessionGet("nome"), sessionGetUserCod(), sessionGet("nomeSetor"));

//Menu do sistema:
$tpl["menuArea"]            = controlsMenuArea(sessionGet("perfil"));

//Titulo da tela atual:
$tpl["titleArea"]           = "Busca por usuários";

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//valores padrões:
$form["nome"]           = "";
$form["email"]          = "";

//Controles gerados dinamicamente:
$form["nivel"]          = controlsSelect("nivel", "nivel", array("0" => "Selecione", "a" => "Administrador", "u" => "Usuário"), $form["nivel"]);

//Destino do formulario:
$tpl["action"]          = "list.php";

//Metodo usado no no formulario:
$tpl["method"]          = "GET";

//Controles de acao na lista:
$control[]              = controlsSubmitButton("", "", "Buscar");
$control[]              = controlsActionButton("", "", "Cancelar", "list.php", array());
$tpl["actionArea"]      = controlsActionArea($control);

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$tpl["formArea"]        = tplIncludeForm("form.search", $form);
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
