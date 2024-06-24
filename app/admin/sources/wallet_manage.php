<?php
    if(!defined('CryptExchanger_INSTALLED')){
        header("HTTP/1.0 404 Not Found");
        exit;
    }    
    
    $preview = '';
    $dashboard_url =  $settings['url'] . 'app/admin';
    $wallet_transfer_url =  $settings['url'] . 'app/admin?a=wallet&b=wallet_gateways';    
    if(isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] != "")
    {
        $id = $_GET['id'];
        $transfer_request = $db->query("SELECT * FROM `ce_wallet_transfer` WHERE `id` = '$id'"); 

        if($transfer_request->num_rows > 0)
        {
            $row = $transfer_request->fetch_assoc();
            $gateway_query = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `id` = " . $row["gateway_id"]);
            $gateway = $gateway_query->fetch_assoc();
            $gateway_id = $gateway["id"]; 
            $CEAction = protect($_POST['ce_btn']);
            if(isset($CEAction) && $_POST['ce_btn'] == 'update')
            {                
                $uid = $row['to'];
                $wallet_transfer_edit_url =  $settings['url'] . 'app/admin?a=wallet&b=wallet_gateways&id='.$id;
                $amount = protect($_POST['amount']);
                        
                if(!is_numeric($amount))
                {
                    $_SESSION["error"] = "Transfer amount should be in number.";
                    header("Location: $wallet_transfer_edit_url");
                    exit;
                }
                $status = protect($_POST['status']);
                $select_wallet_balance = $db->query("SELECT `amount` FROM `ce_user_wallets` WHERE `gateway_id` = '$gateway_id' AND `uid` = '$uid'");
                $wallet_balance = $select_wallet_balance->fetch_assoc()['amount'];
                $select_deposit_balance = $db->query("SELECT `receive_amount` FROM `ce_wallet_transfer` WHERE `id` = '$id'");
                $deposit_balance = $select_deposit_balance->fetch_assoc()['receive_amount'];
                $wallet_balance =  (float)$wallet_balance + (float)$amount;
                $deposit_balance =  (float)$deposit_balance + (float)$amount;
                $db->query("UPDATE `ce_user_wallets` SET `amount` = '$wallet_balance' WHERE `gateway_id` = '$gateway_id' AND `uid` = '$uid'");
                $db->query("UPDATE `ce_wallet_transfer` SET `receive_amount` = '$deposit_balance' , `status` = '$status' WHERE `id` = '$id'");
                $_SESSION["success"] = 'Transfer request updated successfully';
                header("Location: $wallet_transfer_edit_url");
                exit;            
            }
            $preview = 'edit_wallet_transfer';
            
        }
        else
        {
            header("Location: $wallet_transfer_url");
            exit;
        }
    }
    else
    {
        $wallet_gateways = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `status` = 1 ORDER BY `id` ASC");
        $preview = 'listing';
    }
    if($preview == '')
    {
        header("Location: $dashboard_url");
        exit;
    }
?>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <h4 class="card-title"><i class="fa fa-money"></i> Manage Wallet Balances</h4>
        <br><br>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <?php 
                if(isset($_SESSION['success']) && $_SESSION['success'] != '')
                {
                    echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                    $_SESSION['success'] = '';
                } 
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                                if($wallet_gateways->num_rows > 0) {
                                while($row = $wallet_gateways->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td> <?php echo $count++; $currency = $row["currency"]; $gateway_id = $row["id"];  ?> </td>
                                    <td> <?php echo $row["name"] . ' ' . $row["currency"]; ?> </td>
                                    <td> <span class="float-left mt-2 mr-2" style="font-weight: bolder;">%</span> <input type="text" id="<?=$currency?>-amount" class="form-control" value="" style="padding: 5px;width: 100px;"> </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="manage_wallets('increament','<?=$currency?>','<?=$gateway_id?>')" class="badge badge-success">Credit</a>
                                        <a href="javascript:void(0)" onclick="manage_wallets('decreament','<?=$currency?>','<?=$gateway_id?>')" class="badge badge-warning">Debit</a>
                                    </td>
                                </tr>
                            <?php } } else { echo '<tr><td colspan="7">No requests yet.</td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
