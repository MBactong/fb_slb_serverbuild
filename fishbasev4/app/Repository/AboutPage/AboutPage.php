<?php

namespace App\Repository\AboutPage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Repository\fbapp\searchpagestats;
use App\Repository\fbwebwritev4\fbwebwritev4;
use App\Repository\fbwebwritev4\announcement;
//use DB;

class AboutPage extends Model
{

	public static function SearchPagestats($TableName)
	{
		$SearchPage = searchpagestats::where('TableName', $TableName)->get(['DisplayCount','ActualCount', 'DateCovered', 'DateLastUpdate', 'HitsMonthInMillions', 'Sessions']);
		
		 if(count($SearchPage)){
		 	foreach ($SearchPage as $SearchPageResult) {
				$SearchPagestatsArray['DisplayCount'] =  $SearchPageResult->DisplayCount;
				$SearchPagestatsArray['ActualCount'] =  $SearchPageResult->ActualCount;
				$SearchPagestatsArray['DateCovered'] =  $SearchPageResult->DateCovered;
				$SearchPagestatsArray['DateLastUpdate'] =  $SearchPageResult->DateLastUpdate;
				$SearchPagestatsArray['HitsMonthInMillions'] =  $SearchPageResult->HitsMonthInMillions;
				$SearchPagestatsArray['Sessions'] =  $SearchPageResult->Sessions;
				}
		}
		/*
		if($TableName == "News"){
			$News = self::Announcement();
			if($News){
				$SearchPagestatsArray['News'] =  self::Announcement();
			}
		}
		*/
		return $SearchPagestatsArray;
	}//end of public static function SearchPagestats{}


	public static function Announcement(){
		/*
		$announcements = DB::connection('mysql2')->select("select * from announcement where deleted = 0 order by date desc");
		if(count($announcements)){
			return $announcements;
		}
		*/
		$announcements = announcement::where('deleted', 0)->orderBy('date', 'DESC')->get();
		if(count($announcements)){
			return $announcements;
		}
		
	}//end of private static function Announcement
}//end of class AboutPage extends Model


?>