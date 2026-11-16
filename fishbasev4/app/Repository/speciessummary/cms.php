<?php

namespace App\Repository\speciessummary;
use Illuminate\Database\Eloquent\Model;
use App\Repository\fbapp\stocks;
use App\Repository\fbapp\species;
use DB;

class cms extends Model
{
    public static function SpeciesCMS($speccode){
    	$CMSQuery = self::cmsquery($speccode);
     	$CMS = DB::select( $CMSQuery);

     	if(count($CMS)){
			if (!$CMS[0]->CMS) {
				return 'Not Evaluated';
			}
			$txt = '';

			if ($CMS[0]->CMS === 'Appendix I') {
				$txt = 'Endangered migratory species';
			}
			else if ($CMS[0]->CMS === 'Appendix II') {
				$txt = 'Migratory species conserved through agreements';
			}
			else if ($CMS[0]->CMS === 'Appendix I & II') {
				$txt = 'Endangered migratory species conserved through agreements';
			}
			else {
				return 'Not Evaluated';
			}

			return $CMS[0]->CMS.': <a href="https://www.cms.int/en/species/'.urlencode($CMS[0]->genus.'-'.$CMS[0]->species).'" target="_blank">'.$txt.'</a>';
    	}
		
		return 'Not Evaluated';
    }

    private static function cmsquery($speccode){
    	$cmsquery =	"SELECT stocks.CMS, species.genus, species.species FROM stocks INNER JOIN species ON species.SpecCode = stocks.SpecCode 
    			where stocks.CMS IS not NULL and stocks.SpecCode = $speccode";
    	return $cmsquery;
    }
}
