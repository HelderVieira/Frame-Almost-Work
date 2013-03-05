<?php

/*
 * ARQUIVO:             doInsert.php
 * AUTOR:               Daniel Falcao
 * DATA:                25/Jul/2006
 * DESCRICAO:           Executa o cadastro da movimentacao
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
$tpl["titleArea"]           = "Cadastro de usuário";

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Getting data:
$form["email"]    = $_POST["email"];
$form["nome"]     = $_POST["nome"];
$form["nivel"]    = $_POST["nivel"];
$form["userName"] = $_POST["userName"];
$form["passWord"] = $_POST["passWord"];
$form["confirm"]  = $_POST["confirm"];

//Validation:
if(strlen(trim($form["nome"])) < 4) {
    $errors[] = "Informe um valor valido para o campo Nome";
    $form["nome"] = "";
}

if(strlen(trim($form["email"])) < 4) {
    $errors[] = "Informe um valor valido para o campo e-mail";
    $form["email"] = "";
}

if(trim($form["userName"]) != "") {
    $query = "select user_name from admin.usuario where user_name = '".$form["userName"]."' and excluido = 'f'";
    $res = dbQuery($link, $query);
    if(dbNumRows($res) > 0) {
        $errors[] = "Nome Usuário já cadastrado no sistema.";
    }
}else {
    $errors[] = "Informe um valor valido para o campo Nome de usuario";
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
/*
if($form["senha"] == $form["reSenha"] && strlen($form["senha"]) > 6) {
    $form["senhaFinal"] = "(select md5('".$form["senha"]."'))";
}
if(strlen($form["senha"]) > 0 && strlen($form["senha"]) <= 6) {
    //senha vazia, definir a senha "acesso"
    $errors[] = "A senha deverá conter no mínimo 7 letras e/ou números";
}
if(trim($form["senha"]) != trim($form["reSenha"])){
    //senha não confere
    $errors[] = "A senha não confere";
}
*/
if(!empty($errors)) {
    $form["userName"] = $_POST["userName"];
    include("insert.php");
    exit();
}else {
    //Verifica se a query foi executada através do flag checkData:
    if(sessionGet("checkData") != "") {
                
        $query = "
            insert into admin.usuario(
                email,
                nome,
                perfil,
                user_name,
                pass_word
             ) values(
                '".$form["email"]."',
                '".$form["nome"]."',
                '".$form["nivel"]."',
                '".$form["userName"]."',
                ".$form["senhaFinal"]."
            );
            ";
        $res = dbQuery($link, $query);
        //echo "<pre>$query</pre>";
    }
    //Destroi o flag checkData:
    sessionSet("checkData", "");
}

$instructions               = "Usuario cadastrado com sucesso!";
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
