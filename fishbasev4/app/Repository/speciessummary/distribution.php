<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;

class distribution extends Model
{
   public static function SpeciesDistribution($speccode){
         $DistributionQuery = self::distributionquery($speccode);
         $Distribution = DB::select( $DistributionQuery);
        if(count($Distribution)){
          foreach ($Distribution as $DistributionResult) {
               $SpeciesDistributionArray['Distribution'] =  $DistributionResult->StockDefs;
                $SpeciesDistributionArray['StockCode'] =  $DistributionResult->StockCode;
          }//end of foreach ($Distribution as $DistributionResult)
           return  $SpeciesDistributionArray;
        }//end of count($Distribution)
    }//end of private function SpeciesDistribution

	private static function distributionquery($speccode){
		 $distributionquery = 
    	"SELECT
    		stocks.StockDefsGeneral,
    		stocks.StockDefs,
    		stocks.StockCode		
		FROM
			(species LEFT JOIN families ON species.FamCode = families.FamCode)
			LEFT JOIN stocks ON species.SpecCode = stocks.SpecCode
			LEFT Join maturity ON maturity.Speccode = species.SpecCode
		WHERE
			(((species.SpecCode)= $speccode )
			AND ((stocks.Level)='Species in general' Or (stocks.Level)='subSpecies in general'))
			LIMIT 1
		";

	return $distributionquery;
	}//end of public static function environmentquery($speccode
}
