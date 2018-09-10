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
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "MENU")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้"."\n"."\n"."[menu1]เพื่อดูรายการอาหารที่1"."\n"."[menu2] เพื่อดูรายการอาหารที่2" . "\n"  . "[menu3] เพื่อดูรายการอาหารที่3"."\n"."[menu4] เพื่อดูรายการอาหารที่4"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "menu4")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flUe1Z.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flUe1Z.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "menu 3")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flU2uD.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flU2uD.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "menu2")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flUxSv.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flUxSv.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "menu1")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flQmfW.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flQmfW.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เบียร์")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flwkm1.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flwkm1.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กาแฟร้อน")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flwBdg.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flwBdg.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "น้ำอัดลม")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flwzQS.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flwzQS.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ชามะนาว")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flwY4Q.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flwY4Q.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "โอเลี้ยง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flw0bN.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flw0bN.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "นมเย็น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltIPk.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltIPk.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ชานมเย็น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltFKl.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltFKl.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ชาเขียว")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltyWe.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltyWe.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "โกโก้เย็น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltent.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltent.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กาแฟเย็น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltLxP.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltLxP.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "อะโวคาโด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltJzI.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltJzI.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เชอร์รี่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flta30.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flta30.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กีวี่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltVeR.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltVeR.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "แตงโม")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flt8Kz.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flt8Kz.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วย")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltlA1.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltlA1.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "มะละกอ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flt5Rn.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flt5Rn.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "สับปะรด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltwue.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltwue.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "มะม่วง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flt3VI.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flt3VI.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เงาะ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flt4w8.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flt4w8.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ทุเรียน")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fltWVb.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fltWVb.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "บิงซู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flTf8n.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flTf8n.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เครปญี่ปุ่น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flTBqS.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flTBqS.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ทาร์ตไข่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flTzvV.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flTzvV.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เอแคลร์ไส้ครีม")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flTSTE.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flTSTE.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เค้กเนย")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9yUP.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9yUP.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "บราวนี่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9Xcz.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9Xcz.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "คุ้กกี้")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl98ra.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl98ra.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ฟรุตเค้ก")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9upJ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9upJ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "พายสับปะรด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9DZ2.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9DZ2.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "พายแอบเปิ้ล")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9DZ2.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9DZ2.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "บูลเบอร์รี่ชีสเค้ก")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9o0W.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9o0W.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "โดนัท")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl95pQ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl95pQ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ไอศกรีมกะทิ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9RPv.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9RPv.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "สังขยาฟักทอง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9taI.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9taI.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ลอดช่องน้ำกะทิ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl9taI.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl9taI.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "รวมมิตร")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl3FK1.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl3FK1.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วยบวชชี")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl3enW.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl3enW.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "บัวลอย")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl3pOQ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl3pOQ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ทองหยิบ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl3HAE.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl3HAE.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ทองหยิบ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fl3HAE.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fl3HAE.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวเหนียวสังขยา")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkM5P.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkM5P.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวเหนียวมะม่วง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkyJZ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkyJZ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวเหนียวทุเรียน")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkPSW.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkPSW.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวต้มมัด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkQgk.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkQgk.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมไหว้พระจันทร์")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkcBP.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkcBP.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมชั้น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkzvb.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkzvb.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมสอดไส้")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flkST9.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flkST9.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วยทอด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhXZv.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhXZv.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ปาท๋องโก")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flh8rl.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flh8rl.jpg"];
			} 
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมถ้วย")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhDZR.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhDZR.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมครก")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhjrz.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhjrz.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ขนมเบื้อง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhO4a.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhO4a.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "สเต็กหมู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhqbb.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhqbb.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ผัดไทยกุ้งสด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhgd1.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhgd1.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "มักกะโรนี")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flhdkI.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flhdkI.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ยากิโซบะ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flfIAu.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flfIAu.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เย็นตาโฟ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flfyWR.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flfyWR.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เกาเหลาลูกชิ้น")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flfe68.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flfe68.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เกี๊ยวน้ำกุ้ง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flf81D.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flf81D.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ราดหน้าหมู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flfj1N.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flfj1N.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "เส้นใหญ่ผัดซีอิ๊วใส่ไข่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flfcDZ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flfcDZ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยเตี๋ยวเรือ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flfSCy.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flfSCy.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยเตี๋ยวต้มยำกุ้ง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flBmoQ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flBmoQ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยเตี๋ยวแขก")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flBoqq.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flBoqq.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยจั๊วญวณ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flBi82.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flBi82.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยจั๊บ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flB92N.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flB92N.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยเตี๋ยวหลอด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flNmNq.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flNmNq.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "บะหมี่หมูแดง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flNrQ2.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flNrQ2.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ก๋วยเตี๋ยวเนื้อสับ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flNjnv.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flNjnv.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "บะหมี่กึ่งสำเร็จรูป")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/flN93f.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/flN93f.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ไก่ทอด")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjac4l.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjac4l.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "หมูปิ้ง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjaTeI.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjaTeI.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ส้มตำ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjXUha.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjXUha.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "แกงไตปลา")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjXcM9.jpgg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjXcM9.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "แกงเหลือง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjXKiy.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjXKiy.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "สุกี้ยากี้ไก่-หมู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjXfwQ.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjXfwQ.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวหมูกรอบ")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjHUPb.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjHUPb.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ต้มยำกุ้ง")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjHdAP.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjHdAP.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวหมูทอดกระเทียม")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjuxUu.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjuxUu.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "แกงเขียวหวาน")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjutcf.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjutcf.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "แกงกะหรี่ไก่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjuT0b.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjuT0b.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "แกงจืดตำลึงหมู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fj8yx0.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fj8yx0.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวซอยไก่")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjukU9.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjukU9.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "ข้าวผัดหมู")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/10/fjCypE.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/10/fjCypE.jpg"];
			}
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
