<?php

namespace App\Repository\speciessummary;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Repository\fbapp\species;
use App\Repository\fbapp\synonyms;
use App\Repository\fbapp\genera;
use App\Repository\fbapp\speciesauthorsnames;

class name extends Model
{
     public static function SpeciesSummaryName($speccode){
     	$SpeciesNames = species::where('SpecCode', $speccode)->get(['Genus', 'Species', 'FBname', 'Author','speciesrefno']);
      if(count($SpeciesNames)){
     	foreach ($SpeciesNames as $SpeciesName) {
        	$SpeciesNameArray['Author'] = $SpeciesName->Author;
        	$SpeciesNameArray['FBname'] = $SpeciesName->FBname;
        	$SpeciesNameArray['Genus'] =  $SpeciesName->Genus;
        	$SpeciesNameArray['Species'] = $SpeciesName->Species;
          $SpeciesNameArray['speciesrefno'] = $SpeciesName->speciesrefno;
        }//end of foreach ($SpeciesNames as $SpeciesName)
      }//end of if(count($SpeciesNames)) 	
          $Author = $SpeciesNameArray['Author'];
        	$Genus = $SpeciesNameArray['Genus'];
          $speciesAuthorArr = explode(",", $Author);
          $SpeciesNameArray['Specieslinks'] = self::SpeciesNameLinks($speccode);
		    	$SpeciesNameArray['Genuslinks'] = self::GenusNameLinks($speccode, $Genus);
          //$SpeciesNameArray['Authorlinks'] = self::AuthorNameLinks($speccode, $Author);
        return  $SpeciesNameArray;
     }//end of public static function SpeciesSummaryName($speccode)

     private static function SpeciesNameLinks($speccode){
     	$SpeciesNameLinks = synonyms::where('SpecCode', $speccode)
                           ->Where('Valid', '<>' , 0)
                           ->get(['CAS_SPC', 'CAS_REF_NO']);
        if(count($SpeciesNameLinks)){                   
      	foreach ($SpeciesNameLinks as $SpeciesNameLink) {
           	$SpeciesNameLinkArray['CAS_SPC'] = $SpeciesNameLink->CAS_SPC;
        	$SpeciesNameLinkArray['CAS_REF_NO'] = $SpeciesNameLink->CAS_REF_NO;
        }//end of foreach ($SpeciesNameLinks as $SpeciesNameLink)
        return $SpeciesNameLinkArray;
        }//end of  if(count($SpeciesNameLinks))   
     }//private static function SpeciesNameLinks

     private static function GenusNameLinks($speccode, $Genus){
     	$GenusNameLinks = genera::where('GenName', $Genus)
                                    ->Where('GenStatus', 'Valid')
                                    ->get('GSD_GenusFk');
        if(count($GenusNameLinks)){                    
      	foreach ($GenusNameLinks as $GenusNameLink) {
               $GenusNameLinkArray['GSD_GenusFk'] = $GenusNameLink->GSD_GenusFk;
        }//end of  foreach ($GenusNameLinks as $GenusNameLink)
        return  $GenusNameLinkArray;
        }//end of  if(count($GenusNameLinks)){ 
      }//end of private static function GenusNameLinks


      public static function AuthorNameLinks($speccode, $Author){
        $AuthorNameLinksQuery = self::AuthorNameLinksQuery($speccode, $Author);
         $AuthorNameLinks = DB::select( $AuthorNameLinksQuery);
        if(count($AuthorNameLinks)) {
          $AuthorNameLinks = json_decode(json_encode($AuthorNameLinks), true);
          
          return (array)$AuthorNameLinks;
          
        }//end of if(count($AuthorNameLinks))
      }//end of private static function AuthorNameLinks
      

      private static function AuthorNameLinksQuery($speccode, $Author){
          //$AutName = preg_replace("/^\(|\)$/", '', trim($Author));

          $AuthorNameLinksQuery ="SELECT 
                                    speciesauthorsnames.AutName,
                                    speciesauthorsnames.URL, 
                                    speciesauthorsnames.SpecCode, 
                                    speciesauthorsnames.SeqNo
                      FROM speciesauthorsnames
                      WHERE (speciesauthorsnames.SpecCode = $speccode)
                      ORDER BY speciesauthorsnames.SpecCode, speciesauthorsnames.SeqNo";
            //echo $AuthorNameLinksQuery;
            return $AuthorNameLinksQuery;
      }//end of  private static function AuthorNameLinksQuery

}//end of class name extends Model
