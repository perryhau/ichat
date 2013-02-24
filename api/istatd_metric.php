<?php

require_once('../config.php');
$pattern = $_REQUEST['pattern'];
echo  get_metric($pattern);

function get_metric($pattern)
{
    global $istatd;
    $json_data = file_get_contents($istatd['url']."/?q=$pattern*");
    $obj = json_decode($json_data,true);
    foreach($obj as $key)
    {
        foreach($key as $child)
        {
            $echo[] = $child['name'];
        }
    }
    return json_encode($echo);
}

?>
