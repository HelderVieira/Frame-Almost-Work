<?php

/**
 * Session functions. Use the session ti check enviroment variables when one user
 * is connected to the system. Good to simulate authorization and data persistance. 
 *
 * @author DANIEL FALCAO
 * @version 0.1
 * @date 28/03/2006 Joao Pessoa/PB
 */

/**
 * Start one session
 *
 * @return
 * @param
 */
function sessionStart() {
	session_start();
}

/**
 * Set one session var
 *
 * @return
 * @param
 */
function sessionSet($sessionVar, $value) {
	$_SESSION["session_".$sessionVar] = $value;
}

/**
 * Get one session var
 *
 * @return
 * @param
 */
function sessionGet($sessionVar) {
        return($_SESSION["session_".$sessionVar]);
}

/**
 * Set the session userCod var
 *
 * @return
 * @param
 */
function sessionSetUserCod($value) {
	$_SESSION["session_userCod"] = $value;
}

/**
 * Get the session userCod var
 *
 * @return
 * @param
 */
function sessionGetUserCod() {
        return($_SESSION["session_userCod"]);
}

/**
 * Connect to one session if user is registred
 *
 * @return 0 if session not exists, 1 if session exists
 * @param void
 */
function sessionConnect() {
	sessionStart();
	if(!isset($_SESSION["session_userCod"])){
	    $relative_url = "index.php";
	    header("Location: http://" . $_SERVER['HTTP_HOST'].PATH."/".$relative_url);
	    exit();
	}
}

/**
 * Permission to access the page
 *
 * @return 0 if session not exists, 1 if session exists
 * @param void
 */
function sessionAuth($permission) {
	sessionStart();
	if(!isset($_SESSION["session_userCod"])){
	    //Require login, try to login first...
	    $relative_url = "index.php";
	    header("Location: http://" . $_SERVER['HTTP_HOST'].PATH."/".$relative_url);
	    exit();
	}else {
	    if(count($permission) > 0 && is_array($permission)) {
	        $relative_url = "index.php";
	        if(!in_array(sessionGet("perfil"), $permission)) {
	            /*
	            echo "permissoes:<br>";
	            print_r($permission);	            
	            echo
	            */ 
	            //Access denied...
	            $relative_url = "index.php";
	            header("Location: http://" . $_SERVER['HTTP_HOST'].PATH."/".$relative_url);
	            exit();
	        }
	    }else {
	        //Some error in array param!
	        echo "Erro nos parametros de acesso ao script...";
	        exit();
      }
	}
}

/**
 * Disconnect to one session if user is registred
 *
 * @return void
 * @param void
 */
function sessionDisconnect() {
	session_unset();
	session_destroy();
}

?>