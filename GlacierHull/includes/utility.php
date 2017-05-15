<?php


function output_to_console($s){
    echo '<script>';
    echo 'console.log("'.($s).'");';
    echo '</script>';
}


// if($DEBUG){
//     output_to_console("DEBUG TRUE");
// }

function output_to_page($s, $l=""){

    echo '<br>';
    echo '<hr>';
    if ($l != ""){
        echo '<strong>';
        echo("$l");
        echo '</strong>';
    }
    echo($s);
    echo '<hr>';
    echo '<br>';

}


function post_key_value_table(){

    echo "<h2>$_POST</h2>";
    echo "<table class=\"table table-bordered table-hover table-condensed kv-table\">";
    echo "<tr><th>Key</th><th>Value</th>";
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

}
?>