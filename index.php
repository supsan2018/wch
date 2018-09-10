<?php
$access_token = '2qUMqxZsEEIGRE1d3YL/JPnSsUij9lSGmA8R/6GbhP3Y9xyEDK7pZl5PITiinZio4jymqb7fogXeEM4B1PjykpRTdri1w86ais5LH3a99MYFYYKNbZt6/2SYBg0SY73y4U+GZlA8psvT/jgKkqfgFAdB04t89/1O/w1cDnyilFU=';
$host = "ec2-107-22-211-182.compute-1.amazonaws.com";
$user = "mmdkvvqziulstc";
$pass = "e10240d71df70c411f5201bc37491e9091491ff276b8d8b66f8e507ea5b7dc22";
$db = "dcv361109jo6fh";
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
function showtime($time)
{
	$date = date("Y-m-d");
	$h = split(":", $time);
	if ($h[1] < 15)
	{
		$h[1] = "00";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:0:00' and '$date $h[0]:15:00' order by \"DATETIME\" desc limit 1";
	}
	else
	if ($h[1] >= 15 && $h[1] < 30)
	{
		$h[1] = "15";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:15:01' and '$date $h[0]:30:00' order by \"DATETIME\" desc limit 1";
	}
	else
	if ($h[1] >= 30 && $h[1] < 45)
	{
		$h[1] = "30";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:30:01' and '$date $h[0]:45:00' order by \"DATETIME\" desc limit 1";
	}
	else
	if ($h[1] >= 45)
	{
		$h[1] = "45";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:45:01' and '$date $h[0]:59:59' order by \"DATETIME\" desc limit 1";
	}
	
	return array(
		$h[0] . ":" . $h[1],
		$selectbydate
	);
}
// database
$dbconn = pg_connect("host=" . $GLOBALS['host'] . " port=5432 dbname=" . $GLOBALS['db'] . " user=" . $GLOBALS['user'] . " password=" . $GLOBALS['pass']) or die('Could not connect: ' . pg_last_error());
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
$Light = file_get_contents('https://api.thingspeak.com/channels/331361/fields/3/last.txt');
$water = file_get_contents('https://api.thingspeak.com/channels/331361/fields/4/last.txt');
$HUM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/2/last.txt');
$TEM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/1/last.txt');
$aba = ('https://i.imgur.com//yuRTcoH.jpg');
// convert
$sqlgetlastrecord = "select * from weatherstation order by \"DATETIME\" desc limit 1";
if (!is_null($events['events']))
{
	// Loop through each event
	foreach($events['events'] as $event)
	{
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text')
		{
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = ['type' => 'text', 'text' => "ไม่มีคำสั่งที่คุณพิมพ์ "."\n"."พิมพ์ตัวอักษรตามที่กำหนดให้" ."\n" ."\n". "[help] เพื่อดูเมนู" 
			// "text"
			];
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "HELP")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้"."\n"."\n"."[energy] เพื่อดูปริมาณแคลอรี่ที่ต้องใช้ในแต่ละเพศ"."\n"."[menu] เพื่อดูรายการอาหาร" . "\n"  . "[แนะนำ] เพื่อดูรายการอาหารที่แนะนำ"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "อากาศ"){
				
				$messages = ['type' => 'text', 'text' => "สถานที่ : " . "โรงเรียนวิเชียรมาตุ จ.ตรัง" .  "\n" . "อุณหภูมิ C :" . $TEM . "\n" . "ความชื้น :" . $HUM . " %" . "\n" . "[help] เพื่อดูเมนู"];
			}
			
			
			
			
			
			
			
			
			
			//EndCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวผัดไส้กรอก")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjsHlR.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjsHlR.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวคลุกกะปิ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjsnFz.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjsnFz.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวไก่อบ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjs62q.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjs62q.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวสตูว์ไก่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjsAB9.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjsAB9.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กระเพาะปลา")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjsE2W.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjsE2W.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวต้มปลา")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjscjE.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjscjE.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ไข่เจียว")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjfalS.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjfalS.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "โจ๊กใส่ไข่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fj4F2Z.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fj4F2Z.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมจีนน้ำยาปู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fj4948.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fj4948.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวหมกไก่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjdLrJ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjdLrJ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ผัดไทย")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjsZ9v.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjsZ9v.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวขาหมู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjdn0S.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjdn0S.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวหมูแดง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjPpdg.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjPpdg.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวกระเพาะไก่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjdrZn.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjdrZn.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวมันไก่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjWAYJ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjWAYJ.jpg"];
			}
			if (trim(strtoupper($text)) == "HI")
			{
				$messages = ['type' => 'text', 'text' => "Hello Welcome to WCH Health"];
			}
			if (trim(strtoupper($text)) == "สวัสดี")
			{
				$messages = ['type' => 'text', 'text' => "สวัสดียินดีต้อนรับเข้าสู่"."\n"."WCH Health"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "INFO")
			{
				$messages = ['type' => 'text', 'text' => "มหาวิทยาลัยวลัยลักษณ์เป็นมหาวิทยาลัยของรัฐ และอยู่ในกำกับของรัฐบาลที่ได้รับพระมหากรุณาธิคุณจากพระบาทสมเด็จพระเจ้าอยู่หัว พระราชทานชื่ออันเป็นสร้อยพระนามในสมเด็จพระเจ้าลูกเธอ เจ้าฟ้าจุฬาภรณวลัยลักษณ์อัครราชกุมารี" ."\n"."อ่านเพิ่มเติม: https://www.wu.ac.th"];
			}				
			if ( ereg_replace('[[:space:]]+', '', trim($text)) == "ภาพ")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			$textSplited = split(" ", $text);
			if ( ereg_replace('[[:space:]]+', '', trim($textSplited[0])) == "ภาพ")
			{
				$dataFromshowtime = showtime($textSplited[1]);
				$rs = pg_query($dbconn, $dataFromshowtime[1]) or die("Cannot execute query: $query\n");
				$templink = ""; 
				$qcount=0;
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
					$qcount++;
				}
				//$messages = ['type' => 'text', 'text' => "HI $dataFromshowtime[0] \n$dataFromshowtime[1] \n$templink"
				if ($qcount > 0){
				$messages = [
				'type' => 'image',
				'originalContentUrl' => $templink,
					'previewImageUrl' => $templink
				];}
				else {
					$messages = [
						'type' => 'image',
						'originalContentUrl' => "https://imgur.com/aOWIijh.jpg",
							'previewImageUrl' => "https://imgur.com/aOWIijh.jpg" 
		
						];
				}
			}
			if ($text == "ภาพ")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "MAP")
			{
				$messages = ['type' => 'location','title'=> 'my location','address'=> 'โรงเรียนวิเชียรมาตุ',
				'latitude'=> 7.503131848543433,'longitude'=> 99.63012646883726];
			}
			/*if($text == "image"){
			$messages = [
			$img_url = "http://sand.96.lt/images/q.jpg";
			$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
			$response = $bot->replyMessage($event->getReplyToken(), $outputText);
			];
			}*/
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = ['replyToken' => $replyToken, 'messages' => [$messages], ];
			$post = json_encode($data);
			$headers = array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $access_token
			);
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
echo "OK";
echo $date;
