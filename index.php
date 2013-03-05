<?php

/*
 * ARQUIVO:             index.php
 * AUTOR:               Daniel Falcao
 * DATA:                21/Nov/2003
 * DESCRICAO:           Tela de login do sistema
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


$tpl["userArea"] = controlsUser(sessionGet("nome"), sessionGetUserCod(), sessionGet("nomeSetor"));

//Specific support:
$tpl["cssArea"]             = controlsCssArea($tpl["css"]);

//Titulo da pagina:
$tpl["titleArea"]           = "title";

//Ultima atualizacao:
$tpl["lastUpdateArea"]      = controlsLastUpdate($tpl["lastUpdate"][0], $tpl["lastUpdate"][1], $tpl["lastUpdate"][2]);

//Menu
$tpl["menuArea"]            = controlsMenuArea("");

//Titulo da tela atual:
$tpl["titleArea"]           = "Login no sistema";

$instructions               = "Para utilizar o sistema, &eacute; necess&aacute;rio que o usu&aacute;rio esteja devidamente cadastrado pelo administrador.";
$tpl["instructionsArea"]    = controlsInstructions($instructions);

if(!empty($errors)){
    $tpl["warningArea"]     = controlsWarning($tpl["msg"], $errors);
}

//Destino do formulario:
$tpl["action"]          = "login.php";

//Metodo usado no no formulario:
$tpl["method"]          = "POST";

//Manipulando os formularios:
//$form["selectPerfil"]   = '<select name="perfil"><option value="1">1</option><option value="2">2</option></select>';
$currentDate            = date("Y-m-d H:i:s");
$form["ultimoLogin"]    = '<input type="hidden" name="ultimoLogin" value="'.$currentDate.'">';

//Controles de login e senha:
$control[]              = '<input type="submit" class="defbutton" value="Entrar">';
$tpl["actionArea"]      = controlsActionArea($control);

//Imprimindo conteudo:
$tpl["formArea"]        = tplIncludeForm("form.login", $form);
$template               = tplIncludeTemplate("tpl.design", $tpl, "");
echo $template;

?>
