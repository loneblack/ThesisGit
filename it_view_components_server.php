<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
	require_once("db/mysql_connect.php");
    
    $assID = $_GET['id'];
    $assStat = $_GET['assetStatus'];
    echo $assStat;
    
    $pcID = "SELECT computerID AS `pcID` FROM thesis.computer WHERE assetID = '{$assID}';";
    $resultpcID = mysqli_query($dbc, $pcID);
    $rowpcID=mysqli_fetch_array($resultpcID,MYSQLI_ASSOC);
    
    
    if(isset($_POST['submit'])){
                foreach($_POST['toStock'] as $stockTamod){
                    $updateAsset = "UPDATE `thesis`.`asset` SET `assetStatus` = '1' WHERE (`assetID` = '{$stockTamod}');";
                    $resultUpdateAsset = mysqli_query($dbc, $updateAsset);
                }
        
                $delPC = "DELETE FROM computercomponent WHERE computerID = {$rowpcID['pcID']};";
                $resultdelPC = mysqli_query($dbc, $delPC);
        
                foreach($_POST['component'] as $cumponent){
                    //insert to computer cum ponent tamod
                    $pasok = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$cumponent}', '{$rowpcID['pcID']}');";
                    $resultPasok = mysqli_query($dbc,$pasok);
                    
                    $updateAsset = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$cumponent}');";
                    $resultUpdateAsset = mysqli_query($dbc, $updateAsset);
                }
        
                if(isset($_POST['extraRAM']) && isset($_POST['extraHDD'])){
                    //insert to computer cum ponent tamod
                    $pasok1 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraRAM']}', '{$rowpcID['pcID']}');";
                    $resultPasok1 = mysqli_query($dbc,$pasok1);
                    
                    $updateAsset1 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraRAM']}');";
                    $resultUpdateAsset1 = mysqli_query($dbc, $updateAsset1);
                    
                    $pasok2 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraHDD']}', '{$rowpcID['pcID']}');";
                    $resultPasok2 = mysqli_query($dbc,$pasok2);
                    
                    $updateAsset2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraHDD']}');";
                    $resultUpdateAsset2 = mysqli_query($dbc, $updateAsset2);

                }
        
                elseif(isset($_POST['extraHDD'])){
                    $pasok2 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraHDD']}', '{$rowpcID['pcID']}');";
                    $resultPasok2 = mysqli_query($dbc,$pasok2);
                    
                    $updateAsset2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraHDD']}');";
                    $resultUpdateAsset2 = mysqli_query($dbc, $updateAsset2);

                }
        
                elseif(isset($_POST['extraRAM'])){
                    //insert to computer cum ponent tamod
                    $pasok1 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraRAM']}', '{$rowpcID['pcID']}');";
                    $resultPasok1 = mysqli_query($dbc,$pasok1);
                    
                    $updateAsset1 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraRAM']}');";
                    $resultUpdateAsset1 = mysqli_query($dbc, $updateAsset1);

                }
        
            $_SESSION['submitMessage'] = "Success! A new Server has been Created.";
        
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

                <?php
                   if (isset($_SESSION['submitMessage'])){
                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
                
                ?>

                <div class="row">
                    <div class="col-sm-12">


                        <section class="panel">
                            <header class="panel-heading">
                                View Server Components
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form class="form-horizontal" method="POST" action="" role="form">
                                        
                                        <div class="form-group">
                                            <?php 
                                            $assetCat="SELECT rac.name AS asscat FROM ref_assetcategory rac
                                                        JOIN assetmodel am ON am.assetcategory = rac.assetCategoryID
                                                        JOIN asset a ON a.assetModel = am.assetModelID
                                                        WHERE a.assetID = {$assID};";
                                            $resultassetCat=mysqli_query($dbc,$assetCat);
                                            $rowCountAssetCat=mysqli_fetch_array($resultassetCat,MYSQLI_ASSOC);
                                            
                                            ?>
                                            <label class="col-lg-2 col-sm-2 control-label">Asset Category</label>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" value="<?php echo $rowCountAssetCat['asscat'] ?>" readonly>
                                            </div>
                                        </div>

                                        <table class="table table-bordered table-striped table-condensed table-hover" id="addTable">
                                            <thead>
                                                <tr>
                                                    <th>Property Code</th>
                                                    <th>Asset Category</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Specifications</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width='220'>
                                                        <?php
    
                                                        $getRAM = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 22 LIMIT 1;";
                                                        $resultRAM=mysqli_query($dbc,$getRAM);
				                                        $rowCountRAM=mysqli_fetch_array($resultRAM,MYSQLI_ASSOC);
    
                
                                                        echo "<input type='hidden' id='inRAM' name='toStock[]' value='{$rowCountRAM['assetID']}' disabled> <select id= '1' class='form-control' name='component[]' onchange='loadDetails(this.value, this.id); updateRAM({$rowCountRAM['assetID']});' ";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo " required><option value='{$rowCountRAM['assetID']}'>{$rowCountRAM['propertyCode']}</option>";

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
                                                                    <input class='form-control' value='{$rowCountRAM['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountRAM['model']}'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountRAM['specs']}'  disabled>
                                                                </td>";

                                                    ?>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        
                                                        $getHDD = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 17 LIMIT 1;";
                                                        $resultHDD=mysqli_query($dbc,$getHDD);
				                                        $rowCountHDD=mysqli_fetch_array($resultHDD,MYSQLI_ASSOC);
                                                        
                                                        echo"<input type='hidden' id='inHDD' name='toStock[]' value='{$rowCountHDD['assetID']}' disabled> <select id= '2' class='form-control' name='component[]'  onchange='loadDetails(this.value, this.id); updateHDD({$rowCountHDD['assetID']});'";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo "  required><option value='{$rowCountHDD['assetID']}'>{$rowCountHDD['propertyCode']}</option>";

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
                                                                    <input class='form-control' value='{$rowCountHDD['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountHDD['model']}'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountHDD['specs']}'  disabled>
                                                                </td>";

                                                    ?>
                                                </tr>




                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        $getGC = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 49 LIMIT 1;";
                                                        
                                                        $resultGC=mysqli_query($dbc,$getGC);
				                                        $rowCountGC=mysqli_fetch_array($resultGC,MYSQLI_ASSOC);
                                                        
                                                        echo"<input type='hidden' id='inGC' name='toStock[]' value='{$rowCountGC['assetID']}' disabled> <select id= '3' class='form-control' name='component[]'  onchange='loadDetails(this.value, this.id); updateGC({$rowCountGC['assetID']});'";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo "  required><option value='{$rowCountGC['assetID']}'>{$rowCountGC['propertyCode']}</option>";

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
                                                                    <input class='form-control' value='{$rowCountGC['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountGC['model']}'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountGC['specs']}'  disabled>
                                                                </td>";

                                                    ?>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        $getP = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 34 LIMIT 1;";
                                                        
                                                        $resultP=mysqli_query($dbc,$getP);
				                                        $rowCountP=mysqli_fetch_array($resultP,MYSQLI_ASSOC);
                                                        
                                                        echo"<input type='hidden' id='inP' name='toStock[]' value='{$rowCountP['assetID']}' disabled> <select id= '4' class='form-control' name='component[]'  onchange='loadDetails(this.value, this.id); updateP({$rowCountP['assetID']});'";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo "  required><option value='{$rowCountP['assetID']}'>{$rowCountP['propertyCode']}</option>";

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
                                                                    <input class='form-control' value='{$rowCountP['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountP['model']}' disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountP['specs']}' disabled>
                                                                </td>";

                                                    ?>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        $getM = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 24 LIMIT 1;";
                                                        
                                                        $resultM=mysqli_query($dbc,$getM);
				                                        $rowCountM=mysqli_fetch_array($resultM,MYSQLI_ASSOC);
                                                        
                                                        
                                                        echo"<input type='hidden' id='inM' name='toStock[]' value='{$rowCountM['assetID']}' disabled> <select id= '5' class='form-control' name='component[]'  onchange='loadDetails(this.value, this.id); updateM({$rowCountM['assetID']});' ";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo "  required><option value='{$rowCountM['assetID']}'>{$rowCountM['propertyCode']}</option>";

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
                                                                    <input class='form-control' value='{$rowCountM['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountM['model']}'  disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control'  value='{$rowCountM['specs']}' disabled>
                                                                </td>";

                                                    ?>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        $getPS = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 32 LIMIT 1;";
                                                        
                                                        $resultPS=mysqli_query($dbc,$getPS);
				                                        $rowCountPS=mysqli_fetch_array($resultPS,MYSQLI_ASSOC);
                                                        
                                                        
                                                        echo"<input type='hidden' id='inPS' name='toStock[]' value='{$rowCountPS['assetID']}' disabled> <select id= '6' class='form-control' name='component[]'  onchange='loadDetails(this.value, this.id); updatePS({$rowCountPS['assetID']});' ";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo "  required><option value='{$rowCountPS['assetID']}'>{$rowCountPS['propertyCode']}</option>";

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
                                                        $getPS = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND am.assetCategory = 32 LIMIT 1;";
                                                        
                                                        $resultPS=mysqli_query($dbc,$getPS);
				                                        $rowCountPS=mysqli_fetch_array($resultPS,MYSQLI_ASSOC);
                                                            
                                                            
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
                                                                    <input class='form-control' value='{$rowCountPS['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control'  value='{$rowCountPS['model']}' disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountPS['specs']}' disabled>
                                                                </td>";

                                                    ?>
                                                </tr>



                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        $getARAM = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND aa.assetID != {$rowCountRAM['assetID']} AND am.assetCategory = 22 LIMIT 1;";
                                                        
                                                        $resultARAM=mysqli_query($dbc,$getARAM);
				                                        $rowCountARAM=mysqli_fetch_array($resultARAM,MYSQLI_ASSOC);
                                                        
                                                        
                                                        echo"<input type='hidden' id='inERAM' name='toStock[]' value='{$rowCountARAM['assetID']}' disabled> <select id= '7' class='form-control' onchange='loadDetails(this.value, this.id); updateARAM({$rowCountARAM['assetID']});' name='extraRAM' ";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo " ><option value='{$rowCountARAM['assetID']}'>{$rowCountARAM['propertyCode']}</option>";

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

                                                        echo "<option value=''>Select Asset</option>";
                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Additional RAM</td>

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
                                                                    <input class='form-control' value='{$rowCountARAM['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountARAM['model']}' disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountARAM['specs']}' disabled>
                                                                </td>";

                                                    ?>
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        $getAHDD = "SELECT aa.assetID, aa.propertyCode, am.assetCategory, rb.name AS `brand`,  am.description AS `model`, am.itemSpecification AS `specs` FROM asset a
                                                                JOIN computer c ON a.assetID = c.assetID
                                                                JOIN computercomponent cc ON c.computerID = cc.computerID
                                                                JOIN asset aa ON aa.assetID = cc.assetID
                                                                JOIN assetmodel am ON aa.assetmodel = am.assetModelID 
                                                                JOIN ref_brand rb ON am.brand = rb.brandID
                                                                    WHERE a.assetID = {$assID} AND aa.assetID != {$rowCountHDD['assetID']} AND am.assetCategory = 17 LIMIT 1;";
                                                        
                                                        $resultAHDD=mysqli_query($dbc,$getAHDD);
				                                        $rowCountAHDD=mysqli_fetch_array($resultAHDD,MYSQLI_ASSOC);
                                                        
                                                        echo"<input type='hidden' id='inEHDD' name='toStock[]' value='{$rowCountAHDD['assetID']}' disabled> <select id= '8' class='form-control' onchange='loadDetails(this.value, this.id); updateAHDD({$rowCountAHDD['assetID']});' name='extraHDD' ";
                                                       
                                                       if($assStat != 1){
                                                           echo "disabled";
                                                       }
                                                           
                                                       echo " ><option value='{$rowCountAHDD['assetID']}'>{$rowCountAHDD['propertyCode']}</option>";

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

                                                        echo "<option value=''>Select Asset</option>";
                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetID']}>";
                                                            echo "{$row['propertyCode']}</option>";
                                                        }
                                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);                                                            
                                                      
                                                        echo"</select>"
                                                    ?>
                                                    </td>
                                                    <td>Additional HDD</td>
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
                                                                    <input class='form-control' value='{$rowCountAHDD['brand']}' disabled>
                                                                </td>
                                                                <td id='description".$count."'>
                                                                    <input class='form-control' value='{$rowCountAHDD['model']}' disabled>
                                                                </td>
                                                                <td id='specification".$count."'>
                                                                    <input class='form-control' value='{$rowCountAHDD['specs']}' disabled>
                                                                </td>";

                                                    ?>
                                                </tr>




                                            </tbody>
                                        </table>



                                        <div class="clearfix">
                                            <div class="btn-group">
                                                <button class="btn btn-success" type="submit" name="submit" <?php if($assStat != 1){
                                                           echo "disabled";
                                                       } ?>>
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
        function loadDetails(val, id) {

            $.ajax({
                type: "POST",
                url: "loadDetails1.php",
                data: 'assetID=' + val,
                success: function(data) {
                    $("#brand" + id).html(data);

                }
            });
            $.ajax({
                type: "POST",
                url: "loadDetails2.php",
                data: 'assetID=' + val,
                success: function(data) {
                    $("#description" + id).html(data);

                }
            });
            $.ajax({
                type: "POST",
                url: "loadDetails3.php",
                data: 'assetID=' + val,
                success: function(data) {
                    $("#specification" + id).html(data);

                }
            });
            $.ajax({
                type: "POST",
                url: "loadDetails4.php",
                data: 'assetID=' + val,
                success: function(data) {
                    $("#assetID" + id).html(data);

                }
            });
        }
        
        
        function updateRAM(assID){
            var pwet = document.getElementById("1").value;
            
            if(assID != pwet){
                document.getElementById("inRAM").disabled = false;
            }
            
            else{
                document.getElementById("inRAM").disabled = true;
            }
        }
        
        
        function updateHDD(assID){
            var pwet = document.getElementById("2").value;
            
            if(assID != pwet){
                document.getElementById("inHDD").disabled = false;
            }
            
            else{
                document.getElementById("inHDD").disabled = true;
            }
        }
        
        function updateGC(assID){
            var pwet = document.getElementById("3").value;
            
            if(assID != pwet){
                document.getElementById("inGC").disabled = false;
            }
            
            else{
                document.getElementById("inGC").disabled = true;
            }
        }
        
        function updateP(assID){
            var pwet = document.getElementById("4").value;
            
            if(assID != pwet){
                document.getElementById("inP").disabled = false;
            }
            
            else{
                document.getElementById("inP").disabled = true;
            }
        }
        
        function updateM(assID){
            var pwet = document.getElementById("5").value;
            
            if(assID != pwet){
                document.getElementById("inM").disabled = false;
            }
            
            else{
                document.getElementById("inM").disabled = true;
            }
        }
        
        function updatePS(assID){
            var pwet = document.getElementById("6").value;
            
            if(assID != pwet){
                document.getElementById("inPS").disabled = false;
            }
            
            else{
                document.getElementById("inPS").disabled = true;
            }
        }
        
        function updateARAM(assID){
            var pwet = document.getElementById("7").value;
            
            if(assID != pwet){
                document.getElementById("inERAM").disabled = false;
            }
            
            else{
                document.getElementById("inERAM").disabled = true;
            }
        }
        
        function updateAHDD(assID){
            var pwet = document.getElementById("8").value;
            
            if(assID != pwet){
                document.getElementById("inEHDD").disabled = false;
            }
            
            else{
                document.getElementById("inEHDD").disabled = true;
            }
        }
        
    </script>

</body>

</html>