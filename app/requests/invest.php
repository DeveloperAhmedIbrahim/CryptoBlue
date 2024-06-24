<?php
header('Content-Type: application/json');
define('CryptExchanger_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
include(getLanguage($settings['url'],null,2));
$a = protect($_GET['a']);
$data = array();
if($a == "insurance") {
    $invest_id = protect($_GET['invest_id']);
    $CheckInvest = $db->query("SELECT * FROM ce_invest_active WHERE id='$invest_id' and uid='$_SESSION[ce_uid]'");
    if($CheckInvest->num_rows>0) {
        $inv = $CheckInvest->fetch_assoc();
        $data['status'] = 'success';
        $tpl = new Template("../templates/".$settings['default_template']."/modals/invest_insurance.html",$lang);
        $rt = $settings['invest_insurance_duration'] * $inv['amount'];
        $rt = $rt * $settings['invest_insurance_fee'];
        $rt = $rt / 100;
        $return =  $rt;
        $GetUserBalance = $db->query("SELECT * FROM ce_invest_balances WHERE uid='$_SESSION[ce_uid]' and currency='$inv[currency]'");
        $ubalance = $GetUserBalance->fetch_assoc();
        $tpl->set("invest_id",$inv['id']);
        $tpl->set("amount",$inv['amount']);
        $tpl->set("currency",$inv['currency']);
        $tpl->set("insurance_tax",$return);
        $tpl->set("duration",$settings['invest_insurance_duration']);
        $tpl->set("userbalance",$ubalance['amount']); 
        $tpl->set("insurance_fee",$settings['invest_insurance_fee']);
        $data['content'] = $tpl->output();
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'This investment does not exists.';
    }
} elseif($a == "insurance_process") {
    $invest_id = protect($_GET['invest_id']);
    $CheckInvest = $db->query("SELECT * FROM ce_invest_active WHERE id='$invest_id' and uid='$_SESSION[ce_uid]'");
    if($CheckInvest->num_rows>0) {
        $inv = $CheckInvest->fetch_assoc();
        $rt = $settings['invest_insurance_duration'] * $inv['amount'];
        $rt = $rt * $settings['invest_insurance_fee'];
        $rt = $rt / 100;
        $return =  $rt;
        $GetUserBalance = $db->query("SELECT * FROM ce_invest_balances WHERE uid='$_SESSION[ce_uid]' and currency='$inv[currency]'");
        $ubalance = $GetUserBalance->fetch_assoc();
        if($return > $ubalance['amount']) {
            $data['status'] = 'error';
            $data['msg'] = error($lang['error_66']);
        } else {
            $start = time();
            $expire = 84600 * $settings['invest_insurance_duration'];
            $expire = time() + $expire;
            $check_admin_earnings = $db->query("SELECT * FROM ce_invest_earnings WHERE currency='$inv[currency]'");
            if($check_admin_earnings->num_rows>0) {
                $update = $db->query("UPDATE ce_invest_earnings SET amount=amount+$return,updated='$start' WHERE currency='$inv[currency]'");
            } else {
                $insert = $db->query("INSERT ce_invest_earnings (amount,currency,created,updated,status) VALUES ('$return','$inv[currency]','$start','0','1')");
            }
            $update = $db->query("UPDATE ce_invest_balances SET amount=amount-$return WHERE id='$ubalance[id]'");
            $update = $db->query("UPDATE ce_invest_active SET have_insurance='1',insurance_start='$start',insurance_expire='$expire' WHERE id='$inv[id]'");
            $data['status'] = 'success';
            $tpl = new Template("../templates/".$settings['default_template']."/modals/invest_insurance_success.html",$lang);
            $tpl->set("invest_id",$inv['id']);
            $tpl->set("expire",date("d/m/Y H:i",$expire));
            $data['content'] = $tpl->output();
        }
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'This investment does not exists.';
    }
} elseif($a == "invest") {
    $package_id = protect($_GET['package_id']);
    $CheckPackage = $db->query("SELECT * FROM ce_invest_plans WHERE id='$package_id'");
    if($CheckPackage->num_rows>0) {
        $plan = $CheckPackage->fetch_assoc();
        $data['status'] = 'success';
        $tpl = new Template("../templates/".$settings['default_template']."/modals/invest.html",$lang);
        $tpl->set("name",$plan['name']);
        $tpl->set("currency",$plan['currency']);
        $tpl->set("investment_days",$plan['investment_days']);
        $tpl->set("daily_profit",$plan['daily_profit']);
        $tpl->set("min_amount",$plan['min_deposit_amount']);
        $investment_days = $plan['investment_days'];
        $min_amount = $plan['min_deposit_amount'];
        $daily_profit = $plan['daily_profit'];
        $rt = $investment_days * $min_amount;
        $rt = $rt * $daily_profit;
        $rt = $rt / 100;
        $return =  $rt;
        $treturn = $rt + $min_amount;
        $tpl->set("total_return",$treturn);
        $tpl->set("total_profit",$return);
        $tpl->set("package_id",$plan['id']);
        $data['content'] = $tpl->output();
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'This investment plan does not exists.';    
    }
} elseif($a == "invest_process") {
    $package_id = protect($_GET['package_id']);
    $CheckPackage = $db->query("SELECT * FROM ce_invest_plans WHERE id='$package_id'");
    if($CheckPackage->num_rows>0) {
        $plan = $CheckPackage->fetch_assoc();
        $amount = protect($_POST['amount']);
        $investment_days = $plan['investment_days'];
        $min_amount = $plan['min_deposit_amount'];
        $daily_profit = $plan['daily_profit'];
        $rt = $investment_days * $amount;
        $rt = $rt * $daily_profit;
        $rt = $rt / 100;
        $return =  $rt;
        $treturn = $rt + $amount;
        $GetUserBalance = $db->query("SELECT * FROM ce_invest_balances WHERE uid='$_SESSION[ce_uid]' and currency='$plan[currency]'");
        $ubalance = $GetUserBalance->fetch_assoc();
        if($amount < $plan['min_deposit_amount']) {
            $data['status'] = 'error';
            $data['msg'] = error("$lang[error_60] $plan[min_deposit_amount] $plan[currency].");
        } elseif($amount > $ubalance['amount']) {
            $data['status'] = 'error';
            $data['msg'] = error($lang['error_61']);
        } else {
            $time = time();
            $update = $db->query("UPDATE ce_invest_balances SET amount=amount-$amount WHERE id='$ubalance[id]'");
            $insert = $db->query("INSERT ce_invest_active (uid,package_id,amount,currency,daily_profit,total_profit,total_return,total_return_with_profit,investment_days,confirmations,days_left,created,updated,expired,status) VALUES ('$_SESSION[ce_uid]','$plan[id]','$amount','$plan[currency]','$daily_profit','0','$return','$treturn','$investment_days','0','$investment_days','$time','$time','0','1')");
            $data['status'] = 'success';
            $tpl = new Template("../templates/".$settings['default_template']."/modals/invest_success.html",$lang);
            $tpl->set("amount",$amount);
            $tpl->set("currency",$plan['currency']);
            $tpl->set("name",$plan['name']);
            $tpl->set("investment_days",$investment_days);
            $tpl->set("daily_profit",$daily_profit);
            $tpl->set("total_return",$return);
            $tpl->set("total_return_with_profit",$treturn);
            $data['content'] = $tpl->output();
        }
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'This investment plan does not exists.';    
    }
} elseif($a == "deposit") {
    $package_id = protect($_GET['package_id']);
    $CheckPackage = $db->query("SELECT * FROM ce_invest_plans WHERE id='$package_id'");
    if($CheckPackage->num_rows>0) {
        $plan = $CheckPackage->fetch_assoc();
        require_once("../includes/payment_src/coinpayments.inc.php");
        $cps = new CoinPaymentsAPI();
        $cps->Setup($plan['cp_private_key'],$plan['cp_public_key']);
        $time = time();
        $insert_deposit = $db->query("INSERT ce_invest_deposits (uid,package_id,amount,currency,tx_id,cp_txid,qrcode,confirms_need,pay_address,paid,confirmations,created,status) VALUES ('$_SESSION[ce_uid]','$package_id','0','$plan[currency]','','','','','','0','0','$time','1')");
        $GetDeposit = $db->query("SELECT * FROM ce_invest_deposits WHERE uid='$_SESSION[ce_uid]' and currency='$plan[currency]' ORDER BY id DESC LIMIT 1");
        $de = $GetDeposit->fetch_assoc();
        $deposit_id = $de['id'];
        $item_name = 'Deposit: '.$deposit_id;
        $callback_url = $settings['url']."callbacks/Invest_IPN.php?deposit_id=".$deposit_id;
        $req = array(
            'amount' => $plan['min_deposit_amount'],
            'currency1' => $plan['currency'],
            'currency2' => $plan['currency'],
            'buyer_email' => $settings['supportemail'],
            'item_name' => $item_name,
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'ipn_url' => $callback_url,
        );
        // See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
                $error_msg = '';
        $result = $cps->CreateTransaction($req);
        if ($result['error'] == 'ok') {
            $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
            //print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
            //print 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
            //print 'Status URL: '.$result['result']['status_url'].$le;
            $cp_txid = $result['result']['txn_id'];
            $qrcode = $result['result']['qrcode_url'];
            $address = $result['result']['address'];
            $confirms_need = $result['result']['confirms_needed'];
            $update = $db->query("UPDATE ce_invest_deposits SET qrcode='$qrcode',pay_address='$address',confirms_need='$confirms_need',cp_txid='$cp_txid' WHERE id='$de[id]'");
        } else {
            $error_msg = 'Error: '.$result['error']."\n";
        }
        $data['status'] = 'success';
        $tpl = new Template("../templates/".$settings['default_template']."/modals/invest_deposit.html",$lang);
        $tpl->set("qrcode",$qrcode);
        $tpl->set("address",$address);
        $tpl->set("confirms_need",$confirms_need);
        $tpl->set("currency",$plan['currency']);
        $tpl->set("min_amount",$plan['min_deposit_amount']);
        $tpl->set("name",$plan['name']);
        $tpl->set("error_msg",$error_msg);
        $data['content'] = $tpl->output();
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'This investment plan does not exists.';
    }
} elseif($a == "withdrawal") {
    $package_id = protect($_GET['package_id']);
    $CheckPackage = $db->query("SELECT * FROM ce_invest_plans WHERE id='$package_id'");
    if($CheckPackage->num_rows>0) {
        $plan = $CheckPackage->fetch_assoc();
        $GetUserBalance = $db->query("SELECT * FROM ce_invest_balances WHERE uid='$_SESSION[ce_uid]' and currency='$plan[currency]'");
        $ubalance = $GetUserBalance->fetch_assoc();
        $available_balance = $ubalance['amount'];
        if(empty($available_balance)) { $available_balance = 0; }
        $data['status'] = 'success';
        $tpl = new Template("../templates/".$settings['default_template']."/modals/invest_withdrawal.html",$lang);
        $tpl->set("min_withdrawal_amount",$plan['min_withdrawal_amount']);
        $tpl->set("ubalance",$available_balance);
        $tpl->set("name",$plan['name']);
        $tpl->set("currency",$plan['currency']);     
        $tpl->set("package_id",$plan['id']); 
        $data['content'] = $tpl->output();
    } else {
        $data['status'] = 'error';
        $data['msg'] = 'This investment plan does not exists.';
    }  
} elseif($a == "withdrawal_process") {
    $package_id = protect($_GET['package_id']);
    $CheckPackage = $db->query("SELECT * FROM ce_invest_plans WHERE id='$package_id'");
    if($CheckPackage->num_rows>0) {
        $plan = $CheckPackage->fetch_assoc();
        $GetUserBalance = $db->query("SELECT * FROM ce_invest_balances WHERE uid='$_SESSION[ce_uid]' and currency='$plan[currency]'");
        $ubalance = $GetUserBalance->fetch_assoc();
        $amount = protect($_POST['amount']);
        $address = protect($_POST['address']);
        if(empty($amount)) {
            $data['status'] = 'error';
            $data['msg'] = error($lang['error_62']);
        } elseif(!is_numeric($amount)) {
            $data['status'] = 'error';
            $data['msg'] = error($lang['error_63']);
        } elseif($plan['min_withdrawal_amount']>$amount) {
            $data['status'] = 'error';
            $data['msg'] = error("$lang[error_64] $plan[min_withdrawal_amount] $plan[currency].");
        } elseif($amount>$ubalance['amount']) {
            $data['status'] = 'error';
            $data['msg'] = error($lang['error_61']);
        } elseif(empty($address)) {
            $data['status'] = 'error';
            $lang_error_65 = str_ireplace("%name",$plan['name'],$lang['error_65']);
            $data['msg'] = error($lang_error_65);
        } else {
            $time = time();
            $withdrawal_id = strtoupper(randomHash(20));
            $update = $db->query("UPDATE ce_invest_balances SET amount=amount-$amount,updated='$time' WHERE uid='$_SESSION[ce_uid]' and currency='$plan[currency]'");
            $insert = $db->query("INSERT ce_invest_withdrawals (uid,withdrawal_id,earnings_id,deposit_id,gateway_id,amount,currency,tx_id,wallet,created,updated,status) VALUES ('$_SESSION[ce_uid]','$withdrawal_id','','','','$amount','$plan[currency]','','$address','$time','','1')");
            $data['status'] = 'success';
            $tpl = new Template("../templates/".$settings['default_template']."/modals/invest_withdrawal_success.html",$lang);
            $tpl->set("amount",$amount);
            $tpl->set("currency",$plan['currency']);
            $tpl->set("address",$address);
            $tpl->set("name",$plan['name']);
            $data['content'] = $tpl->output();
        }
    } else {
        $data['status'] = 'error';
        $data['msg'] = error("Error processing this request. Please try again later.");
    } 
} else {
    $data['status'] = 'error';
    $data['msg'] = 'Unknown request.';
}
echo json_encode($data);
?>