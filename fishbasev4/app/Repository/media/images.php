<?php

namespace App\Repository\media;

use Illuminate\Database\Eloquent\Model;
use DB;

class images extends Model
{
    public static function images($speccode){
    	$ImagesArray['MainPics'] = self::MainPics($speccode);
    	return $ImagesArray;
    }//end of public static function images

    private static function MainPics($speccode){
		$mainPicsArray = [];
		
    	$MainPicsQry = "SELECT picturesmain.*, species.Genus, species.Species, collaborators.WebPage, collaborators.CollabTypeOrder, picturesmain.LifeStage, collaborators.CollabType, countref.PAESE
    		FROM (species RIGHT JOIN (picturesmain LEFT JOIN zweb_picturetype ON picturesmain.PictureType = zweb_picturetype.PictureType) ON species.SpecCode = picturesmain.SpecCode) LEFT JOIN collaborators ON picturesmain.Entered = collaborators.Personnel LEFT JOIN countref ON picturesmain.C_Code = countref.C_Code
    		WHERE (((picturesmain.SpecCode)= $speccode ) AND ((picturesmain.Scanned)<>0) AND ((picturesmain.PictureType)<>'stamp') AND ((picturesmain.LifeStage)<>'larvae') AND ((picturesmain.LifeStage)<>'egg'))
    		ORDER BY zweb_picturetype.ranktype, picturesmain.PicName";

    	$MainPics = DB::select($MainPicsQry);
    	if(count($MainPics)){
   		 foreach ($MainPics as $MainPicsResult) {
   		 	$mainPicsArray[] = self::GetExtension($MainPicsResult->PicName);
   		 }//end of foreach ($MainPics as $MainPicsResult)
    	}//end of if(count($Images))

    	return $mainPicsArray;
    }//end of private static function MainPics

    private static function GetExtension($filename){
			$GetExtensionArray['FileName'] = $filename;
            $GetExtensionArray['FileExtension'] = pathinfo($filename, PATHINFO_EXTENSION);
            return $GetExtensionArray;
            
    }//end of private static function GetExtension

}//end of class images extends Model
