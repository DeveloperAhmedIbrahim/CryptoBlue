<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$tpl = new Template("app/templates/".$settings['default_template']."/homepage.html",$lang);
$tpl->set("url",$settings['url']);
$tpl->set("name",$settings['name']);
$send_list = '';
$receive_list = '';
$reserve_list = '';
$fid = '';
$sid = '';
$i = 1;
$r = 1;
$partners_list = '';
$QueryGateways = $db->query("SELECT * FROM ce_gateways WHERE allow_send='1' ORDER BY id");
if($QueryGateways->num_rows>0) {
    while($gt = $QueryGateways->fetch_assoc()) {
        if($gt['merchant_source'] == "stripe" or $gt['merchant_source'] == "2checkout") {
            $send_list .= '<option value="'.$gt["id"].'">VISA/MasterCard '.$gt["currency"].'</option>';
        } else {
        $send_list .= '<option value="'.$gt["id"].'">'.$gt["name"].' '.$gt["currency"].'</option>';
        $partners_list .= '<a href="" data-toggle="tooltip" title="'.$gt["name"].'"><img src="'.gticon($gt["id"]).'" width="48px" height="48px" style="margin-bottom:5px;"></a>&nbsp;&nbsp;&nbsp;';
        }
        if($i == 1) {
            $fid = $gt['id'];
        }
        $i++;
    }
} 
$tpl->set("partners_list",$partners_list);
$QueryDirections = $db->query("SELECT * FROM ce_gateways_directions WHERE gateway_id='$fid'");
if($QueryDirections->num_rows>0) {
    $gd = $QueryDirections->fetch_assoc();
    $directions = explode(",",$gd['directions']);
    foreach($directions as $k=>$v) {
        if(gatewayinfo($v,"merchant_source") == "stripe" or gatewayinfo($v,"merchant_source") == "2checkout") { 
            $receive_list .= '<option value="'.$v.'">VISA/MasterCard '.gatewayinfo($v,"currency").'</option>';
        } else { 
        $receive_list .= '<option value="'.$v.'">'.gatewayinfo($v,"name").' '.gatewayinfo($v,"currency").'</option>';
        }
        if($r == 1) {
            $sid = $v;
        }
        $r++;
    }
}
$GetRates = $db->query("SELECT * FROM ce_rates_live WHERE gateway_from='$fid' and gateway_to='$sid'");
$rate = $GetRates->fetch_assoc();
$rate_from = $rate['rate_from'];
$rate_to = $rate['rate_to'];
//discount system
if(checkSession()) {
    $udlevel = idinfo($_SESSION['ce_uid'],"discount_level");
    $CheckDiscountQuery = $db->query("SELECT * FROM ce_discount_system WHERE discount_level='$udlevel'");
    if($CheckDiscountQuery->num_rows>0) {
        $d = $CheckDiscountQuery->fetch_assoc();
        $dfee = $d['discount_percentage'];
        $calculate = ($rate_to * $dfee) / 100;
        $rate_to = $rate_to + $calculate;
    }
}
$tpl->set("am_send",$rate_from);
$tpl->set("am_receive",$rate_to);
$tpl->set("rate_from",$rate_from);
$tpl->set("rate_to",$rate_to);
$tpl->set("currency_from",gatewayinfo($fid,"currency"));
$tpl->set("currency_to",gatewayinfo($sid,"currency"));
$tpl->set("reserve",gatewayinfo($sid,"reserve"));
$tpl->set("send_icon",gticon($fid));
$tpl->set("receive_icon",gticon($sid));
$tpl->set("sic1",gatewayinfo($fid,"is_crypto"));
$tpl->set("sic2",gatewayinfo($sid,"is_crypto"));
$tpl->set("send_list",$send_list);
$tpl->set("receive_list",$receive_list);
$ReservesQuery = $db->query("SELECT * FROM ce_gateways ORDER BY id");
if($ReservesQuery->num_rows>0){
    $r=1;
    while($reserve = $ReservesQuery->fetch_assoc()) {
        $rtpl = new Template("app/templates/".$settings['default_template']."/rows/reserve.html",$lang);
        $rtpl->set("gateway_icon",gticon($reserve['id']));
        if($reserve['merchant_source'] == "stripe" or $reserve['merchant_source'] == "2checkout") { 
            $rtpl->set("gateway_name","VISA/MasterCard");     
        } else {
            $rtpl->set("gateway_name",$reserve['name']);
        }
        $rtpl->set("gateway_reserve",$reserve['reserve']);
        $rtpl->set("gateway_currency",$reserve['currency']); 
        if($r>6) { 
            $rtpl->set("hidden","reserve-hidden");
        } else {
            $rtpl->set("hidden","");
        }
        $reserve_list .= $rtpl->output();
        $r++;
    }
}
$tpl->set("reserve_list",$reserve_list);
$latest_news = '';
$NewsQuery = $db->query("SELECT * FROM ce_news ORDER BY id DESC LIMIT 0");
if($NewsQuery->num_rows>0) {
    while($news = $NewsQuery->fetch_assoc()) {
        $newtpl = new Template("app/templates/".$settings['default_template']."/rows/home_latest_news_row.html",$lang);
        $newtpl->set("url",$settings['url']);
        $newtpl->set("id",$news['id']);
        $newtpl->set("title",$news['title']);
        $newscontent = strip_tags($news['content']);
        $newscontent = croptext2($newscontent,150);
        $newtpl->set("content",$newscontent);
        $newtpl->set("date",date("d F Y",$news['created']));
        $latest_news .= $newtpl->output();
    }
}
$tpl->set("latest_news",$latest_news);
$reviews = '';
$reviews_icons = '';
$ReviewsQuery = $db->query("SELECT * FROM ce_users_reviews WHERE status='1' ORDER BY id DESC LIMIT 10");
if($ReviewsQuery->num_rows>0) {
    while($review = $ReviewsQuery->fetch_assoc()) {
        $retpl = new Template("app/templates/".$settings['default_template']."/rows/home_review_row.html",$lang);
        if($review['type'] == "1") {
            $review_class = 'text text-success';
            $review_icon = 'fa fa-smile';
        } elseif($review['type'] == "2") {
            $review_class = 'text text-danger';
            $review_icon = 'fa fa-frown-o';
        } elseif($review['type'] == "3") {
            $review_class = 'text text-warning';
            $review_icon = 'fa fa-meh-o';
        } else { }
        $retpl->set("url",$settings['url']);
        $retpl->set("review_class",$review_class);
        $retpl->set("review_icon",$review_icon);
        $retpl->set("display_name",$review['display_name']);
        $retpl->set("comment",$review['comment']);
        $retpl->set("date",date("d F Y",$review['posted']));
        $reviews .= $retpl->output();
        $reitpl = new Template("app/templates/".$settings['default_template']."/rows/home_review_row_icon.html",$lang);
        $reitpl->set("display_name",$review['display_name']);
        $reitpl->set("url",$settings['url']);
        $reviews_icons .= $reitpl->output();
    }
}
$tpl->set("reviews",$reviews);
$tpl->set("reviews_icons",$reviews_icons);
$latest_exchanges = '';
$ExchangesQuery = $db->query("SELECT * FROM ce_orders WHERE status='4' ORDER BY id DESC LIMIT 10");
if($ExchangesQuery->num_rows>0) {
    while($ex = $ExchangesQuery->fetch_assoc()) {
        $extpl = new Template("app/templates/".$settings['default_template']."/rows/home_latest_exchange_row.html",$lang);
        $extpl->set("gateway_send_icon",gticon($ex['gateway_send']));
        $extpl->set("gateway_receive_icon",gticon($ex['gateway_receive']));
        $extpl->set("gateway_send",gatewayinfo($ex['gateway_send'],"name"));
        $extpl->set("gateway_receive",gatewayinfo($ex['gateway_receive'],"name"));
        $extpl->set("amount_send",$ex['amount_send']);
        $extpl->set("amount_send_currency",gatewayinfo($ex['gateway_send'],"currency"));
        $extpl->set("amount_receive",$ex['amount_receive']);
        $extpl->set("amount_receive_currency",gatewayinfo($ex['gateway_receive'],"currency"));
        $extpl->set("date",date("d/m/Y H:i",$ex['created']));
        $latest_exchanges .= $extpl->output();
    }
}
$tpl->set("latest_exchanges",$latest_exchanges);
$homepage_wops = '';
if($settings['show_operator_status'] == "1" && $settings['show_worktime'] == "1") {
    $hwops = new Template("app/templates/".$settings['default_template']."/rows/homepage_wops.html",$lang);
    $worktpl = new Template("app/templates/".$settings['default_template']."/rows/worktime.html",$lang);
    $worktpl->set("worktime_start",$settings['worktime_start']);
    $worktpl->set("worktime_end",$settings['worktime_end']);
    $worktpl->set("worktime_gmt",$settings['worktime_gmt']);
    $hwops->set("worktime",$worktpl->output());   
    if($settings['operator_status'] == "1") {
        $wops = new Template("app/templates/".$settings['default_template']."/rows/operator_online.html",$lang);
    } else {
        $wops = new Template("app/templates/".$settings['default_template']."/rows/operator_offline.html",$lang);
    }
    $hwops->set("operator_status",$wops->output());
    $homepage_wops = $hwops->output();
} elseif($settings['show_operator_status'] == "1" && $settings['show_worktime'] == "0") {
    $hwops = new Template("app/templates/".$settings['default_template']."/rows/homepage_wops.html",$lang);
    $hwops->set("worktime","");   
    if($settings['operator_status'] == "1") {
        $wops = new Template("app/templates/".$settings['default_template']."/rows/operator_online.html",$lang);
    } else {
        $wops = new Template("app/templates/".$settings['default_template']."/rows/operator_offline.html",$lang);
    }
    $hwops->set("operator_status",$wops->output());
    $homepage_wops = $hwops->output();
} elseif($settings['show_operator_status'] == "0" && $settings['show_worktime'] == "1") {
    $hwops = new Template("app/templates/".$settings['default_template']."/rows/homepage_wops.html",$lang);
    $worktpl = new Template("app/templates/".$settings['default_template']."/rows/worktime.html",$lang);
    $worktpl->set("worktime_start",$settings['worktime_start']);
    $worktpl->set("worktime_end",$settings['worktime_end']);
    $worktpl->set("worktime_gmt",$settings['worktime_gmt']);
    $hwops->set("worktime",$worktpl->output());  
    $hwops->set("operator_status","");
    $homepage_wops = $hwops->output();
} else { }
$tpl->set("homepage_wops",$homepage_wops);
$tpl->set("worktime_start",$settings['worktime_start']);
$tpl->set("worktime_end",$settings['worktime_end']);
$tpl->set("worktime_gmt",$settings['worktime_gmt']);
echo $tpl->output();
?>