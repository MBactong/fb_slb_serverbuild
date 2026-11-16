<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Repository\fbapp\searchpagestats;
use App\Repository\AboutPage\AboutPage;

class AboutController extends Controller{
	
	public function show(){
		
		$SearchPageArray['Collaborators'] =  AboutPage::SearchPagestats('Collaborators');
		$SearchPageArray['Common names'] =  AboutPage::SearchPagestats('Common names');
		$SearchPageArray['Pictures'] =  AboutPage::SearchPagestats('Pictures');
		$SearchPageArray['References'] =  AboutPage::SearchPagestats('References');
		$SearchPageArray['Species'] =  AboutPage::SearchPagestats('Species');
		$SearchPageArray['Synonyms'] =  AboutPage::SearchPagestats('Synonyms');
		$SearchPageArray['News'] =  AboutPage::Announcement();


		//$SearchPageStatsArray = $SearchPageArray['SearchPageStats']; //['TableName']['ActualCount'];

		return view('about',['searchpagestats' => $SearchPageArray]);
		}
	}
?>