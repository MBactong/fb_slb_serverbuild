<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Repository\fbapp\reproduc;

class reproduction extends Model
{
    public static function SpeciesReproduction($speccode, $stockcode){
    	$SpeciesReproduction = reproduc::where('StockCode', $stockcode)->get('AddInfos');
    	if(count($SpeciesReproduction)){
    	 	foreach ($SpeciesReproduction as $SpeciesReproductionResult) {
               $SpeciesReproductionArray['AddInfos'] = $SpeciesReproductionResult->AddInfos;
    			}//end of foreach ($SpeciesReproduction as $SpeciesReproductionResult)
    		return $SpeciesReproductionArray;
    	}//end of if(count($SpeciesReproduction))
     }//end of public static function SpeciesReproduction($speccode)
}//end of class reproduction extends Model

