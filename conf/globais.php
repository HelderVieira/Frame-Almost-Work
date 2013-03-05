<?php

/**
 * Database functions. Use the "cases" nodes to expand the server suport. Require the configuration
 * file to work property.
 *
 * @author HELDER VIEIRA
 * @version 0.2
 * @date 30/11/2008 Joao Pessoa/PB
 */
 
/*
 * Define global vars:
 */
define("PATH", "/faw"); 
define("SYSTEM", "Frame-Almost-Work"); 
define("ORGANIZATION_SITE", "http://www.helder.eti.br");

//Niveis de acesso:
define("ADMIN", "0");
define("USUARIO", "2");

//Quantidade de ocorrencias por pagina nas listagens:
define("MAX_PER_PAGE", 20);

//Quantidade maxima de letras nos nomes em listagens:
define("MAX_STRING_SIZE", 60);

//Banco de dados:
define("SERVER", "POSTGRES");
define("DBHOST", "localhost");
define("DBPORT", "5432");
define("DBNAME", "faw");
define("DBUSER", "postgres");
define("PASSWD", "postgres");

/*
 * Define global array vars:
 */
define("IMAGEM_CABECALHO", PATH."/images/cabecalho.gif");
$tpl["imagem_cabecalho"] = IMAGEM_CABECALHO;

//$tpl["linkArea"] = '<a href="#">yayayay</a>';
$tpl["copyrightArea"] = "";
$tpl["msg"] = "Os seguintes problemas foram encontrados:";
$tpl["lastUpdate"] = array ("2012", "11", "19");

$tpl["css"] = array (
    array (PATH."/css/estilo.css", "all", ""),
    array (PATH."/css/print.css", "print", ""),
    array (PATH."/css/style.css", "all", ""),
    #array (PATH."/css/redmond/jquery-ui-1.8.4.custom.css", "all", ""),
    #array (PATH."/css/ui.jqgrid.css", "all", ""),
    array (PATH."/css/layout_style/grid.css", "all", ""),
);


$tpl["ORGANIZATIONNAME"] = ORGANIZATION_SITE;
$tpl["PROJECTNAME"] = SYSTEM;
$tpl["PATH"] = PATH;

?>
