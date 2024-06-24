<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "edit") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_invest_withdrawals WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_withdrawals");
    }
    $row = $query->fetch_assoc();
    ?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Investment Withdrawal</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $amount = protect($_POST['amount']);
                        $wallet = protect($_POST['wallet']);
                        $tx_id = protect($_POST['tx_id']);
                        $status = protect($_POST['status']);
                        if(empty($amount)) {
                            echo error("Please enter a amount.");
                        } elseif(!is_numeric($amount)) {
                            echo error("Please enter amount with numbers.");
                        } elseif(empty($wallet)) {
                            echo error("Please enter $row[currency] wallet.");
                        } elseif($status == "2" && empty($tx_id)) {
                            echo error("Please enter a blockchain URL for transaction tracking.");
                        } elseif($status == "2" && !isValidURL($tx_id)) {
                            echo error("Please enter a valid blockchain URL for transaction tracking.");
                        } else {
                            $update = $db->query("UPDATE ce_invest_withdrawals SET amount='$amount',wallet='$wallet',status='$status',tx_id='$tx_id' WHERE id='$row[id]'");
                            $query = $db->query("SELECT * FROM ce_invest_withdrawals WHERE id='$row[id]'");
                            $row = $query->fetch_assoc();
                            echo success("Your changes was saved successfully.");
                        }
                     }
                     ?>

                     <form action="" method="POST">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="text" class="form-control" name="email" disabled value="<?php echo idinfo($row['uid'],"email"); ?>">
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="amount" value="<?php echo $row['amount']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><?php echo $row['currency']; ?></span>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo $row['currency']; ?> Wallet</label>
                            <input type="text" class="form-control" name="wallet" value="<?php echo $row['wallet']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Transaction ID</label>
                            <input type="text" class="form-control" name="tx_id" value="<?php echo $row['tx_id']; ?>">
                            <small>Enter here blockchain URL for transaction tracking.</small>
                        </div>
                        <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                <option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>Pending</option>
                                <option value="2" <?php if($row['status'] == "2") { echo 'selected'; } ?>>Completed</option>
                                <option value="3" <?php if($row['status'] == "3") { echo 'selected'; } ?>>Canceled</option>
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
    $query = $db->query("SELECT * FROM ce_invest_withdrawals WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_withdrawals");
    }
    $row = $query->fetch_assoc();
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-trash"></i> Delete Investment Withdrawal</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $confirmed = protect($_GET['confirmed']);
                     if(isset($confirmed) && $confirmed == "1") {
                        $update = $db->query("UPDATE ce_invest_balances SET amount=amount+$row[amount] WHERE uid='$row[uid]' and currency='$row[currency]'");
                        $delete = $db->query("DELETE FROM ce_invest_withdrawals WHERE id='$id'");
                        echo success("Investment Withdrawal ($row[id]) was deleted successfully.");    
                     } else {
                        echo info("Are you sure you want to delete investment withdrawal ($row[id])?");
                        echo '<a href="./?a=inv_active&b=delete&id='.$id.'&confirmed=1" class="btn btn-success"><i class="fa fa-trash"></i> Yes, I confirm</a> 
                        <a href="./?a=inv_active" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
                     }
                     ?>
                </div>
              </div>
            </div>
        </div>
    <?php
} else {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-arrow-circle-down"></i> Investment Withdrawals</h4>
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
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Email address</th>
                            <th>Amount</th>
                            <th>Wallet</th>
                            <th>Transaction ID</th>
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
                            $statement = "ce_invest_withdrawals";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY status DESC LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    $PlanQuery = $db->query("SELECT * FROM ce_invest_plans WHERE id='$row[package_id]'");
                                    $plan = $PlanQuery->fetch_assoc();
                                    ?>
                                    <tr>
                                     <td><?php echo idinfo($row['uid'],"email"); ?></td>
                                     <td><?php echo $row['amount']." ".$row['currency']; ?></td>
                                     <td><?php echo $row['currency']; ?>: <?php echo $row['wallet']; ?></td>
                                     <td><?php if($row['tx_id']) { ?><a href="<?php echo $row['tx_Id']; ?>" target="_blank"><?php echo croptext($row['tx_id'],50); ?>...</a><?php } else { echo 'n/a'; } ?></td>
                                     <td>
                                        <?php
                                        if($row['status'] == "1") {
                                            echo '<span class="badge badge-warning">Pending</span>';
                                        } elseif($row['status'] == "2") {
                                            echo '<span class="badge badge-success">Completed</span>';
                                        }  elseif($row['status'] == "3") {
                                            echo '<span class="badge badge-danger">Cancaled</span>';
                                        } else {
                                            echo '<span class="badge badge-default">Default</span>';
                                        }
                                        ?>
                                    </td>
                                     <td>
                                     <a href="./?a=inv_withdrawals&b=edit&id=<?php echo $row['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                     <a href="./?a=inv_withdrawals&b=delete&id=<?php echo $row['id']; ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a> 
                                     </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No withdrawals yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=inv_withdrawals";
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