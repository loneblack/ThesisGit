

<?php
	session_start();

		$key = "Fusion";

		require_once("db/mysql_connect.php");

		if($dbc){
		
		
		$username = $_POST['username'];
		$password = $_POST['password'];

		
		$_SESSION['$userID'] = '';
		$userType ='';

    	$sql = "SELECT userID, userType FROM user WHERE username = AES_ENCRYPT('{$username}', '{$key}') and password = AES_ENCRYPT('{$password}', '{$key}');";

	  	$result = mysqli_query($dbc, $sql);

	  		while($row = $result->fetch_assoc()){
			$_SESSION['userID'] = $row['userID'];
			$userType = $row['userType'];

			//echo encrypt($row['userName'], $key);

		}
		
	    if ($result->num_rows > 0) {
	    	unset($_SESSION["message"]);
	    	echo "log-in successful";

	    	if($userType == '1'){
				header("Location:admin_dashboard.php");
	    	}
	        if($userType == '2'){
				header("Location:it_dashboard.php");
	    	}
	        if($userType == '3'){
				header("Location:helpdesk_dashboard.php");
	    	}
	        if($userType == '4'){
				header("Location:engineer_dashboard.php");
	    	}
	    	if($userType == '5'){
				header("Location:requestor_dashboard.php");
	    	}
	    	if($userType == '6'){
				header("Location:procurement_dashboard.php");
	    	}
	    	if($userType == '7'){
				header("Location:director_requests.php");
	    	}
	        
	        exit;
	    } else {
	    	$_SESSION["Lmessage"] = "Wrong username or password";
	        header("Location:login.php");
	        exit;
	    }

	    $dbc->close();
    }
?>