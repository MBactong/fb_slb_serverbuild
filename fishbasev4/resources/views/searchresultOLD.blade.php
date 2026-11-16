@extends('layout/body', ['bodyclass' => 'list'])

@section('content')

	@foreach ($searchtxt['hits']['hits'] as $plugin) 
		
		<br><br>
		<a href="{{ url('summary/'. $plugin['_source']['speccode']. '/') }}">
 			<i>{{$plugin['_source']['genus']}}	{{$plugin['_source']['species']}}</i><br>
			{{$plugin['_source']['fbname']}}<br>
			@isset($plugin['_source']['picpreferredname'])
			<img src= {{asset('/images/thumbnails/jpg/tn_' . $plugin['_source']['picpreferredname'] . '')}}><br> 
			@endisset
		</a>
	@endforeach

@endsection
