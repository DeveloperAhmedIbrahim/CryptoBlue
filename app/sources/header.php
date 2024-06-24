<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$tpl = new Template("app/templates/".$settings['default_template']."/header.html",$lang);
$a = protect($_GET['a']);
if(isset($a) && !empty($a)) { $a = protect($_GET['a']); } else { $a = null; }  
$b = protect($_GET['b']);
if(isset($b) && !empty($b)) { $b = protect($_GET['b']); } else { $b = null; }  
$c = protect($_GET['c']);
if(isset($c) && !empty($c)) { $c = protect($_GET['c']); } else { $c = null; }  
$from = protect($_GET['from']);
if(isset($from) && !empty($from)) { $from = protect($_GET['from']); } else { $from = null; }  
$to = protect($_GET['to']);
if(isset($to) && !empty($to)) { $to = protect($_GET['to']); } else { $to = null; }  
$id = protect($_GET['id']);
if(isset($id) && !empty($id)) { $id = protect($_GET['id']); } else { $id = null; }  
$prefix = protect($_GET['prefix']);
if(isset($prefix) && !empty($prefix)) { $prefix = protect($_GET['prefix']); } else { $prefix = null; }  
$tpl->set("title",decodeTitle($a,$b,$c,$from,$to,$id,$prefix));
$tpl->set("description",$settings['description']);
$tpl->set("keywords",$settings['keywords']);
$tpl->set("url",$settings['url']);
$tpl->set("name",$settings['name']);
if(checkSession()) {
    $umtpl = new Template("app/templates/".$settings['default_template']."/rows/user_logged.html",$lang);
    $umtpl->set("url",$settings['url']);
    $umtpl->set("name",$settings['name']);
    $unames = idinfo($_SESSION['ce_uid'],"first_name").' '.idinfo($_SESSION['ce_uid'],"last_name");
    $umtpl->set("unames",$unames);
    $UserMenu = $umtpl->output();
} else {
    $umtpl = new Template("app/templates/".$settings['default_template']."/rows/user_notlogged.html",$lang);
    $umtpl->set("url",$settings['url']);
    $umtpl->set("name",$settings['name']);
    $UserMenu = $umtpl->output();
}
$tpl->set("UserMenu",$UserMenu);

if(checkSession()) {
    $umtpl = new Template("app/templates/".$settings['default_template']."/rows/user2_logged.html",$lang);
    $umtpl->set("url",$settings['url']);
    $umtpl->set("name",$settings['name']);
    $unames = idinfo($_SESSION['ce_uid'],"first_name").' '.idinfo($_SESSION['ce_uid'],"last_name");
    $umtpl->set("unames",$unames);
    $UserMenu2 = $umtpl->output();
} else {
    $umtpl = new Template("app/templates/".$settings['default_template']."/rows/user2_notlogged.html",$lang);
    $umtpl->set("url",$settings['url']);
    $umtpl->set("name",$settings['name']);
    $UserMenu2 = $umtpl->output();
}
$tpl->set("UserMenu2",$UserMenu2);
$languages_list = getLanguage($settings['url'],null,1); 
$lang_code = strtolower($lang['lang_code']);
$tpl->set("languages_list",$languages_list);
$tpl->set("lang_code",$lang_code);
$tpl->set("lang",$_COOKIE['lang']);
echo $tpl->output();
?>