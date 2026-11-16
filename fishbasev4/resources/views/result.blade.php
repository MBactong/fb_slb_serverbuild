	
	@php	
		$q = Request::get('q');
		$pageno = Request::get('pageno');


		
		$totalSearch = $searchtxt['hits']['total']['value'];

		if( $totalSearch  > 20){
			if($pageno){
				$resultStart = $pageno - 1;
				$resultStart = $resultStart * 20;
				$resultEnd = $resultStart + 20;
				echo "<b>" . $pageno . "</b><br>";
			}else{
				$resultStart = 1;
				$resultEnd = 20;
				$pageno = 1;
				echo "<b>" . $pageno . "</b><br>";

			}
			$n = $resultStart;
			if($resultEnd >= $totalSearch){$resultEnd = $totalSearch;}
			
			if($pageno > 1){
				$backpageno = $pageno - 1;
				echo "<a href =/searchresult?q=" . $q . "&pageno=" . $backpageno . " > back</a>";
			}
			
			echo "showing " . $resultStart . " to " .  $resultEnd . " of " . $totalSearch;
			if($resultEnd < $totalSearch){
				$pageno = $pageno + 1;
				echo "<a href =/searchresult?q=" . $q . "&pageno=" . $pageno . " > next</a>";
			}

		}
			
		
	@endphp

	@foreach ($searchtxt['hits']['hits'] as $plugin) 
		
		<br><br>
		<a href="{{ url('summary/'. $plugin['_source']['speccode']. '/') }}">
			{{$n++}}
 			<i>{{$plugin['_source']['genus']}}	{{$plugin['_source']['species']}}</i><br>
			{{$plugin['_source']['fbname']}}<br>
						
		</a>
	@endforeach

