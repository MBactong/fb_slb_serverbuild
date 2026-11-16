<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;

class environment extends Model
{
	public static function SpeciesSummaryEnvironment($speccode){
		 $EnvironmentQuery = self::environmentquery($speccode);
		 // get original model
		  $Environment = DB::select( $EnvironmentQuery);
          if(count($Environment)){
			return (array)$Environment[0];
          	/*foreach ($Environment as $EnvironmentResult) {
				$SpeciesEnvironmentArray['AnaCat'] =  $EnvironmentResult->AnaCat;
				$SpeciesEnvironmentArray['migratref'] =  $EnvironmentResult->migratref;
				$SpeciesEnvironmentArray['Fresh'] =  $EnvironmentResult->Fresh;
				$SpeciesEnvironmentArray['Brack'] =  $EnvironmentResult->Brack;
				$SpeciesEnvironmentArray['Saltwater'] =  $EnvironmentResult->Saltwater;
				$SpeciesEnvironmentArray['pHMin'] =  $EnvironmentResult->pHMin;
				$SpeciesEnvironmentArray['pHMax'] =  $EnvironmentResult->pHMax;
				$SpeciesEnvironmentArray['dHMin'] =  $EnvironmentResult->dHMin;
				$SpeciesEnvironmentArray['dHMax'] =  $EnvironmentResult->dHMax;
				$SpeciesEnvironmentArray['DepthRangeShallow'] =  $EnvironmentResult->DepthRangeShallow;
				$SpeciesEnvironmentArray['DepthRangeDeep'] =  $EnvironmentResult->DepthRangeDeep;
				$SpeciesEnvironmentArray['DepthRangeRef'] =  $EnvironmentResult->DepthRangeRef;
				$SpeciesEnvironmentArray['DepthRangeComShallow'] =  $EnvironmentResult->DepthRangeComShallow;
				$SpeciesEnvironmentArray['DepthRangeComDeep'] =  $EnvironmentResult->DepthRangeComDeep;
				$SpeciesEnvironmentArray['DepthComRef'] =  $EnvironmentResult->DepthComRef;
				$SpeciesEnvironmentArray['TempMin'] =  $EnvironmentResult->TempMin;
				$SpeciesEnvironmentArray['TempMax'] =  $EnvironmentResult->TempMax;
				$SpeciesEnvironmentArray['TempRef'] =  $EnvironmentResult->TempRef;
				$SpeciesEnvironmentArray['TempPreferred'] =  $EnvironmentResult->TempPreferred;
				$SpeciesEnvironmentArray['TempPrefRef'] =  $EnvironmentResult->TempPrefRef;
				$SpeciesEnvironmentArray['NorthernMost'] =  $EnvironmentResult->NorthernMost;    
				$SpeciesEnvironmentArray['NorthSouthS'] =  $EnvironmentResult->NorthSouthS;
				$SpeciesEnvironmentArray['SoutherMost'] =  $EnvironmentResult->SoutherMost;   
				$SpeciesEnvironmentArray['NorthSouthN'] =  $EnvironmentResult->NorthSouthN;
				$SpeciesEnvironmentArray['WesternMost'] =  $EnvironmentResult->WesternMost;   
				$SpeciesEnvironmentArray['WestEastW'] =  $EnvironmentResult->WestEastW;
				$SpeciesEnvironmentArray['EasternMost'] =  $EnvironmentResult->EasternMost;   
				$SpeciesEnvironmentArray['WestEastE'] =  $EnvironmentResult->WestEastE;
				$SpeciesEnvironmentArray['boundingRef'] =  $EnvironmentResult->boundingRef;
				$SpeciesEnvironmentArray['Maturity'] =  $EnvironmentResult->Maturity;
              }//end of  foreach ($SpeciesEtymology as $GenusEtymologyResult) 
			  return $SpeciesEnvironmentArray;
			  */
		  }//end of if 
		  return null;
	}//end of public static function SpeciesSummaryImages
    
    private static function environmentquery($speccode){
    	$environmentquery = "SELECT

    	species.AnaCat,
		species.migratref,
		species.Fresh,
		species.Brack,
		species.Saltwater,
		species.DemersPelag,

		stocks.pHMin,
		stocks.pHMax,
		stocks.dHMin,
		stocks.dHMax,
		
		species.DepthRangeShallow,
		species.DepthRangeDeep,
		species.DepthRangeRef,
		species.DepthRangeComShallow,
		species.DepthRangeComDeep,
		species.DepthComRef,
    	
    	stocks.TempMin,
		stocks.TempMax,
		stocks.TempRef,
		stocks.TempPreferred,
		stocks.TempPrefRef,
		
		stocks.Envtemp,
		stocks.NorthernMost,		
		stocks.NorthSouthS,
		stocks.SoutherMost,		
		stocks.NorthSouthN,
		stocks.WesternMost,		
		stocks.WestEastW,
		stocks.EasternMost,		
		stocks.WestEastE,
		stocks.boundingRef,
		stocks.Maturity


	FROM
		(species LEFT JOIN families ON species.FamCode = families.FamCode)
		LEFT JOIN stocks ON species.SpecCode = stocks.SpecCode
		LEFT Join maturity ON maturity.Speccode = species.SpecCode
	WHERE
		(((species.SpecCode)= $speccode )
		AND ((stocks.Level)='Species in general' Or (stocks.Level)='subSpecies in general'))
		LIMIT 1
	";

	return $environmentquery;
    }//end of  public static function environmentquery($speccode)

}//end of class speciesenvironment extends Model
