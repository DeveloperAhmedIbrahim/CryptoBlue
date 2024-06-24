<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "new") {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-plus"></i> New Investment Plan</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "new") {
                        $package_name = protect($_POST['package_name']);
                        $name = protect($_POST['name']);
                        $currency = protect($_POST['currency']);
                        $cp_merchant = protect($_POST['cp_merchant']);
                        $cp_secret = protect($_POST['cp_secret']);
                        $cp_public_key = protect($_POST['cp_public_key']);
                        $cp_private_key = protect($_POST['cp_private_key']);
                        $min_deposit_amount = protect($_POST['min_deposit_amount']);
                        $min_withdrawal_amount = protect($_POST['min_withdrawal_amount']);
                        $daily_profit = protect($_POST['daily_profit']);
                        $investment_days = protect($_POST['investment_days']);
                        if(empty($package_name) or empty($name) or empty($currency) or empty($cp_merchant) or empty($cp_secret) or empty($cp_public_key) or empty($cp_private_key) or empty($daily_profit) or empty($investment_days)) {
                            echo error("All fields are required.");
                        } elseif(!is_numeric($daily_profit)) {
                            echo error("Please enter daily profit with numbers.");
                        } elseif(!is_numeric($investment_days)) {
                            echo error("Please enter investment days with numbers.");
                        } else {
                            $time = time();
                            $insert = $db->query( "INSERT ce_invest_plans (package_name,name,currency,min_deposit_amount,min_withdrawal_amount,cp_merchant,cp_secret,cp_public_key,cp_private_key,daily_profit,investment_days,status,created) VALUES ('$package_name','$name','$currency','$min_deposit_amount','$min_withdrawal_amount','$cp_merchant','$cp_secret','$cp_public_key','$cp_private_key','$daily_profit','$investment_days','1','$time')");
                            echo success("Package ($name) was added successfully.");
                        }
                     }
                     ?>

                     <form action="" method="POST">
                        <div class="form-group">
                            <label>Package Name</label>
                            <input type="text" class="form-control" name="package_name">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Coin Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label>Coin Code</label>
                                    <input type="text" class="form-control" name="currency">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    You can find supported coins from CoinPayments.net on this address: <a href='https://www.coinpayments.net/supported-coins' target='_blank'>https://www.coinpayments.net/supported-coins</a><br/>Copy Coin Name and Code and paste it in fields.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net Merchant ID</label>
                            <input type="text" class="form-control" name="cp_merchant">
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net Secret</label>
                            <input type="text" class="form-control" name="cp_secret">
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net API Public API</label>
                            <input type="text" class="form-control" name="cp_public_key">
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net API Private API</label>
                            <input type="text" class="form-control" name="cp_private_key">
                        </div>
                        <div class="form-group">
                            <label>Minimal Deposit Amount</label>
                            <input type="text" class="form-control" name="min_deposit_amount">
                        </div>
                        <div class="form-group">
                            <label>Minimal Withdrawal Amount</label>
                            <input type="text" class="form-control" name="min_withdrawal_amount">
                        </div>
                        <div class="form-group">
                            <label>Daily Profit</label>
                            <input type="text" class="form-control" name="daily_profit">
                            <small>Enter a daily profit in percentage without symbol %. This is a profit which client will earn every day of his investment.</small>
                        </div>
                        <div class="form-group">
                            <label>Investment Days</label>
                            <input type="text" class="form-control" name="investment_days">
                            <small>Enter here timeframe with numbers how many days need to client get a full profit from his investment.</small>
                        </div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="new"><i class="fa fa-plus"></i> Create</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "edit") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_invest_plans WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_plans");
    }
    $row = $query->fetch_assoc();
    ?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Investment Plan</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $package_name = protect($_POST['package_name']);
                        $name = protect($_POST['name']);
                        $currency = protect($_POST['currency']);
                        $cp_merchant = protect($_POST['cp_merchant']);
                        $cp_secret = protect($_POST['cp_secret']);
                        $cp_public_key = protect($_POST['cp_public_key']);
                        $cp_private_key = protect($_POST['cp_private_key']);
                        $min_deposit_amount = protect($_POST['min_deposit_amount']);
                        $min_withdrawal_amount = protect($_POST['min_withdrawal_amount']);
                        $daily_profit = protect($_POST['daily_profit']);
                        $investment_days = protect($_POST['investment_days']);
                        $status = protect($_POST['status']);
                        if(empty($package_name) or empty($name) or empty($currency) or empty($cp_merchant) or empty($cp_secret) or empty($cp_public_key) or empty($cp_private_key) or empty($daily_profit) or empty($investment_days)) {
                            echo error("All fields are required.");
                        } elseif(!is_numeric($daily_profit)) {
                            echo error("Please enter daily profit with numbers.");
                        } elseif(!is_numeric($investment_days)) {
                            echo error("Please enter investment days with numbers.");
                        } else {
                            $time = time();
                            $update = $db->query("UPDATE ce_invest_plans SET package_name='$package_name',name='$name',currency='$currency',min_deposit_amount='$min_deposit_amount',min_withdrawal_amount='$min_withdrawal_amount',cp_merchant='$cp_merchant',cp_secret='$cp_secret',cp_public_key='$cp_public_key',cp_private_key='$cp_private_key',daily_profit='$daily_profit',investment_days='$investment_days',status='$status',updated='$time' WHERE id='$id'");
                            $query = $db->query("SELECT * FROM ce_invest_plans WHERE id='$row[id]'");
                            $row = $query->fetch_assoc();
                            if(isset($_POST['update_daily_profit'])) {
                                $update = $db->query("UPDATE ce_invest_active SET daily_profit='$daily_profit' WHERE status='1' and have_insurance='0'");
                            }
                            echo success("Your changes was saved successfully.");
                        }
                     }
                     ?>

                     <form action="" method="POST">
                        <div class="form-group">
                            <label>Package Name</label>
                            <input type="text" class="form-control" name="package_name" value="<?php echo $row['package_name']; ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Coin Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label>Coin Code</label>
                                    <input type="text" class="form-control" name="currency" value="<?php echo $row['currency']; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    You can find supported coins from CoinPayments.net on this address: <a href='https://www.coinpayments.net/supported-coins' target='_blank'>https://www.coinpayments.net/supported-coins</a><br/>Copy Coin Name and Code and paste it in fields.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net Merchant ID</label>
                            <input type="text" class="form-control" name="cp_merchant" value="<?php echo $row['cp_merchant']; ?>">
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net Secret</label>
                            <input type="text" class="form-control" name="cp_secret" value="<?php echo $row['cp_secret']; ?>">
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net API Public API</label>
                            <input type="text" class="form-control" name="cp_public_key" value="<?php echo $row['cp_public_key']; ?>">
                        </div>
                        <div class="form-group">
                            <label>CoinPayments.net API Private API</label>
                            <input type="text" class="form-control" name="cp_private_key" value="<?php echo $row['cp_private_key']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Minimal Deposit Amount</label>
                            <input type="text" class="form-control" name="min_deposit_amount" value="<?php echo $row['min_deposit_amount']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Minimal Withdrawal Amount</label>
                            <input type="text" class="form-control" name="min_withdrawal_amount" value="<?php echo $row['min_withdrawal_amount']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Daily Profit</label>
                            <input type="text" class="form-control" name="daily_profit" value="<?php echo $row['daily_profit']; ?>">
                            <small>Enter a daily profit in percentage without symbol %. This is a profit which client will earn every day of his investment.</small>
                        </div>
                        <div class="form-check">
                            <div class="checkbox">
                                <label for="checkbox1" class="form-check-label ">
                                    <input type="checkbox" id="checkbox1" name="update_daily_profit" value="1" class="form-check-input"> Update daily profit of active investments (Investments with insurance will not be affected)
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Investment Days</label>
                            <input type="text" class="form-control" name="investment_days" value="<?php echo $row['investment_days']; ?>">
                            <small>Enter here timeframe with numbers how many days need to client get a full profit from his investment.</small>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>Active</option>
                                <option value="0" <?php if($row['status'] == "0") { echo 'selected'; } ?>>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "delete") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_invest_plans WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_plans");
    }
    $row = $query->fetch_assoc();
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-trash"></i> Delete Investment Plan</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $confirmed = protect($_GET['confirmed']);
                     if(isset($confirmed) && $confirmed == "1") {
                        $delete = $db->query("DELETE FROM ce_invest_plans WHERE id='$id'");
                        $delete = $db->query("DELETE FROM ce_invest_active WHERE package_id='$id'");
                        echo success("Investment Plan ($row[package_name]) was deleted successfully.");    
                     } else {
                        echo info("Are you sure you want to delete investment plan ($row[package_name])?");
                        echo '<a href="./?a=inv_plans&b=delete&id='.$id.'&confirmed=1" class="btn btn-success"><i class="fa fa-trash"></i> Yes, I confirm</a> 
                        <a href="./?a=inv_plans" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
                     }
                     ?>
                </div>
              </div>
            </div>
        </div>
    <?php
} else { 
    $ch_status = protect($_GET['ch_status']);
    if(isset($ch_status) && $ch_status == "disable") {
        $update = $db->query("UPDATE ce_settings SET invest_plugin='0'");
        header("Location: ./?a=inv_plans");
    } 
    if(isset($ch_status) && $ch_status == "enable") {
        $update = $db->query("UPDATE ce_settings SET invest_plugin='1'");
        header("Location: ./?a=inv_plans");
    }
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-window-restore"></i> Investment Plans <span class="pull-right"><a href="./?a=inv_plans&b=new" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Plan</a></span></h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    Current Investment Plugin Status is: <?php if($settings['invest_plugin'] == "1") { echo '<span class="badge badge-success">Enabled</span>'; } else { echo '<span class="badge badge-danger">Disabled</span>'; } ?>
                    <br/>
                    <small>
                    <?php if($settings['invest_plugin'] == "1") { ?>
                        <a href="./?a=inv_plans&ch_status=disable">Click here</a> to disable Invest Plugin.
                    <?php } else { ?>
                        <a href="./?a=inv_plans&ch_status=enable">Click here</a> to enable Invest Plugin.
                    <?php } ?>
                    </small>
                </div>
                </div>
            </div>
            
           <div class="col-lg-12">
                <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Installation guide:<br/>
                        To update automatically daily profit of investors and investment days of investments you must add a CRON job which to be run every 1 hour.<br/>
                        Command line: <b>/usr/bin/php -q /home/your username/public_html/app/cron/update_invests.php</b> or <b>curl "<?php echo $settings['url']; ?>app/cron/update_invests.php"</b>
                    </div>
                    </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Package Name</th>
                            <th>Gateway</th>
                            <th>Min. Deposit Amount</th>
                            <th>Min. Withdrawal Amount</th>
                            <th>Daily Profit</th>
                            <th>Investment Days</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                            $limit = 20;
                            $startpoint = ($page * $limit) - $limit;
                            if($page == 1) {
                                $i = 1;
                            } else {
                                $i = $page * $limit;
                            }
                            $statement = "ce_invest_plans";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                     <td><?php echo $row['package_name']; ?></td>
                                     <td><?php echo $row['name']; ?></td>
                                     <td><?php echo $row['min_deposit_amount']." ".$row['currency']; ?></td>
                                     <td><?php echo $row['min_withdrawal_amount']." ".$row['currency']; ?></td>
                                     <td><?php echo $row['daily_profit']; ?>%</td>
                                     <td><?php echo $row['investment_days']; ?></td>
                                     <td><?php if($row['status'] == "1") { echo '<span class="badge badge-success">Active</span>'; } else { echo '<span class="badge badge-danger">Inactive</span>'; } ?></td>
                                     <td>
                                        <a href="./?a=inv_plans&b=edit&id=<?php echo $row['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                        <a href="./?a=inv_plans&b=delete&id=<?php echo $row['id']; ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a>
                                     </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="8">No investment plans yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=inv_plans";
                    if(admin_pagination($statement,$ver,$limit,$page)) {
                        echo '<br>';
                        echo admin_pagination($statement,$ver,$limit,$page);
                    }
                    ?>
                </div>
              </div>
            </div>
        </div>
    <?php
}
?>