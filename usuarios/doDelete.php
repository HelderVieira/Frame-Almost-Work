<?php

/*
 * ARQUIVO:             doDelete.php
 * AUTOR:               Daniel Falcao
 * DATA:                22/Out/2006
 * DESCRICAO:           Remoçao dos dados dos usuarios selecionados
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

//sessionConnect();
sessionAuth(array(ADMIN));

//Specific support:
$tpl["cssArea"]             = controlsCssArea($tpl["css"]);

//Titulo da pagina:
$tpl["titleArea"]           = "MPPB";

//Usuario nao logado no sistema:
$tpl["userArea"] = controlsUser(sessionGet("nome"), sessionGetUserCod(), sessionGet("nomeSetor"));

//Menu do sistema:
$tpl["menuArea"]            = controlsMenuArea(sessionGet("permissao"));

//Titulo da tela atual:
$tpl["titleArea"]           = "Exclusão de usuário(s)";

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

if($_GET["answer"] == 'yes') {

    //TO-DO: Esta mensagem merece ser confirmada pela funcao da query, caso os registros nao sejam removidos
    $instructions               = "Os usuários foram excluidos, com sucesso!<br>OBS: Usuários com acesso a todos os sitemas, administradores e usuário logado não podem ser removidos";
    $tpl["instructionsArea"]    = controlsInstructions($instructions);

    //Delete data:
    if(count($_GET["cod"]) > 0) {
        $query = "begin;";
        foreach($_GET["cod"] as $key) {
            $query .= "update admin.usuario set excluido = 't' where id = $key and user_name <> '".trim(sessionGetUserCod())."'; ";
        }
        $query .= "commit;";
        $res = dbQuery($link, $query);
        //echo $query;
    }
    
    $control[] = controlsActionButton("button", "", "Cadastrar", "insert.php", array());
    $control[] = controlsActionButton("button", "", "Buscar", "search.php", array());
    $control[] = controlsActionButton("button", "", "Listar", "list.php", array());
    $tpl["actionArea"] = controlsActionArea($control);
    
}else {
    //Destino do formulario:
    $tpl["action"]              = "doDelete.php";

    //Metodo usado no no formulario:
    $tpl["method"]              = "GET";

    //Imprime os valores dos codigos em um form invisivel:
    if(count($_GET["cod"]) > 0) {
    
        foreach($_GET["cod"] as $key => $element) {
            $form["codes"] .= controlsHidden("cod[]", "", $element);
        }
        
        //Imprimindo mensagem:
        $instructions               = "Deseja realmente excluir o(s) usuário(s) selecionados?<br>OBS: Usuários com acesso a todos os sitemas, administradores e usuário logado não podem ser removidos";
        $tpl["instructionsArea"]    = controlsInstructions($instructions);
        
        //Controles para exclusão:
        $form["answer"]             = controlsHidden("answer", "", "yes");
        $control[]                  = controlsSubmitButton("button", "", "Sim");
        $control[]                  = controlsBackButton("button", "", "Nao");
        $tpl["actionArea"]          = controlsActionArea($control);

    }else{
        
        //Imprimindo mensagem:
        $instructions               = "Nenhum usuário selecionado, selecione os usuários que serão removidos.";
        $tpl["instructionsArea"]    = controlsInstructions($instructions);
        
        //Controles para exclusão:
        $control[]                  = controlsBackButton("button", "", "Listar");
        $tpl["actionArea"]          = controlsActionArea($control);
        
    }
}

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$tpl["formArea"]        = tplIncludeForm("form.delete", $form);
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
