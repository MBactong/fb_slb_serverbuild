@isset($speciessummary['Classification'])

@push('page-link')
<li>
	<a href="#classification" data-summary-open="#classification">Classification</a>
</li>
@endpush

<details id="classification" open>
	<summary><div>
        	<div class="title">Classification<small> / Names</small></div>
                	<div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div>
	</summary>
	<div>
	<p>
	@if($speciessummary['Classification']['Class']){{ $speciessummary['Classification']['Class']}} ({{ $speciessummary['Classification']['ClassComName']}}) > @endif
    <a href="/summary/OrdersSummary.php?order={!! urlencode($speciessummary['Classification']['Order']) !!}">{{ $speciessummary['Classification']['Order'] }}</a> ({{ ucfirst($speciessummary['Classification']['OrdComName']) }}) >
    <a href="/summary/FamilySummary.php?ID={!! urlencode($speciessummary['Classification']['FamCode']) !!}">{{ $speciessummary['Classification']['Family'] }}</a> ({{ $speciessummary['Classification']['FamComName']}}) 
    
    @if($speciessummary['Classification']['SubFamily'])> {{ $speciessummary['Classification']['SubFamily'] }}@endif
    @isset($speciessummary['Classification']['EtymologyGenus'])
        <br>Etymology: <i>{!! FishBase::text($speciessummary['Classification']['Genus']) !!}</i>: {!! FishBase::text($speciessummary['Classification']['EtymologyGenus']) !!}
    @endisset
    @isset($speciessummary['Classification']['ETYFishURLGenus'])
        (<a href='https://etyfish.org/ETYFish_{!! $speciessummary['Classification']['ETYFishURLGenus'] !!}.pdf' target='_blank'>See ETYFish</a>);
    @endisset
    @isset($speciessummary['Classification']['EtymologySpecies'])
        <i> {!! FishBase::text($speciessummary['Classification']['Species']) !!}</i>: {!! FishBase::text($speciessummary['Classification']['EtymologySpecies']) !!}
    @endisset
    
    @isset($speciessummary['Classification']['ETYFishURLSpecies'])
        (<a href='https://etyfish.org/ETYFish_{!! $speciessummary['Classification']['ETYFishURLSpecies'] !!}.pdf' target='_blank'>See ETYFish</a>)
    @endisset

    @php
        $authorscount = count($speciessummary['Authors']['individualAuthor']);

    @endphp
    <br>
     
    @for($i=0; $i < $authorscount; $i++)
        @if(isset($speciessummary['Authors']['individualAuthor'][$i]['URL']))
        @if($i == 0)
            @if($authorscount > 1)More on authors: 
            @else More on author: 
            @endif  
        @endif

        @if($i == ($authorscount-1))
            @php
                $speciessummary['Authors']['individualAuthor'][$i]['divider'] = "."; 
            @endphp
        @endif

        
            <a href="{{$speciessummary['Authors']['individualAuthor'][$i]['URL']}}" target="_blank">{{ltrim($speciessummary['Authors']['individualAuthor'][$i]['AutName'])}}</a>{{$speciessummary['Authors']['individualAuthor'][$i]['divider']}}
       
        @endif

        
    @endfor
</p>
	</div>
</details>

@endisset
