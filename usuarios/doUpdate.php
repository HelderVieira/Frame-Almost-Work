<?php

/*
 * ARQUIVO:             doUpdate.php
 * AUTOR:               Daniel Falcao
 * DATA:                22/out/2006
 * DESCRICAO:           Executa a atualização de dados do usuário
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
$tpl["titleArea"]           = "Atualização de usuário";

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Getting data:
$form["nome"]     = $_POST["nome"];
$form["email"]    = $_POST["email"];
$form["nivel"]    = $_POST["nivel"];
$form["userName"] = $_POST["userName"];
$form["passWord"] = $_POST["passWord"];
$form["confirm"]  = $_POST["confirm"];
$form["cod"]      = $_POST["cod"];

//Validation:
//if(trim($form["email"]) == trim(sessionGet("email"))) {
//    $errors[] = "Não é permitido modificar as informações de sua conta";
//}
if(strlen(trim($form["nome"])) < 4) {
    $errors[] = "Informe um valor valido para o campo Nome";
    $form["nome"] = "";
}

if(strlen(trim($form["email"])) < 4) {
    $errors[] = "Informe um valor valido para o campo e-mail";
    $form["email"] = "";
}

if($form["nivel"] == "0") {
    $errors[] = "Selecione um nivel de acesso";
}

if($form["passWord"] == $form["confirm"] && strlen($form["passWord"]) == 0) {
    //senha vazia, definir a senha "acesso"
    $form["senhaFinal"] = "(select md5('acesso'))";
}
if($form["passWord"] == $form["confirm"] && strlen($form["passWord"]) > 6) {
    $form["senhaFinal"] = "(select md5('".$form["passWord"]."'))";
}
if(strlen($form["passWord"]) > 0 && strlen($form["passWord"]) <= 6) {
    $errors[] = "A senha deverá conter no mínimo 7 letras e/ou números";
}
if(trim($form["passWord"]) != trim($form["confirm"])){
    //senha não confere
    $errors[] = "A senha não confere";
}
if(!empty($errors)) {
    $form["userName"] = $_POST["userName"];
    include("update.php");
    exit();
}else {
    
    $query = "
            begin;
            update admin.usuario set
                nome = '".$form["nome"]."',
                email = '".$form["email"]."',
                pass_word = ".$form["senhaFinal"].",
                perfil = '".$form["nivel"]."'
            where
                id = ".$form["cod"].";
            commit;";
    //echo $query;
    $res = dbQuery($link, $query);
}

$instructions               = "Os dados foram atualizados com sucesso!";
$tpl["instructionsArea"]    = controlsInstructions($instructions);

$control[]                  = controlsActionButton("", "", "Cadastrar", "insert.php", array());
$control[]                  = controlsActionButton("", "", "Buscar", "search.php", array());
$control[]                  = controlsActionButton("", "", "Listar", "list.php", array());
$tpl["actionArea"]          = controlsActionArea($control);

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
