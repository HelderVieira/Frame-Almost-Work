<?php

/**
 * Quick access to dinamic HTML content
 *
 * @author DANIEL FALCAO
 * @version 0.4
 * @date 04/08/2006 Joao Pessoa/PB
 */

/**
 * Build the tab area
 * 
 * @return content
 * @param var array assoc
 * @param selectedIndex int (-1 = none selected) NOT WORKING!!!
 */
function controlsTab($var, $index) {
    if(count($var) > 0) {
        foreach($var as $key => $location) {
            $tab .= '<li id="menu_'.$position.'"><a href="'.$location.'" title="'.$key.'">'.$key.'</a></li>';
        }
    }
    return $tab;
}

/**
 * Build the tab area
 * 
 * @return content
 * @param userName string
 * @param userCod int
 */
function controlsUser($userName, $userCod, $officeName='') {
    $content = '
            <ul>
                <li>
                    <img src="'.PATH.'/images/agent.png" alt="User"/>
                    <span>Visitante</span>
                </li>
            </ul>';
    if ($userCod != "") {
        $content = '
            <ul>
                <li>
                    <a href="'.PATH.'/usuarios/passwd.php">
                        <img src="'.PATH.'/images/agent.png" alt="Usuário"/>
                        <span>'.$userName.'</span>
                    </a>
                </li>
                <li>
                    <img src="'.PATH.'/images/multi-agents.png" alt="Setor"/>
                    <span>'.$officeName.'</span>
                </li>
                <li>
                    <a href="'.PATH.'/logoff.php" id="btSair">
                        <img src="'.PATH.'/images/shut-down.png" alt="Sair"/>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>';
    }

    return $content;
}

/**
 * Build the menu area
 * 
 * @return content
 * @param var array
 */
function controlsMenu($var) {
    if(count($var) > 0) {
        $menu = '<nav><ul class="menu">';
        foreach($var as $key => $location) {
            $menu .= '<li><a href="'.$location.'">'.$key.'</a></li>';
        }
        $menu .= "</ul></nav>";
    }
    return $menu;
}

function controlsDropDownMenu($var) {
    if(count($var) > 0) {
        $menu = '<nav><ul class="menu">';

        foreach ($var as $group_name => $group) {
            $menu .= '<li><a href="#">'.$group_name.'</a> <ul>';
            foreach($group as $key => $location) {
                $menu .= '<li><a href="'.$location.'">'.$key.'</a></li>';
            }
            $menu .= '</li></ul>';
        }
        
        $menu .= "</ul></nav>";
    }
    return $menu;
}

/**
 * Automated menu area
 * 
 * @return content
 * @param var array
 */
function controlsMenuArea($userAccess) {
    switch($userAccess) {
         case ADMIN:
            $menu = array(
                "Requisi&ccedil;&otilde;es" => PATH."/view/requisicoes/list.php",
                //"Usu&aacute;rios" => PATH."/usuarios/list.php",
                "Alterar a Senha" => PATH."/usuarios/passwd.php",
                "Sair" => PATH."/logoff.php"
                );
            break;
         case USUARIO:
            $menu = array(
                "Requisi&ccedil;&otilde;es" => PATH."/view/requisicoes/list.php",
                
                "Alterar a Senha" => PATH."/usuarios/passwd.php",
                "Sair" => PATH."/logoff.php"
                );
            break;          
         default:
            $menu = array(
                "Institucional" => ORGANIZATION_SITE,
                
                "Login" => PATH."/index.php"
                );
            break;
    } 
    return controlsMenu($menu);
}



/**
 * Build the instruction area
 * 
 * @return content
 * @param instruction string
 */
function controlsInstructions($instruction) {
    $content = "<p>$instruction</p>";
    return $content;
}

/**
 * Build the warning area
 * 
 * @return content
 * @param msg general message string
 * $param var array of topics
 */
function controlsWarning($msg, $var) {
    $content = '<div id="errorsMessageBox" class="errorsMessageBox">';
    $content .= '<h3>'.$msg.'</h3>';
    
    if(count($var) > 0) {
        $content .= '<ul>';
        foreach($var as $key => $warning) {
            $content .= '<li>'.$var[$key].'</li>';
        }
        $content .= '</ul>';
    }

    $content .= controlsActionArea(array(controlsScriptButton("btFechar", "btFechar", "Fechar", "document.getElementById('errorsMessageBox').style.display='none';")));
    $content .= '</div>';
    return $content;      
}

