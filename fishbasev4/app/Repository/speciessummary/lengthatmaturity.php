<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;

class lengthatmaturity extends Model
{
   public static function SpeciesLengthatmaturity($speccode){
		 $LengthatmaturityQuery = self::lengthatmaturityquery($speccode, $female = true);
		 
         $Lengthatmaturity = DB::select( $LengthatmaturityQuery);
          //dd($LengthatmaturityQuery);
          if(count($Lengthatmaturity)){
			  //$SpeciesLengthatmaturityArray = self::$SpeciesLengthatmaturityArray($Lengthatmaturity);
			  return (array)$Lengthatmaturity[0];
          }else{
          	$LengthatmaturityQuery = self::lengthatmaturityquery($speccode, $female = false);
          	$Lengthatmaturity = DB::select( $LengthatmaturityQuery);
			  //$SpeciesLengthatmaturityArray = self::$SpeciesLengthatmaturityArray($Lengthatmaturity);
			  if(count($Lengthatmaturity)){
				  return (array)$Lengthatmaturity[0];
			  }
          }
        
           return  null;
    }//end of private function SpeciesLengthatmaturity

    private static function lengthatmaturityArray($Lengthatmaturity){
    	print_r($Lengthatmaturity);
    	/*
    	foreach ($Lengthatmaturity as $LengthatmaturityResult) {
               $SpeciesLengthatmaturityArray['Distribution'] =  $LengthatmaturityResult->StockDefs;
          }//end of foreach ($Distribution as $DistributionResult)
          */
    }//end of private static function lengthatmaturityArray

    private static function lengthatmaturityquery($speccode, $female){
    	$lengthatmaturityquery = "SELECT
    		stocks.Maturity,
				maturity.Lm,
				Sum(maturity.Lm) AS SumLm,
				Count(maturity.Lm) AS Count,
				Min(maturity.LengthMatMin) AS LmMin,
				Max(maturity.LengthMatMin2) AS LmMax,
				stocks.Level
				
			FROM
				maturity
				INNER Join stocks ON maturity.Speccode = stocks.SpecCode
			WHERE ((maturity.Speccode = $speccode) AND
			((stocks.level = 'Species in general') OR (stocks.level = 'subSpecies in general'))";

		if($female){
			$lengthatmaturityquery .= " AND maturity.Sex = 'female') 
			GROUP BY
			stocks.Maturity";
		}else{
			$lengthatmaturityquery .= ") GROUP BY
			stocks.Maturity";
		}	
		return $lengthatmaturityquery;

    }//end of private static function lengthatmaturityquery
}
