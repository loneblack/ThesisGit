<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
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
                    Welcome IT Officer!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        
                        <div class="row">


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
										<form method="post" id="formSend" action="it_mark_su_DB.php">
                                        <header class="panel-heading">
                                            Mark Assets for Service Units
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
                                                                <th>Item Category</th>
                                                                <th>Property Code</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            //GET For Disposed ASSET 
                                                            $queryAsset="SELECT *, b.name as 'brand', ac.name as 'assetCategory' FROM thesis.asset a
                                                                            JOIN assetmodel m
                                                                        ON a.assetModel = m.assetModelID
                                                                            JOIN ref_brand b
                                                                        ON m.brand = b.brandID
                                                                            JOIN ref_assetcategory ac
                                                                        ON m.assetCategory = ac.assetCategoryID
                                                                            WHERE assetStatus = 1
                                                                            AND isServiceUnit != 1;";
                                                            $resultAsset=mysqli_query($dbc,$queryAsset);
                                                            while($rowAsset=mysqli_fetch_array($resultAsset,MYSQLI_ASSOC)){
                                                                echo "<tr class='gradeX'>
                                                                    <td style='width:7px; text-align:center'><input type='checkbox' class='form-check-input' name='mark[]' id='exampleCheck1' value='{$rowAsset['assetID']}'></td>
                                                                    <td>{$rowAsset['name']}</td>
                                                                    <td>{$rowAsset['propertyCode']}</td>
                                                                    <td>{$rowAsset['brand']} {$rowAsset['itemSpecification']}</td>
                                                                </tr>";
                                                            }
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                            <div style="padding-left:10px; padding-bottom:10px">
                                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                                <button type="button" onclick="window.history.back()" class="btn btn-secondary">Back</button>
                                            </div>
										</form>
                                    </section>
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


    <!-- WAG GALAWIN PLS LANG -->
	
	<script>
	function Confirm() {
		document.getElementById("formSend").submit();
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