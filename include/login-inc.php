<?php 
	if (isset($_POST['submitBTN'])) {
		session_start();
		require 'database.php';

		$emailAddress = $_POST['emailAddress'];
		$password = $_POST['password'];
	
		$sql = "SELECT * FROM tbl_customer";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		if (!empty($result)) {	
			while ($row = $result->fetch_assoc()) {
				$inputHashPass = md5($password);

				$emailMatch = ($emailAddress == $row['emailAddress']) ? true : false;
				$passMatch = ($inputHashPass == $row['password']) ? true : false;
				if ($emailMatch == true && $passMatch == true) {
					$_SESSION['name'] = $row['firstName'] . " " . $row['lastName'];
					$_SESSION['customerID'] = $row['customerID'];
					header("Location: ../index.php");
					exit();		
				} else {
					$_SESSION['message'] = "Error = Incorrect Credentials".$tempName.$passMatch.$terminate;
					$_SESSION['messageType'] = "danger";
					header("Location: ../login.php");
				}
			}					
			$stmt->close();
			$conn->close();
		}		
	}