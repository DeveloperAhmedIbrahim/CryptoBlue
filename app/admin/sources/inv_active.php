<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "edit") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_invest_active WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_active");
    }
    $row = $query->fetch_assoc();
    ?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Active Investment</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $package_id = protect($_POST['package_id']);
                        $amount = protect($_POST['amount']);
                        $daily_profit = protect($_POST['daily_profit']);
                        $total_profit = protect($_POST['total_profit']);
                        $total_return = protect($_POST['total_return']);
                        $total_return_with_profit = protect($_POST['total_return_with_profit']);
                        $investment_days = protect($_POST['investment_days']);
                        $days_left = protect($_POST['days_left']);
                        $status = protect($_POST['status']);
                        if(empty($package_id) or empty($amount) or empty($daily_profit) or empty($total_profit) or empty($total_return) or empty($total_return_with_profit) or empty($investment_days) or empty($days_left) or empty($status)) {
                            echo error("All fields are required.");
                        } elseif(!is_numeric($amount)) {
                            echo error("Please enter amount with numbers.");
                        } elseif(!is_numeric($daily_profit)) {
                            echo error("Please enter daily profit with numbers.");
                        } elseif(!is_numeric($total_profit)) {
                            echo error("Please enter current profit with numbers.");
                        } elseif(!is_numeric($total_return)) {
                            echo error("Please enter total profit with numbers.");
                        } elseif(!is_numeric($total_return_with_profit)) {
                            echo error("Please enter total return + profit with numbers.");
                        } elseif(!is_numeric($investment_days)) {
                            echo error("Please enter investment days with numbers.");
                        } elseif(!is_numeric($days_left)) {
                            echo error("Please enter days left with numbers.");
                        } else {
                            $update = $db->query("UPDATE ce_invest_active SET package_id='$package_id',amount='$amount',daily_profit='$daily_profit',total_profit='$total_profit',total_return='$total_return',total_return_with_profit='$total_return_with_profit',investment_days='$investment_days',days_left='$days_left',status='$status' WHERE id='$row[id]'");
                            $query = $db->query("SELECT * FROM ce_invest_active WHERE id='$row[id]'");
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
                            <label>Package</label>
                            <select class="form-control" name="package_id">
                                <?php
                                $PlanQuery = $db->query("SELECT * FROM ce_invest_plans WHERE status='1' ORDER BY id");
                                if($PlanQuery->num_rows>0) {
                                    while($plan = $PlanQuery->fetch_assoc()) {
                                        if($plan['id'] == $row['package_id']) { $sel = 'selected'; } else { $sel = ''; }
                                        echo '<option value="'.$plan[id].'" '.$sel.'>'.$plan[package_name].'</option>';
                                    }
                                }
                                ?>
                            </select>
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
                            <label>Daily Profit</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="daily_profit" value="<?php echo $row['daily_profit']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Current Profit</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="total_profit" value="<?php echo $row['total_profit']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><?php echo $row['currency']; ?></span>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Total Profit</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="total_return" value="<?php echo $row['total_return']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><?php echo $row['currency']; ?></span>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Total Return + Profit</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="total_return_with_profit" value="<?php echo $row['total_return_with_profit']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><?php echo $row['currency']; ?></span>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                                <label>Investment Days</label>
                                <input type="text" class="form-control" name="investment_days" value="<?php echo $row['investment_days']; ?>">
                        </div>
                        <div class="form-group">
                                <label>Days Left</label>
                                <input type="text" class="form-control" name="days_left" value="<?php echo $row['days_left']; ?>">
                        </div>
                        <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                <option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>In Progress</option>
                                <option value="2" <?php if($row['status'] == "2") { echo 'selected'; } ?>>Completed</option>
                                <option value="3" <?php if($row['status'] == "3") { echo 'selected'; } ?>>Canceled</option>
                                <option value="4" <?php if($row['status'] == "4") { echo 'selected'; } ?>>Canceled & Refunded</option>
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
    $query = $db->query("SELECT * FROM ce_invest_active WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_active");
    }
    $row = $query->fetch_assoc();
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-trash"></i> Delete Active Investment</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $confirmed = protect($_GET['confirmed']);
                     if(isset($confirmed) && $confirmed == "1") {
                        $delete = $db->query("DELETE FROM ce_invest_active WHERE id='$id'");
                        echo success("Investment ($row[id]) was deleted successfully.");    
                     } else {
                        echo info("Are you sure you want to delete investment ($row[id])?");
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
                <h4 class="card-title"><i class="fa fa-history"></i> Active Investments</h4>
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
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Profit</th>
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
                            $statement = "ce_invest_active";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY status DESC LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    $PlanQuery = $db->query("SELECT * FROM ce_invest_plans WHERE id='$row[package_id]'");
                                    $plan = $PlanQuery->fetch_assoc();
                                    ?>
                                    <tr>
                                     <td><?php echo idinfo($row['uid'],"email"); ?></td>
                                     <td><?php echo $plan['package_name']; ?></td>
                                     <td><?php echo $row['amount']." ".$row['currency']; ?></td>
                                     <td><?php echo $row['total_profit']." ".$row['currency']; ?>/<?php echo $row['total_return']." ".$row['currency']; ?></td>
                                     <td><?php echo $row['investment_days']-$row['days_left']; ?>/<?php echo $row['investment_days']; ?><br/><small><?php echo $row['days_left']; ?> days left</small></td>
                                     <td>
                                        <?php
                                        if($row['status'] == "1") {
                                            echo '<span class="badge badge-info">In Progress</span>';
                                        } elseif($row['status'] == "2") {
                                            echo '<span class="badge badge-success">Completed</span>';
                                        }  elseif($row['status'] == "3") {
                                            echo '<span class="badge badge-danger">Cancaled</span>';
                                        } elseif($row['status'] == "4") {
                                            echo '<span class="badge badge-danger">Cancaled & Refunded</span>';
                                        } else {
                                            echo '<span class="badge badge-default">Default</span>';
                                        }
                                        ?>
                                    </td>
                                     <td>
                                     <a href="./?a=inv_active&b=edit&id=<?php echo $row['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                     <a href="./?a=inv_active&b=delete&id=<?php echo $row['id']; ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a> 
                                     </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="6">No active investments yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=inv_balances";
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