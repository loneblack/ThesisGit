<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userID = $_SESSION['userID'];
    $id = $_GET['id'];
	//GET Due Date
	$queryReqID="SELECT s.*, rs.description, e.name FROM salvage s 
                    JOIN ref_status rs ON s.ref_status_statusID = rs.statusID
                    JOIN user u ON s.userID = u.userID
                    JOIN employee e ON u.userID = e.userID WHERE s.id = {$id};";
	$resultReqID=mysqli_query($dbc,$queryReqID);			
	$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);	
	
    $statusID = $rowReqID['ref_status_statusID'];
    $dateCreated=$rowReqID['dateCreated'];
    $description=$rowReqID['description'];
    $name=$rowReqID['name'];

	if(isset($_POST['submit'])){
		
		$status=$_POST['status'];
		$message=null;
		$category=25;
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		$currDate=date("Y-m-d H:i:s");
		$PersonRequestedID = $rowReqID['userID'];

		
		if(!isset($message)){
			//INSERT ASSET TESTING
		$queryAssTest="INSERT INTO `thesis`.`assettesting` (`statusID`, `PersonRequestedID`, `serviceType`, `remarks`) VALUES ('1', '{$rowReqID['userID']}', '25', 'Salvage');";
		$resultAssTest=mysqli_query($dbc,$queryAssTest);
			
		//GET LATEST ASSET TEST
		$queryLatAssTest="SELECT * FROM `thesis`.`assettesting` order by testingID desc limit 1";
		$resultLatAssTest=mysqli_query($dbc,$queryLatAssTest);
		$rowLatAssTest=mysqli_fetch_array($resultLatAssTest,MYSQLI_ASSOC);	
		
            
        //GET ASSET IN SALVAGE TICKET
        $ayokona = "SELECT * FROM thesis.salvage_details WHERE salvageID = {$id};";
        $pumasok=mysqli_query($dbc,$ayokona);
            
        //Create ticket
		$queryCreTick="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `requestedBy`) VALUES ('{$status}', '{$assigned}', '{$_SESSION['userID']}', now(), now(), DATE_ADD(NOW(), INTERVAL 14 DAY), '{$priority}', '{$rowLatAssTest['testingID']}', '{$category}', '{$PersonRequestedID}')";
		$resultCreTick=mysqli_query($dbc,$queryCreTick);
				
		//Get Latest ticket
		$queryLatTick="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
		$resultLatTick=mysqli_query($dbc,$queryLatTick);
		$rowLatTick=mysqli_fetch_array($resultLatTick,MYSQLI_ASSOC);
            
        
        while ($row = mysqli_fetch_array($pumasok, MYSQLI_ASSOC)){
            //UPDATE ASSET STATUS
            $queryUpdAssStat="UPDATE `thesis`.`asset` SET `assetStatus`='8' WHERE `assetID`='{$row['asset_assetID']}'";
            $resultUpdAssStat=mysqli_query($dbc,$queryUpdAssStat);
            
            //Insert to assettesting_details table
            $queryAssTest="INSERT INTO `thesis`.`assettesting_details` (`assettesting_testingID`, `asset_assetID`) VALUES ('{$rowLatAssTest['testingID']}', '{$row['asset_assetID']}')";
            $resultAssTest=mysqli_query($dbc,$queryAssTest);
            
            $queryInsTickAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTick['ticketID']}', '{$row['asset_assetID']}');";
			$resultInsTickAss=mysqli_query($dbc,$queryInsTickAss);
        } 
		
		$message = "Form submitted!";
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
                                    Salvage Request
                                </header>
                                <div style="padding-top:10px; padding-left:10px; float:left">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" <?php if($description !=1); ?>>Create Ticket</button>
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
                                                                <select class="form-control m-bot15" name="priority" readonly required>
                                                                    <option value='Low'>Low</option>
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

                                                        <button type="submit" class="btn btn-success" name="submit">Create</button>
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
                                            <h4>Repair Request</h4>
                                        </header>
                                        <div class="panel-body ">

                                            <div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <img src="images/chat-avatar2.jpg" alt="">
                                                        <strong>
                                                            <?php echo $name; ?></strong>
                                                        to
                                                        <strong>me</strong>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>Date Created:
                                                            <?php echo $dateCreated;?>
                                                        </h5>
                                                    </div>
                                                    <div class="cp;-col-md-4">
                                                    </div>

                                                    <div class="col-md-8">
                                                    </div>
                                                </div>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                            
                                                            
                                                            $query3 =  "SELECT a.assetID, rac.name, a.propertyCode FROM asset a 
                                                                            JOIN assetmodel am ON a.assetmodel = am.assetmodelID
                                                                            JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                                            JOIN salvage_details sd ON a.assetID = sd.asset_assetID
                                                                            WHERE sd.salvageID = '{$id}';";

                                                            $result3 = mysqli_query($dbc, $query3);  


                                                            while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                                               echo "<tr>
                                                                <td>{$row['propertyCode']}</td>
                                                                <td>{$row['name']}</td>
                                                                </tr>";
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
        function checkvalue(val) {
            if (val === "25")
                document.getElementById('others').style.display = 'block';
            else
                document.getElementById('others').style.display = 'none';
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