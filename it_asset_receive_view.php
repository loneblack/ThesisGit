<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
$id = $_GET['id'];

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
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="col-sm-12">
                    <div class="col-sm-12">

                        <div class="row">


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <form action="it_asset_receive_view_DB.php" method="post">
                                        <header class="panel-heading">
                                            Receive Assets from User
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">

                                            <h4>Requestor: </h4>
                                            <h4>Date: </h4>
                                            <hr>

                                            <div class="adv-table">
                                                    
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Property Code</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Expected Return Date</th>
                                                        <th>Status</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                    $query = "  SELECT *, b.name as 'brandName', ac.name as 'categoryName', asts.description as 'statusName',  am.description as 'modelName'
                                                                FROM thesis.assetreturndetails ard 
                                                                JOIN assetreturn ar ON ar.assetReturnID = ard.assetReturnID
                                                                JOIN asset a ON ard.assetID = a.assetID
                                                                JOIN assetassignment aa ON aa.assetID = a.assetID
                                                                JOIN assetmodel am ON a.assetModel = am.assetModelID
                                                                JOIN ref_assetcategory ac ON am.assetCategory = ac.assetCategoryID
                                                                JOIN ref_brand b ON am.brand = b.brandID
                                                                JOIN ref_assetStatus asts ON a.assetStatus = asts.id
                                                                WHERE ard.assetReturnID = '{$id}';";
                                                    $result = mysqli_query($dbc, $query);

                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                    {
                                                         $checkbox = "";
                                                        if($row['received'] == 1){
                                                            $checkbox = "checked disabled";
                                                        }

                                                    ?>
                                                    <tr>
                                                    <td>
                                                        <input type="checkbox" name="assets[]" value ="<?php echo $row['assetID']; ?>" <?php echo $checkbox; ?> >
                                                        <input type="hidden" name="assets[]" value ="0">
                                                    </td>
                                                    <td>
                                                        <?php echo $row['propertyCode']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['brandName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['modelName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['endDate']; ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                     if ($row['isWorking'] == 1) 
                                                    {
                                                        echo "Working";
                                                    }else{
                                                        echo "Damaged";
                                                    }  
                                                    ?>
                                                    <input type="hidden" name="isWorking[]" value ="<?php echo $row['isWorking']; ?>">
                                                    <input type="hidden" name="received[]" value ="<?php echo $row['received']; ?>">
                                                    </td>
                                                    <td>
                                                        <input style="width:100%" class="form-control" type="text" name="comments[]" value = "<?php echo $row['comments']; ?>" readonly>
                                                    </th>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                                </table>
                                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:5px">
                                            <button type="submit" class="btn btn-success">Checkin</button>
                                            <a href="it_asset_receive.php"><button type="button" class="btn btn-danger">Back</button></a>
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