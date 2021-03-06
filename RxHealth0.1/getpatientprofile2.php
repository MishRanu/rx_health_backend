<?php  
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');
//$json=$_GET ['json'];
include('db_config.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);


	try 
		{
			$result = $db->prepare("SELECT pp.PID, u.DOB, pp.Height, pp.Weight, pp.BloodGroup, u.Gender, pp.Address1, pp.Address2, pp.City, pp.PinCode, pp.Allergies, pp.Hereditory, u.FName, u.LName, u.Phone, u.Email
			  from user u inner join patientprofile pp where pp.PID=u.UserID and u.UserID= :UserID");
			$result->bindParam(':UserID', $obj['UserID'], PDO::PARAM_STR);
			$result->execute();
			$row = $result->fetch();
			//$datetime1 = new DateTime($row['DOB']);
			//$dob = date_format($datetime1, "d/m/Y");
			$response['ResponseCode'] = "200";
			$response['ResponseMessage'] = "Patient-Data";
			if(is_null($row['PID']))
				$response['PID'] = "NA";
			else
				$response['PID'] = (string)$row['PID'] ;
			
			if(!is_null($row['DOB']))
				$response['DOB'] = $row['DOB'];
			else
				$response['DOB'] = "NA";

			if(!is_null($row['Height']))
				$response['Height'] = (string)$row['Height'];
			else
				$response['Height'] = "NA";

			if(!is_null($row['Weight']))
				$response['Weight'] = (string)$row['Weight'];
			else
				$response['Weight'] = "NA";

			if(!is_null($row['BloodGroup']))
				$response['BloodGroup'] = (string)$row['BloodGroup'];
			else
				$response['BloodGroup'] = "NA";

			if(!is_null($row['Gender']))
				$response['Gender'] = (string)$row['Gender'];
			else
				$response['Gender'] = "NA";

			if(!is_null($row['Address1']))
				$response['Address1'] = (string)$row['Address1'];
			else
				$response['Address1'] = "NA";

			if(!is_null($row['Address2']))
				$response['Address2'] = (string)$row['Address2'];
			else
				$response['Address2'] = "NA";

			if(!is_null($row['City']))
				$response['City'] = (string)$row['City'];
			else
				$response['City'] = "NA";

			if(!is_null($row['PinCode']))
				$response['PinCode'] = (string)$row['PinCode'];
			else
				$response['PinCode'] = "NA";

			if(!is_null($row['Allergies']))
				$response['Allergies'] = (string)$row['Allergies'];
			else
				$response['Allergies'] = "NA";

			if(!is_null($row['Hereditory']))
				$response['Hereditory'] = (string)$row['Hereditory'];
			else
				$response['Hereditory'] = "NA";

			if(!is_null($row['FName']))
				$response['FName'] = (string)$row['FName'];
			else
				$response['FName'] = "NA";

			if(!is_null($row['LName']))
				$response['LName'] = (string)$row['LName'];
			else
				$response['LName'] = "NA";

			if(!is_null($row['Phone']))
				$response['Phone'] = (string)$row['Phone'];
			else
				$response['Phone'] = "NA";

			if(!is_null($row['Email']))
				$response['Email'] = (string)$row['Email'];
			else
				$response['Email'] = "NA";
			

			$status['Status'] = $response;
			header('Content-type: application/json');
			echo json_encode($status);			
		}
	catch(PDOException $ex) 
		{
			$response['ResponseCode'] = "500";
		    $response['ResponseMessage'] = "An Error occured!" . $ex; //user friendly message
		    $status['Status'] = $response;
		    header('Content-type: application/json');
			echo json_encode($status);
		}