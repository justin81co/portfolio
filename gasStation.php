<?php

function GasStation($strArr) { 

    //Check if any route is possible
    $totalGasAtStation = 0;
    $totalGasToTravel = 0;
    $totalNumGasStation = array_shift($strArr);
    for ($i = 0; $i < $totalNumGasStation; $i++) {
        $gas = explode(':',$strArr[$i]);
        $totalGasAtStation = $totalGasAtStation + $gas[0];
        $totalGasToTravel = $totalGasToTravel + $gas[1];
    }
    if ($totalGasAtStation < $totalGasToTravel) {
        $strArr = "impossible";
    }
    // iterate through the routes 
    else {
        
        $iteration = 0;
        $foundloop = false;
        while (($foundloop == false) && ($iteration <= $totalNumGasStation)) {
            $iteration++;
            $gasTank = 0;
            $isBrokeDown = false;
            $gasStationNum = 0;
            for ($gasStationNum; $gasStationNum < $totalNumGasStation; $gasStationNum++) {
            
                $gas = explode(':',$strArr[$gasStationNum]);
                $gasTank = $gasTank + $gas[0] - $gas[1];
                if ($gasTank < 0) {
                
                    $isBrokeDown = true;
                    break;
                }
            }
        
            if (($isBrokeDown == FALSE) && ($gasStationNum == 4)) {
                $strArr = $iteration;
                $foundloop = true;
            }
            else {
                $deltaGasStation = array_shift($strArr);
                $strArr[] = $deltaGasStation;

            }
        }
    }
    return $strArr; 

}
   
// keep this function call here 
echo GasStation(fgets(fopen('php://stdin', 'r')));

?>