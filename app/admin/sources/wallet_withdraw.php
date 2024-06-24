<?php
    if(!defined('CryptExchanger_INSTALLED')){
        header("HTTP/1.0 404 Not Found");
        exit;
    }    
    
    $preview = '';
    $dashboard_url =  $settings['url'] . 'app/admin';
    $wallet_withdraw_url =  $settings['url'] . 'app/admin?a=wallet&b=wallet_withdraw';    
    if(isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] != "")
    {
        $id = $_GET['id'];
        $deposit_request = $db->query("SELECT * FROM `ce_wallet_withdraw` WHERE `id` = '$id'"); 
        
        if($deposit_request->num_rows > 0)
        {
            $row = $deposit_request->fetch_assoc();
            $gateway_query = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `id` = " . $row["gateway_id"]);
            $gateway = $gateway_query->fetch_assoc();
            $gateway_id = $gateway["id"]; 
            $CEAction = protect($_POST['ce_btn']);
            if(isset($CEAction) && $_POST['ce_btn'] == 'update')
            {                
                $uid = $row['uid'];
                $wallet_withdraw_edit_url =  $settings['url'] . 'app/admin?a=wallet&b=wallet_withdraw&id='.$id;
                $status = protect($_POST['status']);
                $db->query("UPDATE `ce_wallet_withdraw` SET  `status` = '$status' WHERE `id` = '$id'");
                $_SESSION["success"] = 'Withdraw request updated successfully';
                header("Location: $wallet_withdraw_edit_url");
                exit;            
            }
            $preview = 'edit_wallet_withdraw';
            
        }
        else
        {
            header("Location: $wallet_withdraw_url");
            exit;
        }
    }
    else
    {
   
        $wallet_withdraw = $db->query("SELECT * FROM `ce_wallet_withdraw` ORDER BY `id` DESC");
        $preview = 'listing';
    }
    if($preview == '')
    {
        header("Location: $dashboard_url");
        exit;
    }
?>
<?php if($preview == 'edit_wallet_withdraw'){ ?>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h4 class="card-title"><i class="fa fa-money"></i> Withdarw Request <small>Request ID: <?php echo $row['id']; ?></small></h4>
        </div>
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
            <?php 
                if(isset($_SESSION['error']) && $_SESSION['error'] != '')
                {
                    echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                    $_SESSION['error'] = '';
                } 
            ?>
            <?php 
                if(isset($_SESSION['success']) && $_SESSION['success'] != '')
                {
                    echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                    $_SESSION['success'] = '';
                } 
            ?>
            <div class="card-body">
                <h4 class="card-title">REQUEST OVERVIEW</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <b>Request by:</b></td>
                                <td>
                                    <span class="pull-right">
                                        <?php 
                                            $query_email = $db->query("SELECT `email` FROM `ce_users` WHERE `id` = " . $row['uid']);
                                            if($query_email->num_rows > 0) {
                                                $email = $query_email->fetch_assoc()['email'];
                                                echo $email;
                                            } else {
                                                echo "N/A";
                                            }
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <td>
                                <b>Wallet:</b></td>
                                <td>
                                    <span class="pull-right">
                                        <?php 
                                            $cryptoicon_url =   $settings['url'] . $gateway["icon"];
                                            $cryptoicon_image = '<image src="'.$cryptoicon_url.'" wisth="50">'; 
                                            echo $cryptoicon_image . ' ' . $gateway['currency'] . ' Wallet';
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <td>
                                <b>User's Own Wallet Address:</b></td>
                                <td>
                                    <span class="pull-right">
                                        <?php 
                                           echo ($row["wallet_address"] == null || $row["wallet_address"] == "") ? "N/A" : $row["wallet_address"];
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Requested amount:</b></td>
                                <td>
                                    <span class="pull-right">
                                    <?php 
                                        $cryptoicon_url =   $settings['url'] . $gateway["icon"];
                                        $cryptoicon_image = '<image src="'.$cryptoicon_url.'" wisth="50">';
                                        $cryptodetails =  $gateway["name"] . ' (' . $row['amount'] . ' ' .  $gateway["currency"] .')'; 
                                        echo $cryptoicon_image . ' ' . $cryptodetails;
                                    ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Fees Deducted:</b></td>
                                <td>
                                    <span class="pull-right">
                                    <?php 
                                        echo $row["fees"]."%";
                                    ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Send Total To The User:</b></td>
                                <td>
                                    <span class="pull-right">
                                    <?php 
                                        echo $row["total_receive"] . ' ' . $gateway["currency"];
                                    ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Request created on:</b></td>
                                <td><span class="pull-right"><?php echo date("d/m/Y H:i",$row['created']); ?></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>

        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">TAKE ACTION</h4>

                <form action="" method="POST">
                    <div class="form-group">
                        <label>Choose status:</label>
                        <select class="form-control" name="status" >
                        <option value="0" <?php if($row['status'] == "0") { echo 'selected'; } ?>>Processing</option>
                        <option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>Completed</option>
                        <option value="2" <?php if($row['status'] == "2") { echo 'selected'; } ?>>Cancelled</option>
                        </select>
                    </div>                    
                    <button type="submit" class="btn btn-primary" name="ce_btn" value="update">Update</button>
                </form>
            </div>
            </div>
        </div>
    </div>

<?php } else if($preview == 'listing'){ ?>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h4 class="card-title"><i class="fa fa-money"></i> Withdarw Requests</h4>
            <br><br>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Requested By</th>
                                    <th>Requested Amount</th>
                                    <th>Wallet</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    if($wallet_withdraw->num_rows > 0) {
                                    while($row = $wallet_withdraw->fetch_assoc()) {
                                    $gateway_query = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `id` = ". $row["gateway_id"]);    
                                    $gateway =  $gateway_query->fetch_assoc();
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $count++; ?>  
                                        </td>
                                        <td>
                                            <?php                                             
                                                if($row['uid'] > 0) {
                                                    $email_query = $db->query("SELECT  `email` FROM `ce_users` WHERE `id` = " . $row['uid']); 
                                                    if($email_query->num_rows == 1)
                                                    {
                                                        echo '<a href="./?a=users&b=edit&id='.$row["uid"].'">'.$email_query->fetch_assoc()['email'].'</a>'; 
                                                    }
                                                    else
                                                    {
                                                        echo "N/A";    
                                                    }
                                                } 
                                                else { 
                                                    echo "N/A"; 
                                                } 
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $iconurl = $settings['url'] . $gateway["icon"]; 
                                                $details =  $gateway["name"] . ' ('. $row['amount'] . ' ' . $gateway["currency"] .')'; 
                                                echo '<img width="60" src="'.$iconurl.'" alt=""> ' . $details;
                                            ?>                                        
                                        </td>
                                        <td>
                                            <?php echo '<img width="60" src="'.$settings['url'].$gateway["icon"].'" alt=""> '. $gateway["currency"] .' Wallet'  ?>
                                        </td>
                                        <td>
                                            <?php echo date("d/m/Y H:i",$row['created']); ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($row['status'] == "0") { 
                                                    echo '<span class="badge badge-info">Processing</span>'; 
                                                } else if ($row['status'] == "1") { 
                                                    echo '<span class="badge badge-success">Completed</span>'; 
                                                } else if ($row['status'] == "2") { 
                                                    echo '<span class="badge badge-danger">Cancelled</span>'; 
                                                } 
                                            ?>
                                        </td>
                                        <td>
                                            <a href="./?a=wallet&b=wallet_withdraw&id=<?php echo $row['id']; ?>" class="badge badge-primary">Edit</a>
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
<?php } ?>