/**
 * Last updated in...
 * 
 * @return content
 * $param year string
 * $param month string
 * $param day string
 */
function controlsLastUpdate($year, $month, $day) {
    $content = "Ultima atualiza&ccedil;&atilde;o em $day/$month/$year";
    return $content;
}

/**
 * Generate one table with the data selection:
 *
 * @return content
 * @param columnsLabel [ARRAY COM A LISTA DE LABELS DAS COLUNAS]
 * @param rowsData [ARRAY COM TODOS OS VALORES RETORNADOS PARA LISTAGEM (A POSICAO ZERO DEVERA CONTER O CODIGO OU IDENTIFICADOR DE CADA LINHA)]
 * @param jsCAFunction [O NOME DA FUNCAO JAVASCRIPT UTILIZADO PARA CHECAR TODOS OS VALORES]
 * @param checkBoxName [O NOME DA VARIAVEL DOS CHECKBOXES]
 * @param linkAction [A URL UTILIZADA COMO ACAO PARA CLICAR NUMA LINHA DA LISTAGEM]
 * @param linkActived [USAR TRUE PARA UTILIZAR O LINK EM CADA LINHA DA LISTAGEM]
 */
function controlListArea($columnsLabels, $rowsData, $jsCAFunction, $checkBoxName, $linkAction, $linkActived) {
    //Table head:
    $content = '
        <table class="datatable">
        <thead><tr>';
        
    //Columns labels:
    if(count($columnsLabels) > 0) {
        $content .= '<th><!-- input type=checkbox name="selectAll" onClick="'.$jsCAFunction.'(\''.$checkBoxName.'[]\')" --></th>';
        foreach($columnsLabels as $key => $column) {
            $content .= '<th>'.$column.'</th>';
        }
        $content .= '</tr>';
    }
    $content .= '</thead><tbody>';
    
    //Rows data:
    if(count($rowsData) > 0) {
        foreach($rowsData as $line) {
            $i = 0;
            $content .= "\n".'<tr>'."\n";
            foreach($line as $cell) {
                if($i == 0) {
                    $content .= '<td width="1"><input type="checkbox" name="'.$checkBoxName.'[]" value="'.$cell.'"></td>'."\n";
                    $code = $cell;
                }else {
                    $content .= '<td class="shortcut">';
                    if ($linkActived) {
                        $content .= '<a class="datalink" href="'.$linkAction.$code.'">';
                    }
                    $content .= $cell;
                    if ($linkActived) {
                        $content .= '</a>';
                    }
                    $content .= '</td>'."\n";
                }
                $i++;
            }
            $content .= '</tr>'."\n";
        }
    }else {
        $spam = count($columnsLabels);
        $content .= '
            <tr>
                <td width="1"><input type="checkbox" name="'.$checkBoxName.'[]" value="0"></td>
                <td class="shortcut" colspan="'.$spam.'">
                <a class="datalink" href="#">Nenhum registro encontrado</a>
                </td>
            </tr>'."\n";
    }
    
    //Table footer:
    $content .= '</tbody></table>';
    return $content;
}


function controlGridReport($columnsLabels, $rowsData, $counter=true) {
    $cont = 1;
    
    //Table head:
    $content = '
        <table style="width: 100%; text-align: left; margin-left: auto; margin-right: auto;" border="1" bordercolor="#000000" cellpadding="1" cellspacing="0" rules="all">
        <thead><tr>';
        
    //Columns labels:
    if(count($columnsLabels) > 0) {
        if ($counter == true) {
            $content .= '<th>#</th>';
        }
        foreach($columnsLabels as $key => $column) {
            $content .= '<th>'.$column.'</th>';
        }
        $content .= '</tr>';
    }
    $content .= '</thead><tbody>';
    
    //Rows data:
    if(count($rowsData) > 0) {
        foreach($rowsData as $line) {
            $i = 0;
            $content .= "\n".'<tr>'."\n";
            foreach($line as $cell) {
                if($i == 0) {
                    if ($counter == true) {
                        $content .= '<td width="1">'.$cont++.'</td>'."\n";
                    }
                    $code = $cell;
                }else {
                    $content .= '<td class="shortcut">'.$cell.'</td>'."\n";
                }
                $i++;
            }
            $content .= '</tr>'."\n";
        }
    }else {
        $spam = count($columnsLabels);
        $content .= '
            <tr>
                <td width="1">#</td>
                <td class="shortcut" colspan="'.$spam.'">
                Nenhum registro encontrado
                </td>
            </tr>'."\n";
    }
    
    //Table footer:
    $content .= '</tbody></table>';
    return $content;
}




