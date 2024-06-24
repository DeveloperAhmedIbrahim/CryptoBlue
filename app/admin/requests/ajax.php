<?php
    define('CryptExchanger_INSTALLED',TRUE);
    ob_start();
    session_start();
    error_reporting(0);
    include("../../configs/bootstrap.php");
    include("../../includes/bootstrap.php");
    $type = $_POST["type"];
    if($type == "manage_wallets")
    {
        $action = $_POST["action"];
        $percentage = $_POST["amount"];
        $gateway_id = $_POST["gateway_id"];
        $users_wallets = $db->query("SELECT * FROM `ce_user_wallets` WHERE `gateway_id` = '$gateway_id'");
        while($row =  $users_wallets->fetch_assoc())
        {
            $wallet_amount =  $row["amount"];
            if($wallet_amount > 0)
            {
                $wallet_id =  $row["id"];
                $amount_in_percentage = number_format((($wallet_amount * $percentage) / 100),8,".","");
                if($action  == "increament")
                {
                    $new_wallet_amount =  number_format((($wallet_amount + $amount_in_percentage)),8,".","");
                }
                else if($action  == "decreament")
                {
                    $new_wallet_amount =  number_format((($wallet_amount - $amount_in_percentage)),8,".","");
                }
                $db->query("UPDATE `ce_user_wallets` SET  `amount` = '$new_wallet_amount' WHERE `id` = '$wallet_id' AND `gateway_id` = '$gateway_id'");
            }
        }
        $_SESSION["success"] = 'Balance in users wallet updated successfully.';

    }

?>