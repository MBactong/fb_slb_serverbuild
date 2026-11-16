<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\species;
use App\Repository\fbapp\families;
use DB;

class image extends Model
{
    public static function SpeciesSummaryImages($speccode, $Family){
    	$SpeciesImages = species::where('SpecCode')->get(['PicPreferredName', 'PicPreferredNameM', 'PicPreferredNameF', 'PicPreferredNameJ']);;
        
        if(count($SpeciesImages)){
            foreach ($SpeciesImages as $SpeciesImage) {
                $SpeciesImageArray['PicPreferredName'] =  $SpeciesImage->PicPreferredName;
                $SpeciesImageArray['PicPreferredNameM'] =  $SpeciesImage->PicPreferredNameM;
                $SpeciesImageArray['PicPreferredNameF'] =  $SpeciesImage->PicPreferredNameF;
                $SpeciesImageArray['PicPreferredNameJ'] =  $SpeciesImage->PicPreferredNameJ ;
            }//end of foreach ($Distribution as $DistributionResult)
            return  $SpeciesImageArray;
            
        }//end of   if(count($SpeciesImages))
        else{
            $FamilyPic = self::FamilyPic($Family);
            return $FamilyPic;
        }//return null;
    }//end of public static function SpeciesSummaryImages

    
    

    private static function FamilyPic($Family){
        $FamilyImage = families::where('Family', $Family)->get(['FamPic', 'Family']);
        if(count($FamilyImage)){
            foreach ($FamilyImage as $FamilyImageResult) {
                $FamilyImageArray['FamPic'] =  $FamilyImageResult->FamPic;
                $FamilyImageArray['Family'] =  $FamilyImageResult->Family;
            }
            return $FamilyImageArray;
        }
    }//end of private static function FamilyPic

}//end of class image extends Model