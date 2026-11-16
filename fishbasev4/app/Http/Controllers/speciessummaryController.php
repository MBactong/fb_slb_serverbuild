<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Repository\fbapp\species;
use App\Repository\fbapp\synonyms;
use App\Repository\fbapp\genera;
use App\Repository\speciessummary\classification;
use App\Repository\speciessummary\environment;
use App\Repository\speciessummary\distribution;
use App\Repository\speciessummary\image;
use App\Repository\speciessummary\name;
use App\Repository\speciessummary\biology;
use App\Repository\speciessummary\Speciesaquamaps;
use App\Repository\speciessummary\lengthatmaturity;
use App\Repository\speciessummary\morphology;
use App\Repository\speciessummary\reproduction;
use App\Repository\speciessummary\reference;
use App\Repository\speciessummary\iucnstatus;
use App\Repository\speciessummary\cites;
use App\Repository\speciessummary\cms;
use App\Repository\speciessummary\threat;
use App\Repository\speciessummary\uses;
use App\Repository\speciessummary\moreinfo;
use App\Repository\speciessummary\estimates;
use App\Repository\media\images;
use FishBase;



class speciessummaryController extends Controller
{
    public function show($speccode){
        
        $SpeciesSummaryArray = [];
        $species = species::where('SpecCode', $speccode)->get()->first();
        if (!$species) {
            abort(404);
        }
        
        $SpeciesSummaryArray['Species'] = (array)$species->toArray();

        $SpeciesName = name::SpeciesSummaryName($speccode);
        
        $SpeciesClassification = classification::SpeciesSummaryClassification($speccode);
        $SpeciesEnvironment = environment::SpeciesSummaryEnvironment($speccode);
        $SpeciesAquamaps = Speciesaquamaps::SpeciesSummaryAquamaps($speccode);
        $SpeciesDistribution = distribution::SpeciesDistribution($speccode);
        $Specieslengthatmaturity = lengthatmaturity::SpeciesLengthatmaturity($speccode);
        $SpeciesMorphology = morphology::SpeciesMorphology($speccode);
        $SpeciesBiology = biology::SpeciesBiology($speccode);
        $SpeciesReproduction = reproduction::SpeciesReproduction($speccode, $SpeciesDistribution['StockCode']);
        $SpeciesReference = reference::SpeciesReference($SpeciesName['speciesrefno']);
        $SpeciesIucnStatus = iucnstatus::SpeciesIucnstatus($speccode);
        $SpeciesCites = cites::SpeciesCites($speccode);
        $SpeciesCMS = cms::SpeciesCMS($speccode);
        $SpeciesThreat = threat::SpeciesThreat($speccode);
        $SpeciesUses = uses::SpeciesUses($speccode);
        $Estimates = estimates::SpeciesEstimates($speccode, $SpeciesDistribution['StockCode']);
        $SpeciesImages = image::SpeciesSummaryImages($speccode, $SpeciesClassification['Family']);
	    $Images = images::images($speccode, $SpeciesClassification['Family']);

        

        $SpeciesSummaryArray['Name'] =  $SpeciesName;
        $SpeciesSummaryArray['Authors'] =  self::SpeciesNameMethod($speccode, $SpeciesName);
        //$SpeciesSummaryArray['Images'] = $SpeciesImages;
        //$SpeciesSummaryArray['Images2'] = $Images;
        $SpeciesSummaryArray['Images'] = $Images;
        $SpeciesSummaryArray['Images']['Preferred']= $SpeciesImages;
        $SpeciesSummaryArray['Classification'] = $SpeciesClassification;
        $SpeciesSummaryArray['Environment'] = $SpeciesEnvironment;
        $SpeciesSummaryArray['Aquamaps'] = $SpeciesAquamaps; 
        $SpeciesSummaryArray['Distribution'] = $SpeciesDistribution;
        $SpeciesSummaryArray['Morphology'] = $SpeciesMorphology;   //Short description
        $SpeciesSummaryArray['Biology'] = $SpeciesBiology;
        $SpeciesSummaryArray['Reproduction'] = $SpeciesReproduction;   //Life cycle and mating behavior
        $SpeciesSummaryArray['LengthMaturity'] = $Specieslengthatmaturity;   //Size, weight, age
        $SpeciesSummaryArray['Reference'] = $SpeciesReference;   
        $SpeciesSummaryArray['IucnStatus'] = $SpeciesIucnStatus;   
        $SpeciesSummaryArray['Cites'] = $SpeciesCites;
        $SpeciesSummaryArray['CMS'] = $SpeciesCMS;
        $SpeciesSummaryArray['Threat'] = $SpeciesThreat;
        $SpeciesSummaryArray['Uses'] = $SpeciesUses;

        try {
            $stockcode = ($SpeciesSummaryArray['Morphology']['StockCode'] || $SpeciesSummaryArray['Distribution']['StockCode'] ? ($SpeciesSummaryArray['Morphology']['StockCode'] ? $SpeciesSummaryArray['Morphology']['StockCode'] : $SpeciesSummaryArray['Distribution']['StockCode']) : null);
        }
        catch(\Exception $e) {
            $stockcode = null;
        }
        $SpeciesSummaryArray['MoreInfo'] = moreinfo::SpeciesMoreinfo($speccode, $stockcode);
        $SpeciesSummaryArray['Estimates'] = $Estimates;//estimates::SpeciesEstimates($speccode, $stockcode);
        $SpeciesSummaryArray['EstimatesNutrients'] =  self::EstimatesNutrientsMethod($Estimates);
        //print_r($SpeciesSummaryArray['Authors']);

        return view('speciessummary',['speciessummary' => $SpeciesSummaryArray]);
    }//end of public function show($speciesname)

