<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once('db/mysql_connect.php');

$_SESSION['previousPage'] = "requestor_service_request_form.php";

$userID = $_SESSION['userID'];

$sql = "SELECT * FROM `thesis`.`employee` WHERE UserID = {$userID};";//get the employeeID using userID
$result = mysqli_query($dbc, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $employeeID = $row['employeeID'];

}

 $sql1 = "SELECT a.assetID, propertyCode, b.name AS 'brand', c.name as 'category', itemSpecification, aa.statusID, s.id
            FROM thesis.assetassignment aa
                JOIN asset a 
            ON a.assetID = aa.assetID
                JOIN assetModel m
            ON assetModel = assetModelID
                JOIN ref_brand b
            ON brand = brandID
                JOIN ref_assetcategory c
            ON assetCategory = assetCategoryID
                JOIN ref_assetstatus s
            ON a.assetStatus = s.id
                WHERE (personresponsibleID = {$employeeID})
            AND (s.id = 2) AND (aa.statusID = 2);";

$result1 = mysqli_query($dbc, $sql1);

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

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <!-- Custom styles for this template -->
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
                                        Repair Request Form
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_request_form_DB.php">
                                                <div class="form-group ">
                                                    <?php
                                                        if (isset($_SESSION['submitMessage'])){

                                                            echo "<div style='text-align:center' class='alert alert-success'>
                                                                    <strong><h3>{$_SESSION['submitMessage']}</h3></strong>
                                                                  </div>";

                                                            unset($_SESSION['submitMessage']);
                                                        }
                                                    ?>
                                                    <!--
                                                    <div class="col-lg-6">

                                                        <div id="asset" style="padding-left:400px">
                                                            ** Place Asset on Right for Repair
                                                            <select class="multi-select" multiple="" name = "assets[]" id="my_multi_select3">
                                                                <?php
                                                                    
                                                                    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC))
                                                                    {
                                                                        
                                                                        echo "<option value ={$row['assetID']}>";
                                                                        echo "{$row['propertyCode']} ";
                                                                        echo "{$row['brand']} ";
                                                                        echo "{$row['category']} ";
                                                                        echo "{$row['itemSpecification']} ";
                                                                        echo "</option>";

                                                                    }
                                                               ?>
                                                            </select>
                                                        </div>
                                                    </div>
-->
                                                </div>
                                                <h4>Instructions: Write down a summary of the issue with the asset that needs to be repaired and on the table check the asset that needs to be repaired</h4>
                                                <div class="form-group ">
                                                    <label for="details" class="control-label col-lg-3">Description of the Problem</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="5" name="details" style="resize:none" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3"> </label>
                                                    <div class="col-lg-6">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Category</th>
                                                                    <th>Property Code</th>
                                                                    <th>Brand</th>
                                                                    <th>Model</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="checkbox"></td>
                                                                    <td>Laptop</td>
                                                                    <td>PC-0001</td>
                                                                    <td>Samsung</td>
                                                                    <td>GTX-1080</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-primary" type="submit">Send</button>
                                                        <a href="requestor_dashboard.php"><button class="btn btn-default" type="button">Cancel</button></a>
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
        function checkvalue(val) {
            if (val === "29") {
                document.getElementById('others').style.display = 'block';
                document.getElementById('asset').style.display = 'none';
            }
            if (val === "27") {
                document.getElementById('asset').style.display = 'block';
                document.getElementById('others').style.display = 'none';
            }
            if (val != "29" && val != "27") {
                document.getElementById('others').style.display = 'none';
                document.getElementById('asset').style.display = 'none';
            }
        }
    </script>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script src="js/bootstrap-switch.js"></script>

    <script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

    <script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

    <script src="js/select2/select2.js"></script>
    <script src="js/select-init.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/toggle-init.js"></script>

    <script src="js/advanced-form.js"></script>
    <script src="js/dynamic_table_init.js"></script>

</body>

</html>