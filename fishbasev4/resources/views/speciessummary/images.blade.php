@php
	$imgs = [];
	//print_r($speciessummary['Images']['MainPics']);
	if (isset($speciessummary['Images']['Preferred']['PicPreferredName']) && $speciessummary['Images']['Preferred']['PicPreferredName']) {
		$imgs[$speciessummary['Images']['Preferred']['PicPreferredName']] = '';
	}
	if (isset($speciessummary['Images']['Preferred']['PicPreferredNameM']) && $speciessummary['Images']['Preferred']['PicPreferredNameM']) {
		$imgs[$speciessummary['Images']['Preferred']['PicPreferredNameM']] = 'Male';
	}
	if (isset($speciessummary['Images']['Preferred']['PicPreferredNameF']) && $speciessummary['Images']['Preferred']['PicPreferredNameF']) {
		$imgs[$speciessummary['Images']['Preferred']['PicPreferredNameF']] = 'Female';
	}
	if (isset($speciessummary['Images']['Preferred']['PicPreferredNameJ']) && $speciessummary['Images']['Preferred']['PicPreferredNameJ']) {
		$imgs[$speciessummary['Images']['Preferred']['PicPreferredNameJ']] = 'Juvenile';
	}
	
	if(count($imgs) < 10 && isset($speciessummary['Images']['MainPics']) && is_array($speciessummary['Images']['MainPics'])) {
		foreach($speciessummary['Images']['MainPics'] as $img) {
			if (!isset($imgs[$img['FileName']])) {
				$imgs[$img['FileName']] = '';
			}
			if (count($imgs) >= 10) {
				break;
			}
		}
	}
	$FamilyImgs = "";
	if(count($speciessummary['Images']['MainPics']) == NULL){
		$FamilyImgs = $speciessummary ['Images']['Preferred']['FamPic'];
		$FamilyImgs = $FamilyImgs . ".gif";
		$FamilyName = $speciessummary ['Images']['Preferred']['Family'];
		$imgs[$FamilyImgs] = '';
	}
	
@endphp

@if(count($imgs))
<div id="species-images">
	@foreach ($imgs as $img => $figcaption)
		<figure class="item">
			<a href="{{ url('images/species/' . $img) }}"><img src="{{ asset('images/species/' . $img) }}"></a>
			@if($figcaption)
		<figcaption>
		{{ $figcaption }}
		</figcaption>
		@endif

		</figure>
	@endforeach
</div>
	<p style="margin-top:0;margin-bottom:1.5em;text-align: center;"><small>
	@if(!isset($imgs[$FamilyImgs]))
		<a href="/photos/ThumbnailsSummary.php?Genus={{ urlencode($speciessummary['Species']['Genus']) }}&Species={{ urlencode($speciessummary['Species']['Species']) }}" target="_blank">View all media</a> /
	@else
		No image available for this species; drawing shows typical species in {{ $FamilyName }}. <br>
	@endif
	Upload your <a href="https://www.fishbase.us/tools/UploadPhoto/start.php?speccode={{ urlencode($speciessummary['Species']['SpecCode']) }}" target="_blank">photos</a> and <a href="https://www.fishbase.us/tools/UploadVideo/start_info.php?speccode={{ urlencode($speciessummary['Species']['SpecCode']) }}" target="_blank">videos</a></small></p>

@push('header-css')
<style type="text/css">
.tns-outer {
	margin: 0 0 10px;
}
#species-images {
	margin: 0 auto;
}
</style>
@endpush

@once
    @push('pswp')
        @include('shared.pswp')
    @endpush
@endonce

@endif
              
              