function controlGridArea($columnsLabels, $rowsData, $linkAction, $linkActived) {
    //Table head:
    $content = '
        <table class="datatable">
        <thead><tr>';
        
    //Columns labels:
    if(count($columnsLabels) > 0) {
        //$content .= '<th><input type=checkbox name="selectAll" onClick="'.$jsCAFunction.'(\''.$checkBoxName.'[]\')"></th>';
        foreach($columnsLabels as $key => $column) {
            $content .= '<th>'.$column.'</th>';
        }
        $content .= '</tr>';
    }
    $content .= '</thead><tbody>';
    
    //Rows data:
    if(count($rowsData) > 0) {
        foreach($rowsData as $line) {
            $i = 0;
            $content .= "\n".'<tr>'."\n";
            foreach($line as $cell) {
                
                if($i == 0) {
                    //$content .= '<td width="1"><input type="checkbox" name="'.$checkBoxName.'[]" value="'.$cell.'"></td>'."\n";
                    $code = $cell;
                }else {
                    $content .= '<td class="shortcut">';
                    if ($linkActived) {
                        $content .= '<a class="datalink" href="'.$linkAction.$code.'">';
                    }
                    $content .= $cell;
                    if ($linkActived) {
                        $content .= '</a>';
                    }
                    $content .= '</td>'."\n";
                    #$content .= '<td class="shortcut"><a class="datalink" href="'.$linkAction.$code.'">'.$cell.'</a></td>'."\n";
                }                
                $i++;
            }
            $content .= '</tr>'."\n";
        }
    }else {
        $spam = count($columnsLabels);
        /*
        $content .= '
            <tr>
                <td width="1"><input type="checkbox" name="'.$checkBoxName.'[]" value="0"></td>
                <td class="shortcut" colspan="'.$spam.'">
                <a class="datalink" href="#">Nenhum registro encontrado</a>
                </td>
            </tr>'."\n";
        */
        $content .= '
            <tr>
                <td class="shortcut" colspan="'.$spam.'">
                <a class="datalink" href="#">Nenhum registro encontrado</a>
                </td>
            </tr>'."\n";
            
    }
    
    //Table footer:
    $content .= '</tbody></table>';
    return $content;
}

function controlsActionArea($var) {
    if(count($var) > 0) {
        $action = '<ul class="buttons">';
        foreach($var as $key => $control) {
            $action .= '<li>'.$control.'</li>';
        }    
        $action .= "</ul>";
    }
    return $action;
}

function controlsActionSubArea($var) {
    if(count($var) > 0) {
        $action = '<ul class="buttons">';
        foreach($var as $key => $control) {
            $action .= '<li>'.$control.'</li>';
        }    
        $action .= "</ul><br />";
    }
    return $action;
}

/**
 * Build the link area
 * 
 * @return content
 * @param var array
 */
function controlsLinkArea($var) {
    if(count($var) > 0) {
        foreach($var as $key => $link) {
            $list .= '<li>'.$link.'</li>';
        }    
    }
    return $list;
}

/**
 * Build the link area
 * 
 * @return content
 * @param var array
 */
function controlsCssArea($var) {
    if(count($var) > 0) {
        foreach($var as $key => $link) {
            //$list .= '<li>'.$link.'</li>';
            $list .= '<link rel="stylesheet" type="text/css" href="'.$link[0].'" title="'.$link[2].'" media="'.$link[1].'">'."\n";
            //$list .= '<link rel="stylesheet" type="text/css" href="'.$link[0].'">'."\n";
        }    
    }
    return $list;
}

/**
 * Auto generate one HTML label pointing to one control
 * 
 * @return html label
 * @param the label caption
 * @param the control pointer
 */
function controlsLabel($caption, $controlName) {
    $label = "<label for=\"$controlName\" class=\"deflabel\">$caption</label>";
    return $label;
}

