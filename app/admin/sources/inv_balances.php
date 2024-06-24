<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "edit") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_invest_balances WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=inv_balances");
    }
    $row = $query->fetch_assoc();
    ?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Balance</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                       $amount = protect($_POST['amount']);
                       if(empty($amount)) {
                           echo error("Please enter some amount.");
                       } elseif(!is_numeric($amount)) {
                           echo error("Please enter amount with numbers.");
                       } else {
                           $update = $db->query("UPDATE ce_invest_balances SET amount='$amount' WHERE id='$row[id]'");
                           $query = $db->query("SELECT * FROM ce_invest_balances WHERE id='$row[id]'");
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
                            <label>Balance</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="amount" value="<?php echo $row['amount']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><?php echo $row['currency']; ?></span>
                                    </div>
                                </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} else {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-money"></i> Investment Balanaces</h4>
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
                            <th>Available Balance</th>
                            <th>Last Update</th>
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
                            $statement = "ce_invest_balances";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                     <td><?php echo idinfo($row['uid'],"email"); ?></td>
                                     <td><?php echo $row['amount']." ".$row['currency']; ?></td>
                                     <td><?php echo date("d/m/Y H:i",$row['updated']); ?></td>
                                     <td><?php if($row['status'] == "1") { echo '<span class="badge badge-success">Active</span>'; } else { echo '<span class="badge badge-danger">Inactive</span>'; } ?></td>
                                     <td>
                                        <a href="./?a=inv_balances&b=edit&id=<?php echo $row['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                     </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No deposits yet.</td></tr>';
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