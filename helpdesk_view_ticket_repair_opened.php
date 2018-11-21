<!DOCTYPE html>
<html lang="en">
<?php
session_start();

$id = $_GET['id'];//get the id of the selected service request

require_once("db/mysql_connect.php");

$query =  "SELECT   * FROM thesis.ticket WHERE ticketID = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        
        $dateCreated = $row['dateCreated'];
        $dueDate = $row['dueDate'];
        $summary = $row['summary'];
        $details = $row['details'];
        $status = $row['status'];
        $description = $row['description'];
        $priority = $row['priority'];
        $others = $row['others'];
        $assigneeUserID = $row['assigneeUserID'];

    }
$assets = array();

$query2 =  "SELECT * FROM thesis.ticketedasset WHERE ticketID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['assetID']);
}
?>
<?php
// Insertion to ticket
    
    if(isset($_POST['submit'])){
        
        $message=null;
        $status=$_POST['status'];
        $assigned=$_POST['assigned'];
        $priority=$_POST['priority'];
        $comment=$_POST['comment'];
        $currDate=date("Y-m-d H:i:s");

        if(!isset($message)){

            $querya="UPDATE `thesis`.`ticket` 
                    SET `status` = '{$status}',
                        `assigneeUserID` = '{$assigned}',
                        `dateClosed` = '{$currDate}',
                        `priority` = '{$priority}',
                        `comment` = '{$comment}' 
                            WHERE (`ticketID` = '{$id}');";
            $resulta=mysqli_query($dbc,$querya);
        
            $queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
            $resultaa=mysqli_query($dbc,$queryaa);
            $rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);






            for ($i=0; $i < count($assets); $i++) { 

                $queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowaa['ticketID']}', '{$assets[$i]}');";
                $resultaaaa=mysqli_query($dbc,$queryaaaa);
            }

            $sql = "UPDATE `thesis`.`service` SET `status` = '2' WHERE (`id` = '{$id}');";
            $output = mysqli_query($dbc, $sql);
        
            $message = "Ticket Created";
            $_SESSION['submitMessage'] = $message;
        }
        
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
                        <div class="col-sm-9">
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-success">Opened</a></h4>
                                    <h4>Repair Request</h3>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>IT Office</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                                <h5>Date Created: <?php echo $dateCreated;?></h5>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h5>Summary: <?php echo $summary;?></h5>
                                                            </div>
                                                            <div class="cp;-col-md-4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="view-mail">
                                                        <p>Details: <?php echo $details;?></p>
                                                    </div>
                                                </div>
                            </section>

                            <section class="panel">
                                <div class="panel-body ">
                                    <h5><b>** Check the Checkbox if item is repaired</b></h5>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Property Code</th>
                                                <th>Asset/ Software Name</th>
                                                <th>Building</th>
                                                <th>Room</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                        
                                            for ($i=0; $i < count($assets); $i++) { 
                                                
                                                
                                                $query3 =  "SELECT a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description, b.name as 'building', f.floorroom
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            JOIN ref_assetstatus s
                                                        ON a.assetStatus = s.id
                                                            JOIN assetassignment aa
                                                        ON a.assetID = aa.assetID
                                                            JOIN building b
                                                        ON aa.BuildingID = b.BuildingID
                                                            JOIN floorandroom f
                                                        ON aa.FloorAndRoomID = f.FloorAndRoomID 
                                                            WHERE a.assetID = {$assets[$i]};";

                                                $result3 = mysqli_query($dbc, $query3);  

                                                while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                                   echo "<tr>
                                                   <td align='center'>
                                                    <input type='checkbox' value=''>
                                                </td>
                                                    <td>{$row['propertyCode']}</td>
                                                    <td>{$row['brand']} {$row['category']} {$row['description']}</td>
                                                    <td>{$row['building']}</td>
                                                    <td>{$row['floorroom']}</td>
                                                    </tr>";
                                                }  

                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                    <label for="category" class="control-label col-lg-4">Category</label>
                                                    <div class="col-lg-7">
                                                        <select class="form-control m-bot15" disabled="">
                                                            <option selected="selected">Repair</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="status" class="control-label col-lg-4">Status</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" name ="status">
                                                        <option <?php if($status=='1') echo "selected";?> >Open</option>
                                                        <option <?php if($status=='2') echo "selected";?> >Assigned</option>
                                                        <option <?php if($status=='3') echo "selected";?> >In Progress</option>
                                                        <option <?php if($status=='4') echo "selected";?> >Transferred</option>
                                                        <option <?php if($status=='5') echo "selected";?> >Escalated</option>
                                                        <option <?php if($status=='6') echo "selected";?> >Waiting For Parts</option>
                                                        <option <?php if($status=='7') echo "selected";?> >Closed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-4">Priority</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15">
                                                        <option <?php if($priority=='Low') echo "selected";?> >Low</option>
                                                        <option <?php if($priority=='Medium') echo "selected";?> >Medium</option>
                                                        <option <?php if($priority=='High') echo "selected";?> >High</option>
                                                        <option <?php if($priority=='Urgent') echo "selected";?> >Urgent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-4">Escalate To</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" name = "assigned">
                                                        <option value='0'>None</option>
                                                       <?php
                                                            $query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer';";
                                                            $result3=mysqli_query($dbc,$query3);
                                                                    
                                                            while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                if($assigneeUserID == $row3['UserID']){
                                                                    echo "<option selected value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                }
                                                                else
                                                                    echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                            }                                       
                                                            
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Due Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value=<?php echo $dueDate;?> disabled/>
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
                                        <h4>Comments or Request For Parts (if needed)</h4>
                                    </div>
                                    <div class="view-mail">
                                        <textarea class="form-control" style="resize:none" rows="5" name="comment"></textarea>
                                    </div>
                                </div>
                            </section>
                            <button onclick="#" class="btn btn-success">Send</button></a>
                            <a href="helpdesk_all_ticket.php"><button class="btn btn-danger">Back</button></a>
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