<?php

/**
 * Database functions. Use the "cases" nodes to expand the server suport. Require the configuration
 * file to work property.
 *
 * @author DANIEL FALCAO
 * @version 0.1
 * @date 27/03/2006 Joao Pessoa/PB
 */

/**
 * Connect to the specifeied database
 *
 * @return
 * @param host location
 * @param database name
 * @param user name
 * @param password check
 * @param session sid (oracle server)
 */
function dbConnect($host, $port, $dbname, $user, $password, $sid) {
	switch(SERVER) {
		case "POSTGRES":
			//Set the values:
			$host           = ($host) ? "host=".$host : "";
			$port           = ($port) ? "port=".$port : "";
			$dbname         = ($dbname) ? "dbname=".$dbname : "";
			$user           = ($user) ? "user=".$user : "";
			$password       = ($password) ? "password=".$password : "";

			//Build the postgres connection url:
			$param = "$host $port $dbname $user $password";
			$param = trim($param);
			$connection = pg_connect($param);
			//echo $param;
			break;
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($connection);
}

/**
 * Execute one SQL query (some cases, transaction support).
 *
 * @return
 * @param connection resource
 * @param SQL query string
 */
function dbQuery($connection, $query) {
	switch(SERVER) {
		case "POSTGRES":
			$result = pg_query($connection, $query);
			break;
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($result);
}

/**
 * Check the number of rows in one result set
 *
 * @return 
 * @param server name
 * @param result query
 */
function dbNumRows($result) {
	switch(SERVER) {
		case "POSTGRES":
			$numRows = pg_num_rows($result);
			break;
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($numRows);
}

/**
 * Check the number of fields in one result set
 *
 * @return
 * @param result query
 */
function dbNumFields($result) {
	switch(SERVER) {
		case "POSTGRES":
			$numFields = pg_num_fields($result);
			break;
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($numFields);
}

/**
 * Check the field name (array style) in one result set
 *
 * @return
 * @param result query
 * @param field number (position in array)
 */
function dbFieldName($result, $fieldNumber) {
	switch(SERVER) {
		case "POSTGRES":
			$fieldName = pg_field_name($result, $fieldNumber);
			break;
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($fieldName);
}

/**
 * Return one tuple of one result set to use with list() function
 *
 * @return
 * @param result query
 */
function dbFetchArray($result) {
	switch(SERVER) {
		case "POSTGRES":
			$tuple = pg_fetch_array($result);
			break;
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($tuple);
}

function dbConvertArray($result) {
    switch(SERVER) {
        case "POSTGRES":
        $data = pg_fetch_all($result);
        ///pg_fetch_all returns array or boolean??? :P
        if(!is_array($data)) {
            $data = array();
        }
        break;
    default:
        //Database internal error, show the default error page:
        //$tpl["error"] = "Database not found, check the configuration file!";
        //echo $tpl["error"];
        break;
    }
    return($data);
}

/**
 * Close the connection with the database.
 *
 * @return
 * @param connection resource
 */
function dbClose($connection) {
	switch(SERVER) {
		case "POSTGRES":
			$status = pg_close($connection);
		default:
			//Database internal error, show the default error page:
			//$tpl["error"] = "Database not found, check the configuration file!";
			//echo $tpl["error"];
			break;
	}
	return($status);
}

?>
