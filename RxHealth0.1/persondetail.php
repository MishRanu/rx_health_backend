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
			$result = $db->prepare("SELECT u.FName, u.LName, u.Pic, u.Phone, u.Gender, u.Email, u.DOB, pp.City, pp.State  
			  from user u INNER JOIN patientprofile pp on u.UserID = pp.PID where u.UserID= :UserID");
			$result->bindParam(':UserID', $obj['UserID'], PDO::PARAM_STR);
			$result->execute();
			$row = $result->fetch();
			$response['Phone'] = (string)$row['Phone'];
			$response['Email']= (string)$row['Email'];
			$response['IsDoctor']= (string)$row['IsDoctor'];
			if(!is_null($row['FName']))
				$response['FName'] = (string)$row['FName'];
			else
				$response['FName'] = "NA";

			if(!is_null($row['LName']))
				$response['LName'] = (string)$row['LName'];
			else
				$response['LName'] = "NA";

            if(!is_null($row['Pic']))
				$response['Pic'] = (string)$row['Pic'];
			else
				$response['Pic'] = "NA";
			if(!is_null($row['City']))
				$response['City'] = (string)$row['City'];
			else
				$response['City'] = "NA";
			if(!is_null($row['State']))
				$response['State'] = (string)$row['State'];
			else
				$response['State'] = "NA";
			if(!is_null($row['Gender']))
				$response['Gender'] = (string)$row['Gender'];
			else
				$response['Gender'] = "NA";
			if(!is_null($row['DOB']))
				$response['DOB'] = (string)$row['DOB'];
			else
				$response['DOB'] = "NA";

                 
                        $response['ResponseCode'] = "200";
		        $response['ResponseMessage'] = " Successfully";
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