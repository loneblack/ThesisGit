<!DOCTYPE html>
<html lang="en">
<?php
session_start();

$id = $_GET['id'];//get the id of the selected service request

require_once("db/mysql_connect.php");

$query =  "SELECT *, details, dateNeed, endDate, dateReceived, s.serviceType AS 'serviceTypeID', t.serviceType, statusID, description AS 'status', others, steps
            FROM thesis.service s
                JOIN ref_servicetype t
            ON s.serviceType = t.id
                JOIN ref_status a
            ON s.status = a.statusID
                JOIN employee e 
            ON s.UserID = e.UserID
                WHERE s.id = {$id}";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    
        $name = $row['name'];      
        $dateReceived = $row['dateReceived'];
        $details = $row['details'];
        $serviceTypeID = $row['serviceTypeID'];
        $serviceType = $row['serviceType'];
        $statusID = $row['statusID'];
        $description = $row['description'];
        $steps = $row['steps'];

    }
$assets = array();

$query2 =  "SELECT * FROM thesis.servicedetails WHERE serviceID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['asset']);
}
?>
<?php
// Insertion to ticket
    
    if(isset($_POST['submit'])){
        
        $message=null;
        $status=$_POST['status'];
        $priority=$_POST['priority'];
        $assigned=$_POST['assigned'];
        $currDate=date("Y-m-d H:i:s");

        if(!isset($message)){
			//echo "<script>alert('{$status}');</script>";
			//echo "<script>alert('{$assigned}');</script>";
			//echo "<script>alert('{$_SESSION['userID']}');</script>";
			//echo "<script>alert('{$priority}');</script>";
			//echo "<script>alert('{$details}');</script>";
			//echo "<script>alert('{$id}');</script>";
            //if($assigned=='0'){
              //  $querya="INSERT INTO `thesis`.`ticket` (`status`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `summary`, `description`, `details`) VALUES ('{$status}', '{$_SESSION['userID']}', now(), now(), '{$dateNeed}', '{$priority}', '27', '{$summary}', '{$description}', '{$details}')";
              //  $resulta=mysqli_query($dbc,$querya);
            //}
            //else{
				$querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `priority`, `serviceType`, `description`, `details`, `service_id`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$priority}', '27', '{$description}', '{$details}','{$id}')";
                $resulta=mysqli_query($dbc,$querya);
                //$querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `priority`, `serviceType`, `details`, `service_id`) 
                //VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), '{$priority}', '27', '{$details}, '{$id}')";
                //$resulta=mysqli_query($dbc,$querya);
            //}
        
            $queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
            $resultaa=mysqli_query($dbc,$queryaa);
            $rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);

            for ($i=0; $i < count($assets); $i++) { 

                $queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`, `checked`) VALUES ('{$rowaa['ticketID']}', '{$assets[$i]}', '0');";
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
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Repair Request
                                </header>
                                <div style="padding-top:10px; padding-left:10px; float:left">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" <?php if($statusID != 1) echo "disabled";
                                    ?>>Create Ticket</button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Create a Ticket</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                        <div class="form-group ">
                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="2" readOnly>
                                                                    <option value="2">Assigned</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" required>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High'>High</option>
                                                                    <option value='Urgent'>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned" required>
                                                                <option value=''>None</option>
                                                                <?php
                                                                    $query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer'";
                                                                    $result3=mysqli_query($dbc,$query3);
                                                                    
                                                                    while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                        echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                    }                                       
                                                                
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                                MODAL END-->
                                
                                <div style="padding-top:55px" class="panel-body">
                                    <div class="form" method="post">
                                        <?php 
                                            if(isset($_POST['submit'])){
                                                echo   "<div style='text-align:center' class='alert alert-success'>
                                                            <strong><h3>{$message}</h3></strong>
                                                        </div>";

                                                    unset($_SESSION['submitMessage']);
                                            }
                                        ?>
                                        
                                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                                    <h4 class="gen-case" style="float:right"> 
                                                        <?php
                                                        if($statusID == '1'){//pending
                                                            echo " <a class='btn btn-warning'>{$description}</span></a>";
                                                        }
                                                        if($statusID == '2'){//ongoing
                                                            echo "<a class='btn btn-info'>{$description}</span></a>";
                                                        }
                                                        if($statusID == '3'){//completed
                                                            echo " <a class='btn btn-success'>{$description}</span></a>";
                                                        }
                                                        if($statusID == '4'){//disapproved
                                                            echo " <a class='btn btn-danger'>{$description}</span></a>";
                                                        }
                                                        ?>
                                                    </h4>
                                                    <h4>Repair Request</h3>
                                                </header>
                                                <div class="panel-body ">

                                                    <div>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <img src="images/chat-avatar2.jpg" alt="">
                                                                <strong><?php echo $name; ?></strong>
                                                                to
                                                                <strong>me</strong>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h5>Date Created: <?php echo $dateReceived;?></h5>
                                                            </div>
                                                            <div class="cp;-col-md-4">
                                                            </div>

                                                            <div class="col-md-8">
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
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            
                                                            <th>Property Code</th>
                                                            <th>Category</th>
                                                            <th>Brand</th>
                                                            <th>Description</th>
                                                            <th>Building</th>
                                                            <th>Room</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                        for ($i=0; $i < count($assets); $i++) { 
                                                            
                                                            
                                                            $query3 =  "SELECT a.assetID, propertyCode, b.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description, b.name as 'building', f.floorroom
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
                                                                <td>{$row['propertyCode']}</td>
                                                                <td>{$row['category']}</td>
                                                                <td>{$row['brand']}</td>
                                                                <td>{$row['description']}</td>
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
                                            <a href="helpdesk_all_request.php"><button type="button" class="btn btn-danger">Back</button></a>
                                                                            

                                    </div>
                                </div>
                            

                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    
    <script>
    function checkvalue(val){
        if(val==="25")
           document.getElementById('others').style.display='block';
        else
           document.getElementById('others').style.display='none'; 
    }
    </script>

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