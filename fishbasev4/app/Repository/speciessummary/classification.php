<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;

class classification extends Model
{

    public $table = 'species';
    
    public static function SpeciesSummaryClassification($speccode){
    
        $SpeciesClassification = self::classificationquery($speccode);
        $summaryclassifications = DB::select($SpeciesClassification);
          if(count($summaryclassifications)){
         foreach ($summaryclassifications as $summaryclassification) {
                $SpeciesClassificationArray['SubFamily'] =  $summaryclassification->SubFamily;
                $SpeciesClassificationArray['FamCode'] =  $summaryclassification->FamCode;
                $SpeciesClassificationArray['Family'] =  $summaryclassification->Family;
                $SpeciesClassificationArray['FamComName'] =  $summaryclassification->FamComName;
                $SpeciesClassificationArray['Ordnum'] =  $summaryclassification->Ordnum;
                $SpeciesClassificationArray['Order'] =  $summaryclassification->Order;
                $SpeciesClassificationArray['OrdComName'] =  $summaryclassification->OrdComName;
                $SpeciesClassificationArray['ClassComName'] =  $summaryclassification->ClassComName;
                $SpeciesClassificationArray['Class'] =  $summaryclassification->Class;
         }//end of  foreach ($GenusNameLinks as $GenusNameLink)
        }//end of if(count($summaryclassifications))

          $GenusEtymologyQuery = self::GenusEtymologyQuery($speccode);
          $GenusEtymology = DB::select($GenusEtymologyQuery);
          
          //echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
         // print_r($GenusEtymology);
          if($GenusEtymology){
          foreach ($GenusEtymology as $GenusEtymologyResult) {
                $SpeciesClassificationArray['Genus'] = $GenusEtymologyResult->GenName;
                if($GenusEtymologyResult->ETYFish){
                    $SpeciesClassificationArray['EtymologyGenus'] = $GenusEtymologyResult->ETYFish;
                    $SpeciesClassificationArray['ETYFishURLGenus'] = $GenusEtymologyResult->ETYFishURL;
                  }else{
                    $SpeciesClassificationArray['EtymologyGenus'] = $GenusEtymologyResult->Etymology;
                  }
          }//end of  foreach ($SpeciesEtymology as $GenusEtymologyResult) 
          }//end of  if(count($GenusEtymology)
          
          $SpeciesEtymologyQuery = self::SpeciesEtymologyQuery($speccode);
          $SpeciesEtymology = DB::select($SpeciesEtymologyQuery);
          //print_r($SpeciesEtymology);
          if($SpeciesEtymology){
          foreach ($SpeciesEtymology as $SpeciesEtymologyResult) {
            $SpeciesClassificationArray['Species'] = $SpeciesEtymologyResult->SynSpecies;
            if($SpeciesEtymologyResult->ETYFish){
                $SpeciesClassificationArray['EtymologySpecies'] = $SpeciesEtymologyResult->ETYFish;
                $SpeciesClassificationArray['ETYFishURLSpecies'] = $GenusEtymologyResult->ETYFishURL;
            }else{
                $SpeciesClassificationArray['EtymologySpecies'] = $SpeciesEtymologyResult->Etymology;
            }
            
          }//end of  foreach ($SpeciesEtymology as $SpeciesEtymologyResult)
          }//end of if(count($SpeciesEtymology)){
          return $SpeciesClassificationArray;
    } //end of public static function SpeciesSummaryClassification




    private static function classificationquery($speccode){
    	
    	$classificationquery = 
    	"SELECT
    					species.SubFamily,
    					families.FamCode,
    					families.Family,
    					families.CommonName as FamComName,
    					orders.Ordnum,
    					orders.Order,
    					orders.CommonName as OrdComName,
    					classes.ClassNum,
    					classes.Class,
    					classes.CommonName as ClassComName
    				FROM
    					((species LEFT JOIN families ON species.FamCode = families.FamCode)
    					LEFT JOIN orders ON families.Order = orders.Order)
    					LEFT JOIN classes ON families.ClassNum = classes.ClassNum
    				WHERE
    					species.speccode = $speccode";

    	return $classificationquery;

    }//end of public function query

    

	private static function GenusEtymologyQuery($speccode){
		$GenusEtymologyQuery = "SELECT genera.GenName, genera.Etymology, genera.ETYFish, genera.ETYFishURL
			FROM species INNER JOIN genera ON species.GenCode = genera.GenCode
			WHERE (((genera.GenStatus)='Valid') AND species.SpecCode = $speccode)
			LIMIT 1";

			return $GenusEtymologyQuery;
	}//end ofpublic static function classificationquery

	private static function SpeciesEtymologyQuery($speccode){
		$SpeciesEtymologyQuery = "SELECT synonyms.SynSpecies, synonyms.Etymology, synonyms.ETYFish, synonyms.ETYFishURL
			FROM species
			INNER JOIN synonyms ON species.SpecCode = synonyms.SpecCode
			WHERE Valid = 1 AND species.SpecCode = $speccode
			LIMIT 1";

			return $SpeciesEtymologyQuery;
	}//end ofpublic static function classificationquery
}
