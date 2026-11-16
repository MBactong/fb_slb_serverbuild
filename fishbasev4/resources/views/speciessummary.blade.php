@extends('layout/body')

@push('header-css')
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.0/css/all.css">
    <script defer src="https://use.fontawesome.com/releases/v5.15.0/js/all.js"></script>
	<link rel="stylesheet" href="{{ asset('assets/photoswipe/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/photoswipe/default-skin/default-skin.css') }}">

	<link rel="stylesheet" href="{{ asset('assets/tiny-slider/tiny-slider.css') }}">
        <style type="text/css">
        span.mark {
                display: inline-block;
                width: 1.5em;
                height:1.5em;
                border: 1px solid #333;
                border-radius: 3px;
        }
        span.mark {
                background:#fff;
        }
        span.mark.ok {
                background:#0f0;
        }
        span.mark.warn {
                background:#ff0;
        }
        span.mark.danger {
                background:#f00;
        }
        div#species-images figure.item>a>img {
                width: 100%;
                height: calc(100% / 4);
                
                min-height: 120px;
                max-height: 250px;
                object-fit: contain;
                object-position: 50% 50%;
                display: block;
                vertical-align: middle;
        }
        div#species-images figure.item {
                vertical-align: middle;
        }
        main details {
                padding-top: 42px; margin-top: -42px;
        }
        div#species-images figure.item figcaption {
                display:block;
                text-align: center;
                background: rgba(255,255,255,0.8);
                font:var(--w1-default);
        }
        </style>
@endpush

@push('header-js')
	<script src="{{ asset('assets/photoswipe/photoswipe.min.js') }}"></script>
        <script src="{{ asset('assets/photoswipe/photoswipe-ui-default.min.js') }}"></script>

	<script src="{{ asset('assets/tiny-slider/min/tiny-slider.js') }}"></script>
    <script type="text/javascript">
        
        var StoredetailsStatus;

        function  expandFunction(){
            const DetailsList = document.querySelectorAll("details");
            const IconNode = document.createElement("i");
            const att = document.createAttribute("class");
            const ExpandElement = document.getElementById("expand");
            var detailsStatus = StoredetailsStatus;

            if (detailsStatus == "open"){
                detailsStatus = "";
                att.value = "fas fa-angle-double-right";
                document.getElementById("expand").innerHTML = " Expand all";

             }else{
                detailsStatus = "open";
                att.value = "fas fa-angle-double-down";
                document.getElementById("expand").innerHTML = " Collapse all";
             }
                for (let i = 0; i < DetailsList.length; i++) {
                    DetailsList[i].open = detailsStatus;
            }
            
            ExpandElement.appendChild(IconNode);
            ExpandElement.setAttributeNode(att); 
            StoredetailsStatus = detailsStatus;
            
        }//end of function  expand(form){
    
    
</script>    
@endpush

@push('footer-js')
	<script src="{{ asset('assets/js/media.js') }}" type="text/javascript"></script>
@endpush






@section('title', $speciessummary['Name']['Genus'].' '.$speciessummary['Name']['Species'].($speciessummary['Name']['FBname'] ? ', '.$speciessummary['Name']['FBname'] : ''))

@section('content')
<main role="main">
    
<article>
@include('speciessummary.name')
@include('speciessummary.images')
     
       <button id="expand" onclick="expandFunction()"><i class="fas fa-angle-double-right"></i> Expand all</button><br><br>

@include('speciessummary.classification')
@include('speciessummary.environment')
@include('speciessummary.distribution')
@include('speciessummary.aquamaps')
@include('speciessummary.length')
@include('speciessummary.morphology')
@include('speciessummary.biology')
@include('speciessummary.reproduction')
@include('speciessummary.reference')
@include('speciessummary.iucnstatus')
@include('speciessummary.cites')
@include('speciessummary.cms')
@include('speciessummary.threat')
@include('speciessummary.uses')
@include('speciessummary.moreinfo')
@include('speciessummary.estimates')

{{-- 
@include('speciessummary.tools')
@include('speciessummary.specialreport')
@include('speciessummary.downloadXML')
@include('speciessummary.internetsources')

@include('speciessummary.entered') --}}
</article>
</main>
@stack('pswp')
@endsection


@section('page-links')
<div id="links">
        <p><a href="#top"><b><i>{{$speciessummary['Name']['Genus']}} {{ $speciessummary['Name']['Species']}}</i></b>
        @if (isset($speciessummary['Name']['FBname']))<br>{{ $speciessummary['Name']['FBname']}}@endif
        </a></p>
        <nav>
            <div>
                <ul>
                        @stack('page-link')
                </ul>
            </div>
        </nav>
</div>
@endsection



