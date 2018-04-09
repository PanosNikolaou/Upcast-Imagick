<?
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

echo remapRange(10808,0,22125,0,100)

?>