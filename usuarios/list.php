<?php

/*
 * ARQUIVO:             list.php
 * AUTOR:               Daniel Falcao
 * DATA:                28/Set/2006
 * DESCRICAO:           Lista os usuarios do sistema
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
$tpl["menuArea"]            = controlsMenuArea(sessionGet("perfil"));

//Titulo da tela atual:
$tpl["titleArea"]           = "Usuários";

$instructions               = "Administração de usuários do sistema.";
$tpl["instructionsArea"]    = controlsInstructions($instructions);

//Recupera os valores para buscas:
$nome                   = trim($_GET["nome"]);
$email                  = trim($_GET["email"]);
$pg                     = $_GET["pg"];

//Validacoes para busca:
if($nivel != "0" && $nivel != "") {
    $query_nivel = "u.perfil = '$nivel' and ";
}

//Recurso para a paginacao:
if ($pg == ""){
    $pg = 0;
}
$init       = $pg * MAX_PER_PAGE;
$quant      = MAX_PER_PAGE;

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Executa a transacao:
$query = "
    select
        u.id, 
        u.nome,
        u.email,
        case u.perfil
            when 'a' then 'Administrador'
            when 'u' then 'Usuário do Protocolo'
            when 'l' then 'Usuário Limitado'
            else 'Indeterminado'
        end as perfil
    from admin.usuario u
    where
        u.excluido = 'f' and
        to_ascii(u.nome) ilike to_ascii('%$nome%') and
        to_ascii(u.email) ilike to_ascii('%$email%') and
        $query_nivel
        1 = 1
    order by u.nome, u.email, u.perfil
    limit $quant offset $init";

$res = dbQuery($link, $query);
$columnsLabels      = array(1 => "nome", 2 => "email", 3 => "nivel");
$rowsData           = dbConvertArray($res);
$jsCAFunction       = "testeAll";
$checkBoxName       = "cod";
$linkAction         = "update.php?cod=";
$linkActived        = false;
$tpl["listArea"]    = controlListArea($columnsLabels, $rowsData, $jsCAFunction, $checkBoxName, $linkAction, $linkActived);

//Destino do formulario:
$tpl["action"]          = "doSomething.php";

//Metodo usado no no formulario:
$tpl["method"]          = "GET";

//Controles de acao na lista:
$control[] = controlsSelect("operation", "", array(0 => "Selecione", 1 => "Remover"), 0);
$control[] = controlsSubmitButton("button", "", "Ok");
$control[] = controlsActionButton("button", "", "Cadastrar", "insert.php", array());
$control[] = controlsActionButton("button", "", "Buscar", "search.php", array());

//Query para a paginacao:
$query = "
    select
        count(*)
    from admin.usuario u
    where
        u.excluido = 'f' and
        to_ascii(u.nome) ilike to_ascii('%$nome%') and
        to_ascii(u.email) ilike to_ascii('%$email%') and
        $query_nivel
        1 = 1 
        ";

$res = dbQuery($link, $query);
list($count) = dbFetchArray($res);

//Gerando os botoes de paginacao:
$paginas = ceil($count / MAX_PER_PAGE);
if($pg <> 0) {
    $pgAnt = $pg - 1;
    $control[] = controlsActionButton("button", "", "Anterior", "list.php", array("pg" => $pgAnt, "nome" => $nome, "email" => $email, "nivel" => $nivel));
}
if ($pg < $paginas -1) {
    $pgProx = $pg + 1;
    $control[] = controlsActionButton("button", "", "Proximo", "list.php", array("pg" => $pgProx, "nome" => $nome, "email" => $email, "nivel" => $nivel));
}

$pg++;
$control[] = "<label class=\"pglabel\">$pg/$paginas</label>";
$tpl["actionArea"]      = controlsActionArea($control);

//Disconnect from database:
dbClose($link);
unset($link); 

//Imprimindo conteudo:
$template               = tplIncludeTemplate("../tpl.design", $tpl, "");
echo $template;

?>