/**
 * Static function
 *
 * @return element to readonly field
 * $param boolean is it readonly?
 */
function controlsIsReadOnly($quest) {
    return $quest ? "readonly" : "";
}

/**
 * Static function
 *
 * @return element to check field
 * $param boolean is it checked?
 */
function controlsIsCheck($quest) {
    return $quest ? "checked" : "";
}

/**
 * Auto generate one HTML check button (logic AND)
 * 
 * @return html check
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the control value if checked
 * @param boolean checked or not
 * @param is it a read only field?
 */
function controlsCheck($name, $id, $value, $checked = false, $readOnly = false) {
    $check = controlsIsCheck($checked);
    $read = controlsIsReadOnly($readOnly);
    return "<input type=\"checkbox\" name=\"$name\" id=\"$id\" value=\"$value\" $read $check>";
}

/**
 * Auto generate one HTML radio button (logic OR)
 * 
 * @return html radio
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the control value if checked
 * @param boolean checked or not
 * @param is it a read only field? 
 */
function controlsRadio($name, $id, $value, $checked = false, $readOnly = false) {
    $check = controlsIsCheck($checked);
    $read = controlsIsReadOnly($readOnly);
    return "<input type=\"radio\" name=\"$name\" id=\"$id\" value=\"$value\" $read $check>";
}

/**
 * Auto generate one HTML single select
 * 
 * @return html select
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param array options (works with single arrays and assocs arrays)
 * @param mixed the selected option in array
 */
function controlsSelect($name, $id, $options, $selected) {
    $select = "<select name=\"$name\" id=\"$id\">";
    if(count($options) > 0) {
        while(list($key, $val) = each($options)) {
            
            if($key == $selected) {
                $select .= '<option value="'.$key.'" selected>'.$val.'</option>';
            }else{
                $select .= '<option value="'.$key.'">'.$val.'</option>';
            }

        }
    }
    $select .= "</select>";
    return $select;
}

function controlsDBSelect($name, $id, $resultQuery, $selected) {
    $options = dbConvertArray($resultQuery);
    $options = matrixNx2ToArray($options);
    $options[0] = "Selecione";
    //ksort($options);
    $select = controlsSelect($name, $id, $options, $selected);
    return $select;
}

/**
 * Auto generate one HTML multiple select
 * 
 * @return html select
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param array options (works with single arrays and assocs arrays)
 * @param array selected values (works with single arrays)
 */
function controlsSelectMultiple($name, $id, $rows, $options, $selecteds) {
    $select = "<select name=\"$name\" id=\"$id\" size=\"$rows\" multiple>";
    if(count($options) > 0 && count($selecteds)) {
        while(list($key, $val) = each($options)) {
            if(in_array($val, $selecteds)) {
                $select .= '<option value="'.$key.'" selected>'.$val.'</option>';
            }else{
                $select .= '<option value="'.$key.'">'.$val.'</option>';
            }
        }
    }
    $select .= "</select>";
    return $select;
}

function controlsDBSelectMultiple($name, $id, $rows, $resultQuery, $selecteds) {
    $options = dbConvertArray($resultQuery);
    $options = matrixNx2ToArray($options);
    //ksort($options);
    $select = controlsSelectMultiple($name, $id, $rows, $options, $selecteds);
    return $select;
}

/**
 * Auto generate one HTML text
 * 
 * @return html text
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the text value
 * @param the size of the control
 * @param the maxlenght string in the control
 * @param is it a password control?
 * @param is it a read only field?
 */
function controlsText($name, $id, $value, $size, $maxlength, $isPassword, $readOnly = false) {
    $type = $isPassword ? "password" : "text";
    $read = controlsIsReadOnly($readOnly);
    $text = "<input type=\"$type\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" $read>";
    return $text;
}

/**
 * Auto generate one HTML textarea (or memo)
 * 
 * @return html textarea
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the text value
 * @param the height of the control
 * @param the width of the control
 */
function controlsMemo($name, $id, $value, $cols, $rows, $readOnly = false) {
    $read = controlsIsReadOnly($readOnly);
    $memo = "<textarea name=\"$name\" id=\"$id\" cols=\"$cols\" rows=\"$rows\" $read>$value</textarea>";
    return $memo;
}

/**
 * Auto generate one HTML browse (input file)
 * 
 * @return html inputFile
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the control size
 */
