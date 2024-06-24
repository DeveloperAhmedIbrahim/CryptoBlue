<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "edit_balance") {

} else {
?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-check-circle"></i> Active Insurances</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h5>Your earnings from Insurances</h5>
                    <div class="row">
                        <?php
                        $EarningsQuery = $db->query("SELECT * FROM ce_invest_earnings ORDER BY id");
                        if($EarningsQuery->num_rows>0) {
                            while($e = $EarningsQuery->fetch_assoc()) {
                                ?>
                                <div class="col-md-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Crypto</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $e['currency']; ?></td>
                                                <td><?php echo $e['amount']; ?></td>
                                                <td><a href="./?a=inv_insurance_active&b=edit_balance&id=<?php echo $e['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-md-12">Still no have earnings yet.</div>';
                        }
                        ?>
                    </div>
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
                            <th>Insurance Expire on</th>
                            <th>Investment Days</th>
                            <th>Status</th>
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
                            $statement = "ce_invest_active WHERE have_insurance='1'";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY status LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    $PlanQuery = $db->query("SELECT * FROM ce_invest_plans WHERE id='$row[package_id]'");
                                    $plan = $PlanQuery->fetch_assoc();
                                    ?>
                                    <tr>
                                     <td><?php echo idinfo($row['uid'],"email"); ?></td>
                                     <td><?php echo $plan['package_name']; ?></td>
                                     <td><?php echo $row['amount']." ".$row['currency']; ?></td>
                                     <td><?php echo date("d/m/Y H:i",$row['insurance_expire']); ?></td>
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
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="6">No active insurances yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=inv_insurance_active";
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