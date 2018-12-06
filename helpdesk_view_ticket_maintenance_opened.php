<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$serviceID=$_GET['id'];
	
	//GET SERVICE DATA
	$queryServData="SELECT * FROM thesis.service where id='{$serviceID}'";
	$resultServData=mysqli_query($dbc,$queryServData);
	$rowServData=mysqli_fetch_array($resultServData,MYSQLI_ASSOC);
	
	if(isset($_POST['submit'])){
		if(!empty($_POST['assigneeUserID'])){
			foreach (array_combine($_POST['assigneeUserID'], $_POST['forMain']) as $assigneeUserID => $forMain){
				//CREATE TICKET
				$querya="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `serviceType`, `summary`, `description`, `details`, `service_id`) VALUES ('1', '{$assigneeUserID}', '{$_SESSION['userID']}', now(), now(), '{$rowServData['dateNeed']}', 'Urgent', '28', '{$rowServData['summary']}', 'Pending', '{$rowServData['details']}','{$serviceID}')";
				$resulta=mysqli_query($dbc,$querya);
			
				//GET LATEST TICKET
				$queryaa="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
				$resultaa=mysqli_query($dbc,$queryaa);
				$rowaa=mysqli_fetch_array($resultaa,MYSQLI_ASSOC);
				
				//GET ASSETS FROM ASSETASSIGNMENT BASED ON GIVEN BUILDING
				$queryBuildAss="SELECT * FROM thesis.assetassignment where BuildingID='{$forMain}'";
				$resultBuildAss=mysqli_query($dbc,$queryBuildAss);
				
				while($rowBuildAss=mysqli_fetch_array($resultBuildAss, MYSQLI_ASSOC)){
					$queryaaaa="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`, `checked`) VALUES ('{$rowaa['ticketID']}', '{$rowBuildAss['assetID']}', '0');";
					$resultaaaa=mysqli_query($dbc,$queryaaaa);
				}
				$sql = "UPDATE `thesis`.`service` SET `status` = '2' WHERE (`id` = '{$serviceID}');";
				$output = mysqli_query($dbc, $sql);
				
				$message = "Ticket Created";
				$_SESSION['submitMessage'] = $message;
			}
		}
		
	}
	
?>

<html lang="en">

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
				<?php 
                    if(isset($_POST['submit'])){
                        echo   "<div style='text-align:center' class='alert alert-success'>
									<strong><h3>{$message}</h3></strong>
                                </div>";

                        unset($_SESSION['submitMessage']);
					}
                ?>
                <div class="row">
                    <div class="col-sm-12">
						<form method="post">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-success">Open</a></h4>
                                    <h4>Service Request</h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>IT Office</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="date"> 10:15AM 02 FEB 2018</p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        
                        <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4>Assets</h4>
                                </header>
                                <div class="panel-body ">

                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                        <thead>
                                            <tr>
                                                <th>Building</th>
                                                <th>Number of Assets</th>
                                                <th>Assigned Engineer</th>
                                            </tr>
                                        </thead>
										
										
										
                                        <tbody>
											<?php
												//GET For Maintenance Data
												$queryMaint="SELECT aa.BuildingID, b.name as `buildingName`, count(*) as `numAssets` FROM thesis.servicedetails sd join asset a on sd.asset=a.assetID
															   join assetassignment aa on a.assetID=aa.assetID
															   join building b on aa.BuildingID=b.BuildingID
															   where sd.serviceID='{$serviceID}'
															   group by aa.BuildingID";
												$resultMaint=mysqli_query($dbc,$queryMaint);
												while($rowMaint=mysqli_fetch_array($resultMaint,MYSQLI_ASSOC)){
													echo "<tr>
														<input type='hidden' name='forMain[]' value='{$rowMaint['BuildingID']}'>
														<td>{$rowMaint['buildingName']}</td>
														<td>{$rowMaint['numAssets']}</td>
														<td>
															<select class='form-control' name = 'assigneeUserID[]'>";
																
															$query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer';";
                                                            $result3=mysqli_query($dbc,$query3);
                                                                    
                                                            while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                            }                                       	
													echo "</select>
														</td>
													</tr>";
												}
											?>
                                            <!-- <tr>
                                                <td>Gokongwei</td>
                                                <td>100</td>
                                                <td>
                                                    <select class="form-control">
                                                        <option>Engineer Marvin Lao</option>
                                                    </select>
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>



                                </div>
                            </section>

                        
                        
                        <div class="col-sm-12">
                            <a href=""><button class="btn btn-success" type="submit" name="submit">Submit</button></a>
                            <a href="engineer_all_ticket.php"><button class="btn btn-danger">Back</button></a>
                        </div>
                        </form>
                        
                        

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