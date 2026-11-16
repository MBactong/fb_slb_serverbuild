<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\refrens;

class reference extends Model
{
     public static function SpeciesReference($refno){
    	$SpeciesReference = refrens::where('refno', $refno)->get(['author','year','refno', 'source', 'title']);
    	if(count($SpeciesReference)){
    	 	foreach ($SpeciesReference as $SpeciesReferenceResult) {
              $SpeciesReferenceArray['author'] = $SpeciesReferenceResult->author;
              $SpeciesReferenceArray['year'] = $SpeciesReferenceResult->year;
              $SpeciesReferenceArray['refno'] = $SpeciesReferenceResult->refno;
              $SpeciesReferenceArray['source'] = $SpeciesReferenceResult->source;
              $SpeciesReferenceArray['title'] = $SpeciesReferenceResult->title;
    			}//end of foreach ($SpeciesReproduction as $SpeciesReproductionResult)
    		return $SpeciesReferenceArray;
    	}//end of if(count($SpeciesReproduction))
     }//end of public static function SpeciesReproduction($speccode)
}//end of class reference extends Model
