<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;

class morphology extends Model
{
    public static function SpeciesMorphology($speccode){
    	 $MorphologyQuery = self::morphologyquery($speccode);
         $Morphology = DB::select( $MorphologyQuery);
        if(count($Morphology)) {
            return (array)$Morphology[0];
          /*foreach ($Morphology as $MorphologyResult) {
               $SpeciesMorphologyArray['StockCode'] =  $MorphologyResult->StockCode;
               $SpeciesMorphologyArray['Males'] =  $MorphologyResult->Males;
               $SpeciesMorphologyArray['Females'] =  $MorphologyResult->Females;
               $SpeciesMorphologyArray['dorsalspinesmin'] =  $MorphologyResult->dorsalspinesmin;
               $SpeciesMorphologyArray['dorsalspinesmax'] =  $MorphologyResult->dorsalspinesmax;
               $SpeciesMorphologyArray['dorsalsoftraysmin'] =  $MorphologyResult->dorsalsoftraysmin;
               $SpeciesMorphologyArray['dorsalsoftraysmax'] =  $MorphologyResult->dorsalsoftraysmax;
               $SpeciesMorphologyArray['analfinspinesmin'] =  $MorphologyResult->analfinspinesmin;
               $SpeciesMorphologyArray['analfinspinesmax'] =  $MorphologyResult->analfinspinesmax;
               $SpeciesMorphologyArray['araymin'] =  $MorphologyResult->araymin;
               $SpeciesMorphologyArray['Vertebraetotalmin'] =  $MorphologyResult->Vertebraetotalmin;
               $SpeciesMorphologyArray['Vertebraetotalmax'] =  $MorphologyResult->Vertebraetotalmax;
               $SpeciesMorphologyArray['addchars'] =  $MorphologyResult->addchars;
          }//end of foreach ($Distribution as $DistributionResult)
           return  $SpeciesMorphologyArray;*/
        }//end of count($Distribution)
        return null;
    }//end of public static function SpeciesMorphology
    
    private static function morphologyquery($speccode){
    	$morphologyquery = "SELECT StockCode, Males, Females,
    										dorsalspinesmin,
    										dorsalspinesmax,
    										dorsalsoftraysmin,
    										dorsalsoftraysmax,
											analfinspinesmin,
											analfinspinesmax,
											araymin, araymax,
											Vertebraetotalmin,
											Vertebraetotalmax,
											addchars
			FROM morphdat WHERE morphdat.SpecCode = $speccode";
			return $morphologyquery;
    }//end of private static function dmorphologyquery


}//end of class morphology extends Model
