<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use DB;
//use App\Quotation;

use Elasticsearch;

use App\Repository\speciessummary\image;
use App\Repository\media\images;

class SearchController extends Controller
{

    const PAGESIZE = 20;

    public function show()
    {
//$searchtxt

	request()->validate([
                'q' => 'required',
                'page' => 'integer|min:1',
        ]);

	$q = request()->q;
    $page = request()->page;


    $sorts = [
        'relevance' => '_score',
        'scientific' => 'ScientificName.keyword',
        'common' => 'fbname.keyword',
        'family' => 'family.keyword',
    ];

    $sort = request()->sort;
    if (!$sort || !isset($sorts[$sort])) {
        $sort = 'relevance';
    }

    $order = request()->order;
    if (!$order || !preg_match("/^(asc|desc)$/", $order)) {
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
    $q = join(' ', $qs);
    $queries = [];
    $queries[] = '('.join(' ',$qs).')';
    $queries[] = '('.join(' and ',$qs).')';
    $queries[] = '('.join(' or ',$qs).')';


$sortarr = [];
$sortarr[$sorts[$sort]] = ['order' => $order];
if ($sort !== 'scientific') {
//    $sortarr['ScientificName.keyword'] = ['order' => 'asc'];
}


// try exact match on scientific name

$params = [
	'index' => 'fbsearch',
	'body' => [
/*	'query' => [
		'bool' => [
			'must' => [
				'match' => [
					'ScientificName.lc' => join(" ",$qs)
				]
			]
		]
	]*/
	'query' => [
		'match' => [
			'ScientificName.lc' => join(" ",$qs)
		]
	]
	]
];


try {
	$response = Elasticsearch::search($params);
    //print_r($response['hits']['total']['value']);
	//dd($response);
	//exit;

	if ($response['hits']['total']['value'] === 1) {
		//return redirect()->route(request()->route()->getName() , ['q' => $q]);
	return redirect()->route('speciesSummary', ['speciesname' => $response['hits']['hits'][0]['_id']]);
	}
}
catch (\Exception $e) {

}

$params =   ['index' => 'fbsearch',
             'from' => $from,
             'size' => self::PAGESIZE,
             
             'body' => [
                'sort' => $sortarr,
                /*[
                    $sorts[$sort] => ['order' => $order],
                    
                    //'fbname.keyword' => ['order' => 'asc']
                    /*'_score' => ['order' => 'desc'],
                    'species.keyword' => ['order' => 'asc'],
                    'genus.keyword' => ['order' => 'asc'],
                    //'fbname.keyword' => ['order' => 'asc']
                 ],*/
                  'query' =>[
                    'bool' => [
                        'should' =>[
                            [
                                "match" => 
                                [
                                    "ScientificName" => [
                                        "query" => $q,
                                        "boost" => 20
                                    ],
                                    
                                ]
                                
                            ],
			    [
                                "match" =>
                                [
                                    "genus" => [
                                        "query" => $q,
                                        "boost" => 15
                                    ],

                                ]

                            ],
                            [
                                "match" =>
                                [
                                    "family" => [
                                        "query" => $q,
                                        "boost" => 12
                                    ],
                                ]
                            ],
                            [
                                "match" => 
                                [
                                    "fbname" => [
                                        "query" => $q,
                                        "boost" => 10
                                    ],
                                ]
                            ],
                            [
                                "match" => 
                                [
                                    "species" => [
                                        "query" => $q,
                                        "boost" => 7
                                    ],
                                ]
                            ],
                            [
                                "match" => 
                                [
                                    "commonnames" => [
                                        "query" => $q,
                                        "boost" => 5
                                    ],
                                ]
                            ],
			    [
                                "match" =>
                                [
                                    "synonyms" => [
                                        "query" => $q,
                                        "boost" => 2
                                    ],
                                ]
                            ],
			    /*[
                                'query_string' =>
                                [
                                'query' => '\''.$q.'*\'',
				'type'=> 'phrase',
                                'fields' => ['ScientificName^12','genus^10','family^8','species^6','commonnames^5','fbname^3', 'synonyms^1',],
                                ]
                            ],*/
			    /*[
				'query_string' => 
				[
				'query' => '(*'.join('* and *',$qs).'*)',
				'fields' => ['ScientificName^7','genus^6','family^5','species^4','commonnames^3','fbname^2', 'synonyms^1',],
				]
			    ],*/
                            [
                                'multi_match' =>
                                [
                                    'query' => $q,
                                    //'analyzer' => 'standard',
                                    'type'=> 'phrase',
                                    'fields' => ['ScientificName^12','genus^10','family^8','species^6','commonnames^5','fbname^3', 'synonyms^1',],
//				    'operator' => 'and'
//				    'fuzziness' =>' AUTO'
                                ]
                            ],
			    [
                                'multi_match' =>
                                [
                                    'query' => $q,
                                    //'analyzer' => 'standard',
                                    'type'=> 'best_fields',
                                    'fields' => ['ScientificName^4','genus','family','species','commonnames','fbname^3', 'synonyms',],
//                                    'operator' => 'and',
                                    'fuzziness' => 'AUTO'
                                ]
                            ],

/*                            [
                                'multi_match' =>[
                                    'query' => $q,
                                    'type'=> 'most_fields',
                                    'fields' => ['ScientificName^2','fbname', 'synonyms', 'commonnames', 'family',],
                                    'fuzziness' => 'AUTO',
			 	     'operator' => 'and'
				    
                                ]
                            ],*/
                            /*[
                                'multi_match' =>[
                                    'query' => join(' or ',$queries),
                                    'type'=> 'phrase',
                                    'fields' => ['ScientificName^4','fbname^3', 'synonyms', 'commonnames', 'family',],
                                ]
                            ],*/
                            



                            /*['multi_match' =>[
                                //'query' => join(' and ',$queries),
                                'query' => $q,
                                'type'=> 'phrase',
                                'fields' => ['fbname', 'species', 'genus', 'synonyms', 'commonnames', 'family',],
                                'boost'=> 20,
                                ]//end of first multimatch entry
                            ],//end of first multimatch
                                ['multi_match' =>[
                                    'query' => join(' or ',$queries),
                                    'type'=> 'phrase',
                                    'fields' => ['fbname', 'species', 'genus', 'synonyms', 'commonnames', 'family',],
                                    'boost'=> 10,
                                    ]//end of first multimatch entry
                                ],//end of first multimatch
                                ['multi_match' =>[
                                    'query' => $q,
                                    'type'=> 'most_fields',
                                    'fields' => ['fbname', 'species', 'genus', 'synonyms', 'commonnames', 'family',],
                                     'fuzziness'=> 'AUTO',
                                    ]//end of 2nd multimatch entry
                                ]//end of second multimatch
                                */
                                ]//end of 'should'
                            ]//end of bool
                        ],//end of first query 
                        //'explain' => true

                    ]//end of 'body'
            ];//end of $params

	$response = Elasticsearch::search($params);

	if ($response['hits']['total']['value'] > 0 && $from > $response['hits']['total']['value']) {
		return redirect()->route(request()->route()->getName() , ['q' => $q]);
    }

    if (request()->data) {
        dd($response);
    }

    foreach($response['hits']['hits'] as &$hit) {
        $hit['_images'] =  images::images($hit['_source']['speccode']);
        $hit['_images']['Preferred'] = image::SpeciesSummaryImages($hit['_source']['speccode'], $hit['_source']['family']);
        /* $cs = $this->_getCountries($hit['_source']['speccode'], $hit['_source']['fbname'], $q);
        $hit['_countries'] = $cs['_countries'];
        $hit['_languages'] = $cs['_languages'];
        $hit['_types'] = $cs['_types']; */
    }
    /*
    echo "<pre>";
    print_r($response); 
    echo "</pre>";
    */
    return view('searchresult',['searchtxt' => $response, 
		'pagination' => [
			'count'  => $response['hits']['total']['value'],
			'page'   => $page,
			'size'   => self::PAGESIZE,
			'params' => ['q' => $q, 'sort' => $sort, 'order' => $order]
			]
		]);

    
    }

    // get countries
    private function _getCountries($speccode, $cname, $q) {
        $sql = "SELECT cr.PAESE AS country, c.Language AS language, c.NameType AS type FROM comnames c, countref cr 
            WHERE c.SpecCode = ? AND c.C_Code = cr.C_Code AND c.ComName = ?
            ORDER BY cr.PAESE ASC";
        $result = DB::select($sql, [$speccode, $cname]);
        $cs = [
            '_countries' => [],
            '_languages' => [],
            '_types' => []
        ];
        foreach($result as $res) {
            if (!in_array($res->country, $cs['_countries'])) {
                $cs['_countries'][] = $res->country;
            }
            if (!in_array($res->language, $cs['_languages'])) {
                $cs['_languages'][] = $res->language;
            }
            if (!in_array($res->type, $cs['_types'])) {
                $cs['_types'][] = $res->type;
            }
        }
        sort($cs['_languages']);
        sort($cs['_types']);

        return $cs;
    }
}
