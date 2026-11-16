<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use DB;
//use App\Quotation;

use Elasticsearch;

use App\Repository\speciessummary\image;
use App\Repository\media\images;

class testController extends Controller
{

    const PAGESIZE = 20;

    public function show()
    {
//$searchtxt

     request()->validate([
                'q' => 'required',
                'page' => 'integer|min:1'
        ]);

    $q = request()->q; 
        $page = request()->page; 

    if(!$page){
        $page = 1;
    }

    $from = self::PAGESIZE * ($page - 1);

    // prapre $q TODO
   $fields = array('ScientificName', 'family', 'genus', 'species', 'commonnames', 'synonyms', 'fbname' );
   $n = 0;
	
	foreach($fields as $field){
		
		$response = self::SearchExactMatch($q, $field, $from);
		if($response['hits']['total']['value'] > 0 ){
			echo $field;
			break;
		}	
	}

	if($response['hits']['total']['value'] <= 0 ){
		echo "Fuzzy";
		$response = self::SearchFuzzyMatch($q, $from, $page);

	}
     dd($response);
	foreach($response['hits']['hits']['_source'] as $hit){
		echo $hit['ScientificName'] . "<br>";
		echo $hit['fbname'] . "<br>";
		echo $hit['family'] . "<br>";


	}//end of foreach
   
    }//end of public function show

private static function SearchExactMatch($q, $field, $from){


	 $qs = preg_split("/\s+/", trim($q));
    $queries = [];
    $queries[] = '('.join(' ',$qs).')';
    $queries[] = '('.join(' and ',$qs).')';
    $queries[] = '('.join(' or ',$qs).')';

$params =   ['index' => 'namessearch',
             'from' => $from,
             'size' => 1000,
            "explain" => true,
             'body' => [
                'sort' => [
                    //'fbname.keyword' => ['order' => 'asc']
                    '_score' => ['order' => 'desc'],
                    'species.keyword' => ['order' => 'asc'],
                    'genus.keyword' => ['order' => 'asc'],
                    //'fbname.keyword' => ['order' => 'asc']
                 ],
                  'query' =>[
                    'bool' => [
                        'must' =>[
				['multi_match' =>[
                                'query' => $q,
                                'type'=> 'phrase',
                               'fields' => [$field],
                                ]//end of first multimatch entry
                            	],//end of first multimatch 
                                ]//end of 'should'
                            ]//end of bool
                        ],//end of first query 
                       // 'explain' => true

                    ]//end of 'body'
            ];//end of $params

$response = Elasticsearch::search($params);


return $response; 

}//end of private static function SearchExactMatch

private static function SearchExactMatch2($q, $field, $from){


	 $qs = preg_split("/\s+/", trim($q));
    $queries = [];
    $queries[] = '('.join(' ',$qs).')';
    $queries[] = '('.join(' and ',$qs).')';
    $queries[] = '('.join(' or ',$qs).')';

$params =  ['index' => 'namessearch',
             'from' => $from,
             'size' => 1000,
            "explain" => true,
             'body' => [
                'sort' => [
                    //'fbname.keyword' => ['order' => 'asc']
                    '_score' => ['order' => 'desc'],
                    'species.keyword' => ['order' => 'asc'],
                    'genus.keyword' => ['order' => 'asc'],
                    //'fbname.keyword' => ['order' => 'asc']
                 ],
                  'query' =>[
			'match' => [				
						$field => $q,
					],//end of 'match'
				
			
					
				
		],//end of first query 
                       

                    ]//end of 'body'
            ];//end of $params

$response = Elasticsearch::search($params);


return $response; 

}//end of private static function SearchExactMatch2

private static function SearchFuzzyMatch($q, $from, $page){

 $sorts = [
        'relevance' => '_score',
        'scientific' => 'ScientificName.keyword',
        'common' => 'fbname.keyword',
        'family' => 'family.keyword',
    ];

    $sort = request()->sort;
    if (!$sort || !preg_match("/^".join("|",array_keys($sorts))."$/", $sort)) {
        $sort = 'relevance';
    }

    $order = request()->order;
    if (!$order || !preg_match("/^asc|desc$/", $order)) {
        if ($sort === 'relevance') {
            $order = 'desc';
        }
        else {
            $order = 'asc';
        }
    }

	if(!$page){
	    $page = 1;
	}

	$from = self::PAGESIZE * ($page - 1);

    // prapre $q TODO
    $qs = preg_split("/\s+/", trim($q));
    $queries = [];
    $queries[] = '('.join(' ',$qs).')';
    $queries[] = '('.join(' and ',$qs).')';
    $queries[] = '('.join(' or ',$qs).')';




$params =   ['index' => 'namessearch',
             'from' => $from,
            'size' => 1000,
             
             'body' => [
                'sort' => [
                    $sorts[$sort] => ['order' => $order]
                    //'fbname.keyword' => ['order' => 'asc']
                    /*'_score' => ['order' => 'desc'],
                    'species.keyword' => ['order' => 'asc'],
                    'genus.keyword' => ['order' => 'asc'],*/
                    //'fbname.keyword' => ['order' => 'asc']
                 ],
                  'query' =>[
                    'bool' => [
                        'should' =>[
                            [
                                'multi_match' =>
                                [
                                    'query' => $q,
                                    //'analyzer' => 'standard',
                                    'type'=> 'phrase',
                                    'fields' => ['ScientificName^8','fbname^6', 'synonyms', 'commonnames', 'family',],
                                ]
                            ],
                            [
                                'multi_match' =>[
                                    'query' => $q,
                                    'type'=> 'most_fields',
                                    'fields' => ['ScientificName^4','fbname^3', 'synonyms', 'commonnames', 'family',],
                                    "fuzziness" => "AUTO"
                                ]
                            ],
                            /*[
                                'multi_match' =>[
                                    'query' => join(' or ',$queries),
                                    'type'=> 'phrase',
                                    'fields' => ['ScientificName^4','fbname^3', 'synonyms', 'commonnames', 'family',],
                                ]
                            ],*/
                            [
                                "term" => 
                                [
                                    "ScientificName.raw" => [
                                        "value" => $q,
                                        "boost" => 20
                                    ],
                                    
                                ]
                                
                            ],
                            [
                                "term" => 
                                [
                                    "fbname.raw" => [
                                        "value" => $q,
                                        "boost" => 15
                                    ],
                                ]
                            ],
                            [
                                "term" => 
                                [
                                    "family.raw" => [
                                        "value" => $q,
                                        "boost" => 12
                                    ],
                                ]
                            ],



                         
                                ]//end of 'should'
                            ]//end of bool
                        ],//end of first query 
                        //'explain' => true

                    ]//end of 'body'
            ];//end of $params

$response = Elasticsearch::search($params);


return $response;

}//end of private static function SearchFuzzyMatch($q, $from)
    
}//end of class
