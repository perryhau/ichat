<?php

require_once('../config.php');
$counter = $_REQUEST['iplist'];

$day = $_REQUEST['day'];
echo get_counter($counter, $day);

function get_counter($counter, $day)
{
    global $istatd;
 
    empty($day) ? $day = 7 : $day;
    $start = time() - ($day * 86400);
    $end = time();
    $json_data = file_get_contents($istatd['url']."/$counter?start=$start&end=$end");
    $obj = json_decode($json_data,true);
    foreach($obj as $key)
    {
        foreach($key as $child)
        {
            $echo[] = array(intval($child['time'].'000'), intval($child['data']['avg']));
        }
    }
    return json_encode($echo);
}

?>
