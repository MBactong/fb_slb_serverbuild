<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\estimate;
use App\Repository\fbapp\species;
use App\Repository\fbapp\stocks;
use DB;

class estimates extends Model
{
   public static function SpeciesEstimates($speccode, $stockcode){
   		$SpeciesEstimatesArray['Preftemp'] = self::Preftemp($speccode);
   		$SpeciesEstimatesArray['getPD50'] = self::getPD50($speccode);
   		$SpeciesEstimatesArray['Bayesian'] = self::Bayesian($speccode);
   		$SpeciesEstimatesArray['TrophicLevel'] = self::TrophicLevel($speccode);
   		$SpeciesEstimatesArray['RegenerationTime'] = self::RegenerationTime($speccode);
   		$SpeciesEstimatesArray['Resilience'] = self::Resilience($speccode, $stockcode);
   		$SpeciesEstimatesArray['PriorR'] = self::PriorR($speccode);
   		$SpeciesEstimatesArray['Vulnerability'] = self::Vulnerability($speccode);
   		$SpeciesEstimatesArray['PriceCategory'] = self::PriceCategory($speccode);
      $SpeciesEstimatesArray['Nutrients'] = self::Nutrients($speccode);
   		return $SpeciesEstimatesArray;
   }//end of public static function SpeciesBiology($speccode)

   private static function Preftemp($speccode){
   		 $Preftemp = estimate::where('SpecCode', $speccode)->get(['TempPrefMin', 'TempPrefMean', 'TempPrefMax', 'nCells']);
   	 	if(count($Preftemp)){
         foreach($Preftemp as   $PreftempResult) {
             $PreftempArray['TempPrefMin']= $PreftempResult->TempPrefMin;
             $PreftempArray['TempPrefMean']= $PreftempResult->TempPrefMean;
             $PreftempArray['TempPrefMax']= $PreftempResult->TempPrefMax;
             $PreftempArray['nCells']= $PreftempResult->nCells;
         }//end of foreach ( $SpeciesBiology as  $SpeciesBiologyResult)
          return  $PreftempArray;
        }//end of if(count($SpeciesBiology))
   }//end of private static function Preftemp

   private static function getPD50($speccode){
   		$getPD50 = species::where('SpecCode', $speccode)->get('PD50');
   		if(count($getPD50)){
   			foreach($getPD50 as $getPD50Result) {
   				$getPD50value = $getPD50Result->PD50;
   			}//end of $getPD50
   			return $getPD50value;
   		}//end of if(count($getPD50))
   }//end of private static function getPD50

   private static function Bayesian($speccode){
   		 $Bayesian = estimate::where('SpecCode', $speccode)->get(['a', 'sd_log10a', 'b', 'sd_b', 'Method_ab']);
   	 	if(count($Bayesian)){
         foreach($Bayesian as   $BayesianResult) {
             $BayesianArray['a']= $BayesianResult->a;
             $BayesianArray['sd_log10a']= $BayesianResult->sd_log10a;
             $BayesianArray['b']= $BayesianResult->b;
             $BayesianArray['sd_b']= $BayesianResult->sd_b;
             $BayesianArray['Method_ab']= $BayesianResult->Method_ab;
         }//end of foreach ( $SpeciesBiology as  $SpeciesBiologyResult)
          return  $BayesianArray;
        }//end of if(count($SpeciesBiology))
   }//end of private static function Preftemp

   private static function TrophicLevel($speccode){
   		$TrophicLevelQry = "Select
				ecology.DietTroph,
				ecology.FoodTroph,
				ecology.DietSeTroph,
				ecology.FoodSeTroph,
				estimate.Troph,
				estimate.seTroph
				From
				(estimate
				Right Join species ON estimate.SpecCode = species.SpecCode)
				Left Join ecology ON  ecology.SpecCode = species.SpecCode
				WHERE species.SpecCode = $speccode";

		$TrophicLevel = DB::select( $TrophicLevelQry);
		if(count($TrophicLevel)){
			foreach($TrophicLevel as $TrophicLevelResult){
				$TrophicLevelArray['DietTroph'] = $TrophicLevelResult->DietTroph;
				$TrophicLevelArray['FoodTroph'] = $TrophicLevelResult->FoodTroph ;
				$TrophicLevelArray['DietSeTroph'] = $TrophicLevelResult->DietSeTroph ;
				$TrophicLevelArray['FoodSeTroph'] = $TrophicLevelResult->FoodSeTroph ;
				$TrophicLevelArray['Troph'] = $TrophicLevelResult->Troph ;
				$TrophicLevelArray['seTroph'] = $TrophicLevelResult->seTroph ;
			}//end of foreach($TrophicLevel as $TrophicLevelResult)
			return $TrophicLevelArray;
		}//end of if(count($TrophicLevel))
   }//end of private static function TrophicLevel($speccode)

