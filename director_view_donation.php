<!DOCTYPE html>

<html lang="en">

<?php
session_start();
require_once("db/mysql_connect.php");
$donationID=$_GET['donationid'];

//GET ALL DONATION DATA
$queryDon="SELECT * FROM thesis.donation where donationID='{$donationID}';";
$resultDon=mysqli_query($dbc,$queryDon);
$rowDon=mysqli_fetch_array($resultDon,MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Request For Donation Outsider</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/outside_form.css" rel="stylesheet" />
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
        <?php include 'director_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <div class="panel-body">
                                        <div class="container">
                                            <form id="contact" action="" method="post" class="col-lg-18">
                                                <h3>Request For Donation</h3>
                                                <fieldset>
													<label for="building" class="control-label col-lg-6">School / Organization</label>
                                                    <input id="schoolorg" name="schoolorg" class="form-control" placeholder="School / Organization" type="text" onkeyup="lettersOnly(this)" disabled value='<?php echo $rowDon['schoolName']; ?>'>
                                                </fieldset>			
												<br>
                                                <fieldset>
													<label for="building" class="control-label col-lg-6">Contact Person</label>
                                                    <input id="contactPerson" name="contactPerson" class="form-control" placeholder="Contact Person" type="text" onkeyup="lettersOnly(this)" disabled value='<?php echo $rowDon['contactPerson']; ?>'>
                                                </fieldset>
												<br>
                                                <fieldset>
													<label for="building" class="control-label col-lg-6">Contact No.</label>
                                                    <input id="contactNo" name="contactNo" class="form-control" placeholder="Contact No." type="text" disabled value='<?php echo $rowDon['contactNumber']; ?>'>
                                                </fieldset>
												<br>
                                                <fieldset>
													<label for="building" class="control-label col-lg-6">Date and Time Needed</label>
                                                    <input id="dateNeeded" name="dateNeeded" class="form-control" type="datetime-local" placeholder="Date and Time Needed" disabled value='<?php 
														$date = new DateTime($rowDon['dateNeed']);
														echo date_format($date,"Y-m-d\TH:i:s");
													 ?>' />
                                                </fieldset><br>
                                                <fieldset>
													<label for="building" class="control-label col-lg-6">Purpose</label>
                                                    <input id="purpose" name="purpose" class="form-control" placeholder="Purpose" type="text" onkeyup="lettersOnly(this)" disabled value='<?php echo $rowDon['purpose']; ?>' >
                                                </fieldset><br>
                                                <fieldset>
													<label for="building" class="control-label col-lg-6">Assets to be Donated</label>
                                                    <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest" align="center" cellpadding="0" cellspacing="0" border="1" required>
                                                        <thead>
                                                            <tr>
                                                                <th style="width:500px">Equipment</th>
                                                                <th style="width:150px">Quantity</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															<?php
																//GET ALL DONATION DETAILS DATA
																$queryDonDet="SELECT dd.quantity,rac.name as `assetCat` FROM thesis.donationdetails dd join ref_assetcategory rac on dd.assetCategoryID=rac.assetCategoryID where dd.donationID='{$donationID}'";
																$resultDonDet=mysqli_query($dbc,$queryDonDet);
																while($rowDonDet=mysqli_fetch_array($resultDonDet,MYSQLI_ASSOC)){
																	echo "<tr>
																			<td>
																				<select class='form-control' id='txtName' disabled>
																				<option selected>{$rowDonDet['assetCat']}</option>
																				</select>
																			</td>
																			<td><input class='form-control' type='number' id='txtCountry' value='{$rowDonDet['quantity']}' disabled /></td>
																			</tr>";
																}
															?>
                                                            
                                                        </tbody>
                                                    </table>
                                                </fieldset>
                                               <br>
											   <?php
													if($rowDon['statusID']=='6'){
														echo "<fieldset>
															<label for='reasForDisapprov' class='control-label col-lg-6'>Reason For Disapproval</label>
															<textarea class='form-control' rows='5' id='comment' name='reason' style='resize:none' disabled>{$rowDon['reason']}</textarea>
															
														</fieldset>
														<br>";
													}
											   
											   
											   
											   ?>
                                                
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

    <!-- WAG BAGUHIN ANG BABA PLS LANG -->

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            //Build an array containing Customer records.
            var customers = new Array();


            //Add the data rows.
            for (var i = 0; i < customers.length; i++) {
                AddRow(customers[i][0], customers[i][1]);
            }
        };
		
		function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
		
		function Add() {
            var row_index = 0;
			var isRenderd = false;
			$("td").click(function() {
                row_index = $(this).parent().index();
            });
            var delayInMilliseconds = 300; //1 second
			setTimeout(function() {
                appendTableRow(row_index);
            }, delayInMilliseconds);
           
		};
		
		 var appendTableRow = function(rowCount) {
            var cnt = 0;
            var tr = "<tr>" +
                     "<td><select class='form-control' id='txtName' name='assetCategory[]' required>" +
                     "<option value=\"\">Select</option>" +
					 '<?php
					  $sql = "SELECT * FROM thesis.ref_assetcategory;";
                      $result = mysqli_query($dbc, $sql);
					  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                      {   
                        echo "<option value ={$row['assetCategoryID']}>";
                        echo "{$row['name']}</option>";
                      }
					 ?>' 
                     + "</select></td>" 
                     + "<td><input class='form-control' type='number' min='1' id='txtCountry' name='qty[]' required /></td>" 
					 + "<td>" 
					 + "<button id='remove' class='btn btn-danger' type='button' onClick='removeRow(this)'>Remove</button>" 
                     + "</td>" 
                     + "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
							
        }


        function Remove(button) {
            //Determine the reference of the Row using the Button.
            var row = button.parentNode.parentNode;
            var name = row.getElementsByTagName("TD")[0].innerHTML;
            if (confirm("Remove: " + name)) {

                //Get the reference of the Table.
                var table = document.getElementById("tblCustomers");

                //Delete the Table row using it's Index.
                table.deleteRow(row.rowIndex);
            }
        };

        function lettersOnly(input){
            var regex = /[^a-z, , 0-9, &, #, @, %, *]/gi;
            input.value = input.value.replace(regex, "");
        }
        
    </script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>