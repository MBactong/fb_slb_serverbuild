@isset($speciessummary['Aquamaps']['filename'])

@push('page-link')
<li>
        <a href="#maps" data-summary-open="#maps">Maps</a>
</li>
@endpush

<details id="maps" open>
                    <summary><div>
                        <div class="title">Maps</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div>
		</summary>
		<div id="species-maps">
			<figure class="item">
				<a href="https://www.aquamaps.org/preMap.php?cache=1&SpecID={{ urlencode($speciessummary['Aquamaps']['speciesid']) }}" target="_blank">
					<img src="https://www.aquamaps.org/imagethumb/file_destination/pic_{{ urlencode($speciessummary['Aquamaps']['speciesid']) }}.jpg" name="Native range of {{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}">
				</a>
				<figcaption>
					<p><i>{{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}</i> / <b>Native range</b><br>
					<a href="https://www.aquamaps.org/" target="_blank">AquaMaps</a> Data sources:
					<a href="https://www.gbif.org/occurrence/search?q={{ urlencode($speciessummary['Name']['Genus'].' '.$speciessummary['Name']['Species']) }}" target="_blank">GBIF</a>
					<a href="https://obis.org/taxon/{{ urlencode($speciessummary['Aquamaps']['WoRMS_id']) }}" target="_blank">OBIS</a>
					@if (!$speciessummary['Aquamaps']['expert_id'])<br><small>This map was computer-generated and has not yet been reviewed.</small>@endif
					</p>
				</figcaption>
			</figure>
			<figure class="item">
                                <a href="https://www.aquamaps.org/preMap.php?cache=1&SpecID={{ urlencode($speciessummary['Aquamaps']['speciesid']) }}" target="_blank">
                                        <img src="https://www.aquamaps.org/imagethumb/cached_maps/suitable/pic_{{ urlencode($speciessummary['Aquamaps']['speciesid']) }}.jpg" name="Suitable habitat of {{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}">
                                </a>
                                <figcaption>
                                        <p><i>{{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}</i> / <b>Suitable habitat</b><br>
                                        <a href="https://www.aquamaps.org/" target="_blank">AquaMaps</a> Data sources:
                                        <a href="https://www.gbif.org/occurrence/search?q={{ urlencode($speciessummary['Name']['Genus'].' '.$speciessummary['Name']['Species']) }}" target="_blank">GBIF</a>
                                        <a href="https://obis.org/taxon/{{ urlencode($speciessummary['Aquamaps']['WoRMS_id']) }}" target="_blank">OBIS</a>
                                        @if (!$speciessummary['Aquamaps']['expert_id'])<br><small>This map was computer-generated and has not yet been reviewed.</small>@endif
                                        </p>
                                </figcaption>
                        </figure>
			<figure class="item">
                                <a href="https://www.aquamaps.org/preMap.php?cache=1&SpecID={{ urlencode($speciessummary['Aquamaps']['speciesid']) }}" target="_blank">
                                        <img src="https://www.aquamaps.org/imagethumb/cached_maps/pointmap/pic_{{ urlencode($speciessummary['Aquamaps']['speciesid']) }}.jpg" name="Point map of {{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species'] }}">
                                </a>
                                <figcaption>
                                        <p><i>{{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}</i> / <b>Point map</b><br>
                                        <a href="https://www.aquamaps.org/" target="_blank">AquaMaps</a> Data sources:
                                        <a href="https://www.gbif.org/occurrence/search?q={{ urlencode($speciessummary['Name']['Genus'].' '.$speciessummary['Name']['Species']) }}" target="_blank">GBIF</a>
                                        <a href="https://obis.org/taxon/{{ urlencode($speciessummary['Aquamaps']['WoRMS_id']) }}" target="_blank">OBIS</a>
                                        @if (!$speciessummary['Aquamaps']['expert_id'])<br><small>This map was computer-generated and has not yet been reviewed.</small>@endif
                                        </p>
                                </figcaption>
                        </figure>
			<figure class="item">
                                <a href="https://www.aquamaps.org/preMap.php?cache=1&SpecID={{ urlencode($speciessummary['Aquamaps']['speciesid']) }}" target="_blank">
                                        <img src="https://www.aquamaps.org/imagethumb/cached_maps/2050/pic_{{ urlencode($speciessummary['Aquamaps']['speciesid']) }}.jpg" name="Year 2050 native range of {{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species'] }}">
                                </a>
                                <figcaption>
                                        <p><i>{{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}</i> / <b>Year 2050</b><br>
                                        <a href="https://www.aquamaps.org/" target="_blank">AquaMaps</a> Data sources:
                                        <a href="https://www.gbif.org/occurrence/search?q={{ urlencode($speciessummary['Name']['Genus'].' '.$speciessummary['Name']['Species']) }}" target="_blank">GBIF</a>
                                        <a href="https://obis.org/taxon/{{ urlencode($speciessummary['Aquamaps']['WoRMS_id']) }}" target="_blank">OBIS</a>
                                        @if (!$speciessummary['Aquamaps']['expert_id'])<br><small>This map was computer-generated and has not yet been reviewed.</small>@endif
                                        </p>
                                </figcaption>
                        </figure>
		</div>
<p style="margin-top:0;text-align: center;">
	<a href="https://www.fishbase.us/FishWatcher/checkpassword.php?Genus={{ urlencode($speciessummary['Name']['Genus']) }}&Species={{ urlencode($speciessummary['Name']['Species']) }}&vtable=contribution_a">
		<small>Add your observation in Fish Watcher</small>
	</a>
</p>
</details>
@endisset

{{--
{{ dd($speciessummary) }}


<br><br>
	@isset($speciessummary['Aquamaps']['filename'])
		<img src= {{asset('images/aquamaps/native/' . $speciessummary['Aquamaps']['filename']. '')}}>
		<img src= {{asset('images/aquamaps/suitable/' . $speciessummary['Aquamaps']['filename']. '')}}>
		<img src= {{asset('images/aquamaps/2050/' . $speciessummary['Aquamaps']['filename']. '')}}>
		<img src= {{asset('images/aquamaps/pointmap/' . $speciessummary['Aquamaps']['filename']. '')}}>
		
	@endisset
--}}
