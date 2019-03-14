<!DOCTYPE html>
<html lang="en">
<?php
session_start();

$_SESSION['previousPage'] = "requestor_service_request_form.php";
$id = $_GET['id'];//get the id of the selected service request

require_once("db/mysql_connect.php");

$query =  " SELECT details, dateNeed, endDate, dateReceived, s.serviceType AS 'serviceTypeID', t.serviceType, statusID, description AS 'status', others, steps
            FROM thesis.service s
                JOIN ref_servicetype t
            ON s.serviceType = t.id
                JOIN ref_status a
            ON s.status = a.statusID
                WHERE s.id = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

        $details = $row['details'];
        $dateNeed = $row['dateNeed'];
        $endDate = $row['endDate'];
        $dateReceived = $row['dateReceived'];
        $serviceTypeID = $row['serviceTypeID'];
        $serviceType = $row['serviceType'];
        $statusID = $row['statusID'];
        $status = $row['status'];
        $others = $row['others'];
        $steps = $row['steps'];

    }
$assets = array();
if($serviceTypeID=='27'){

    $query2 =  "SELECT * FROM thesis.servicedetails WHERE serviceID = {$id};";
    $result2 = mysqli_query($dbc, $query2);

    while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
        array_push($assets, $row['asset']);
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

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>

    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="#" class="logo"><img src="images/dlsulogo.png" alt="" width="200px" height="40px">
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'requestor_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Service Request Form
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_request_form_DB.php">
                                                <div class="form-group ">
                                                    <div style="float:right; padding-right:20px">
                                                        <?php

                                                          if($statusID == '1'){//pending
                                                            echo "<button class='btn btn-warning' disabled>{$status}</button>";
                                                        }
                                                        if($statusID == '2'){//ongoing
                                                            echo "<button class='btn btn-info' disabled>{$status}</button>";
                                                        }
                                                        if($statusID == '3'){//completed
                                                            echo "<button class='btn btn-success' disabled>{$status}</button>";
                                                        }
                                                        if($statusID == '4'){//disapproved
                                                            echo "<button class='btn btn-danger' disabled>{$status}</button>";
                                                        }
                                                            ?>
                                                    </div>
                                                    <label for="serviceType" class="control-label col-lg-3">Type of Service Requested</label>
                                                    <div class="col-lg-6">
                                                        <select name="serviceType" onchange='checkvalue(this.value)' class="form-control m-bot15" disabled>
                                                            <option><?php echo $serviceType;?></option>
                                                        </select>
														<input type="text" class="form-control" name="others" id="others" placeholder="Specify request" disabled
                                                            <?php 

                                                                if ($serviceTypeID != '29') echo "style='display:none'";

                                                                echo "value = '{$others}'";
                                                            ?>
                                                        />
                                                    </div>
                                                </div>
												
                                                <div class="form-group ">
                                                    <label for="details" class="control-label col-lg-3">Details</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="5" name="details" style="resize:none"  disabled><?php echo $details;?></textarea>
                                                    </div>
                                                </div><br><br>

                                                <?php if($serviceTypeID=='27'){ ?>
                                                <!-- BUTAS NG PWET KO-->
                                                <h4 class="col-lg-3">Assets For Repair</h4><br><br>
                                                <div class="col-lg-6">
                                                <table class="table table-hover">
                                                    <thead>
                                                      <tr>
                                                        <th>Property Code</th>
                                                        <th>Category</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                        for ($i=0; $i < count($assets); $i++) { 
                                                            

                                                            $query3 =  "SELECT a.assetID, propertyCode, b.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description
                                                                    FROM asset a 
                                                                        JOIN assetModel m
                                                                    ON assetModel = assetModelID
                                                                        JOIN ref_brand b
                                                                    ON brand = brandID
                                                                        JOIN ref_assetcategory c
                                                                    ON assetCategory = assetCategoryID
                                                                        JOIN ref_assetstatus s
                                                                    ON a.assetStatus = s.id
                                                                        WHERE a.assetID = {$assets[$i]};";

                                                            $result3 = mysqli_query($dbc, $query3);  



                                                            while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                                               echo "<tr>
                                                                <td>{$row['propertyCode']}</td>
                                                                <td>{$row['category']}</td>
                                                                <td>{$row['brand']}</td>
                                                                <td>{$row['description']}</td>
                                                                </tr>";
                                                            }  

                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- END NG BUTAS NG PWET KO -->
                                        <?php } ?>


                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <input type="checkbox" disabled>&nbsp;Opt for service unit
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="col-lg-offset-0 col-lg-6">
                                                        <a href="requestor_dashboard.php"><button class="btn btn-danger" type="button">Back</button></a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>