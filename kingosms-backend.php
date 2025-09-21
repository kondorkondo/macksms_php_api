<?php

//SEND SINGLE SMS
if(isset($_POST['send_single_sms'])){
	//Collect infos
	$phone = $_POST['phone'];
	$message = $_POST['message'];

	//Validate phone
	if(strlen($phone) <> 10 || !is_numeric($phone)){
		die('Invalid phone number');
	}

	//send message
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://macksms.co.tz/portal/api/text',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
	    "request_type": "single_sms",
	    "sender_id": "SoftMack",
	    "phone": "'.$phone.'",
	    "message": "'.$message.'"
	}',
	  CURLOPT_HTTPHEADER => array(
	    'Content-Type: application/json',
	    'Accept: application/json',
	    'Authorization: Basic '
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response; //Create message from this response
	/*Sample response structure (json):
	{"success":true,"sms_data":[{"action_status":true,"sender":"SoftMack","phone":"255678453797","text":"Samaki","sms_count":1,"messageID":315513031550028764,"status":"SENT","description":"Message sent to next instance","action_date_time":"2025-03-28 16:30:41"}]}

	*/
}



//SEND SINGLE SMS
if(isset($_POST['send_multi_sms'])){
	//Collect infos
	$recepients = explode(",",trim($_POST['recepients']));
	$message = $_POST['message'];

	#Initialize message array
	$messages = array();

	//SenderID
	$SenderID = "SoftMack";

	//Validate recepients and create message
	if(empty($recepients)){
		die('Add recepients');
	}else{
		foreach($recepients as $phone){
			$phone = trim($phone);
			if(strlen($phone) <> 12 || !is_numeric($phone)){
				$errorLog[] = 'Invalid phone number';
			}else{
				//Create message
				$thisMessage = [
					"from" => $SenderID,
					"to" => $phone,
					"text" => $message
				];

				//Add this message to major sms object
				array_push($messages,$thisMessage);
			}
		}
	}

	#Create messages json
	$messageToSend = json_encode($messages);
	//die($messageToSend);

	//send message
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://macksms.co.tz/portal/api/text',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		"request_type": "multiple_sms",
		"sender_id": "'.$SenderID.'",
		"message_data": '.$messageToSend.'
		}',
	  CURLOPT_HTTPHEADER => array(
	    'Content-Type: application/json',
	    'Accept: application/json',
	     'Authorization: Basic YzlmMGY4OTVmYjk4YWI5MTU5ZjUxZmQwMjk3ZTIzNmQ6ZDg5YmU0OWZlYzc0MWFhN2I1ZmJiMjFiMjg5MTkwNjI='
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response; //Create message from this response
	/*Sample response structure (json):
	{"success":true,"sms_data":[{"action_status":true,"sender":"SoftMack","phone":"255629833155","text":"NYANYAAAAAAA","sms_count":1,"messageID":230680250246550627,"status":"SENT","description":"Message sent to next instance","action_date_time":"2025-03-28 17:10:04"},{"action_status":true,"sender":"SoftMack","phone":"255678453797","text":"NYANYAAAAAAA","sms_count":1,"messageID":541541983860705022,"status":"SENT","description":"Message sent to next instance","action_date_time":"2025-03-28 17:10:04"}]}

	*/
}


?>
