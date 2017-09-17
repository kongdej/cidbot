<?php

$access_token = 'R4WtFLXk2/LkimTrKmi7KtIGryBJt/Uwiaeg3gDIxAIF8dGZ36pbt1kwmvE0ZFGzb8EwhcWsbBNwrAVQ1fyckfC4r8Gv3kQASIfkDMnri7soc+/whU9q8NkWVEKlV4VDkvXHGUv5tsWAFVZu/2xSeQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			$text  = strtoupper($text);
			$url = "https://cid-egat.firebaseio.com/KKS.json?orderBy=%22code%22&startAt=%22".$text."%22&endAt=%22".$text."\uf8ff%22";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_USERPWD, "{YOUR NETPIE.IO APP KEY}:{YOUR NETPIE.IO APP SECRET}");
			$response = curl_exec($ch); 
			curl_close ($ch);
			$res = json_decode($response);

			foreach ($res as $kks => $value) {
				$reply .= $value->code .'='. $value->name ."\r\n";
			}


			if (strlen($reply) > 3) {
			// Repy back
				$messages = [
					'type' => 'text',
					'text' => $reply
				];
			  
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages],
				];
				$post = json_encode($data);
				$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				$result = curl_exec($ch);
				curl_close($ch);

				echo $result . "\r\n";
			}
		}
	}
}

echo "OK";

/*
function get($url) {
	 $ch = curl_init($url);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	 curl_setopt($ch, CURLOPT_USERPWD, "{YOUR NETPIE.IO APP KEY}:{YOUR NETPIE.IO APP SECRET}");
	 $response = curl_exec($ch);
	 curl_close ($ch);

	 return $response;
}

function put($url,$tmsg) {                 
     $ch = curl_init($url); 
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
     curl_setopt($ch, CURLOPT_POSTFIELDS, $tmsg);
     curl_setopt($ch, CURLOPT_USERPWD, "{YOUR NETPIE.IO APP KEY}:{YOUR NETPIE.IO APP SECRET}");
     $response = curl_exec($ch);
     curl_close ($ch);
     
     return $response;
}

*/

/*


	$url = "https://cid-egat.firebaseio.com/KKS.json?orderBy=%22code%22&startAt=%22UR%22&endAt=%22UR\uf8ff%22";
//	$url = "https://cid-egat.firebaseio.com/KKS.json";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_USERPWD, "{YOUR NETPIE.IO APP KEY}:{YOUR NETPIE.IO APP SECRET}");
	$response = curl_exec($ch); 
	curl_close ($ch);
	$res = json_decode($response);

	foreach ($res as $kks => $value) {
		echo $value->code .'='. $value->name .' ('. $value->discipline .")\r\n";
	}

	//echo $response;
*/