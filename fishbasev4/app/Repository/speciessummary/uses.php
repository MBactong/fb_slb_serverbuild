<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\species;
use DB;

class uses extends Model
{
    public static function SpeciesUses($speccode){
    	$SpeciesUses = species::where('species.SpecCode', $speccode)
          ->leftJoin('ISSCAAP', 'ISSCAAP.SpecCode', '=', 'species.SpecCode')
          ->leftJoin('stocks', 'stocks.SpecCode', '=', 'species.SpecCode')
          ->where('ISSCAAP.FIRMS_Summ', '<>', 0)
          ->where('ISSCAAP.DB', '=', 'FB')
          ->where('stocks.level', '=', 'species in general')
          ->get(['Importance', 'GameFish', 'UsedforAquaculture', 'UsedasBait', 'Aquarium', 'pricecateg', 'pricereliability', 'Stats_Aquaculture', 'FS_CulturedSumm', 'Stats_Catch', 'FS_AquaticSumm', 'Species.genus', 'Species.species', 'ISSCAAP.figis_id', 'AlphaCode', 'stocks.saup_id', 'fbname']);
      
    	if(count($SpeciesUses)){
    	 	foreach ($SpeciesUses as $SpeciesUsesResult) {
              $SpeciesUsesArray['Importance'] = $SpeciesUsesResult->Importance;
              $SpeciesUsesArray['GameFish'] = $SpeciesUsesResult->GameFish;
              $SpeciesUsesArray['UsedforAquaculture'] = $SpeciesUsesResult->UsedforAquaculture;
              $SpeciesUsesArray['UsedasBait'] = $SpeciesUsesResult->UsedasBait;
              $SpeciesUsesArray['Aquarium'] = $SpeciesUsesResult->Aquarium;
              $SpeciesUsesArray['pricecateg'] = $SpeciesUsesResult->pricecateg;
              $SpeciesUsesArray['pricereliability'] = $SpeciesUsesResult->pricereliability;
              $SpeciesUsesArray['Stats_Aquaculture'] = $SpeciesUsesResult->Stats_Aquaculture;
              $SpeciesUsesArray['FS_CulturedSumm'] = $SpeciesUsesResult->FS_CulturedSumm;
              $SpeciesUsesArray['Stats_Catch'] = $SpeciesUsesResult->Stats_Catch;
              $SpeciesUsesArray['FS_AquaticSumm'] = $SpeciesUsesResult->FS_AquaticSumm;
              $SpeciesUsesArray['genus'] = $SpeciesUsesResult->genus;
              $SpeciesUsesArray['species'] = $SpeciesUsesResult->species;
              $SpeciesUsesArray['ISSCAAP.figis_id'] = $SpeciesUsesResult->figis_id;
              $SpeciesUsesArray['AlphaCode'] = $SpeciesUsesResult->AlphaCode;
              $SpeciesUsesArray['saup_id'] = $SpeciesUsesResult->saup_id;
              $SpeciesUsesArray['fbname'] = $SpeciesUsesResult->fbname;
            }//end of foreach ($SpeciesThreat as $SpeciesThreatResult)
        $SpeciesCommonNameFao = self::CommonNameFao($speccode);
        $summaryCommonNameFao = DB::select($SpeciesCommonNameFao);
        if(count($summaryCommonNameFao)){
          foreach ($summaryCommonNameFao as $summaryCommonNameFaoResult) {
                $SpeciesUsesArray['ComName'] = $summaryCommonNameFaoResult->ComName;
                $SpeciesUsesArray['unicodetext'] = $summaryCommonNameFaoResult->unicodetext;
          }//end of  foreach ($summaryCommonNameFao as $summaryCommonNameFaoResult) 
          }//end of    if(count($summaryCommonNameFao))

    		return  $SpeciesUsesArray;
    	}//end of if(count($SpeciesThreat))
     }//end of  public static function SpeciesThreat
     
     private static function CommonNameFao($speccode){
       $CommonNameFaoQry = "SELECT
              zweb_CN3.autoctr,
              zweb_CN3.ComName,
              zweb_CN3.unicodetext
            FROM
              zweb_CN3
            WHERE
              ((zweb_CN3.SpecCode)=$speccode)
            AND
              zweb_CN3.Rank1 <> 5
            LIMIT 3";

        return $CommonNameFaoQry;
     }//end of private static function CommonNameFao
}


