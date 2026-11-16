@extends('layout/body', ['bodyclass' => 'list'])


@isset($searchtxt['hits'])
@section('title', 'Search for „'.Request::get('q').'“')
@endisset

@push('header-css')
        <style type="text/css">
        .list .rh {
            grid-template-columns: 5fr 2fr;
        }

        .rl {
            clear:both;
        }
        .family {
            text-align: right;
            white-space: nowrap;
        }

        .list .ri .ri-t {
            grid-template-columns: 5fr 2fr;
        }

        .rh a {
                color:#fff;
        }
        .rh a:hover {
            border-color:#fff;
            box-shadow: inset 0 -1px 0 #fff;
        }
        .list .rl .rh .science {
            font-style: normal;
            font-weight: 700;
        }
        .list .rl .rh .science span {
            font:var(--w2-serif);
            font-style: italic;
        }
        /*.list .rl .rh .sort, .list .rl .rh .sort span {
            font-weight: 700;
        }*/

        .button-group {
            outline: 0;
            font: var(--w2-default);
            display: inline-flex;
            position:relative;
            justify-content: flex-start;
            background-color: #F9F9F9;
            font-family: 'PT Sans', sans-serif;
            font-weight: 700;
            -webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            -moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            border: 1px solid #D9D9D9;
            padding:0;
            border-radius: 3px;
            color: #284193;
            letter-spacing: normal;
            line-height: 1;
            height:40px;
        }

        .button-group > * {
            padding: .5em 1em;
        }

        .button-group > a {
            border-right: 1px solid #D9D9D9;
        }

        .button-group > a:hover {
            border:none;
            box-shadow:none;
            border-right: 1px solid #D9D9D9;
        }

        

        .button-group:hover {
            background-color: #F3F3F3;
            cursor: pointer;
            -webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            -moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            border: 1px solid #D9D9D9;
        }

        .dropdown {
            width: auto;
            padding-top:0;
            line-height: 40px;
        }

        .dropdown .dropdown-content {
            position: absolute;
            visibility:hidden;
            display: block;
            padding:.3em;            
        }

        .dropdown:hover .dropdown-content {
            visibility:visible;
            background-color: #F9F9F9;
            left:-1px;
            right:-1px;
            top:38px;
            text-align:right;
            padding-right: 1em;
            -webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            -moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
            border: 1px solid #D9D9D9;
            /* border-top:none; */
            border-radius-bottom-left: 3px;
            border-radius-bottom-right: 3px;
            
        }

        .dropdown-item {
            /*font-weight:400;*/
            font: var(--w1-default);
            line-height:2;
        }


        </style>
@endpush

