<!DOCTYPE html>
<html lang="en">

<?php 
    session_start();
    require_once('db/mysql_connect.php');
    
    
    if (isset($_POST['checkin'])){
        if(!empty($_POST['check'])){
            
            foreach (array_combine($keys, $vars) as $key => $var){
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
                                                            $query="SELECT a.assetID, a.propertyCode, rb.name AS `brand`, am.description AS `model`, am.itemSpecification, rac.name AS `category`, ras.description, e.name AS `employee`, b.name AS `building`, fr.floorRoom FROM asset a 
                                                            LEFT JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                            LEFT JOIN ref_brand rb ON am.brand = rb.brandID
                                                            LEFT JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID
                                                            LEFT JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                            LEFT JOIN assetassignment aa ON a.assetID = aa.assetID
                                                            LEFT JOIN employee e ON aa.personresponsibleID = e.employeeID
                                                            LEFT JOIN building b ON aa.BuildingID = b.BuildingID
                                                            LEFT JOIN floorandroom fr ON aa.FloorAndRoomID = fr.FloorAndRoomID
                                                            WHERE (rac.name = 'laptop' OR rac.name = 'VGA Cable' OR rac.name='Projector' OR rac.name='Cable' OR rac.name = 'HDMI') AND ras.id = 2;";
                                                            $result=mysqli_query($dbc,$query);

                                                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
																
                                                                echo "<tr>
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
                document.getElementById(x).disabled = true;

            }
            //Escalate stat
            else if (document.getElementById(selectID).value == "9") {
                //comments
                document.getElementById(x).disabled = false;

            } else {
                //comments
                document.getElementById(x).disabled = true;

            }
        }

        function change(x, y) {
            var selectID = "assetStatus_" + x;

            //Is Checked
            if (y.checked == true) {
                //comments
                document.getElementById(selectID).disabled = false;

            }
            //Unchecked
            if (y.checked == false) {
                //comments
                document.getElementById(selectID).disabled = true;

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