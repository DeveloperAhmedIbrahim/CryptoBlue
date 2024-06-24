<?php
header('Content-Type: application/json');
define('CryptExchanger_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
include(getLanguage($settings['url'],null,2));

$query = $db->query("SELECT * FROM ce_rates ORDER BY id");
if($query->num_rows>0) {
    while($row = $query->fetch_assoc()) {
        $from = $row['gateway_from'];
        $to = $row['gateway_to'];
        $rate = get_rates($from,$to);
        $rate_from = $rate['rate_from'];
        $rate_to = $rate['rate_to'];
        $time = time();
        $check = $db->query("SELECT * FROM ce_rates_live WHERE gateway_from='$from' and gateway_to='$to'");
        if($check->num_rows>0) {
            $r = $check->fetch_assoc();
            $update = $db->query("UPDATE ce_rates_live SET rate_from='$rate_from',rate_to='$rate_to',updated='$time' WHERE id='$r[id]'");
        } else {
            $insert = $db->query("INSERT ce_rates_live (gateway_from,gateway_to,rate_from,rate_to,updated) VALUES ('$from','$to','$rate_from','$rate_to','$time')");
        }
    }
}
?>