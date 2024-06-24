<?php
header('Content-Type: application/json');
define('CryptExchanger_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
include(getLanguage($settings['url'],null,2));
$data = array();
$a = protect($_GET['a']);
if($a == "receive_list") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_gateways_directions WHERE gateway_id='$id'");
    $receive_list = '';
    if($query->num_rows>0) {
        $row = $query->fetch_assoc();
        $directions = explode(",",$row['directions']);
        foreach($directions as $k=>$v) {
            $receive_list .= '<option value="'.$v.'">'.gatewayinfo($v,"name").' '.gatewayinfo($v,"currency").'</option>';
        }
        $data['status'] = 'success';
        $data['content'] = $receive_list;
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'Error loading gateway directions.';
    }
} elseif($a == "rate") {
    $from = protect($_GET['from']);
    $to = protect($_GET['to']);
    $GetRates = $db->query("SELECT * FROM ce_rates_live WHERE gateway_from='$from' and gateway_to='$to'");
    if($GetRates->num_rows>0) {  
        $rate = $GetRates->fetch_assoc();
        $data['status'] = 'success';
        $data['rate_from'] = $rate['rate_from'];
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
        $data['rate_to'] = $rate_to;
        $data['currency_from'] = gatewayinfo($from,"currency");
        $data['currency_to'] = gatewayinfo($to,"currency");
        $data['reserve'] = gatewayinfo($to,"reserve");
        $data['sic1'] = gatewayinfo($from,"is_crypto");
        $data['sic2'] = gatewayinfo($to,"is_crypto");
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'Error loading exchange rate.';
    }
} elseif($a == "img") {
    $id = protect($_GET['id']);
    $icon = gticon($id); 
    if($icon) {
        $data['status'] = 'success';
        $data['content'] = $icon;
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'Error loading gateway icon';
    }
} elseif($a == "wallet_balance") {
    $wallet_id = $_POST["wallet_id"];
    $balance_query = $db->query("SELECT `amount` FROM `ce_user_wallets` WHERE `id` = '$wallet_id'");
    if($balance_query->num_rows > 0)
    {
        $data["balance"] = $balance_query->fetch_assoc()["amount"];
    }
    else
    {
        $data["balance"] = 0;
    }
} elseif($a == "search_user_by_wallet") {
    $wallet_id = $_POST["wallet_id"];
    $user = $db->query("SELECT `id`,`email` FROM `ce_users` WHERE `wallet_id` = '$wallet_id'");
    $wallets_html = "<option value='0' selected disabled>Select wallet</option>";
    if($user->num_rows > 0)
    {
        $user = $user->fetch_assoc();
        $id = $user["id"];
        $email = $user["email"];
        if($_SESSION["ce_uid"] != $id)
        {
            $data["code"] = 1;
            $data["message"] = $email;
        }
        else
        {
            $data["code"] = 0;
            $data["message"] = "You cannot transfer balance to youself.";    
        }    
    }
    else
    {
        $data["code"] = 0;
        $data["message"] = "User not found with this Wallet ID. Please enter valid Wallet ID.";
    }
} elseif($a == "wallet_currency_convertor"){
    $wallets_data =  json_decode($_POST["wallets_data"]);
    $to_currency = $_POST["currency"];
    $new_wallets_data = array();
    if($to_currency == "Default")
    {
        $new_wallets_data = $wallets_data;
    }
    else
    {
        for($i = 0; $i < count($wallets_data); $i++)
        {
            $from_currency = $wallets_data[$i]->currency;
            $amount = $wallets_data[$i]->amount;
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,"https://api.coinconvert.net/convert/$from_currency/$to_currency?amount=$amount");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data);
            $data = json_decode(json_encode($data), true);
            if($data["status"] == "success")
            {
                $new_wallets_data[$i]["currency"] = $from_currency;
                $new_wallets_data[$i]["amount"] = number_format(($data[$to_currency]),4,".","");
            }
            else
            {
                if($data["message"] == "Bad request.")
                {
                    $new_wallets_data[$i]["currency"] = $from_currency;
                    $new_wallets_data[$i]["amount"] = number_format(0,4,".","");                    
                }
                else
                {
                    $new_wallets_data[$i]["currency"] = $from_currency;
                    $new_wallets_data[$i]["amount"] = "N/A";    
                }
            }
        }
    }
    $data = $new_wallets_data;
} else {
    $data['status'] = 'error';
    $data['msg'] = 'Error getting information';
}
echo json_encode($data);
?>