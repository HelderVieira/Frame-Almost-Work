<?php

/*
 * ARQUIVO:             main.php
 * AUTOR:               Daniel Falcao
 * DATA:                12/Jul/2006
 * DESCRICAO:           Tela inicial do sistema
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

//Specific support:
$tpl["cssArea"]             = controlsCssArea($tpl["css"]);

//Usuario nao logado no sistema:
$tpl["userArea"] = controlsUser(sessionGet("nome"), sessionGetUserCod(), sessionGet("nomeSetor"));

/*
//Links de apoio:
$tpl["linkArea"]            = "";

//Dados sobre a instituicao:
$tpl["copyrightArea"]       = "";

//Ultima atualizacao:
$tpl["lastUpdateArea"]      = "";
*/

//Menu do sistema:
$tpl["menuArea"]            = controlsMenuArea(sessionGet("perfil"));

//Titulo da tela atual:
$tpl["titleArea"]           = "Bem vindo(a) ao sistema: ".SYSTEM;

$instructions               = "Este &eacute; o sistema de ".SYSTEM.".";
$tpl["instructionsArea"]    = controlsInstructions($instructions);

if(!empty($_GET)){
    $msg                = "Os seguintes erros foram encontrados:";
    $errors             = array ("Possivelmente o usuario nao esta autorizado a entrar no sistema", "Possivelmente login ou senha incorreta");
    $tpl["warningArea"] = controlsWarning($msg, $errors);
}

//Imprimindo conteudo:
$template               = tplIncludeTemplate("tpl.design", $tpl, "");
echo $template;

?>
