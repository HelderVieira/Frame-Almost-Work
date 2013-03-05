<?php

/**
 * Use this funtions to generate HTML contents or put data inside HTML area (portlets)
 *
 * @author DANIEL FALCAO
 * @version 0.4
 * @date 29/03/2006 Joao Pessoa/PB
 */

/**
 * Modify one string (using <lgc=?> tag) with the specified file and array of variables
 *
 * @return StringFile
 * @param the form file path
 * @param var array
 */
function tplIncludeForm($formPath, $var) {

    $stringFile = "";
    if (file_exists($formPath) && is_readable($formPath)) {
        $stringFile = file_get_contents($formPath);

        //Walk in the var array replacing the html content:
        if(count($var) > 0) {
            foreach($var as $key => $value) {
                //echo "[$key] - [$value]";
                $stringFile = str_replace("<form=$key>", $value, $stringFile);
            }
        }
    }

    $stringFile = preg_replace("/<tpl=[a-zA-Z0-9_ ]*>/", "", $stringFile);
    return($stringFile);
}

/**
 * Modify one string (using <tpl=?> tag) with the specified file and array of variables
 *
 * @return StringFile
 * @param the template file path
 * @param var array
 * @param form or list string created
 */
function tplIncludeTemplate($templatePath, $var, $contentString) {

    $stringFile = "";
    if (file_exists($templatePath) && is_readable($templatePath)) {
        $stringFile = file_get_contents($templatePath);

        //Walk in the var array replacing the html content:
        if(count($var) > 0) {
            foreach($var as $key => $value) {
                //echo "[$key] - [$value]";
                $stringFile = str_replace("<tpl=$key>", $value, $stringFile);
            }
        }
    }

    $stringFile = preg_replace("/<tpl=[a-zA-Z0-9_ ]*>/", "", $stringFile);
    return($stringFile);
}

/**
 * Translate one string (using <lang=?> tag) with the specified file
 *
 * @return StringFile
 * @param the locale file path
 * @param the template string created
 */
function tplIncludeLang($langPath, $contentString) {

    $stringFile = $contentString;
    if (file_exists($langPath) && is_readable($langPath)) {
        $lang = tplLoadConfig($langPath);

        //Walk in the var array replacing the html content:
        foreach($lang as $key => $value) {
            //echo "[$key] - [$value]";
            $stringFile = str_replace("<lang=$key>", $value, $stringFile);
        }
    }

    $stringFile = ereg_replace("<lang=[a-zA-Z0-9_ ]*>", "", $stringFile);
    return($stringFile);
}

/**
 * Load one configuration file (classic style)
 *
 * @return array assoc with values
 * @param the file path to be loaded
 */
function tplLoadConfig($filePath) {

    if (file_exists($filePath) && is_readable($filePath)) {
    //EXAMPLE:
    //$fp = @fopen($_SERVER["DOCUMENT_ROOT"].PATH."portal.conf","r");
    $fp = @fopen($filePath,"r");
    while($line = @fgets($fp,1024)){
        $line	= ereg_replace("#.*S","",$line);
        list($param,$value)	= explode('=',$line);
            $param = trim($param);
            $value = trim($value);
            $var[$param] = $value;
        }
    }
    return($var);
}

?>
