<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;

use App\Repository\fbapp\species;
use App\Repository\fbapp\country;
use App\Repository\fbapp\faoareas;
use App\Repository\fbapp\ecosystem;
use App\Repository\fbapp\occurrence;
use App\Repository\fbapp\intrcase;
use App\Repository\fbapp\stocks;
use App\Repository\fbapp\ecology;
use App\Repository\fbapp\diet;
use App\Repository\fbapp\fooditems;
use App\Repository\fbapp\popqb;
use App\Repository\fbapp\ration;
use App\Repository\fbapp\comnames;
use App\Repository\fbapp\synonyms;
use App\Repository\fbapp\oxygen;
use App\Repository\fbapp\predats;
use App\Repository\fbapp\cl50;
use App\Repository\fbapp\reproduc;
use App\Repository\fbapp\maturity;
use App\Repository\fbapp\spawning;
use App\Repository\fbapp\spawnagg;
use App\Repository\fbapp\fecundity;
use App\Repository\fbapp\eggs;
use App\Repository\fbapp\eggdev;
use App\Repository\fbapp\popchar;
use App\Repository\fbapp\popgrowth;
use App\Repository\fbapp\poplw;
use App\Repository\fbapp\popll;
use App\Repository\fbapp\poplf;
use App\Repository\fbapp\morphmet;
use App\Repository\fbapp\morphdat;
use App\Repository\fbapp\larvae;
use App\Repository\fbapp\larvdyn;
use App\Repository\fbapp\abundance;
use App\Repository\fbapp\biblio;
use App\Repository\fbapp\cultsys;
use App\Repository\fbapp\strains;
use App\Repository\fbapp\genetics;
use App\Repository\fbapp\elecstudies;
use App\Repository\fbapp\genedat;
use App\Repository\fbapp\diseases;
use App\Repository\fbapp\proxims;
use App\Repository\fbapp\massconversion;
use App\Repository\fbapp\vision;
use App\Repository\fbapp\acknowledge;
use App\Repository\fbapp\picturesmain;
use App\Repository\fbapp\sounds;
use App\Repository\fbapp\ciguafb;
use App\Repository\fbapp\speed;
use App\Repository\fbapp\swimming;
use App\Repository\fbapp\gillarea;
use App\Repository\fbapp\otoliths;
use App\Repository\fbapp\brains;

use DB;
class moreinfo extends Model
{
    public static function SpeciesMoreinfo($speccode, $stockcode){
    	
              $SpeciesMoreinfoArray['country'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\country');
              $SpeciesMoreinfoArray['faoareas'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\faoareas');
              $SpeciesMoreinfoArray['ecosystem'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\ecosystem');
              $SpeciesMoreinfoArray['occurrence'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\occurrence');
              $SpeciesMoreinfoArray['intrcase'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\intrcase');
              $SpeciesMoreinfoArray['stockcode'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\stocks');
              $SpeciesMoreinfoArray['ecology'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\ecology');
              $SpeciesMoreinfoArray['diet'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\diet');
              $SpeciesMoreinfoArray['fooditems'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\fooditems');
              $SpeciesMoreinfoArray['popqb'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\popqb');
              $SpeciesMoreinfoArray['ration'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\ration');
              $SpeciesMoreinfoArray['comnames'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\comnames');
              $SpeciesMoreinfoArray['synonyms'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\synonyms');
              $SpeciesMoreinfoArray['oxygen'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\oxygen');
              $SpeciesMoreinfoArray['predats'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\predats');
              $SpeciesMoreinfoArray['cl50'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\cl50');
              $SpeciesMoreinfoArray['reproduc'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\reproduc');
              $SpeciesMoreinfoArray['maturity'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\maturity');
              $SpeciesMoreinfoArray['spawning'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\spawning');
              $SpeciesMoreinfoArray['spawnagg'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\spawnagg');
              $SpeciesMoreinfoArray['fecundity'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\fecundity');
              $SpeciesMoreinfoArray['eggs'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\eggs');
              $SpeciesMoreinfoArray['eggdev'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\eggdev');
              $SpeciesMoreinfoArray['popchar'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\popchar');
              $SpeciesMoreinfoArray['popgrowth'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\popgrowth');
              $SpeciesMoreinfoArray['poplw'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\poplw');
              $SpeciesMoreinfoArray['popll'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\popll');
              $SpeciesMoreinfoArray['poplf'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\poplf');
              $SpeciesMoreinfoArray['morphmet'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\morphmet');
              $SpeciesMoreinfoArray['morphdat'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\morphdat');
              $SpeciesMoreinfoArray['larvae'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\larvae');
              $SpeciesMoreinfoArray['larvdyn'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\larvdyn');
              $SpeciesMoreinfoArray['abundance'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\abundance');
              $SpeciesMoreinfoArray['biblio'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\biblio');
              $SpeciesMoreinfoArray['cultsys'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\cultsys');
 	      $SpeciesMoreinfoArray['profile'] = self::moreinfoqry2($speccode, 'App\Repository\fbapp\species');
              $SpeciesMoreinfoArray['strains'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\strains');
              $SpeciesMoreinfoArray['genetics'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\genetics');
              $SpeciesMoreinfoArray['elecstudies'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\elecstudies');
              $SpeciesMoreinfoArray['genedat'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\genedat');
              $SpeciesMoreinfoArray['diseases'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\diseases');
              $SpeciesMoreinfoArray['proxims'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\proxims');
              $SpeciesMoreinfoArray['massconversion'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\massconversion'); 
              $SpeciesMoreinfoArray['vision'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\vision');
              $SpeciesMoreinfoArray['acknowledge'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\acknowledge');
	      $SpeciesMoreinfoArray['stamps'] = self::moreinfoqry3($speccode, 'App\Repository\fbapp\picturesmain');
              $SpeciesMoreinfoArray['sounds'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\sounds'); 
              $SpeciesMoreinfoArray['ciguafb'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\ciguafb');
              $SpeciesMoreinfoArray['speed'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\speed');
              $SpeciesMoreinfoArray['swimming'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\swimming');
              $SpeciesMoreinfoArray['gillarea'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\gillarea');
              $SpeciesMoreinfoArray['otoliths'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\otoliths');
              $SpeciesMoreinfoArray['brains'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\brains');           

              $SpeciesMoreinfoArray['recruitment'] = self::moreinfoqry($speccode, 'App\Repository\fbapp\recruitment');           




            
    		return  $SpeciesMoreinfoArray;
    
     }//end of  public static function SpeciesMoreinfo

     private static function moreinfoqry($speccode, $tablename){
        $table =  new $tablename;
        $withRecord = $table::where('SpecCode', $speccode)->get('SpecCode')->take(1);
        if(count($withRecord)){
          return $speccode;
        }
     }//end of private static function moreinfoqry

     private static function moreinfoqry2($speccode, $tablename){
        $table =  new $tablename;
        $withRecord = $table::where('SpecCode', $speccode)
                              ->whereNotNull('Profile')
                              ->get('SpecCode')->take(1);
        if(count($withRecord)){
          return $speccode;
        }
     }//end of private static function moreinfoqry2


     private static function moreinfoqry3($speccode, $tablename){
        $table =  new $tablename;
        $withRecord = $table::where('SpecCode', $speccode)
                              ->where('picturesmain.PictureType', 'stamp')
                              ->get('SpecCode')->take(1);
        if(count($withRecord)){
          return $speccode;
        }
     }//end of private static function moreinfoqry3

}//end of class moreinfo