function controlsBrowse($name, $id, $size) {
    $inputFile = "<input type=\"file\" name=\"$name\" id=\"$id\" size=\"$size\">";
    return $inputFile;
}

/**
 * Auto generate one HTML hidden field
 * 
 * @return html hidden
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the control value
 */
function controlsHidden($name, $id, $value) {
    $hidden = "<input type=\"hidden\" name=\"$name\" id=\"$id\" value=\"$value\">";
    return $hidden;
}

/**
 * Auto generate one HTML submit button for use with forms
 * 
 * @return html button
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the button caption
 */
function controlsSubmitButton($name, $id, $caption) {
    $button = "<input type=\"submit\" class=\"defbutton\" name=\"$name\" id=\"$id\" value=\"$caption\">";
    return $button;
}

function controlsResetButton($name, $id, $caption) {
    $button = "<input type=\"reset\" class=\"defbutton\" name=\"$name\" id=\"$id\" value=\"$caption\">";
    return $button;
}

/**
 * Auto generate one HTML/_javaScript back button for use with or without forms
 * 
 * @return html button
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the button caption
 */
function controlsBackButton($name, $id, $caption) {
    $button = "<input type=\"button\" class=\"defbutton\" name=\"$name\" id=\"$id\" value=\"$caption\" onClick=\"history.back()\">";
    return $button;
}

/**
 * Auto generate one HTML button for use with or without forms
 * 
 * @return html button
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the button caption
 * @param the url ended in .htm, .html, .php
 * @param the values to be setted in the GET parameters (works with single arrays and assocs arrays)
 */
function controlsActionButton($name, $id, $caption, $url, $urlValues) {
    $url = controlsUrl($url, $urlValues);
    $button = "
              <input type=\"button\" class=\"defbutton\" name=\"$name\" value=\"$caption\" id=\"$id\" 
              onClick=\"window.location='$url'\">
              ";
    return $button;
}

function controlsScriptButton($name, $id, $caption, $function) {
    $url = controlsUrl($url, $urlValues);
    $button = "
              <input type=\"button\" class=\"defbutton\" name=\"$name\" value=\"$caption\" id=\"$id\" 
              onClick=\"$function\">
              ";
    return $button;
}

/**
 * Auto generate one HTML button for use with or without forms
 * 
 * @return html button
 * @param the control name
 * @param the control id (for use with _javaScript)
 * @param the button caption
 * @param the url ended in .htm, .html, .php
 * @param the values to be setted in the GET parameters (works with single arrays and assocs arrays)
 * @param the windown width
 * @param the windown height
 */
 /*
function controlsPopUpButton($name, $id, $caption, $url, $urlValues, $width, $height) {
    $url = controlsUrl($url, $urlValues);
    $options = "toolbar=1,scrollbars=1,location=1,statusbar=1,menubar=1,resizable=1,width=$width,height=$height,left=625,top=200";
    $button = "
              <input type=\"button\" class=\"defbutton\" name=\"$name\" value=\"$caption\" id=\"$id\" 
              onClick=\"window.open('$url', this.target, '$options');return false;\" target=\"newWin\">
              ";
    return $button;
}
*/
function controlsPopUpButton($name, $id, $caption, $url, $urlValues, $width, $height) {
    $url = controlsUrl($url, $urlValues);
    $options = "toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=0,width=$width,height=$height,left=625,top=200";
    $button = "
              <input type=\"button\" class=\"defbutton\" name=\"$name\" value=\"$caption\" id=\"$id\" 
              onClick=\"window.open('$url', this.target, '$options');return false;\" target=\"newWin\">
              ";
    return $button;
}

/**
 * Generate one full url with get values with GET parameters
 * 
 * @return url
 * @param the url ended in .htm, .html, .php
 * @param the values to be setted in the GET parameters (works with single arrays and assocs arrays)
 */
function controlsUrl($url, $values) {
    $url = trim($url);
    if(count($values) > 0) {
        $url .= "?";
        while (list($key, $val) = each($values)) {
            $url .= "$key=$val&";
        }
        $url = substr($url, 0, strlen($url)-1);
    }
    return $url;
}

/**
 * Auto generate one HTML link
 * 
 * @return html link
 * @param the link caption
 * @param the url ended in .htm, .html, .php
 * @param the values to be setted in the GET parameters (works with single arrays and assocs arrays)
 */
