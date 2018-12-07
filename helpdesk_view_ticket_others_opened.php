<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once('db/mysql_connect.php');

$userID = $_SESSION['userID'];
$ticketID=$_GET['id'];

$queryTicket="SELECT *, t.status as 'status', s.status as 'statusName' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID WHERE t.ticketID = '{$ticketID}';";
$resultTicket=mysqli_query($dbc,$queryTicket);          
$rowTicket=mysqli_fetch_array($resultTicket,MYSQLI_ASSOC);  

$status=$rowTicket['status'];
$summary=$rowTicket['summary'];
$details=$rowTicket['details'];
$priority=$rowTicket['priority'];
$dueDate=$rowTicket['dueDate'];
$dateCreated=$rowTicket['dateCreated'];
$lastUpdateDate=$rowTicket['lastUpdateDate'];
$description=$rowTicket['description'];
$creatorUserID=$rowTicket['creatorUserID'];
$assigneeUserID=$rowTicket['assigneeUserID'];
$serviceType=$rowTicket['serviceType'];
$others=$rowTicket['others'];
$comment=$rowTicket['comment'];

$queryUser="SELECT * FROM thesis.employee WHERE UserID = '{$creatorUserID}';";
$resultUser=mysqli_query($dbc,$queryUser);          
$rowUser=mysqli_fetch_array($resultUser,MYSQLI_ASSOC);  

$name=$rowUser['name'];

if(isset($_POST['submit'])){
        
        $status=$_POST['status'];
        $priority=$_POST['priority'];
        $assigned=$_POST['assigned'];
        if($assigned == 0) $assigned = "NULL";

        $queryTicket =  "UPDATE `thesis`.`ticket` SET `status` = '{$status}', `assigneeUserID` = '{$assigned}', `lastUpdateDate` = now(), `priority` = '{$priority}' 
                        WHERE (`ticketID` = '{$ticketID}');";
        $resultTicket = mysqli_query($dbc, $queryTicket);
        //Update status and steps
    }

?>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>DLSU IT Asset Management</title>

    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>

    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="#" class="logo">
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-8">
                            <section class="panel">
                                <header style="padding-bottom:20px"class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-success">Opened</a></h4>
                                    <h4>Service Request</h3>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>Helpdesk</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="date"><?php echo $dateCreated; ?></p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p><b>Service Type Details: </b><?php echo $others;?></p>
                                        <p><b>Summary: </b><?php echo $summary;?></p>
                                        <p><b>Details: </b><?php echo $details;?></p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-4">

                            <section class="panel">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked labels-info ">
                                        <li>
                                            <h4>Properties</h4>
                                        </li>
                                    </ul>
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" readonly>
                                                       <?php
                                                                //do selected and form submitted
                                                            $query="SELECT * FROM thesis.ref_servicetype";
                                                            $result=mysqli_query($dbc,$query);
                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                            
                                                                if ($serviceType == $row['id']){
                                                                    echo "<option value='{$row['id']}' selected>{$row['serviceType']}</option>";
                                                                }
                                                                else{
                                                                    echo "<option value='{$row['id']}'>{$row['serviceType']}</option>";
                                                                }
                                                                
                                                            }
                                                            
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                                
                                                <label for="status" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status'])) echo $_POST['status']; ?>" required >
                                                        <?php
                                                                //do selected and form submitted
                                                            $queryb="SELECT * FROM thesis.ref_ticketstatus";
                                                            $resultb=mysqli_query($dbc,$queryb);
                                                            while($rowb=mysqli_fetch_array($resultb,MYSQLI_ASSOC)){
                                                            
                                                                if ($status == $rowb['ticketID']){
                                                                    echo "<option value='{$rowb['ticketID']}' selected>{$rowb['status']}</option>";
                                                                }
                                                                else{
                                                                    echo "<option value='{$rowb['ticketID']}'>{$rowb['status']}</option>";
                                                                }
                                                                
                                                            }
                                                            
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-3">Priority</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority'])) echo $_POST['priority']; ?>" required>
                                                            <option <?php if($priority == 'Low') echo "selected"; ?> value='Low'>Low</option>
                                                            <option <?php if($priority == 'Medium') echo "selected"; ?> value='Medium'>Medium</option>
                                                            <option <?php if($priority == 'High') echo "selected"; ?> value='High'>High</option>
                                                            <option <?php if($priority == 'Urgent') echo "selected"; ?> value='Urgent'>Urgent</option>
                                                        </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="assigned" value="<?php if (isset($_POST['assigned'])) echo $_POST['assigned']; ?>" required>
                                                            <option value='NULL'>None</option>
                                                            <?php
                                                                $query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer'";
                                                                $result3=mysqli_query($dbc,$query3);
                                                                
                                                                while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                    if($assigneeUserID == $row3['UserID']){
                                                                        echo "<option value='{$row3['UserID']}' selected>{$row3['fullname']}</option>";
                                                                    }
                                                                    else{
                                                                        echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                    }
                                                                }                                       
                                                            
                                                            ?>

                                                        </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Due Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="datetime" value="<?php echo $dueDate ?>" readonly />
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </section>
                        </div>
        
                        <div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">

                                    <div>
                                        <h4>Comments (if needed)</h4>
                                    </div>
                                    <div class="view-mail">
                                        <textarea class="form-control" style="resize:none" rows="5" disabled><?php echo $comment;?></textarea>
                                    </div>
                                </div>
                            </section>
                            <button onclick="return confirm('Send and close ticket?')" class="btn btn-success">Send</button></a>
                            <button class="btn btn-danger" onclick="window.history.back()" >Back</button></a>
                        </div>


                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
   
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>