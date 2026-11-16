@php
  $imgs = [];

  if (isset($hit['_images']['Preferred']['PicPreferredName']) && $hit['_images']['Preferred']['PicPreferredName']) {
		$imgs[strtolower($hit['_images']['Preferred']['PicPreferredName'])] = 1;
	}
	if (isset($hit['_images']['Preferred']['PicPreferredNameM']) && $hit['_images']['Preferred']['PicPreferredNameM']) {
		$imgs[strtolower($hit['_images']['Preferred']['PicPreferredNameM'])] = 1;
	}
	if (count($imgs) < 2 && isset($hit['_images']['Preferred']['PicPreferredNameF']) && $hit['_images']['Preferred']['PicPreferredNameF']) {
		$imgs[strtolower($hit['_images']['Preferred']['PicPreferredNameF'])] = 1;
	}
	if (count($imgs) < 2 && isset($hit['_images']['Preferred']['PicPreferredNameJ']) && $hit['_images']['Preferred']['PicPreferredNameJ']) {
		$imgs[strtolower($hit['_images']['Preferred']['PicPreferredNameJ'])] = 1;
	}
@endphp

@if (isset($hit['_images']['MainPics']) && count($imgs) < 2)
  @foreach ($hit['_images']['MainPics'] as $img)
    @if (!isset($imgs[$img['FileName']]))
      @php
      $imgs[$img['FileName']] = 1;
      @endphp
    @endif
    @if(count($imgs) > 1)
      @break
    @endif
  @endforeach  
@endif

@if(count($imgs) > 0)
<div>
@foreach (array_keys($imgs) as $img)
<img src="{{ asset('images/species/'.$img) }}">
@endforeach
</div>
@endif

