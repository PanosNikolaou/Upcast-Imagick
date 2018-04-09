<?php


/**
* =====================================
*              Remap Range            
* =====================================
* - Convert one range to another. (including value)
*
* @param    int $intValue   The value in the old range you wish to convert
* @param    int $oMin       The minimum of the old range
* @param    int $oMax       The maximum of the old range
* @param    int $nMin       The minimum of the new range
* @param    int $nMax       The maximum of the new range
*
* @return   float $fResult  The old value converted to the new range
*/
function remapRange($intValue, $oMin, $oMax, $nMin, $nMax) {
    // Range check
    if ($oMin == $oMax) {
        echo 'Warning: Zero input range';
        return false;
    }

    if ($nMin == $nMax) {
        echo 'Warning: Zero output range';
        return false;
    }

    // Check reversed input range
    $bReverseInput = false;
    $intOldMin = min($oMin, $oMax);
    $intOldMax = max($oMin, $oMax);
    if ($intOldMin != $oMin) {
        $bReverseInput = true;
    }

    // Check reversed output range
    $bReverseOutput = false;
    $intNewMin = min($nMin, $nMax);
    $intNewMax = max($nMin, $nMax);
    if ($intNewMin != $nMin) {
        $bReverseOutput = true;
    }

    $fRatio = ($intValue - $intOldMin) * ($intNewMax - $intNewMin) / ($intOldMax - $intOldMin);
    if ($bReverseInput) {
        $fRatio = ($intOldMax - $intValue) * ($intNewMax - $intNewMin) / ($intOldMax - $intOldMin);
    }

    $fResult = $fRatio + $intNewMin;
    if ($bReverseOutput) {
        $fResult = $intNewMax - $fRatio;
    }

    return $fResult;
}


require_once ('../fuzzy-logic-class.php');
$x = new Fuzzy_Logic();
$x->clearMembers(); 
$x->SetInputNames(array('red_colorspace'));
$x->addMember($x->getInputName(0),'min', 0,remapRange(10808,0,22125,0,40),remapRange(22125,0,22125,0,60),LINFINITY);
$x->addMember($x->getInputName(0),'mean'  , remapRange(22125,0,22125,0,20),remapRange(27426,0,33898,0,50),remapRange(33898,0,33898,0,80),TRIANGLE);
$x->addMember($x->getInputName(0),'max'  , remapRange(33898,0,33898,0,60), remapRange(44044,0,65535,0,80),remapRange(65535,0,65535,0,100) ,RINFINITY);
$x->SetOutputNames(array('output_red_colorspace'));
$x->addMember($x->getOutputName(0),'min',0,remapRange(10808,0,22125,0,40),remapRange(22125,0,22125,0,60),LINFINITY);
$x->addMember($x->getOutputName(0),'mean',remapRange(22125,0,22125,0,20),remapRange(27426,0,33898,0,50),remapRange(33898,0,33898,0,80),TRIANGLE);
$x->addMember($x->getOutputName(0),'max',remapRange(33898,0,33898,0,60), remapRange(44044,0,65535,0,80),remapRange(65535,0,65535,0,100) ,RINFINITY);
$x->clearRules();
$x->addRule('IF red_colorspace.min THEN output_red_colorspace.min');
$x->addRule('IF red_colorspace.mean THEN output_red_colorspace.mean');
$x->addRule('IF red_colorspace.max THEN output_red_colorspace.max');

$red_colorspace = (isset($_GET['red_colorspace'])) ? $_GET['red_colorspace'] : 14;   

$x->SetRealInput('red_colorspace' , $red_colorspace	);
$fuzzy_arr = $x->calcFuzzy();
$output_red_colorspace = $fuzzy_arr['output_red_colorspace'];
echo $output_red_colorspace;
?>