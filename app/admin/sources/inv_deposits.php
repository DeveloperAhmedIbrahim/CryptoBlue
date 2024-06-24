<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-credit-card"></i> Investment Deposits</h4>
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
                            <th>CoinPayments TXID</th>
                            <th>Confirmations</th>
                            <th>Status</th>
                            <th>Date</th>
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
                                     <td><?php echo $row['amount']." ".$row['currency']; ?></td>
                                     <td><?php echo $row['tx_id'] ?></td>
                                     <td><?php echo $row['confirmations']; ?></small></td>
                                     <td>
                                        <?php
                                        if($row['status'] == "1") {
                                            echo '<span class="badge badge-warning">Pending Payment</span>';
                                        } elseif($row['status'] == "2") {
                                            echo '<span class="badge badge-info">Pending Confirmations</span>';
                                        }  elseif($row['status'] == "3") {
                                            echo '<span class="badge badge-success">Completed</span>';
                                        } elseif($row['status'] == "4") {
                                            echo '<span class="badge badge-danger">Payment Error</span>';
                                        } else {
                                            echo '<span class="badge badge-default">Default</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php if($row['updated']>0) { echo date("d/m/Y H:i",$row['updated']); } else { echo date("d/m/Y H:i",$row['created']); } ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="6">No deposits yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=inv_deposits";
                    if(admin_pagination($statement,$ver,$limit,$page)) {
                        echo '<br>';
                        echo admin_pagination($statement,$ver,$limit,$page);
                    }
                    ?>
                </div>
              </div>
            </div>
        </div>