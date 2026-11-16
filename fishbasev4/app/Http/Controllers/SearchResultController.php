<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//use App\Quotation;

use Elasticsearch;

class SearchResultController extends Controller
{

    const PAGESIZE = 20;

    public function show()
    {
//$searchtxt
	request()->validate([
		'q' => 'required',
		'pageno' => 'numeric|min:1'
	]);
	$q = request()->q;


	if($pageno){
	    $pageno = $pageno -1;
	    $from = $pageno * self::PAGESIZE;
            $size = 20;
	}else{
	    $from = 0;
            $size = 20;
	}
    	
	echo "page = " . $pageno . "<br>";
	echo "from = " . $from . "<br>";
        echo "size = " . $size . "<br>";


$params =   ['index' => 'species',
             'from' => $from,
             'size' => 20,
            'body' => [
                  'query' =>[
                    'bool' => [
                        'should' =>[
                                ['multi_match' =>[
                                    'query' => $q,
                                    'type'=> 'phrase',
                                    'fields' => ['fbname', 'species', 'genus',],
                                    'boost'=> 10,
                                    ]//end of first multimatch entry
                                ],//end of first multimatch
                                ['multi_match' =>[
                                    'query' => $q,
                                    'type'=> 'most_fields',
                                    'fields' => ['fbname', 'species', 'genus',],
                                     'fuzziness'=> 'AUTO',
                                    ]//end of 2nd multimatch entry
                                ]//end of second multimatch
                                ]//end of 'should'
                            ]//end of bool
                        ]//end of first query 
                    ]//end of 'body'
            ];//end of $params

	$response = Elasticsearch::search($params);
	
    	return view('result',['searchtxt' => $response ]);

    	

    }
}//test
