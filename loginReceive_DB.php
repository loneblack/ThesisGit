

<?php
	session_start();

		$key = "Fusion";

		require_once("db/mysql_connect.php");

		if($dbc){
		
		
		$username = $_POST['username'];
		$password = $_POST['password'];

		
		$_SESSION['userID'] = '';
		$userType ='';

    	$sql = "SELECT userID, userType FROM user WHERE username = AES_ENCRYPT('{$username}', '{$key}') and password = AES_ENCRYPT('{$password}', '{$key}');";

	  	$result = mysqli_query($dbc, $sql);

	  		while($row = $result->fetch_assoc()){
			$_SESSION['userID'] = $row['userID'];
			$userType = $row['userType'];

			//echo encrypt($row['userName'], $key);

		}
		
	    if ($result->num_rows > 0)
	    {
	    	unset($_SESSION["message"]);
	    	echo "log-in successful";

	    	
	    	if($userType == '5'){
				header("Location:receiving_dashboard.php");
	    	}
	    	else{
	    		$_SESSION["Lmessage"] = "Wrong username or password";
	        	header("Location:login.php");
	    	}
	        
	    } else {
	    	$_SESSION["Lmessage"] = "Wrong username or password";
	        header("Location:login.php");
	        exit;
	    }

	    $dbc->close();
    }
?>