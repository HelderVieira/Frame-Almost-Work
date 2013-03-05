<?php

/**
 * Converts strings representations (casts) 
 *
 * @author DANIEL FALCAO
 * @version 0.2
 * @date 18/07/2006 Joao Pessoa/PB
 */

/**
 *
 */
 function traduzDiaDaSemana($dia) {
    if ($dia == 'Sun') {
      return "Domingo";
    } else if ($dia == 'Mon') {
      return "Segunda-feira";
    } else if ($dia == 'Tue') {
      return "Terca-feira";
    } else if ($dia == 'Wed') {
      return "Quarta-feira";
    } else if ($dia == 'Thu') {
      return "Quinta-feira";
    } else if ($dia == 'Fri') {
      return "Sexta-feira";
    } else if ($dia == 'Sat') {
      return "Sabado";
    }
 }


 
 /**
  * normaliza_nome($nome)
  * Normaliza o nome
  */
 function normalizaNome($nome){
        $arrayNome = explode(" ", $nome); //Retorna uma matriz de strings da variavel nome, separando pelos espacos
        $tamanhoArray = count($arrayNome);  //Conta a quantidade de elementos do array
        $arrayConectivos = array('', 'da', 'de', 'di', 'do', 'du', 'das', 'dos', 'e');
        $nomeNormalizado = "";

        for ($cont = 0; $cont < $tamanhoArray; $cont++){
                $temp = $arrayNome[$cont];
                $temp = strtolower($temp);

                if(array_search($temp, $arrayConectivos) == null)
                        $nomeNormalizado .= ucfirst($temp)." ";
                else
                        $nomeNormalizado .= $temp." ";
        }
        return(trim($nomeNormalizado));
 }

 function string_query($string){
	$array = explode(" ",strtoupper(trim($string)));
	$string = "%";
	for($count = 0; $count < count($array); $count++){
		if($array[$count])
			$string .= $array[$count]."%";
	}
	return($string);
 }


/**
 * Convert one string of the search and replace all empty spaces by %
 * 
 * @return the string to convert
 * @param sql string
 */
function stringToSQLSearch($string){
    $sqlString = str_replace(" ", "%", $string);
    return "%$sqlString%";
}

/**
 * Convert one date string of the search and replace all empty spaces by %
 * 
 * @return sqlString
 * @param the string to convert
 */
function dateToSQLSearch($date){
    $sqlString = stringToSQLSearch($date);
    return "%$sqlString%";
}

/**
 * Convert one timestamp string of the search and replace all empty spaces by %
 * 
 * @return the string to convert
 * @param sql string
 */
function timestampToSQLSearch($timestamp){
    $sqlString = str_replace(" ", "%", $timestamp);
    return "%$sqlString%";
}

/**
 * Convert brazilian date format to database format
 * 
 * @return the date to convert
 * @param sql string
 */
function brDateToDbDate($brDate) {
    $date = explode("/",$brDate);
    $sqlDate = $date[2]."-".$date[1]."-".$date[0];
    if($sqlDate == "--") {
        $sqlDate = "";
    }
    return $sqlDate;
}

function brDateToPhpDate($brDate) {
    $date = explode("/",$brDate);
    $phpDate = mktime(0,0,0,$date[1], $date[0], $date[2]);


    return $phpDate;
}

/**
 * Convert database date format to brazilian format
 * 
 * @return sql string to convert
 * @param date
 */
function dbDateToBrDate($sqlDate) {
    $date = explode("-",$sqlDate);
    $brDate = $date[2]."/".$date[1]."/".$date[0];
    if($brDate == "//") {
        $brDate = "";
    }    
    return $brDate;
}

/**
 * Convert brazilian timestamp format to database format
 * 
 * @return the timestamp to convert
 * @param sql string
 */
function brTimestampToDbTimestamp($brTimestamp) {
    $timestamp = explode(" ",$brTimestamp);
    $timestamp[0] = brDateToDbDate($timestamp[0]);
    $sqlTimestamp = $timestamp[0]." ".$timestamp[1];
    return $sqlTimestamp;
}

/**
 * Convert database date format to brazilian format
 * 
 * @return sql string to convert
 * @param Timestamp
 */
function dbTimestampToBrTimestamp($sqlTimestamp) {
    $timestamp = explode(" ",$brTimestamp);
    $timestamp[0] = dbDateToBrDate($timestamp[0]);
    $brTimestamp = $timestamp[0]." ".$timestamp[1];    
    return $brTimestamp;
}

/**
 * Convert database money format to brazilian real format
 * 
 * @return 
 * @param 
 */
function brRealToDbMoney($brReal) {
    $tmp = str_replace(".", ":", $brReal);
    $tmp = str_replace(",", ".", $tmp);
    $tmp = str_replace(":", ",", $tmp);
    $sqlMoney = $tmp;
    return $sqlMoney;
}
 
/**
 * Convert brazilian real format to database money format
 * 
 * @return 
 * @param 
 */
function dbMoneyToBrReal($sqlMoney) {
    $tmp = str_replace(",", ":", $sqlMoney);
    $tmp = str_replace(".", ",", $tmp);
    $tmp = str_replace(":", ".", $tmp);
    $brReal = $tmp;
    return $brReal;
}

/**
 * Convert database float format to brazilian float format
 * 
 * @return 
 * @param 
 */
function brFloatToDbFloat($brFloat) {
    $tmp = str_replace(".", "", $brFloat);
    $tmp = str_replace(",", ".", $tmp);
    $sqlFloat = $tmp;
    return $sqlFloat;
}
 
/**
 * Convert brazilian float format to database float format
 * 
 * @return 
 * @param 
 */
function dbFloatToBrFloat($sqlFloat) {
    $tmp = str_replace(",", ":", $sqlFloat);
    $tmp = str_replace(".", ",", $tmp);
    $tmp = str_replace(":", ".", $tmp);
    $brFloat = $tmp;
    return $brFloat;
}

/**
 * Convert one matrix Nx2 to one single array
 *
 * @return array
 * @param matrix
 */
function matrixNx2ToArray($matrix) {
    if(count($matrix) > 0) {
        while(list($index, $arrayLine) = each($matrix)) {
            if(count($arrayLine) == 2) {
                $x = 0;
                while(list($arrayKey, $arrayVal) = each($arrayLine)) {
                    if($x == 0) {
                        $index = $arrayVal;
                    }else {
                        $array[$index] = $arrayVal;
                    }
                    $x++;
                }
            }else {
                $array = array();
            }
        }
    }else {
        $array = array();
    }
    return $array;
} 
 
?>
