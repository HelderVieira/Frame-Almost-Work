<?php

/*
 * ARQUIVO:             update.php
 * AUTOR:               Daniel Falcao
 * DATA:                22/Out/2006
 * DESCRICAO:           Tela de atualização de dados do usuario
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

//Recupera o codigo via metodo GET:
$code = $_GET["cod"];
if($code != ""){
    $cod = $code;
    unset($code);
}

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Check data (validation):
if(!empty($errors)){
    $tpl["warningArea"]     = controlsWarning($tpl["msg"], $errors);
}else {
    //Get data:
    $query = "
        select
            u.id,
            u.nome,
            u.email,
            u.user_name,
            u.perfil
        from admin.usuario u
        where
            u.id = $cod
    ";
    $res = dbQuery($link, $query);
    if(dbNumRows($res) == 1) {
        list($cod, $nome, $email, $userName, $nivel) = dbFetchArray($res);
            $form["cod"]                            = $cod;
            $form["nome"]                           = $nome;            
            $form["email"]                          = $email;
            $form["userName"]                       = $userName;
            $form["nivel"]                          = $nivel;     
            unset($errors);
    }else {
        //TO-DO... registro removido durante a execucao do script! Resolver isto depois
    }
}

//Controles gerados dinamicamente:
$form["nivel"]    = controlsSelect("nivel", "nivel", array("0" => "Selecione", "a" => "Administrador", "u" => "Usuário"), $form["nivel"]);
$form["userName"] = '<input type="text" name="userName" id="userName" size="20" maxlength="16" value="'.$form["userName"].'" disabled>';

//Destino do formulario:
$tpl["action"]          = "doUpdate.php";

//Metodo usado no no formulario:
$tpl["method"]          = "POST";

//Controles de acao:
$control[] = controlsSubmitButton("button", "", "Salvar");
$control[] = controlsActionButton("button", "", "Remover", "doDelete.php", array("cod[]" => $form["cod"]));
$control[] = controlsBackButton("button", "", "Voltar");
$tpl["actionArea"] = controlsActionArea($control);

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$tpl["formArea"]        = tplIncludeForm("form.default", $form);
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
