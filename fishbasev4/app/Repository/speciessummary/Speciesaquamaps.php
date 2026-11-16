<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\aquamaps;
use DB;

class Speciesaquamaps extends Model
{
   public static function SpeciesSummaryAquamaps($speccode){
   	$SpeciesAquamaps = aquamaps::where('aquamaps.speccode', $speccode)
                      ->leftJoin('synonyms', 'aquamaps.speccode', '=', 'synonyms.speccode')
                      ->where('synonyms.valid', '=', 1)
                      ->get(['speciesid', 'FAOAreaIn', 'database_id', 'expert_id', 'WoRMS_id']);
      if(count($SpeciesAquamaps)){
   	  foreach ( $SpeciesAquamaps as  $SpeciesAquamapResult) {
            if($SpeciesAquamapResult->expert_id){
              $SpeciesAquamapArray['filename'] = "exp_" . $SpeciesAquamapResult->expert_id . "_" . "pic_" . trim($SpeciesAquamapResult->speciesid) . ".jpg";
            }else{
               $SpeciesAquamapArray['filename'] = "pic_" . trim($SpeciesAquamapResult->speciesid) . ".jpg";
            }
            $SpeciesAquamapArray['speciesid']= $SpeciesAquamapResult->speciesid;
            $SpeciesAquamapArray['FAOAreaIn']= $SpeciesAquamapResult->FAOAreaIn;
            $SpeciesAquamapArray['database_id']= $SpeciesAquamapResult->database_id;
            $SpeciesAquamapArray['expert_id']= $SpeciesAquamapResult->expert_id;
            $SpeciesAquamapArray['WoRMS_id']= $SpeciesAquamapResult->WoRMS_id;
         }//end of foreach ( $SpeciesBiology as  $SpeciesBiologyResult)
          return  $SpeciesAquamapArray;
      }//end of if(count($SpeciesAquamaps)){
   }//end of  public static function SpeciesAquamaps($speccode)
}
            

           