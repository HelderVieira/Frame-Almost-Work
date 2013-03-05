<?php

/**
 * Check if the data is correct
 *
 * @author DANIEL FALCAO
 * @version 0.1
 * @date 11/07/2006 Joao Pessoa/PB
 */

function checkBrReal($brReal, $required){
    if($brReal != ""){
        if(!eregi("^[0-9]{1,},[0-9]{2}$",$brReal)){
            return false;
        }else{
            return true;
        }
    }
    if($required){
        return false;
    }else{
        return true;
    }
}

function checkBrDate($brDate, $required){
    if($brDate != ""){
        //Verify DD/MM/YYYY
        if(!eregi("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$brDate)){
            return false;
        }else{
            list($day, $month, $year) = explode('/',$brDate);
            if(checkdate($month, $day, $year)){
                return true;
            }else{
                return false;
            }
        }
    }
    if($required){
        return false;                
    }else{
        return true;
    }
}

function checkBrTime($brTime, $required){
    if($brTime != ""){
        //Verify HH:MM
        if(!eregi("^[0-9]{2}:[0-9]{2}$",$brTime)){
            return false;
        }else{
            list($hour, $min) = explode(':',$brTime);
            if($hour < 24 && $min < 60){
                return true;
            }else{
                return false;
            }
        }
    }
    if($required){
        return false;
    }else{
        return true;
    }
}

function checkCnpf($cnpf, $required){
    if($cnpf != ""){
        $tam_cpf = strlen($cnpf);
        for($i = 0; $i < $tam_cpf; $i++){
            $carac = substr($cnpf, $i, 1);
            if(ord($carac) >= 48 && ord($carac) <= 57){
                $cnpf_limpo .= $carac;
            }
        }

        if(strlen($cnpf_limpo)!=11){
            return false;
        }

        $soma = 0;
        for($i = 0; $i < 9; $i++){
            $soma += (int)substr($cnpf_limpo, $i, 1) * (10-$i);
        }

        if($soma == 0){
            return false;
        }

        $primeiro_digito = 11 - $soma % 11;
        if($primeiro_digito > 9){
            $primeiro_digito = 0;
        }

        if(substr($cnpf_limpo, 9, 1) != $primeiro_digito){
            return false;
        }

        $soma = 0;
        for($i = 0; $i < 10; $i++){
            $soma += (int)substr($cnpf_limpo, $i, 1) * (11-$i);
        }
        $segundo_digito = 11 - $soma % 11;

        if($segundo_digito > 9){
            $segundo_digito = 0;
        }

        if(substr($cnpf_limpo, 10, 1) != $segundo_digito){
            return false;
        }

        return true; //O CNPF esta correto!
    }

    if($required){
        return false;
    }else{
        return true;
    }
 }

function checkCnpj($cnpj, $required){
    if($cnpj != ""){
        $s = "";
        for($x = 1; $x <= strlen($cnpj); $x = $x+1){
            $ch = substr($cnpj, $x-1, 1);
            if(ord($ch) >= 48 && ord($ch) <= 57){
                $s .= $ch;
            }
        }
                                                                                 
        if(strlen($cnpj) != 14){
            return false;
        }else{
            if($cnpj == "00000000000000"){
                return false;
            }else{
                $Numero[1]      = intval(substr($cnpj,1-1,1));
                $Numero[2]      = intval(substr($cnpj,2-1,1));
                $Numero[3]      = intval(substr($cnpj,3-1,1));
                $Numero[4]      = intval(substr($cnpj,4-1,1));
                $Numero[5]      = intval(substr($cnpj,5-1,1));
                $Numero[6]      = intval(substr($cnpj,6-1,1));
                $Numero[7]      = intval(substr($cnpj,7-1,1));
                $Numero[8]      = intval(substr($cnpj,8-1,1));
                $Numero[9]      = intval(substr($cnpj,9-1,1));
                $Numero[10]     = intval(substr($cnpj,10-1,1));
                $Numero[11]     = intval(substr($cnpj,11-1,1));
                $Numero[12]     = intval(substr($cnpj,12-1,1));
                $Numero[13]     = intval(substr($cnpj,13-1,1));
                $Numero[14]     = intval(substr($cnpj,14-1,1));
    
                $soma           =
                    $Numero[1]  * 5 +
                    $Numero[2]  * 4 +
                    $Numero[3]  * 3 +
                    $Numero[4]  * 2 +
                    $Numero[5]  * 9 +
                    $Numero[6]  * 8 +
                    $Numero[7]  * 7 +
                    $Numero[8]  * 6 +
                    $Numero[9]  * 5 +
                    $Numero[10] * 4 +
                    $Numero[11] * 3 +
                    $Numero[12] * 2;
        
                $soma = $soma-(11*(intval($soma/11)));
                if($soma == 0 || $soma == 1){
                    $resultado1 = 0;
                }else{
                    $resultado1 = (11 - $soma);
                }
                if($resultado1 == $Numero[13]){
                    $soma           =
                        $Numero[1]  * 6 +
                        $Numero[2]  * 5 +
                        $Numero[3]  * 4 +
                        $Numero[4]  * 3 +
                        $Numero[5]  * 2 +
                        $Numero[6]  * 9 +
                        $Numero[7]  * 8 +
                        $Numero[8]  * 7 +
                        $Numero[9]  * 6 +
                        $Numero[10] * 5 +
                        $Numero[11] * 4 +
                        $Numero[12] * 3 +
                        $Numero[13] * 2;
                    $soma = $soma - (11 * (intval($soma/11)));
                    if($soma == 0 || $soma == 1){
                        $resultado2 = 0;
                    }else{
                        $resultado2 = 11 - $soma;
                    }
                    if($resultado2 == $Numero[14]){
                        return true; //O CNPJ esta correto!
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }
    }

    if($required){
        return false;
    }else{
        return true;
    }
}

?>