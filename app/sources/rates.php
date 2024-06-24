<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$tpl = new Template("app/templates/".$settings['default_template']."/rates.html",$lang);
$tpl->set("url",$settings['url']);
$tpl->set("name",$settings['name']);
$rates_list = '';
$GetGateways = $db->query("SELECT * FROM ce_gateways ORDER BY id");
if($GetGateways->num_rows>0) {
    while($gt = $GetGateways->fetch_assoc()) {
        $ttpl = new Template("app/templates/".$settings['default_template']."/rows/rates_table.html",$lang);
        $rates_rows = '';
        $GetRates = $db->query("SELECT * FROM ce_rates_live WHERE gateway_from='$gt[id]' ORDER BY id");
        if($GetRates->num_rows>0) {
            while($rate = $GetRates->fetch_assoc()) {
                $trtpl  = new Template("app/templates/".$settings['default_template']."/rows/rates_row.html",$lang);
                $trtpl->set("give_icon",gticon($gt['id']));
                $trtpl->set("give_name",$gt['name']);
                $trtpl->set("give_currency",$gt['currency']);
                $trtpl->set("give_rate",$rate['rate_from']);
                $trtpl->set("get_icon",gticon($rate['gateway_to']));
                $trtpl->set("get_name",gatewayinfo($rate['gateway_to'],"name"));
                $trtpl->set("get_currency",gatewayinfo($rate['gateway_to'],"currency"));
                $trtpl->set("get_reserve",gatewayinfo($rate['gateway_to'],"reserve"));
                $trtpl->set("get_rate",$rate['rate_to']);
                $gtname_send = str_ireplace(" ","-",$gt['name']);
                $gtname_send = $gtname_send.'_'.$gt['currency'];
                $gtname_receive = str_ireplace(" ","-",gatewayinfo($rate['gateway_to'],"name"));
                $gtname_receive = $gtname_receive.'_'.gatewayinfo($rate['gateway_to'],"currency");
                $redirect = $settings['url']."exchange/".$gt["id"]."_".$rate["gateway_to"]."/".$gtname_send."-to-".$gtname_receive;
                $trtpl->set("exchange_href",$redirect);
                $rates_rows .= $trtpl->output();
            }
        }
        $ttpl->set("rates_rows",$rates_rows);
        if($GetRates->num_rows>0) {
        $rates_list .= $ttpl->output();
        }
    }
}
$tpl->set("rates_list",$rates_list);
$UserMenu = '';
if(checkSession()) {
        $umtpl = new Template("app/templates/".$settings['default_template']."/rows/e_user_logged.html",$lang);
        $umtpl->set("url",$settings['url']);
        $UserMenu= $umtpl->output();
} else {
        $umtpl = new Template("app/templates/".$settings['default_template']."/rows/e_user_notlogged.html",$lang);
        $umtpl->set("url",$settings['url']);
        $UserMenu= $umtpl->output();
}
$tpl->set("UserMenu",$UserMenu);
echo $tpl->output();   
?>