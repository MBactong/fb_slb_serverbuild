<?php
namespace App\Repository\speciessummary;
use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\stocks;
use DB;

class cites extends Model
{
     public static function SpeciesCites($speccode){
     	$citesArray['CITES_Ref'] = self::citesRef($speccode);
    	$citesArray['CITES_Code'] = self::citesCode($speccode);;
    	return $citesArray;
     }//end of public static function SpeciesCites

     private static function citesRef($speccode){

     	$citesRefQuery = "SELECT Distinct CITES_Ref FROM stocks where stocks.CITES_Ref IS not NULL";
     	$citesRef = DB::select( $citesRefQuery);

     	if(count($citesRef)){
    	 	foreach ($citesRef as $citesRefResult) {
    	 		$CITES_Ref =  $citesRefResult->CITES_Ref;
    	  	}//end of foreach ($Iucnstatus as $IucnstatusResult) 
    	  	return $CITES_Ref;
    	}//end of if(count($citesRef))

     }//end of private static function citesRefquery

     private static function citesCode($speccode){
     	$citesCodequery = "SELECT CITES_Code FROM stocks where stocks.CITES_Code IS not NULL and stocks.SpecCode = $speccode";
     	$citesCode = DB::select($citesCodequery);

     	if(count($citesCode)){
    	 	foreach ($citesCode as $citesCodeResult) {
    	 		$CITES_Code =  $citesCodeResult->CITES_Code;
    	  	}//end of foreach ($Iucnstatus as $IucnstatusResult) 
    	  	if ($CITES_Code == 'Appendix I') {
				return 'Appendix I: <a href="http://www.cites.org/eng/app/appendices.php" target="_blank">International trade banned</a>';
			}else if ($CITES_Code == 'Appendix II') {
				return 'Appendix II: <a href="http://www.cites.org/eng/app/appendices.php" target="_blank">International trade monitored</a>';
			}else if ($CITES_Code == 'Appendix III') {
				return 'Appendix III: <a href="http://www.cites.org/eng/app/appendices.php" target="_blank">International trade cooperation</a>';
			} else{
				
		}
    	}//end of if(count($citesRef))
    	else{return 'Not Evaluated';}
    	
     }//end of private static function citesRefquery


}//end of class cites extends Model
