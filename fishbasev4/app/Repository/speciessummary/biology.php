<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\species;
use DB;

class biology extends Model
{
   public static function SpeciesBiology($speccode){
   	 $SpeciesBiology = species::where('SpecCode', $speccode)->get('Comments');
   	 	if(count($SpeciesBiology)){
         foreach ( $SpeciesBiology as  $SpeciesBiologyResult) {
            $SpeciesBiologyArray['Comments']= $SpeciesBiologyResult->Comments;
         }//end of foreach ( $SpeciesBiology as  $SpeciesBiologyResult)
          return $SpeciesBiologyArray;
        }//end of if(count($SpeciesBiology))
   }//end of public static function SpeciesBiology($speccode)
}
