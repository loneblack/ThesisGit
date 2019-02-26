<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("db/mysql_connect.php");
$_SESSION['previousPage'] = "requestor_request_for_procurement_service_material.php";
$_SESSION['count'] = 0;
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
                                        Request To Purchase An Asset
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_request_for_procurement_service_material_DB.php">
                                                <?php
                                                    if (isset($_SESSION['submitMessage'])){

                                                        echo "<div style='text-align:center' class='alert alert-success'>
                                                                <strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                                                              </div>";

                                                        unset($_SESSION['submitMessage']);
                                                    }
                                                ?>

                                                <!--
                                                <section>
                                                    <h4>User Location Information</h4>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Building</label>
                                                        <div class="col-lg-6">
                                                            <select name="buildingID" id="buildingID" class="form-control m-bot15" onChange="getRooms(this.value)" required>
                                                                <option value="">Select building</option>
                                                                <?php

                                                                    $sql = "SELECT * FROM thesis.building;";

                                                                    $result = mysqli_query($dbc, $sql);

                                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                    {
                                                                        
                                                                        echo "<option value ={$row['BuildingID']}>";
                                                                        echo "{$row['name']}</option>";

                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="floorRoom" class="control-label col-lg-3">Floor & Room</label>
                                                        <div class="col-lg-6">
                                                            <select name="FloorAndRoomID" id="FloorAndRoomID" class="form-control m-bot15" required>
                                                                <option value=''>Select floor & room</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="form-group ">
                                                        <label for="recipient" class="control-label col-lg-3">Recipient</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="recipient" name="recipient" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" />
                                                        </div>
                                                    </div>
                                                </section>
                                                -->
<!--                                                <hr>-->

                                                <section>
                                                    <h4>Request Details</h4>
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Reason of Request</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="comment" name= "comment" style="resize: none" required></textarea>
                                                            </div>
                                                        </div>
                                                     </div>
                                                    
                                                     <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="dateNeeded" name="dateNeeded" type="date" value="<?php 
															
																																				$date0 = new DateTime(date("Y-m-d"));
																																				date_modify($date0,"+1 week");
																																				echo date_format($date0,"Y-m-d");
																																			
																																			?>" min="<?php 
																																						
																																						$date = new DateTime(date("Y-m-d"));
																																						date_modify($date,"+1 week");
																																						echo date_format($date,"Y-m-d");
																																						//$date->modify('+1 week');
																																						//$minDate = $date->format('Y-m-d');
																																						//echo $minDate;
																																						
																																					?>" max="<?php 
																																								$CurDate = date("Y-m-d"); //Current date.
																																								$check = false;
																																								$dateNeeded=null;
																																								
																																								//GET END OF TERM DATE
																																								$querySY="SELECT * FROM thesis.schoolyear order by SchoolYearID asc";
																																								$resultSY=mysqli_query($dbc,$querySY);
																																								while($rowSY=mysqli_fetch_array($resultSY, MYSQLI_ASSOC)){
																																									if($CurDate<$rowSY['Term1End']&&$check==false){
																																										$dateNeeded=$rowSY['Term1End'];
																																										$check = true;
																																									}
																																									elseif($CurDate<$rowSY['Term2End']&&$check==false){
																																										$dateNeeded=$rowSY['Term2End'];
																																										$check = true;
																																									}
																																									elseif($CurDate<$rowSY['Term3End']&&$check==false){
																																										$dateNeeded=$rowSY['Term3End'];
																																										$check = true;
																																									}
																																								}
																																																					
																																								$date1 = new DateTime($dateNeeded);
																																								date_modify($date1,"-1 week");
																																								echo date_format($date1,"Y-m-d");
																																								//$date->modify('-1 week');
																																								//$finDate = $date->format('Y-m-d');
																																								//echo $finDate;
																																																						
																																							?>" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group ">
                                                        <label for="dateNeeded" class="control-label col-lg-3">Room</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control" name="room" id="room">
                                                                <option>Select</option>
                                                                <?php
 
                                                                                $sql = "SELECT fr.FloorAndRoomID, fr.floorRoom FROM department_list dl
                                                                                JOIN employee e ON dl.employeeid = e.employeeID
                                                                                JOIN department d ON dl.DepartmentID = d.DepartmentID
                                                                                JOIN departmentownsroom dor ON d.DepartmentID = dor.DepartmentID
                                                                                JOIN floorandroom fr ON dor.FloorAndRoomID = fr.FloorAndRoomID
                                                                                JOIN user u ON e.userID = u.userID
                                                                                WHERE u.UserID = {$_SESSION['userID']}";

                                                                                $result = mysqli_query($dbc, $sql);

                                                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                                {
                                                                                    
                                                                                    echo "<option value ={$row['FloorAndRoomID']}>";
                                                                                    echo "{$row['floorRoom']}</option>";

                                                                                }
                                                                           ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group ">
                                                        <label for="building" class="control-label col-lg-3">Asset Description</label>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" rows="5" id="" name= "assetDescription" style="resize: none" placeholder="If you do not know what the asset is called, kindly describe the asset that you would like us to purchase for you."></textarea>
                                                            </div>
                                                        </div>
                                                     </div>
                                                    
                                                </section>

                                                <hr>
                                                 <h5>Instructions: Fill up all the fields in the table. If you wish to request for more assets, add another entry to the table. The start of the date needed is 1 week after the request and the latest you could order is 1 week before the end of the term.</h5>
                                                 <hr>

                                                <section>
                                                    <h4>Requested Services/Materials</h4>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity</th>
                                                                <th>Category</th>
                                                                <th>Specifications</th>
                                                                <th>Purpose</th>
                                                                <th>Remove</th>
                                                                <th>Add</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <input style="display: none" type="number" id="count" value=<?php echo $_SESSION['count'];?>/>
                                                                        <input class="form-control" type="number"  name="quantity0" id="quantity0" min="1" step="1" placeholder="Quantity" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" name="category0" id="category0">
                                                                            <option>Select</option>
                                                                            <?php
 
                                                                                $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                                                $result = mysqli_query($dbc, $sql);

                                                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                                {
                                                                                    
                                                                                    echo "<option value ={$row['assetCategoryID']}>";
                                                                                    echo "{$row['name']}</option>";

                                                                                }
                                                                           ?>
                                                                        </select>
                                                                    </div>
                                                                </td>

                                                                <td style="padding-top:5px; padding-bottom:5px">
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" type="text" name="description0" id="description0" placeholder="Item specifications" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" type="text" name="purpose0" id="purpose0" placeholder="Purpose">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                <button type='button' class='btn btn-primary' onclick='addTest();'> Add </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                    <br>
                                                </section>
                                                
                                                
                                                
                                                
												<section>
                                                    <input type="checkbox" name="isITTeamChooseSpecs" value="1"> Check the checkbox if you would like the IT Team to choose the closest specifications to your request in case the suppliers would not have assets that are the same as your specifications.
                                                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leave it unchecked if you yourself would like to choose the specifications that are the closest to your specifications.
                                                    <br><br><br>
                                                </section>

                                                
                                                
                                                
                                                
                                                
                                                
                                                <div class="form-group">
                                                    <div class="col-lg-offset-0 col-lg-8">
                                                        <button class="btn btn-primary" type="button"data-toggle="modal" data-target="#myModal">Save</button>
                                                        <button class="btn btn-default" type="button">Cancel</button>
                                                    </div>
                                                </div>


                                                <!-- Modal -->
                                                  <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">
                                                    
                                                      <!-- Modal content-->
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          <h4 class="modal-title">Confirmation</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                          <p>Are you sure about your request? Once you submit, this cannot be changed.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary" type="submit" onclick="getData('tblRequest');">Save</button>
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                      </div>
                                                      
                                                    </div>
                                                  </div>
                                                <!-- Modal End-->

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
        var count = 1;
		// Shorthand for $( document ).ready()
        $(function() {

        });


        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }

        function addTest() {


           
            var row_index = 0;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }
		
		
        var appendTableRow = function(rowCount) {

             $("#count").val(count);

            var tr = 
                
                            "<tr>" +
                                    "<td>" +
                                       " <div class='col-lg-12'>" +
                                            "<input class='form-control' type='number' id='quantity"+count+"' name = 'quantity"+count+"' min='1'" + "step='1' placeholder='Quantity' />" +
                                        "</div>" +
                                    "</td>" +
                                    "<td>" +
                                        "<div class='col-lg-12'>" +
                                            "<select class='form-control' id='category"+count+"' name = 'category"+count+"'>" +
                                                "<option>Select</option>" +

                                                '<?php

                                                    $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                    $result = mysqli_query($dbc, $sql);

                                                    $_SESSION['count'] += 1;

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                        
                                                        echo "<option value ={$row['assetCategoryID']}>";
                                                        echo "{$row['name']}</option>";

                                                    }
                                                ?>'

                                            +"</select>" +
                                        "</div>" +
                                    "</td>" +
                                    "<td style='padding-top:5px; padding-bottom:5px'>" +
                                        "<div class='col-lg-12'>" +
                    "<input class='form-control' type='text' id='description"+count+"' name ='description"+count+"' placeholder='Item description' />" +
                                        "</div>" +
                                    "</td>" +

"<td style='padding-top:5px; padding-bottom:5px'>" +
                                        "<div class='col-lg-12'>" +
                    "<input class='form-control' type='text' id='purpose"+count+"' name ='purpose"+count+"' placeholder='Purpose' />" +
                                        "</div>" +

                                    "<td>" +
        "<button id='remove' class='btn btn-danger' type='button' onClick='removeRow(this)'>Remove</button>" +
                                    "</td>" +
                                    "<td>" +
                                    "</td>" +
                                    "</tr>"
				
				
				
				
            $('#tableTest tbody tr').eq(rowCount).after(tr);

            count++;

             $.ajax({
            type:"POST",
            url:"count.php",
            data: 'count='+count,
            success: function(data){
                $("#count").html(data);

                }
            });
			
        }
			function getRooms(val){
            $.ajax({
            type:"POST",
            url:"requestor_getRooms.php",
            data: 'buildingID='+val,
            success: function(data){
                $("#FloorAndRoomID").html(data);

                }
            });
        }
	</script>

</body>

</html>