function controlsActionLink($caption, $url, $urlValues) {
    $url = controlsUrl($url, $urlValues);
    $link = "<a href=\"$url\">$caption</a>";
    return $link;
}

/**
 * Auto generate one HTML pop up link 
 * 
 * @return html link
 * @param the link caption
 * @param the url ended in .htm, .html, .php
 * @param the values to be setted in the GET parameters (works with single arrays and assocs arrays)
 * @param the windown width
 * @param the windown height
 */
function controlsPopUpLink($caption, $url, $urlValues, $width, $height) {
    $url = controlsUrl($url, $urlValues);
    $options = "toolbar=1,scrollbars=1,location=1,statusbar=1,menubar=1,resizable=1,width=$width,height=$height,left=625,top=200";
    $link = "
            <a href=\"$url\" target=\"newWin\" 
            onClick=\"window.open(this.href, this.target, '$options');return false;\">$caption</a>
            ";
    return $link;
}

function controlsLongSearch($name, $form, $file, $value = null, $cod = null, $size = null, $width = null, $height = null) {
    $showName   = "show_".$name;
    $fkName     = "fk_".$name;

    if(is_int($size)) {
        $sizeParam = 'size="'.$size.'"';
    }
    
    if(!is_int($width)) {
        $width = 350;
    }

    if(!is_int($height)) {
        $height = 265;
    }
    
    $url = controlsUrl($file, array("show_name" => $showName, "fk_name" => $fkName, "name" => $name, "form" => $form));
    
    if($value == null || $cod == null) {
        $longSearch = '
                <input type="text" name="'.$showName.'" value="'.$value.'" '.$sizeParam.' disabled onFocus="javascript:this.blur()">
                <input type="hidden" name="'.$name.'" value="">
                <input type="button" value=" ? " onClick="javascript:window.open(\''.$url.'\' , \'Busca\', \'width='.$width.',height='.$height.',resizable=0\');">
                <input type="hidden" name="'.$fkName.'" value="">
                ';
    }else {
        $longSearch = '
                <input type="text" name="'.$showName.'" value="'.$value.'" '.$sizeParam.' disabled onFocus="javascript:this.blur()">
                <input type="hidden" name="'.$name.'" value="'.$value.'">
                <input type="button" value=" ? " onClick="javascript:window.open(\''.$url.'\' , \'Busca\', \'width=350,height=250,resizable=0\');">
                <input type="hidden" name="'.$fkName.'" value="'.$cod.'">
                ';
    }
    return $longSearch;
}

/**
 * Auto generate one HTML div to store data (use with ajax)
 * 
 * @return div
 * @param the control id (for use with _javaScript)
 * @param the CSS class
 * @param array of values
 */
/*
function controlsDiv($id, $class, $values) {
    if(count($values) > 0) {
        $div = '<div id="$id" class="$class"><ul id="nav">';
        foreach($var as $key) {
            $div .= "<li>$key</li>";
        }
        $div .= "</ul></div>";
    }
    return $div;
}
*/

function controlsSelectUf($name, $id, $selected){
    $$selected          = trim(strtoupper($selected));
    $options = array(
        "AC" => "Acre",
        "AL" => "Alagoas",
        "AP" => "Amapa",
        "AM" => "Amazonas",
        "BA" => "Bahia",
        "CE" => "Ceara",
        "DF" => "Distrito Federal",
        "GO" => "Goias",
        "ES" => "Espirito Santo",
        "MA" => "Maranhao",
        "MT" => "Mato Grosso",
        "MS" => "Mato Grosso do Sul",
        "MG" => "Minas Gerais",
        "PA" => "Para",
        "PB" => "Paraiba",
        "PR" => "Parana",
        "PE" => "Pernambuco",
        "PI" => "Piaui",
        "RJ" => "Rio de Janeiro",
        "RN" => "Rio Grande do Norte",
        "RS" => "Rio Grande do Sul",
        "RO" => "Rondonia",
        "RR" => "Roraima",
        "SP" => "Sao Paulo",
        "SC" => "Santa Catarina",
        "SE" => "Sergipe",
        "TO" => "Tocantins",
        "EX" => "Exterior"
    );
    return controlsSelect($name, $id, $options, $selected);
}

?>
