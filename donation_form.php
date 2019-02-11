<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require_once("db/mysql_connect.php");
  
if(isset($_POST['save'])){
	$schoolorg=$_POST['schoolorg'];
	$contactPerson=$_POST['contactPerson'];
	$contactNo=$_POST['contactNo'];
	$dateNeeded=$_POST['dateNeeded'];
    $purpose = $_POST['purpose'];
    $assetCategory=$_POST['assetCategory'];
	$quantity=$_POST['qty'];
    
    //INSERT TO DONATION TABLE
    $queryDon = "INSERT INTO `thesis`.`donation` (`contactNumber`, `dateNeed`, `dateCreated`, `purpose`, `schoolName`, `contactPerson`, `statusID`, `stepsID`) VALUES ('{$contactNo}', '{$dateNeeded}', now(), '{$purpose}', '{$schoolorg}', '{$contactPerson}', '1', '1')";
    $resultDon = mysqli_query($dbc, $queryDon);

	
	//GET DONATION ID
    $queryDonID = "SELECT * FROM thesis.donation order by donationID desc limit 1;";
    $resultDonID = mysqli_query($dbc, $queryDonID);
    $rowDonID = mysqli_fetch_array($resultDonID, MYSQLI_ASSOC);

    foreach (array_combine($assetCategory, $quantity) as $assetCat => $qty)
    {
        //INSERT TO DONATIONDETAILS TABLE
        $queryDonDet = "INSERT INTO `thesis`.`donationdetails` (`donationID`, `assetCategoryID`, `quantity`) VALUES ('{$rowDonID['donationID']}', '{$assetCat}', '{$qty}');";
        $resultDonDet = mysqli_query($dbc, $queryDonDet);

        
    }
	echo "<script>alert('Success');</script>";
}
?>    
    
    
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
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

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="full-width">

    <section id="container" class="hr-menu">
        <!--header start-->

        <section id="main-content">
            <section class="wrapper">
                <div class="panel-body">
                    <div class="container">
                        <form id="contact" action="" method="post">
                            <h3>Request For Donation</h3>
                            <fieldset>
                                <input id="schoolorg" name="schoolorg" class="form-control" placeholder="School / Organization" type="text" onkeyup="lettersOnly(this)" required>
                            </fieldset>
                            <fieldset>
                                <input id="contactPerson" name="contactPerson" class="form-control" placeholder="Contact Person" type="text" onkeyup="lettersOnly(this)" required>
                            </fieldset>
                            <fieldset>
                                <input id="contactNo" name="contactNo" class="form-control" placeholder="Contact No." type="text" required>
                            </fieldset>
                            <fieldset>
                                <input id="dateNeeded" name="dateNeeded" class="form-control" type="datetime-local" placeholder="Date and Time Needed" required />
                            </fieldset>
                            <fieldset>
                                <input id="purpose" name="purpose" class="form-control" placeholder="Purpose" type="text"  onkeyup="lettersOnly(this)" required>
                            </fieldset>
                            <fieldset>
                                <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest" align="center" cellpadding="0" cellspacing="0" border="1" required>
                                                        <thead>
                                                            <tr>
                                                                <th style="width:500px">Equipment</th>
                                                                <th style="width:150px">Quantity</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
														<tr>
                                                            <td>
                                                                <select class="form-control" id="txtName" name="assetCategory[]" required>
                                                                    <option value="">Select</option>
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
                                                            </td>
                                                            <td><input class="form-control" type="number" min="1" id="txtCountry" name="qty[]" required /></td>
                                                            <td style="text-align:center"><input class="btn btn-primary" type="button" onclick="Add()" value="Add" /></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>  
                                                        </tfoot>
                                                    </table>
                            </fieldset>
                            <fieldset>
                                <button id="save" name="save" class="btn btn-success" type="submit">Submit</button>
                            </fieldset>
                            <fieldset>
                                <button class="btn btn-danger" type="submit" onclick="window.location.href='login.php'">Back</button>
                            </fieldset>

                        </form>
                    </div>

                </div>
            </section>
        </section>
    </section>

    <!-- Placed js at the end of the document so the pages load faster -->
    
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

    
    
    
    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/hover-dropdown.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <!--Easy Pie Chart-->
    <script src="js/easypiechart/jquery.easypiechart.js"></script>
    <!--Sparkline Chart-->
    <script src="js/sparkline/jquery.sparkline.js"></script>
    <!--jQuery Flot Chart-->
    <script src="js/flot-chart/jquery.flot.js"></script>
    <script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-chart/jquery.flot.resize.js"></script>
    <script src="js/flot-chart/jquery.flot.pie.resize.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>