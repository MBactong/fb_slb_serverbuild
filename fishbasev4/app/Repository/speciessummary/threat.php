<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\species;

class threat extends Model
{
   public static function SpeciesThreat($speccode){
    	$SpeciesThreat = species::where('SpecCode', $speccode)->get(['Dangerous', 'DangerousRef']);
    	if(count($SpeciesThreat)){
    	 	foreach ($SpeciesThreat as $SpeciesThreatResult) {
              $SpeciesThreatArray['Dangerous'] = $SpeciesThreatResult->Dangerous;
              $SpeciesThreatArray['DangerousRef'] = $SpeciesThreatResult->DangerousRef;
             }//end of foreach ($SpeciesThreat as $SpeciesThreatResult)
    		return $SpeciesThreatArray;
    	}//end of if(count($SpeciesThreat))
     }//end of  public static function SpeciesThreat
}