   private static function RegenerationTime($speccode){
   		$RegenerationTimeQry = "Select
				estimate.Median_T,
				estimate.lcl_T,
				estimate.ucl_T,
				estimate.n_T,
				species.FamCode,
        species.SpecCode
				From
				estimate 
				Right Join species ON estimate.SpecCode = species.SpecCode
				WHERE species.SpecCode = $speccode";


		
		$RegenerationTime = DB::select($RegenerationTimeQry);
		if(count($RegenerationTime)){
			foreach($RegenerationTime as $RegenerationTimeResult){
				$RegenerationTimeArray['Median_T'] = $RegenerationTimeResult->Median_T ;
				$RegenerationTimeArray['lcl_T'] = $RegenerationTimeResult->lcl_T ;
				$RegenerationTimeArray['ucl_T'] = $RegenerationTimeResult->ucl_T ;
				$RegenerationTimeArray['n_T'] = $RegenerationTimeResult->n_T;
				$RegenerationTimeArray['FamCode'] = $RegenerationTimeResult->FamCode;
        $RegenerationTimeArray['SpecCode'] = $RegenerationTimeResult->SpecCode;
			}//end of foreach($RegenerationTime 
			return $RegenerationTimeArray;
		}//end of if(count($RegenerationTime))

   }//end of private static function RegenerationTime

   private static function Resilience($speccode, $stockcode){
   		$Resilience = stocks::where('StockCode', $stockcode)->get(['resilience', 'resilienceremark']);
   		if(count($Resilience)){
   			foreach($Resilience as $ResilienceResult){
   				$ResilienceArray['resilience'] = $ResilienceResult->resilience;
   				$ResilienceArray['resilienceremark'] = $ResilienceResult->resilienceremark;
   			}//end of foreach($Resilience as $ResilienceResult)
   			return $ResilienceArray;
   		}//end of if(count($Resilience))
   }//end of private static function Resilience

   private static function PriorR($speccode){
   		$PriorR = estimate::where('SpecCode', $speccode)->get(['prior_r', 'lcl_r', 'ucl_r', 'comment_r']);

   		if(count($PriorR)){
   			foreach($PriorR as $PriorRResult){
   				$PriorRArray['prior_r'] = $PriorRResult->prior_r;
   				$PriorRArray['lcl_r'] = $PriorRResult->lcl_r;
   				$PriorRArray['ucl_r'] = $PriorRResult->ucl_r;
   				$PriorRArray['comment_r'] = $PriorRResult->comment_r;
   			}//end of foreach($PriorR as $PriorRResult)
   			return $PriorRArray;
   		}//end of if(count($PriorR))
   }//end of private static function PriorR

   private static function Vulnerability($speccode){
   		$Vulnerability = species::where('SpecCode', $speccode)->get(['vulnerability', 'VulnerabilityClimate']);
   		if(count($Vulnerability)){
   			foreach($Vulnerability as $VulnerabilityResult){
   				$VulnerabilityArray['vulnerability'] = $VulnerabilityResult->vulnerability;
          $VulnerabilityArray['VulnerabilityClimate'] = $VulnerabilityResult->VulnerabilityClimate;
   			}//end of foreach($Vulnerability as $VulnerabilityResult)
   			return $VulnerabilityArray;
   		}//end of if(count($Vulnerability)
   }//end of private static function Vulnerability

  
   private static function PriceCategory($speccode){
   		$PriceCategory = species::where('SpecCode', $speccode)->get(['pricecateg', 'pricereliability']);
   		if(count($PriceCategory)){
   			foreach ($PriceCategory as $PriceCategoryResult){
   				$PriceCategoryArray['pricecateg'] = $PriceCategoryResult->pricecateg;
   				$PriceCategoryArray['pricereliability'] = $PriceCategoryResult->pricereliability;
   			}//end of foreach $PriceCategory() 
   				return $PriceCategoryArray;
   		}//end of if(count($PriceCategory))
   }//end of private static function PriceCategory

