<!DOCTYPE html>
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

                <div class="row">
                    <div class="col-sm-12">


                        <section class="panel">
                            <header class="panel-heading">
                                Build A Desktop or Thin Client
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form class="form-horizontal" role="form" method="POST" action="">

                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label">Asset Category</label>
                                            <div class="col-lg-10">
                                                <select class="form-control m-bot15">
                                                    <option name="assetCat" id="assetCat">Select Asset Category</option>
                                                    <option value="13">Desktop</option>
                                                    <option value="46">Thin Client</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-primary" onclick="addTest(5)"> Add </button>
                                        </div>

                                        <table class="table table-bordered table-striped table-condensed table-hover" id="addTable">
                                            <thead>
                                                <tr>
                                                    <th>Property Code</th>
                                                    <th>Asset Category</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Specifications</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '1' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '23' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Monitor</td>
                                                    <?php
                                                        
                                                        $count = 1;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '2' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '18' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Keyboard</td>
                                                    <?php
                                                        
                                                        $count = 2;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '3' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '25' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Mouse</td>
                                                    <?php
                                                        
                                                        $count = 3;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '4' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '22' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>RAM</td>
                                                    
                                                    <?php
                                                        
                                                        $count = 4;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '5' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '17' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>HDD</td>
                                                    <?php
                                                        
                                                        $count = 5;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>
                                                
                                                
                                                
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '6' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '49' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Graphics Card</td>
                                                    <?php
                                                        
                                                        $count = 6;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '7' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '34' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Processor</td>
                                                    <?php
                                                        
                                                        $count = 7;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '8' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '24' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Motherboard</td>
                                                    <?php
                                                        
                                                        $count = 8;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '9' class='form-control' onchange='loadDetails(this.value, this.id)' required><option value=''>Select Property Code</option>";

                                                        $sql = "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description
                                                                FROM asset a 
                                                                    JOIN assetModel m
                                                                ON assetModel = assetModelID
                                                                    JOIN ref_brand br
                                                                ON brand = brandID
                                                                    JOIN ref_assetcategory c
                                                                ON assetCategory = assetCategoryID
                                                                    WHERE assetCategoryID = '32' AND a.assetStatus = 1;";

                                                        $result = mysqli_query($dbc, $sql);


                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Power Supply</td>
                                                    <?php
                                                        
                                                        $count = 9;
                                                        $query="SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', itemSpecification, m.description as'modelDescription'
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            WHERE assetCategoryID = '1';";
                                                        $result=mysqli_query($dbc,$query);

                                                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        
                                                        echo
                                                            "<td id='brand".$count."'>
                                                                    <input class='form-control' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  disabled>
                                                                </td>";

                                                    ?>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>



                                        <div class="clearfix">
                                            <div class="btn-group">
                                                <button class="btn btn-success">
                                                    <i class="fa fa-check"></i> Submit
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-danger" onClick="window.location.href = 'it_all_compound_assets.php'">
                                                    Back
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>



                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script type="text/javascript" src="js/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <!--script for this page only-->
    <script src="js/table-editable.js"></script>

    <!-- END JAVASCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            EditableTable.init();
        });
    </script>

    <script type="text/javascript">
        // Shorthand for $( document ).ready()
        $(function() {

        });




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
            var cnt = 0
            var tr = "<tr>" +
                "<td><input type='number' class='form-control' min='0.00' required></td>" +
                "<td>" +
                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                " <option>Select Brand</option>" +
                "<option>Samsung</option>" +
                "<option>Huawei" +
                "<option>LG</option>" +
                "</select>" +
                "</td>" +
                "<td>" +
                "<select class='form-control' id='exampleFormControlSelect1' required>" +
                " <option>Select Model</option>" +
                "<option>S9</option>" +
                "<option>Iphone X" +
                "<option>Nova 2</option>" +
                "</select>" +
                "</td>" +
                "<td><button class='btn btn-danger' onclick='deleteTest(this)'> Delete </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }

        function deleteTest(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("tableTest").deleteRow(i);
        }
        
        function loadDetails(val, id){
            
            $.ajax({
            type:"POST",
            url:"loadDetails1.php",
            data: 'assetID='+val,
            success: function(data){
                $("#brand"+id).html(data);

                }
            });
            $.ajax({
            type:"POST",
            url:"loadDetails2.php",
            data: 'assetID='+val,
            success: function(data){
                $("#description"+id).html(data);

                }
            });
            $.ajax({
            type:"POST",
            url:"loadDetails3.php",
            data: 'assetID='+val,
            success: function(data){
                $("#specification"+id).html(data);

                }
            });
            $.ajax({
            type:"POST",
            url:"loadDetails4.php",
            data: 'assetID='+val,
            success: function(data){
                $("#assetID"+id).html(data);

                }
            });
        }
    </script>

</body>

</html>