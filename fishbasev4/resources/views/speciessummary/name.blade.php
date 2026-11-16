<h1>

<i>	
@if(isset($speciessummary['Name']['Genuslinks']['GSD_GenusFk']))
<a href="http://researcharchive.calacademy.org/research/ichthyology/catalog/fishcatget.asp?genid={{$speciessummary['Name']['Genuslinks']['GSD_GenusFk']}}" target="_blank">{{$speciessummary['Name']['Genus']}}</a> 
@else
{{$speciessummary['Name']['Genus']}}
@endif
@if(isset($speciessummary['Name']['Specieslinks']['CAS_SPC']))
<a href="http://researcharchive.calacademy.org/research/ichthyology/catalog/fishcatget.asp?spid={{$speciessummary['Name']['Specieslinks']['CAS_SPC']}}" target="_blank">{{ $speciessummary['Name']['Species']}}</a>
@else
{{ $speciessummary['Name']['Species']}}
@endif
</i>


<!-- <small><br><small>{{ preg_replace("/^\(|\)$/", '', trim($speciessummary['Name']['Author'])) }}</small> -->


<br><small style="color:#284193">
	@php
		$authorscount = count($speciessummary['Authors']['individualAuthor']);
	@endphp
		
	@for($i=0; $i < $authorscount; $i++)
		@if(isset($speciessummary['Authors']['individualAuthor'][$i]['URL']))
			@if($i == 0){{$speciessummary['Authors']['startparenthesis']}}@endif<a href="{{$speciessummary['Authors']['individualAuthor'][$i]['URL']}}" target="_blank">{{ltrim($speciessummary['Authors']['individualAuthor'][$i]['AutName'])}}</a>{{$speciessummary['Authors']['individualAuthor'][$i]['divider']}}
		@else
			@if($i == 0){{$speciessummary['Authors']['startparenthesis']}}@endif{{ltrim($speciessummary['Authors']['individualAuthor'][$i]['AutName'])}}{{$speciessummary['Authors']['individualAuthor'][$i]['divider']}}
		@endif

		
	@endfor

	@if (isset($speciessummary['Authors']['Year']))
		<a href="https://researcharchive.calacademy.org/research/ichthyology/catalog/getref.asp?id={{$speciessummary['Name']['Specieslinks']['CAS_REF_NO']}}" target="_blank">{{$speciessummary['Authors']['Year']}}</a>{{$speciessummary['Authors']['endparenthesis']}}
	@endif

	

		
</small>




<!--<small><br><small>{{ $speciessummary['Name']['Author']}}</small>-->
@if (isset($speciessummary['Name']['FBname']))<br><small><b>{{ $speciessummary['Name']['FBname']}}</b></small>@endif
</small>

</h1>
