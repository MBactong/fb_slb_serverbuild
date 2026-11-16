<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@hasSection('title')@yield('title') - @endif FishBase</title>
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
	@stack('header-css')
    <style type="text/css">
        ul.social {
            float: right;
        }
        ul.social li {
            display: inline-block;
            padding: 0 0 0 .5em;
        }

        ul.social li a {
            color: #fff;
            display: block;
            padding: 0;
            text-decoration: none;
            width: 2em;
            height: 2em;
            line-height: 2em;
            text-align: center;
            border: none;
            box-shadow: none;
        }
        ul.social li img {
            width: 100%;
        }
    </style>
	@stack('header-js')
    <script>window.MSInputMethodContext && document.documentMode && document.write('<script src="/assets/js/polyfills/ie11CustomProperties.min.js"><\/script><script src="/assets/js/polyfills/calc.min.js"><\/script><script src="/assets/js/polyfills/focus-within.js"><\/script><link href="/assets/css/ie.css" rel="stylesheet">');</script>
    </head>
    <body class="{{ $bodyclass }}">
        <header>
    <h1 id="logo">
        <a href="{{ url('') }}" title="FishBase - A global database about fish"><img src="{{ asset('assets/gfx/FishBase.png') }}" alt="FishBase Logo"><span>FishBase</span></a>
        <span class="claim"><a href="{{ url('about') }}" title="About FishBase">The global encyclopedia about fish</a></span>
    </h1>
    @include('shared.navigation')
    <div id="search">
        <label for="main-search-input" title="Search a fish ...">
            <svg class="icon">
                <use xlink:href="#icon-magnify" />
            </svg>
            <span>Search</span>
        </label>
    </div>
    <div id="extend">
        <a href="/donate/donate.php" class="button-round">Donate</a>
    </div>
@yield('page-links')
</header>
<form action="{{ url('search') }}" method="GET" id="main-search">
    <div class="form-group">
        <input type="text" name="q" id="main-search-input" placeholder="Search a fish ...">
        <button type="submit"><svg class="icon invert">
            <use xlink:href="#icon-magnify" />
        </svg></button>
    </div>
</form>