    private static function SpeciesNameMethod($speccode, $SpeciesSummaryNameArray){
        
        //isolate author names
        $SpeciesAuthor = $SpeciesSummaryNameArray['Author'];
        //echo $SpeciesAuthor;
        //$SpeciesAuthorLinks = $SpeciesSummaryNameArray['Authorlinks'];
        //$SpeciesAuthors = preg_replace('/^\(|\)$|\d|\,|\&/', "", $SpeciesAuthor); //remove year
        $SpeciesAuthors = preg_replace('/^\(|\)$|\d|/', "", $SpeciesAuthor); //remove year
        $SpeciesAuthorArray = preg_split('/\,|\&/', trim($SpeciesAuthors), -1, PREG_SPLIT_NO_EMPTY);
        $AuthourCount = count($SpeciesAuthorArray);
        //echo $AuthourCount . "<br><br>" ;
      //  print_r($SpeciesAuthorArray);

        
        
        //check if there is a start parenthesis
        if(strpos($SpeciesAuthor, ")")){
            $SpeciesSummaryNameSectionArray['startparenthesis'] = "(";
        }else{
            $SpeciesSummaryNameSectionArray['startparenthesis'] = "";
        }
        
        for($i = 0; $i < $AuthourCount; $i++){
           // echo $SpeciesAuthorArray[$i];
            $individualAuthor = $SpeciesAuthorArray[$i];
            $SpeciesSummaryNameSectionArray['individualAuthor'][$i]['AutName'] = $individualAuthor;
            $SpeciesNameLinks = name::AuthorNameLinks($speccode, $SpeciesAuthorArray[$i]);
            //$SpeciesNameLinksArray = $SpeciesNameLinks;
            
           
            if(isset($SpeciesNameLinks[$i]['URL'])){
                $SpeciesSummaryNameSectionArray['individualAuthor'][$i]['URL'] = ($SpeciesNameLinks[$i]['URL']);       
            }
            if($AuthourCount > 1 && $i < ($AuthourCount -1) ){
                $SpeciesSummaryNameSectionArray['individualAuthor'][$i]['divider'] = ",";
            }
            if($AuthourCount > 1 && $i == ($AuthourCount -2) ){
                $SpeciesSummaryNameSectionArray['individualAuthor'][$i]['divider'] = " &";
            }
            if($i == ($AuthourCount -1) ){
                $SpeciesSummaryNameSectionArray['individualAuthor'][$i]['divider'] = ",";
            }
          
        }
         
        

        //isolate year from authornames
        if(preg_match_all('/\d+/', $SpeciesAuthor, $AuthorYearArray)){
            $SpeciesSummaryNameSectionArray['Year'] = $AuthorYearArray[0][0];
        }

        //check if there is a ending parenthesis
        if(strpos($SpeciesAuthor, ")")){
            $SpeciesSummaryNameSectionArray['endparenthesis'] = ")";
        }else{
            $SpeciesSummaryNameSectionArray['endparenthesis'] = "";
        }
        //print_r($SpeciesSummaryNameSectionArray);
        return $SpeciesSummaryNameSectionArray;
    }//end of private static function SpeciesNameMethod

