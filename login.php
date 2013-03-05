<?php

/*
 * ARQUIVO:             login.php
 * AUTOR:               Daniel Falcao
 * DATA:                11/Jul/2006
 * DESCRICAO:           Executa o login no sistema
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

function sessionConfigure($perfil, $nome, $userName, $idSetor, $nomeSetor, $idUsuario) {
    sessionSet("perfil", $perfil);
    sessionSet("nome", $nome);
    sessionSet("idSetor", $idSetor);
    sessionSet("nomeSetor", $nomeSetor);
    sessionSetUserCod($userName); 
    sessionSet("idUsuario", $idUsuario);
}

//Start the session
sessionStart();

//Get the values from the login form:
$userName    = trim($_POST["userName"]);
$passWord    = trim($_POST["passWord"]);
$ultimoLogin = trim($_POST["ultimoLogin"]);

//Search for "_" and "%" in the login and password strings:
//$passWord    = md5($passWord);

//Connect to the database:
$link = dbConnect(DBHOST, DBPORT, DBNAME, DBUSER, PASSWD, SID);

//Setting the permission to session:
$query = "
    select 
        u.id_usuario,
        u.login,
        u.nome, 
        to_char(u.nivel, '9'),
        u.id_setor,
        s.nome
    from usuario u, setor s
    where
        u.id_setor = s.id_setor and
        u.login = '$userName' and
        u.senha = '$passWord'
    ";
    
    //echo $query;
$res = dbQuery($link, $query);
list($idUsuario, $userName, $nome, $perfil, $idSetor, $nomeSetor) = dbFetchArray($res);

//Destroy password:
unset($passWord);

/*
//Checking log:
if(isset($userName) && isset($ultimoLogin)) {
    $query = "select admin.checa_log('$userName', '$ultimoLogin')";
    //echo $query;
    $res = dbQuery($link, $query);
    list($log) = dbFetchArray($res);
    if($log == 't') {
        sessionDisconnect();
        include("index.php");
        exit();
    }
}
*/

//Disconnect from database:
dbClose($link);
unset($link); 

switch($perfil) {
    case ADMIN:
    case USUARIO:
    case LIMITADO:
        sessionConfigure($perfil, $nome, $userName, $idSetor, $nomeSetor, $idUsuario);
        include("main.php");
        break;
    default:
        $errors[] = "Usuario ou senha incorretos!";
        sessionDisconnect();
        include("index.php");
        exit();
        break;
}

?>
