<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$tpl = new Template("app/templates/".$settings['default_template']."/footer.html",$lang);
$tpl->set("url",$settings['url']);
$tpl->set("name",$settings['name']);

if(checkSession()) {
    $umtpl = new Template("app/templates/".$settings['default_template']."/rows/user3_logged.html",$lang);
    $umtpl->set("url",$settings['url']);
    $umtpl->set("name",$settings['name']);
    $unames = idinfo($_SESSION['ce_uid'],"first_name").' '.idinfo($_SESSION['ce_uid'],"last_name");
    $umtpl->set("unames",$unames);
    $UserMenu2 = $umtpl->output();
} else {
    $umtpl = new Template("app/templates/".$settings['default_template']."/rows/user3_notlogged.html",$lang);
    $umtpl->set("url",$settings['url']);
    $umtpl->set("name",$settings['name']);
    $UserMenu2 = $umtpl->output();
}
$tpl->set("UserMenu",$UserMenu2);
echo $tpl->output();
?>