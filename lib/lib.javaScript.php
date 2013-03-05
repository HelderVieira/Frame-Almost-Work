<?php

function jsTinyMCE($style, $path) {
    switch($style) {
        case "word":
            $mode           = "textareas";
            $theme          = "advanced";            
            $ext            = '
                plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen",
                theme_advanced_buttons1_add_before : "save,newdocument,separator",
                theme_advanced_buttons1_add : "fontselect,fontsizeselect",
                theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
                theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
                theme_advanced_buttons3_add_before : "tablecontrols,separator",
                theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                content_css : "example_word.css",
                    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
                    plugi2n_insertdate_timeFormat : "%H:%M:%S",
                external_link_list_url : "example_link_list.js",
                external_image_list_url : "example_image_list.js",
                flash_external_list_url : "example_flash_list.js",
                file_browser_callback : "fileBrowserCallBack",
                paste_use_dialog : false,
                theme_advanced_resizing : true,
                theme_advanced_resize_horizontal : false,
                theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
                paste_auto_cleanup_on_paste : true,
                paste_convert_headers_to_strong : false,
                paste_strip_class_attributes : "all",
                paste_remove_spans : false,
                paste_remove_styles : false		            
            ';
            $jsFunctions    = '
                function fileBrowserCallBack(field_name, url, type, win) {
                    // This is where you insert your custom filebrowser logic
                    alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

                    // Insert new URL, this would normaly be done in a popup
                    win.document.forms[0].elements[field_name].value = "someurl.htm";
                }
            ';
            
            break;
        case "full":
            $mode           = "textareas";
            $theme          = "advanced";
            $ext            = '
                plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
                theme_advanced_buttons1_add_before : "save,newdocument,separator",
                theme_advanced_buttons1_add : "fontselect,fontsizeselect",
                theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
                theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
                theme_advanced_buttons3_add_before : "tablecontrols,separator",
                theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_path_location : "bottom",
                content_css : "example_full.css",
                    plugin_insertdate_dateFormat : "%Y-%m-%d",
                    plugin_insertdate_timeFormat : "%H:%M:%S",
                extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
                external_link_list_url : "example_link_list.js",
                external_image_list_url : "example_image_list.js",
                flash_external_list_url : "example_flash_list.js",
                file_browser_callback : "fileBrowserCallBack",
                theme_advanced_resize_horizontal : false,
                theme_advanced_resizing : true
		        ';
            $jsFunctions    = '
                function fileBrowserCallBack(field_name, url, type, win) {
                    // This is where you insert your custom filebrowser logic
                    alert("Example of filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

                    // Insert new URL, this would normaly be done in a popup
                    win.document.forms[0].elements[field_name].value = "someurl.htm";
                }
            ';		        
            break;
        case "simple":
            $mode           = "textareas";
            $theme          = "simple";
            break;
        /*
        case "advanced":
            $mode           = "advanced";
            $theme          = "exact";
            break;
        */
        default:
            //Use simple mode!!!
            $mode           = "textareas";
            $theme          = "simple";        
            break;
    }

    $js = '
        <!-- tinyMCE -->
        <script language="javascript" type="text/javascript" src="'.$path.'"></script>
        <script language="javascript" type="text/javascript">
        tinyMCE.init({
            mode : "'.$mode.'",
            theme : "'.$theme.'"
            '.$ext.'
        });
        
        '.$jsFunctions.'
        
        </script>
        <!-- /tinyMCE -->
    ';
    return $js;
}

?>