@section('content')
@php
$order = 'desc';
if (!Request::get('order')) {
    if (!Request::get('sort')) {
        $order = 'desc';
    }
    else {
        $order = 'asc';
    }
}
else {
    $order = Request::get('order');
}
@endphp
@include('shared.pagination')
<main role="main">
	    <input type="checkbox" id="show-images" data-toggle="show-images">
            <section class="result">
            {{-- <p><span class="header">{{ $searchtxt['hits']['total']['value'] }} @choice('hit|hits', $searchtxt['hits']['total']['value']) for  <b>„{{ Request::get('q') }}“</b></span></p> --}}
            <p><span class="header">{{ $searchtxt['hits']['total']['value'] }} @choice('hit|hits', $searchtxt['hits']['total']['value']) for  <b>"{{ Request::get('q') }}"</b></span></p>

            @if ($searchtxt['hits']['total']['value'] > 0)
		@stack('pagination-showing')
            <div style="width:100%;margin:0;margin-bottom:.5em;display:flex;flex-wrap: wrap;justify-content: space-between;" class="clearfix">
                <label class="button" for="show-images" data-toggle="action-show-images" style="margin-bottom:.5em;">
                    <svg class="icon show" data-toggle="show-images">
                        <use xlink:href="#icon-image" />
                    </svg>
                    <svg class="icon hide" data-toggle="show-images">
                        <use xlink:href="#icon-noimage" />
                    </svg>
                    <span class="show" data-toggle="show-images">Show images</span>
                    <span class="hide" data-toggle="show-images">Hide images</span>
                </label>

                <div class="button-group" style="margin-bottom:.5em;margin-left:auto;">
                        {{-- <svg class="icon">
                            <use xlink:href="#icon-sort" />
                        </svg> --}}
                        <a href="?q={!! urlencode(Request::get('q')) !!}&order={{ ($order == 'desc') ? 'asc' : 'desc' }}&sort={!! urlencode(Request::get('sort')) !!} " title="Order {{ ($order == 'desc') ? 'ascending' : 'descending' }}"><svg class="icon" style="{{ ($order == 'desc') ? 'transform: scale(1,-1);' : '' }} width:24px;height:24px;vertical-align: text-bottom;">
                            <use xlink:href="#icon-sort" />
                        </svg></a>
                        <div class="dropdown">
                            @if(Request::get('sort') == 'scientific') Scientific Name
                            @elseif(Request::get('sort') == 'common') Common Name
                            @elseif(Request::get('sort') == 'family') Family Name
                            @else Relevance
                            @endif
                            <div class="dropdown-content">
                                @if(Request::get('sort'))<div class="dropdown-item"><a href="?q={!! urlencode(Request::get('q')) !!}" title="Sort by Relevance">Relevance</a></div>@endif
                                @if(Request::get('sort') != 'scientific')<div class="dropdown-item"><a href="?q={!! urlencode(Request::get('q')) !!}&sort=scientific&order={{ (Request::get('sort') && $order == 'desc') ? 'desc' : 'asc' }}" title="Sort by Scientific Name">Scientific Name</a></div>@endif
                                @if(Request::get('sort') != 'common')<div class="dropdown-item"><a href="?q={!! urlencode(Request::get('q')) !!}&sort=common&order={{ (Request::get('sort') && $order == 'desc') ? 'desc' : 'asc' }}" title="Sort by Common Name">Common Name</a></div>@endif
                                @if(Request::get('sort') != 'family')<div class="dropdown-item"><a href="?q={!! urlencode(Request::get('q')) !!}&sort=family&order={{ (Request::get('sort') && $order == 'desc') ? 'desc' : 'asc' }}" title="Sort by Family Name">Family Name</a></div>@endif
                            </div>
                        </div>
                </div>

                        
            </div>
            </section>
	
    {{-- {{ dd($searchtxt) }} --}}
    
	<div class="rl">
		<div class="rh">
                    <div class="science @if(Request::get('sort') === 'scientific') sort @endif"><span><b>Scientific Name</b></span>{{-- &darr; --}}</div>
                    <div class="common @if(Request::get('sort') === 'common') sort @endif">English Common Name{{-- <b>&uarr;</b> --}}</div>
                    {{-- <div clasS="country">Country / Countries</div> --}}
                    <div class="family @if(Request::get('sort') === 'family') sort @endif">Family Name</div>
                    {{-- <div class="lang">
                        <span title="Language">
                            <svg class="icon invert">
                                <use xlink:href="#icon-language" />
                            </svg>
                        </span>
                    </div> --}}
                </div>
		@foreach ($searchtxt['hits']['hits'] as $hit)
        
		<a href="{{ url('summary/'. $hit['_source']['speccode']. '/') }}">
		<div class="ri">
			<div class="ri-i hide" data-toggle="show-images">
				@include('showimage')
                        </div>
			<div class="ri-t">
                            <div class="science"><span>{{ $hit['_source']['genus'] }} {{ $hit['_source']['species'] }}</span></div>
                            <div class="common">{{ $hit['_source']['fbname'] }}</div>
                            {{-- <div clasS="country">{{ join(', ', $hit['_countries']) }} </div> --}}
                            <div class="family">{{ $hit['_source']['family'] }}</div>
                            {{-- <div class="lang small right">
                            @foreach ($hit['_languages'] as $lang)
                            <span>{{ $lang }}</span>
                            @endforeach
                            </div> --}}
                        </div>
		</div>
		</a>
		@endforeach
	</div>
	@stack('pagination-pages')
	@endif
	</main>
@endsection
