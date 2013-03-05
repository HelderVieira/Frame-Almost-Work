<?php

/*
 * ARQUIVO:             passwd.php
 * AUTOR:               Daniel Falcao
 * DATA:                23/Out/2006
 * DESCRICAO:           Tela de atualização de senha do usuario
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
sessionConnect();

//Specific support:
$tpl["cssArea"]             = controlsCssArea($tpl["css"]);

//Titulo da pagina:
$tpl["titleArea"]           = "MPPB";

//Usuario nao logado no sistema:
$tpl["userArea"] = controlsUser(sessionGet("nome"), sessionGetUserCod(), sessionGet("nomeSetor"));

//Menu do sistema:
$tpl["menuArea"]            = controlsMenuArea(sessionGet("perfil"));

//Titulo da tela atual:
$tpl["titleArea"]           = "Alteração de senha do usuário";

$instructions               = "Para modificar a senha, digite a senha atual 
                               seguida da nova senha. Será necessário redigitar 
                               a nova senha no último campo.";
$tpl["instructionsArea"]    = controlsInstructions($instructions);

//Connect to the database:
//$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Check data (validation):
if(!empty($errors)){
    $tpl["warningArea"]     = controlsWarning($tpl["msg"], $errors);
}else {
    //Get data:
    //Bucando nome e matricula do usuario...
}

//Destino do formulario:
$tpl["action"]          = "doPasswd.php";

//Metodo usado no no formulario:
$tpl["method"]          = "POST";

//Controles de acao:
$control[] = controlsSubmitButton("button", "", "Atualizar");
$control[] = controlsActionButton("", "", "Cancelar", PATH."/start.php", array());
$tpl["actionArea"] = controlsActionArea($control);

//Disconnect from database:
//dbClose($link);
//unset($link); 

//Imprimindo conteudo:
$tpl["formArea"]        = tplIncludeForm("form.passwd", $form);
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
