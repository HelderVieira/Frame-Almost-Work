<?php

/*
 * ARQUIVO:             insert.php
 * AUTOR:               Daniel Falcao
 * DATA:                28/Set/2006
 * DESCRICAO:           Cadastra um novo usuário
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
$tpl["cssArea"]         = controlsCssArea($tpl["css"]);

//Titulo da pagina:
$tpl["titleArea"]       = "MPPB";

//Usuario nao logado no sistema:
$tpl["userArea"] = controlsUser(sessionGet("nome"), sessionGetUserCod(), sessionGet("nomeSetor"));

//Menu do sistema:
$tpl["menuArea"]            = controlsMenuArea(sessionGet("perfil"));

//Titulo da tela atual:
$tpl["titleArea"]       = "Cadastro de usuário";

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Check data (validation):
if(!empty($errors)){
    $tpl["warningArea"] = controlsWarning($tpl["msg"], $errors);
}else {
    //Valores padroes nos controles:
    $form["nome"]               = "";
    $form["email"]              = "";
    $form["nivel"]              = "0";
    sessionSet("checkData", date("Y-m-d H:i:s"));
}

//Controles gerados dinamicamente:
$form["nivel"] = controlsSelect("nivel", "nivel", array("0" => "Selecione", "a" => "Administrador", "u" => "Usuário"), $form["nivel"]);
$form["userName"] = '<input type="text" name="userName" id="userName" size="20" maxlength="16" value="'.$form["userName"].'">';

//Destino do formulario:
$tpl["action"]          = "doInsert.php";

//Metodo usado no no formulario:
$tpl["method"]          = "POST";

//Controles de acao na lista:
$control[]              = controlsSubmitButton("", "", "Salvar");
$control[]              = controlsActionButton("", "", "Cancelar", "list.php", array());
$tpl["actionArea"]      = controlsActionArea($control);

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$tpl["formArea"]        = tplIncludeForm("form.default", $form);
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