   private static function Nutrients($speccode){
      $Nutrients = estimate::where('estimate.SpecCode', $speccode)
      ->leftJoin('nutrientssummary', 'estimate.SpecCode', '=', 'nutrientssummary.SpecCode')
      ->get(['NutrientRefNo', 'Environment', 'SampleForm', 'PrepForm', 'NutrientsCode', 'GenusUsed', 'SpeciesUsed','Calcium', 'Calcium_l95', 'Calcium_u95', 'Iron', 'Iron_l95', 'Iron_u95', 'Omega3', 'Omega3_l95', 'Omega3_u95', 'Protein', 'Protein_l95', 'Protein_u95', 'Selenium', 'Selenium_l95', 'Selenium_u95', 'VitaminA', 'VitaminA_l95', 'VitaminA_u95', 'Zinc', 'Zinc_l95', 'Zinc_u95'])
      ->take(1);
     // print_r($Nutrients);
        if(count($Nutrients)){
          foreach ($Nutrients as $NutrientsResult){
            $NutrientsArray['NutrientRefNo'] = $NutrientsResult->NutrientRefNo;
            $NutrientsArray['Environment'] = $NutrientsResult->Environment;
            $NutrientsArray['SampleForm'] = $NutrientsResult->SampleForm;
            $NutrientsArray['PrepForm'] = $NutrientsResult->PrepForm;
            $NutrientsArray['NutrientsCode'] = $NutrientsResult->NutrientsCode;
            //$NutrientsArray['Speccode'] = $NutrientsResult->SpecCode;
            $NutrientsArray['Calcium'] = $NutrientsResult->Calcium;
            $NutrientsArray['Calcium_l95'] = $NutrientsResult->Calcium_l95;
            $NutrientsArray['Calcium_u95'] = $NutrientsResult->Calcium_u95;
            $NutrientsArray['Iron'] = $NutrientsResult->Iron;
            $NutrientsArray['Iron_l95'] = $NutrientsResult->Iron_l95;
            $NutrientsArray['Iron_u95'] = $NutrientsResult->Iron_u95;
            $NutrientsArray['Omega3'] = $NutrientsResult->Omega3;
            $NutrientsArray['Omega3_l95'] = $NutrientsResult->Omega3_l95;
            $NutrientsArray['Omega3_u95'] = $NutrientsResult->Omega3_u95;
            $NutrientsArray['Protein'] = $NutrientsResult->Protein;
            $NutrientsArray['Protein_l95'] = $NutrientsResult->Protein_l95;
            $NutrientsArray['Protein_u95'] = $NutrientsResult->Protein_u95;
            $NutrientsArray['Selenium'] = $NutrientsResult->Selenium;
            $NutrientsArray['Selenium_l95'] = $NutrientsResult->Selenium_l95;
            $NutrientsArray['Selenium_u95'] = $NutrientsResult->Selenium_u95;
            $NutrientsArray['VitaminA'] = $NutrientsResult->VitaminA;
            $NutrientsArray['VitaminA_l95'] = $NutrientsResult->VitaminA_l95;
            $NutrientsArray['VitaminA_u95'] = $NutrientsResult->VitaminA_u95;
            $NutrientsArray['Zinc'] = $NutrientsResult->Zinc;
            $NutrientsArray['Zinc_l95'] = $NutrientsResult->Zinc_l95;
            $NutrientsArray['Zinc_u95'] = $NutrientsResult->Zinc_u95;
            $NutrientsArray['GenusUsed'] = $NutrientsResult->GenusUsed;
            $NutrientsArray['SpeciesUsed'] = $NutrientsResult->SpeciesUsed;
          }//end of foreach ($Nutrients as $NutrientsResult){
          return $NutrientsArray;
        }//end of if(count($Nutrients)){

   }//end of private static function PriceCategory



}//end of class estimates extends Model