    private static function EstimatesNutrientsMethod($Estimates){
        $EstimatesNutrientsArray['Calcium'] = FishBase::sigFig($Estimates['Nutrients']['Calcium'], 3); 
        $EstimatesNutrientsArray['Calcium_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Calcium'], $Estimates['Nutrients']['Calcium_l95']); 
        $EstimatesNutrientsArray['Calcium_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Calcium'], $Estimates['Nutrients']['Calcium_u95']); 
        $EstimatesNutrientsArray['Iron'] = FishBase::sigFig($Estimates['Nutrients']['Iron'], 3); 
        $EstimatesNutrientsArray['Iron_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Iron'], $Estimates['Nutrients']['Iron_l95']); 
        $EstimatesNutrientsArray['Iron_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Iron'], $Estimates['Nutrients']['Iron_u95']);
        $EstimatesNutrientsArray['Omega3'] = FishBase::sigFig($Estimates['Nutrients']['Omega3'], 3); 
        $EstimatesNutrientsArray['Omega3_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Omega3'], $Estimates['Nutrients']['Omega3_l95']); 
        $EstimatesNutrientsArray['Omega3_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Omega3'], $Estimates['Nutrients']['Omega3_u95']);  
        $EstimatesNutrientsArray['Protein'] = FishBase::sigFig($Estimates['Nutrients']['Protein'], 3); 
        $EstimatesNutrientsArray['Protein_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Protein'], $Estimates['Nutrients']['Protein_l95']); 
        $EstimatesNutrientsArray['Protein_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Protein'], $Estimates['Nutrients']['Protein_u95']); 
        $EstimatesNutrientsArray['Selenium'] = FishBase::sigFig($Estimates['Nutrients']['Selenium'], 3); 
        $EstimatesNutrientsArray['Selenium_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Selenium'], $Estimates['Nutrients']['Selenium_l95']); 
        $EstimatesNutrientsArray['Selenium_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Selenium'], $Estimates['Nutrients']['Selenium_u95']);  
        $EstimatesNutrientsArray['VitaminA'] = FishBase::sigFig($Estimates['Nutrients']['VitaminA'], 3);
        $EstimatesNutrientsArray['VitaminA_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['VitaminA'], $Estimates['Nutrients']['VitaminA_l95']); 
        $EstimatesNutrientsArray['VitaminA_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['VitaminA'], $Estimates['Nutrients']['VitaminA_u95']);
        $EstimatesNutrientsArray['Zinc'] = FishBase::sigFig($Estimates['Nutrients']['Zinc'], 3); 
        $EstimatesNutrientsArray['Zinc_l95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Zinc'], $Estimates['Nutrients']['Zinc_l95']); 
        $EstimatesNutrientsArray['Zinc_u95'] = FishBase::setDecimalPlace($EstimatesNutrientsArray['Zinc'], $Estimates['Nutrients']['Zinc_u95']);
        
        return $EstimatesNutrientsArray;

    }//end of private static function SpeciesNameMethod
   
}//end of class speciessummaryController extends Controller


