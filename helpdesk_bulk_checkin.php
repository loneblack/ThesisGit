<!DOCTYPE html>
<html lang="en">

<?php 
    session_start();
    require_once('db/mysql_connect.php');
    $userID = $_SESSION['userID'];
    
    $today = date('Y/m/d');
    
    if (isset($_POST['checkin'])){
        if(!empty($_POST['check'])){
            $check = $_POST['check'];
            $status = $_POST['status'];
            $comment = $_POST['comment'];
            
            $mi = new MultipleIterator();
            $mi->attachIterator(new ArrayIterator($check));
            $mi->attachIterator(new ArrayIterator($status));
            $mi->attachIterator(new ArrayIterator($comment));
            
            foreach($mi as $value){
                list($check, $status, $comment) = $value;
                $getUser="SELECT * FROM assetassignment WHERE assetID = {$check} AND statusID = 2;";
                $resultGetUser=mysqli_query($dbc,$getUser); 
                $rowGetUser = mysqli_fetch_array($resultGetUser, MYSQLI_ASSOC);
                
                
                if($status == '1'){
                    $queryAsset="UPDATE asset SET assetStatus = 1 WHERE assetID = {$check};";
					$resultAsset=mysqli_query($dbc,$queryAsset);      
                    
                    $queryInsertAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetAssignmentID`, `assetStatus`) VALUES ('{$rowGetUser['personresponsibleID']}', '{$today}', '{$check}', '{$rowGetUser['AssetAssignmentID']}', '1');";
					$resultInsertAudit=mysqli_query($dbc,$queryInsertAudit);      
                }
                
                elseif($status == '18'){
                    $queryAssetLost="UPDATE asset SET assetStatus = 18 WHERE assetID = {$check};";
					$resultAssetLost=mysqli_query($dbc,$queryAssetLost);    
                    
                    $queryInsertAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetAssignmentID`, `assetStatus`) VALUES ('{$rowGetUser['personresponsibleID']}', '{$today}', '{$check}', '{$rowGetUser['AssetAssignmentID']}', '18');";
					$resultInsertAudit=mysqli_query($dbc,$queryInsertAudit);  
                }
                
                else{
                    $queryAssetBroken="INSERT INTO `thesis`.`service` (`details`, `dateReceived`, `UserID`, `serviceType`, `status`, `steps`, `replacementUnit`) VALUES ('{$comment}', '{$today}', '{$userID}', '27', '1', '14', '0');";
					$resultAssetBroken=mysqli_query($dbc,$queryAssetBroken);
                    
                    $queryAssetLost="UPDATE asset SET assetStatus = 9 WHERE assetID = {$check};";
					$resultAssetLost=mysqli_query($dbc,$queryAssetLost);    
                    
                    $sql1 = "SELECT MAX(id) as 'id' FROM thesis.service;";//status is set to 1 for pending status

	               $result1 = mysqli_query($dbc, $sql1);
                    $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                    $id = $row['id'];
                    
                    $query = "INSERT INTO `thesis`.`servicedetails` (`serviceID`, `asset`) VALUES ('{$id}', '{$check}');";
	    	        $resulted = mysqli_query($dbc, $query);
                    
                    $queryInsertAudit="INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetAssignmentID`, `assetStatus`) VALUES ('{$rowGetUser['personresponsibleID']}', '{$today}', '{$check}', '{$rowGetUser['AssetAssignmentID']}', '9');";
					$resultInsertAudit=mysqli_query($dbc,$queryInsertAudit);  
                }
                
                
            }
            
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
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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
                <form method="POST" action="">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <div class="row">


                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">
                                            <header class="panel-heading">
                                                Asset Checkin
                                                <span class="tools pull-right">
                                                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                                                </span>
                                            </header>
                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th class="hidden"></th>
                                                                <th></th>
                                                                <th>Property Code</th>
                                                                <th>Brand</th>
                                                                <th>Model</th>
                                                                <th>Asset Specifications</th>
                                                                <th>Asset Category</th>
                                                                <th>Checked Out To</th>
                                                                <th>Status</th>
                                                                <th>Comments</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $query="SELECT e.UserID, a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model`, am.itemSpecification, rac.name AS `category`, ras.description, e.name AS `employee`, b.name AS `building`, fr.floorRoom FROM asset a 
                                                            LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                            LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                            LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                            LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                            LEFT JOIN assetassignment aa ON a.assetID = aa.assetID
                                                            LEFT JOIN employee e ON aa.personresponsibleID = e.employeeID
                                                            LEFT JOIN building b ON aa.BuildingID = b.BuildingID
                                                            LEFT JOIN floorandroom fr ON aa.FloorAndRoomID = fr.FloorAndRoomID
                                                            WHERE (rac.name = 'Laptop' OR rac.name = 'VGA Cable' OR rac.name='Projector' OR rac.name = 'HDMI Cable' OR rac.name = 'Extension') AND ras.id = 2
                                                            AND aa.personresponsibleID IS NOT NULL
                                                            GROUP BY a.assetID;";
                                                            $result=mysqli_query($dbc,$query);

                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
																
                                                                echo "<tr>
                                                                    <td class='hidden'>
                                                                    <input type='hidden' name='assID[]'  value='{$row['assetID']}'  disabled>
                                                                    </td>
                                                                    
                                                                    <td><input type='checkbox' name='check[]' value='{$row['assetID']}' onChange='change(\"{$row['assetID']}\",this);'></td>
                                                                    <td>{$row['propertyCode']}</td>
                                                                    <td>{$row['brand']}</td>
                                                                    <td>{$row['model']}</td>
                                                                    <td>{$row['itemSpecification']}</td>
                                                                    <td>{$row['category']}</td>
                                                                    <td>{$row['employee']}</td>
                                                                    <td>
                                                                        <select class='form-control' name='status[]' id='assetStatus_".$row['assetID']."' onChange='changetextbox(\"{$row['assetID']}\");' disabled>
                                                                            <option value='1'>Returned - Working</option>
                                                                            <option value='9'>Returned - Broken</option>
                                                                            <option value='18'>Missing</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type='text' class='form-control' name='comment[]' id='{$row['assetID']}' disabled></td>
                                                                    </tr>";
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="btn btn-success" name="checkin">Checkin</button>
                                            <button class="btn btn-danger" onclick="window.history.back()">Back</button>
                                        </section>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- page end-->
                </form>
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->
    <script type="text/javascript">
        function changetextbox(x) {
            var selectID = "assetStatus_" + x;

            //Working stat
            if (document.getElementById(selectID).value == "1") {
                //comments
                document.getElementById(x).readOnly = true;

            }
            //Escalate stat
            else if (document.getElementById(selectID).value == "9") {
                //comments
                document.getElementById(x).readOnly = false;

            } else {
                //comments
                document.getElementById(x).readOnly = true;

            }
        }

        function change(x, y) {
            var selectID = "assetStatus_" + x;
            var userID = "user_" + x;

            //Is Checked
            if (y.checked == true) {
                //comments
                document.getElementById(selectID).disabled = false;
                document.getElementById(x).disabled = false;
                document.getElementById(x).readOnly = true;

            }
            //Unchecked
            if (y.checked == false) {
                //comments
                document.getElementById(selectID).disabled = true;
                document.getElementById(x).disabled = true;
                document.getElementById(x).readOnly = false;

            }
        }
    </script>

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/morris-chart/morris.js"></script>
    <script src="js/morris-chart/raphael-min.js"></script>
    <script src="js/morris.init.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>

</body>

</html>