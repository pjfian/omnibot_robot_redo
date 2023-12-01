//PHP Code
 <?php 
require("php_serial.class.php"); 
if (isset($_GET['action'])) 
{ 
$serial = new phpSerial;
$serial->deviceSet("/dev/ttyACM0");
$serial->confBaudRate(115200);
$serial->deviceOpen();
    if ($_GET['action'] == "greenon") 
	{ 
	$serial->sendMessage("0"); 
	$done = false;
	$line = "";
		while (!$done) 
		{
		$read = $serial->readPort();
			for ($i = 0; $i < strlen($read); $i++) 
			{
				if ($read[$i] == "\n") 
				{
				$done = true;
				echo "Response from Arduino: ".$line."\n";
				$line = "";
				} 
				else 
				{
				$line .= $read[$i];
				}
			}
		}
	}	 
	else if ($_GET['action'] == "greenoff") 
	{ 
    $serial->sendMessage("1\r"); 
    }
	else if ($_GET['action'] == "redon") 
	{ 
    $serial->sendMessage("2\r"); 
	$read = $serial->readPort();
	echo $read;
	} 
	else if ($_GET['action'] == "redoff") 
	{ 
    $serial->sendMessage("3\r"); 
    }
$serial->deviceClose(); 
} 


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<title>Arduino Project 1: Serial LED Control</title> 
</head> 
<body> 

<h1>Arduino Project 1: Serial LED Control</h1> 
<p><a href="<?=$_SERVER['PHP_SELF'] . "?action=greenon" ?>">
Click here to turn pin13 on.</a></p> 
<p><a href="<?=$_SERVER['PHP_SELF'] . "?action=greenoff" ?>">
Click here to turn pin13 off.</a></p> 
<p><a href="<?=$_SERVER['PHP_SELF'] . "?action=redon" ?>">
Click here to turn the RED LED on.</a></p> 
<p><a href="<?=$_SERVER['PHP_SELF'] . "?action=redoff" ?>">
Click here to turn the RED LED off.</a></p> 
</body> 
</html>

/* ##Arduino code
int ledPin13 = 13; // the pin that the green LED is attached to
int ledPin12 = 12; // the pin that the red LED is attached to
int relay = 8;
int incomingByte;      // a variable to read incoming serial data into
void setup() 
{
   
Serial.begin(115200); // initialize serial communication
  
pinMode(ledPin13, OUTPUT);  // initialize the green LED pin as an output
pinMode(ledPin12, OUTPUT);  // initialize the red LED pin as an output
pinMode(relay, OUTPUT);
 }
 void loop() {
   digitalWrite(relay, HIGH);
   // see if there's incoming serial data:
   if (Serial.available() > 0) {
     
     incomingByte = Serial.read(); // read the oldest byte in the serial buffer
//Preform the code to switch on or off the leds
    if (incomingByte == '0') {

    digitalWrite(ledPin13, HIGH); //If the serial data is 0 turn red LED on
delay(100);
Serial.println("0");
} 
   if (incomingByte == '1') {
   digitalWrite(ledPin13, LOW); //If the serial data is 1 turn red LED off
 Serial.println("1"); 
 }
 
     if (incomingByte == '2') {
    digitalWrite(ledPin12, HIGH); //If the serial data is 2 turn green LED on
Serial.println("2"); 
} 
   if (incomingByte == '3') {
   digitalWrite(ledPin12, LOW); //If the serial data is 3 turn green LED off
 Serial.println("3"); 
 }

   }
 }

*/