<?php
require_once ('fuzzy-logic-class.php');
$x = new Fuzzy_Logic();
$x->clearMembers();
 
$x->SetInputNames(array('temperature','humidity','smoke','wind_speed'));

$x->addMember($x->getInputName(0),'low',  -20, 0, 40 ,LINFINITY);
$x->addMember($x->getInputName(0),'mid'  , 20, 50, 80 ,TRIANGLE);
$x->addMember($x->getInputName(0),'high'  , 60, 80, 100,RINFINITY);

$x->addMember($x->getInputName(1),'low', 0, 20, 40,LINFINITY);
$x->addMember($x->getInputName(1),'mid', 20, 50, 80,TRIANGLE);
$x->addMember($x->getInputName(1),'high',50, 80, 100,RINFINITY);

$x->addMember($x->getInputName(2),'low', 0, 20, 40,LINFINITY);
$x->addMember($x->getInputName(2),'mid', 20, 50, 80,TRIANGLE);
$x->addMember($x->getInputName(2),'high',50, 80, 100,RINFINITY);

$x->addMember($x->getInputName(3),'low', 0, 20, 40,LINFINITY);
$x->addMember($x->getInputName(3),'mid', 20, 50, 80,TRIANGLE);
$x->addMember($x->getInputName(3),'high',50, 80, 100,RINFINITY);

$x->SetOutputNames(array('risk'));

$x->addMember($x->getOutputName(0),'low',0, 20 ,40 ,LINFINITY);
$x->addMember($x->getOutputName(0),'normal',20, 50 ,80 ,TRIANGLE);
$x->addMember($x->getOutputName(0),'high',60,  80 , 100 ,RINFINITY);

$x->clearRules();

$x->addRule('IF temperature.high OR humidity.low THEN risk.low');
$x->addRule('IF temperature.mid AND humidity.large THEN risk.normal');
$x->addRule('IF temperature.mid THEN risk.low');
$x->addRule('IF smoke.mid THEN risk.high');
$x->addRule('IF wind_speed.high THEN risk.high');


$temperature = (isset($_GET['temperature'])) ? $_GET['temperature'] : 35;   
$humidity = (isset($_GET['humidity'])) ? $_GET['humidity'] : 65; 
$smoke = (isset($_GET['smoke'])) ? $_GET['smoke'] : 15; 
$wind_speed = (isset($_GET['wind_speed'])) ? $_GET['wind_speed'] : 15; 

$x->SetRealInput('temperature',	  $temperature	);
$x->SetRealInput('humidity' , $humidity	);
$x->SetRealInput('smoke' , $smoke	);
$x->SetRealInput('wind_speed' , $wind_speed	);


$fuzzy_arr = $x->calcFuzzy();
$risk = $fuzzy_arr['risk'];
$bar_width = 320;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Calculate Fire Risk </title>
<link href="css/screen.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<div class="container">
<h2 align="center">Calculate Fire Risk</h2>
<div class="span-16 prepend-4 append-4 last">
<form>
<label for="temperature">Temperature [-20-100]</>
<input type="text" id="temperature" name="temperature" value="<?php echo $temperature;?>" /><br />  
<label for="humidity">Humidity [0-100]</>
<input type="text" id="humidity" name="humidity" value="<?php echo $humidity;?>" /><br /> 
<label for="smoke">Smoke [0-100]</>
<input type="text" id="smoke" name="smoke" value="<?php echo $smoke;?>" /><br /> 
<label for="wind_speed">Wind Speed [0-100]</>
<input type="text" id="wind_speed" name="wind_speed" value="<?php echo $wind_speed;?>" /><br /> 
<input type="submit" name="calculate" value="calculate" />
<div style="width: <?php echo $bar_width;?>px;height:22px;border: 1px solid #000;;text-align:center;">
<div style="width: <?php echo round($risk*$bar_width/100); ?>px;height:18px;margin:1px;background-color:red;border: 1px solid #000"><?php echo sprintf("%3.1f %%",$risk);?></div>
</div>
</form>
</div>
</body>
</html>]