<?php

function para_metric($pattern, $day){

    $url = $_SERVER ['HTTP_HOST'].'/';
    $metric_list = "http://".$url."api/istatd_metric.php?pattern=$pattern";
    $json_data = file_get_contents("$metric_list");
    $obj = json_decode($json_data,true);
    foreach($obj as $metric)
    {
        $chart_list[$metric] = array(
                "iplist" => "$metric",
                "title" => "$metric",
                "uri"   => "http://".$url."/api/display_istatd.php?day=$day&iplist=",
                "img_size" => "large",
                "item" => array(
                    array("name" => "$metric","title" => "$metric"),
                    ),
                );
    }
    return $chart_list;
}

?>

