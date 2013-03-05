<?php

/*
 * ARQUIVO:             doPasswd.php
 * AUTOR:               Daniel Falcao
 * DATA:                23/Out/2006
 * DESCRICAO:           Executa a atualização da senha do usuário
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

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Getting data:
$form["oldPassWord"] = trim( $_POST["oldPassWord"] );
$form["newPassWord"] = $_POST["newPassWord"];
$form["confirm"]     = $_POST["confirm"];

//Validation:
$query = "select senha from usuario where login = '".trim(sessionGetUserCod())."'";

$res = dbQuery($link, $query);
list($graSenha) = dbFetchArray($res);

if($form["oldPassWord"] != trim($graSenha)) {
    $errors[] = "A antiga senha não confere";
}

if(strlen($form["newPassWord"]) > 0 && strlen($form["newPassWord"]) <= 2) {
    //senha vazia, definir a senha "acesso"
    $errors[] = "A nova senha deverá conter no mínimo 3 letras e/ou números";
}

if(trim($form["newPassWord"]) != trim($form["confirm"])) {
    //senha não confere
    $errors[] = "A nova senha não confere";
}

if(!empty($errors)) {
    include("passwd.php");
    exit();
}else {
    $query = "
            update usuario set 
                senha = '".$form["newPassWord"]."'
            where
                login = '".trim(sessionGetUserCod())."'";
    $res = dbQuery($link, $query);
    
}

$instructions               = "A senha foi alterada com sucesso!";
$tpl["instructionsArea"]    = controlsInstructions($instructions);

$control[]                  = controlsActionButton("", "", "Ok", PATH."/start.php", array());
$tpl["actionArea"]          = controlsActionArea($control);

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
