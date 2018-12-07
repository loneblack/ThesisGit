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

$queryUser="SELECT * FROM thesis.employee WHERE UserID = '{$creatorUserID}';";
$resultUser=mysqli_query($dbc,$queryUser);          
$rowUser=mysqli_fetch_array($resultUser,MYSQLI_ASSOC);  

$name=$rowUser['name'];

if(isset($_POST['submit'])){
        
        $status=$_POST['status'];
        $priority=$_POST['priority'];
        $assigned=$_POST['assigned'];
        if($assigned == 0) $assigned = "NULL";

        $queryTicket =  "UPDATE `thesis`.`ticket` SET `status` = '{$status}', `assigneeUserID` = {$assigned}, `lastUpdateDate` = now(), `priority` = '{$priority}' 
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

                <?php
                    if (isset($_POST['submit'])){

                        echo "<div style='text-align:center' class='alert alert-success'>
                                <strong><h3>Form Submitted!</h3></strong>
                              </div>";
                    }
                ?>
                <!-- page start-->
                <form class="cmxform form-horizontal " id="signupForm" method="post" action=""> 
                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="row">
                            <div class="col-sm-9">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Asset Testing Checklist
                                    </header>
                                    <div class="panel-body">
                                    
                                        <div class="panel-body">
                                            <section>
                                            <label><h5>Name:</h5></label><input type="text" value="<?php echo $name ;?>" class="form-control" disabled>
                                            <br>
                                            
                                            </section>
                                        </div>

                                        <section>
                                            <p>Check those which are functioning as intended.
                                            If any damage or defect is found, please specify it in the comments.
                                            Leave both checkbox and comment blank for escalation.</p>
                                            <br>
                                        </section>
                                        
                                        <section id="unseen">
                                        
                                            <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    
                                                    $query="SELECT b.name as 'brand',propertyCode,am.description as 'item',am.itemSpecification
                                                            FROM thesis.ticketedasset t
                                                            join asset a on t.assetID=a.assetID
                                                            join assetmodel am on a.assetModel=am.assetModelID
                                                            join ref_brand b on am.brand = b.brandID
                                                            WHERE ticketID = '{$ticketID}';";
                                                    $result=mysqli_query($dbc,$query);
                                                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                                        echo "<tr>
                                                                <td style='text-align:center'><input type='checkbox' class='form-check-input' disabled></td>
                                                                <td style='text-align:center'>{$row['propertyCode']}</td>
                                                                <td style='text-align:center'>{$row['brand']}</td>
                                                                <td style='text-align:center'>{$row['item']}</td>
                                                                <td><input style='text' class='form-control' disabled></td>
                                                            </tr>";
                                                    }
                                                    
                                                ?>

                                                </tbody>
                                            </table>
                                            
                                            
                                            

                                            <div>
                                                <button type="submit" name="submit" id="submit" class="btn btn-success" data-dismiss="modal" disabled>Send</button> 
                                                <a ><button onclick="window.history.back()" type="button" class="btn btn-danger" data-dismiss="modal">Back</button></a>
                                            </div>

                                        </section>
                                    </div>
                                </section>
                            </div>
                            
                            
                            <div class="col-sm-3">
                                <section class="panel">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked labels-info ">
                                            <li>
                                                <h4>Properties</h4>
                                            </li>
                                        </ul>
                                        <div class="form">
                                            
                                                <div class="form-group ">
                                                    <div class="form-group ">
                                                        <label style="padding-left:22px" for="category" class="control-label col-lg-4">Category</label>
                                                        <div class="col-lg-8" style="padding-right:30px">
                                                            <select class="form-control m-bot15" name="category" readonly>
                                                                <option value = '25'>Repair</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <label for="status" class="control-label col-lg-4">Status</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status'])) echo $_POST['status']; ?>" disabled >
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
                                                    <label for="priority" class="control-label col-lg-4">Priority</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority'])) echo $_POST['priority']; ?>" disabled>
                                                            <option <?php if($priority == 'Low') echo "selected"; ?> value='Low'>Low</option>
                                                            <option <?php if($priority == 'Medium') echo "selected"; ?> value='Medium'>Medium</option>
                                                            <option <?php if($priority == 'High') echo "selected"; ?> value='High'>High</option>
                                                            <option <?php if($priority == 'Urgent') echo "selected"; ?> value='Urgent'>Urgent</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="assign" class="control-label col-lg-4">Assign To</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" name="assigned" value="<?php if (isset($_POST['assigned'])) echo $_POST['assigned']; ?>" disabled>
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
                                                    <label class="control-label col-lg-4">Due Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="datetime" value="<?php echo $dueDate ?>" readonly />
                                                    </div>
                                                </div>
                                            
                                        </div>
                                        
                                    </div>
                                </section>
                            </div>
                            
                        </div>
                    </div>
                </div>
                 </form>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->


    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
    </script>
    
    
    

</body>

</html>