@php    
        $q = Request::get('q');
        $pageno = Request::get('pageno');
        $totalSearch = $searchtxt['hits']['total']['value'];

        if( $totalSearch  > 20){
            if($pageno){
                $resultStart = $pageno - 1;
                $resultStart = $resultStart * 20 + 1;
                $resultEnd = $resultStart + 19;
                //echo "<b>" . $pageno . "</b><br>";
            }else{
                $resultStart = 1;
                $resultEnd = 20;
                $pageno = 1;
               // echo "<b>" . $pageno . "</b><br>";

            }
            $n = $resultStart;
            if($resultEnd >= $totalSearch){$resultEnd = $totalSearch;}
            
            if($pageno > 1){
                $backpageno = $pageno - 1;
                echo "<a href =/search?q=" . $q . "&page=" . $backpageno . " > back</a>";
            }
            
            echo " Showing " . $resultStart . " to " .  $resultEnd . " of " . $totalSearch;
            if($resultEnd < $totalSearch){
                $pageno = $pageno + 1;
                echo "<a href =/search?q=" . $q . "&page=" . $pageno . " > next</a>";
            }

        }
            
	$rpath = Request::path() ;        
	$rpath = Request::root();
    @endphp
<p>{{ $rpath }}</p>
