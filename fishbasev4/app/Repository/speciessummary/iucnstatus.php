<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Repository\fbapp\stocks;


class iucnstatus extends Model
{
    
    public static function SpeciesIucnstatus($speccode){
    	 $IucnstatusQuery = self::iucnstatusquery($speccode);
    	 $Iucnstatus = DB::select( $IucnstatusQuery);
    	 if(count($Iucnstatus)){
			return (array)$Iucnstatus[0];
    	 	/*foreach ($Iucnstatus as $IucnstatusResult) {
    	 		 $IucnstatusArray['IUCN_id'] =  $IucnstatusResult->IUCN_id;
    	 		 $IucnstatusArray['IUCN_Code'] =  $IucnstatusResult->IUCN_Code;
    	 		 $IucnstatusArray['IUCN_Assessment'] =  $IucnstatusResult->IUCN_Assessment;
    	 		 $IucnstatusArray['IUCN_DateAssessed'] =  $IucnstatusResult->IUCN_DateAssessed;
    	 	}//end of foreach ($Iucnstatus as $IucnstatusResult) 
    	 	return $IucnstatusArray;*/
		 }//end of if(count($Iucnstatus)) 
		 return null;
    }//end of public static function SpeciesIucnstatus
    
    private static function iucnstatusquery($speccode){
    	$iucnstatusquery = "SELECT
    	 	stocks.IUCN_ID,
			stocks.IUCN_IDAssess,
		   	stocks.IUCN_Code,
		   	stocks.IUCN_Assessment,
		   	stocks.IUCN_DateAssessed
    		FROM
		(species LEFT JOIN families ON species.FamCode = families.FamCode)
		LEFT JOIN stocks ON species.SpecCode = stocks.SpecCode
		LEFT Join maturity ON maturity.Speccode = species.SpecCode
	WHERE
		(((species.SpecCode)= $speccode )
		AND ((stocks.Level)='Species in general' Or (stocks.Level)='subSpecies in general'))
		LIMIT 1
    	";
    	
    	return 	$iucnstatusquery;
    }//end of private static function iucnstatusquery($speccode)
  
}//end of class iucnstatus extends Model
