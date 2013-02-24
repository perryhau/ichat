<?php

require_once('../config.php');
require_once('../include/header.ini.php');
require_once('../include/chart_istatd_config.php');
require_once('../include/chart_func.php');

?>

<?php
if(!empty($_REQUEST['p'])) {
	$pattern = $_REQUEST['p'];
}

if(!empty($_REQUEST['img_type'])) {
	$img_type = $_REQUEST['img_type'];
}

if(!empty($_REQUEST['day'])) {
	$day = $_REQUEST['day'];
}

if(!empty($_REQUEST['ip'])) {
        $ip_popup = $_REQUEST['ip'];
}
echo '<br>';
echo '<br>';
$day_link = $_SERVER["SCRIPT_NAME"].'?ip='.$ip_popup.'&p='.$pattern.'&img_type='.$img_type.'&';
echo '
<div class="btn-group">
  <a class="btn" href="'.$day_link.'day=1">day</a>
  <a class="btn" href="'.$day_link.'day=7">week</a>
  <a class="btn" href="'.$day_link.'day=30">month</a>
  <a class="btn" href="'.$day_link.'day=90">3month</a>
  <a class="btn" href="'.$day_link.'day=365">year</a>
';
echo '<p class="pull-right">';
echo '<a class="btn btn-primary"  href="'.$_SERVER["SCRIPT_NAME"].'?p='.$pattern.'&img_type=small">small</a>';
echo '<a class="btn btn-primary"  href="'.$_SERVER["SCRIPT_NAME"].'?p='.$pattern.'&img_type=large">large</a>';
echo '</p></div>';
echo '</div>';

//table summary
$chart_list = para_metric($pattern, $day);
if(!empty($chart_list)) {
	foreach($chart_list as $chart_id => $chart_info) {
		if($chart_info['title']) {
			$iplist_arr = explode(',',$chart_info['iplist']);
			$node_count = count($iplist_arr);
		}
		if(!empty($chart_info['item'])) {
			foreach($chart_info['item'] as $_key => $item) {
                        
				if(isset($chart_info['type']) && ($chart_info['type'] == 'multi')) {
					echo '<div class="span3">';
					multi_line_chart($chart_id.'_'.$_key,$chart_info['uri'],$item['name'],$item['title'],$chart_info['img_size']);
					echo '</div>';

				} else {
					foreach($iplist_arr as $ip){
            					$query_str = "{$chart_info['uri']}$ip&type=";
						if($img_type == 'large') {
						if(!empty($ip_popup) && $ip_popup != $ip) {
								continue;
						}

						chart($chart_id.'_'.$_key.'_'.$ip,$query_str,$item['name'],$ip.'<br>'.$item['title'],'large',$day);
							echo "<br>";
						} else {
							echo '<div class="span35">';
							echo '<h4>'.$item['title'].'</h4>' ;
							chart($chart_id.'_'.$_key.'_'.$ip,$query_str,$item['name'],$ip.'<br>'.$item['title'],'small',$day);
							echo '</div>';
						}
	
					}
				}
			}
		}
	}
}

require('../include/footer.ini.php');
?>
