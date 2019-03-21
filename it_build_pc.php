<!DOCTYPE html>
<html lang="en">

<?php
    
    session_start();
	require_once("db/mysql_connect.php");
    
    if(isset($_POST['submit'])){	
//                $message = "Tangina MO";
//                echo "<script type='text/javascript'>alert('$message');</script>";
				//Count Curr Assets based on assetCategory
            //desktop
            if($_POST['assetCat'] == 13){
                
                $queryCount="SELECT Count(assetID) as `assetPosition` FROM thesis.asset a 
                            join assetmodel am on a.assetModel=am.assetModelID where am.assetCategory='13';";
				$resultCount=mysqli_query($dbc,$queryCount);
				$rowCount=mysqli_fetch_array($resultCount,MYSQLI_ASSOC);
				
				//$propertyCode="0".$row1['assetCategory']."-".sprintf('%06d', $rowCount['assetPosition']);
				$propertyCode=sprintf('%03d', 13)."-".sprintf('%06d', $rowCount['assetPosition']);
				
                //INSERT TO Asset Model
                $queryProp="INSERT INTO `thesis`.`assetmodel` (`assetCategory`, `description`) VALUES ('13', 'Desktop');";
				$resultProp=mysqli_query($dbc,$queryProp);
        
                //get latest asset model
                $maxAssetModel = "SELECT MAX(assetmodelID) AS maxID FROM assetmodel;";
                $resultMaxAssetModel=mysqli_query($dbc,$maxAssetModel);
                $rowCountMaxAssetModel=mysqli_fetch_array($resultMaxAssetModel,MYSQLI_ASSOC);
        
				//INSERT Property Code
				$queryProp="INSERT INTO `thesis`.`asset` (`assetModel`, `propertyCode`, `dateDelivered`, `assetStatus`) VALUES ('{$rowCountMaxAssetModel['maxID']}', '{$propertyCode}', NOW(), '1');";
				$resultProp=mysqli_query($dbc,$queryProp);
            
                //get latest asset created
                $maxAsset = "SELECT MAX(assetID) AS assetmaxID FROM asset;";
                $resultMaxAsset=mysqli_query($dbc,$maxAsset);
                $rowCountMaxAsset=mysqli_fetch_array($resultMaxAsset,MYSQLI_ASSOC);
        
                //INSERT TO COMPUTER
                $insertPC = "INSERT INTO `thesis`.`computer` (`assetStatus`, `assetID`, `isComplete`) VALUES ('1', '{$rowCountMaxAsset['assetmaxID']}', True);";
                $resultInsertPC = mysqli_query($dbc,$insertPC);
                
                //get max pc
                $maxPC = "SELECT MAX(computerID) AS comMax FROM computer;";
                $resultMaxPC=mysqli_query($dbc,$maxPC);
                $rowCountMaxPC=mysqli_fetch_array($resultMaxPC,MYSQLI_ASSOC);
        
                foreach($_POST['component'] as $cumponent){
                    //insert to computer cum ponent tamod
                    $pasok = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$cumponent}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok = mysqli_query($dbc,$pasok);
                    
                    $updateAsset = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$cumponent}');";
                    $resultUpdateAsset = mysqli_query($dbc, $updateAsset);
                }
        
                if(isset($_POST['extraRAM']) && isset($_POST['extraHDD'])){
                    //insert to computer cum ponent tamod
                    $pasok1 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraRAM']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok1 = mysqli_query($dbc,$pasok1);
                    
                    $updateAsset1 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraRAM']}');";
                    $resultUpdateAsset1 = mysqli_query($dbc, $updateAsset1);
                    
                    $pasok2 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraHDD']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok2 = mysqli_query($dbc,$pasok2);
                    
                    $updateAsset2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraHDD']}');";
                    $resultUpdateAsset2 = mysqli_query($dbc, $updateAsset2);

                }
        
                elseif(isset($_POST['extraHDD'])){
                    $pasok2 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraHDD']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok2 = mysqli_query($dbc,$pasok2);
                    
                    $updateAsset2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraHDD']}');";
                    $resultUpdateAsset2 = mysqli_query($dbc, $updateAsset2);

                }
        
                elseif(isset($_POST['extraRAM'])){
                    //insert to computer cum ponent tamod
                    $pasok1 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraRAM']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok1 = mysqli_query($dbc,$pasok1);
                    
                    $updateAsset1 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraRAM']}');";
                    $resultUpdateAsset1 = mysqli_query($dbc, $updateAsset1);

                }
            }
                
                
            if($_POST['assetCat'] == 46){
                
                $queryCount="SELECT Count(assetID) as `assetPosition` FROM thesis.asset a 
                            join assetmodel am on a.assetModel=am.assetModelID where am.assetCategory='46';";
				$resultCount=mysqli_query($dbc,$queryCount);
				$rowCount=mysqli_fetch_array($resultCount,MYSQLI_ASSOC);
				
				//$propertyCode="0".$row1['assetCategory']."-".sprintf('%06d', $rowCount['assetPosition']);
				$propertyCode=sprintf('%03d', 46)."-".sprintf('%06d', $rowCount['assetPosition']);
				
                //INSERT TO Asset Model
                $queryProp="INSERT INTO `thesis`.`assetmodel` (`assetCategory`, `description`) VALUES ('46', 'Server');";
				$resultProp=mysqli_query($dbc,$queryProp);
        
                //get latest asset model
                $maxAssetModel = "SELECT MAX(assetmodelID) AS maxID FROM assetmodel;";
                $resultMaxAssetModel=mysqli_query($dbc,$maxAssetModel);
                $rowCountMaxAssetModel=mysqli_fetch_array($resultMaxAssetModel,MYSQLI_ASSOC);
        
				//INSERT Property Code
				$queryProp="INSERT INTO `thesis`.`asset` (`assetModel`, `propertyCode`, `dateDelivered`, `assetStatus`) VALUES ('{$rowCountMaxAssetModel['maxID']}', '{$propertyCode}', NOW(), '1');";
				$resultProp=mysqli_query($dbc,$queryProp);
            
                //get latest asset created
                $maxAsset = "SELECT MAX(assetID) AS assetmaxID FROM asset;";
                $resultMaxAsset=mysqli_query($dbc,$maxAsset);
                $rowCountMaxAsset=mysqli_fetch_array($resultMaxAsset,MYSQLI_ASSOC);
        
                //INSERT TO COMPUTER
                $insertPC = "INSERT INTO `thesis`.`computer` (`assetStatus`, `assetID`, `isComplete`) VALUES ('1', '{$rowCountMaxAsset['assetmaxID']}', True);";
                $resultInsertPC = mysqli_query($dbc,$insertPC);
                
                //get max pc
                $maxPC = "SELECT MAX(computerID) AS comMax FROM computer;";
                $resultMaxPC=mysqli_query($dbc,$maxPC);
                $rowCountMaxPC=mysqli_fetch_array($resultMaxPC,MYSQLI_ASSOC);
        
                foreach($_POST['component'] as $cumponent){
                    //insert to computer cum ponent tamod
                    $pasok = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$cumponent}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok = mysqli_query($dbc,$pasok);
                    
                    $updateAsset = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$cumponent}');";
                    $resultUpdateAsset = mysqli_query($dbc, $updateAsset);
                }
        
                if(isset($_POST['extraRAM']) && isset($_POST['extraHDD'])){
                    //insert to computer cum ponent tamod
                    $pasok1 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraRAM']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok1 = mysqli_query($dbc,$pasok1);
                    
                    $updateAsset1 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraRAM']}');";
                    $resultUpdateAsset1 = mysqli_query($dbc, $updateAsset1);
                    
                    $pasok2 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraHDD']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok2 = mysqli_query($dbc,$pasok2);
                    
                    $updateAsset2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraHDD']}');";
                    $resultUpdateAsset2 = mysqli_query($dbc, $updateAsset2);

                }
        
                elseif(isset($_POST['extraHDD'])){
                    $pasok2 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraHDD']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok2 = mysqli_query($dbc,$pasok2);
                    
                    $updateAsset2 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraHDD']}');";
                    $resultUpdateAsset2 = mysqli_query($dbc, $updateAsset2);

                }
        
                elseif(isset($_POST['extraRAM'])){
                    //insert to computer cum ponent tamod
                    $pasok1 = "INSERT INTO computercomponent (`assetID`, `computerID`) VALUES ('{$_POST['extraRAM']}', '{$rowCountMaxPC['comMax']}');";
                    $resultPasok1 = mysqli_query($dbc,$pasok1);
                    
                    $updateAsset1 = "UPDATE `thesis`.`asset` SET `assetStatus` = '20' WHERE (`assetID` = '{$_POST['extraRAM']}');";
                    $resultUpdateAsset1 = mysqli_query($dbc, $updateAsset1);

                }
            }   
                
                
                
                
                
                
                
        
            $_SESSION['submitMessage'] = "Success! A new PC has been Created.";
        
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
                                Build A Desktop or Thin Client
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form class="form-horizontal" role="form" method="POST" action="">

                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label">Asset Category</label>
                                            <div class="col-lg-10">
                                                <select class="form-control m-bot15" name="assetCat" required>
                                                    <option name="assetCat" id="assetCat">Select Asset Category</option>
                                                    <option value="13">Desktop</option>
                                                    <option value="46">Thin Client</option>
                                                </select>
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
                                                        echo"<select id= '1' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '2' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '3' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '4' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '5' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>
                                                
                                                
                                                
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '6' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '7' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '8' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>
                                                
                                                <tr>
                                                    <td width='220'>
                                                    <?php
                                                        echo"<select id= '9' class='form-control' onchange='loadDetails(this.value, this.id)' name='component[]' required><option value=''>Select Property Code</option>";

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
                                                </tr>
                                                
                                                
                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        echo"<select id= '10' class='form-control' onchange='loadDetails(this.value, this.id)' name='extraRAM'><option value=''>Select Property Code</option>";

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
                                                    <td>Additional RAM</td>

                                                    <?php
                                                        
                                                        $count = 10;
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
                                                </tr>

                                                <tr>
                                                    <td width='220'>
                                                        <?php
                                                        echo"<select id= '11' class='form-control' onchange='loadDetails(this.value, this.id)' name='extraHDD'><option value=''>Select Property Code</option>";

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
                                                    <td>Additional HDD</td>
                                                    <?php
                                                        
                                                        $count = 11;
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
                                                </tr>
                                                
                                                
                                            </tbody>
                                        </table>



                                        <div class="clearfix">
                                            <div class="btn-group">
                                                <button class="btn btn-success" type="submit" name="submit">
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