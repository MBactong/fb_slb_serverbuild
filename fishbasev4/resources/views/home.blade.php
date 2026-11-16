
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FishBase - A Global Information System on Fishes</title>
        <link rel="preload" href="{{ asset('assets/fonts/pt-sans-v11-latin-ext_latin_cyrillic-ext_cyrillic-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('assets/fonts/pt-sans-v11-latin-ext_latin_cyrillic-ext_cyrillic-italic.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('assets/fonts/pt-sans-v11-latin-ext_latin_cyrillic-ext_cyrillic-700.woff2') }}" as="font" type="font/woff2" crossorigin>

        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
        <script>window.MSInputMethodContext && document.documentMode && document.write('<script src="/assets/js/polyfills/ie11CustomProperties.min.js"><\/script><script src="/assets/js/polyfills/calc.min.js"><\/script><link href="/assets/css/ie.css" rel="stylesheet">');</script>
    
    <style type="text/css">
        
        .home header {
            background:var(--theme--secondary);
            /* width: 100%; */
            height: 52px;
            z-index:200;
        }

        .home header #navigation label {
            display:block;
        }
        .home header #navigation nav {
            width: min-content;
        }

        @media (min-width: 960px) {
            .home header {
                width: 100%;
                height: 52px;
            }
        }

        .home main {
            display:block;
            padding-top:20px;
        }
        
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
    </head>
    <body class="home">
    <header>
    @include('shared.navigation')
    </header>
    <main role="main">
            <img src="{{ asset('assets/gfx/FishBase.png') }}" title="FishBase - A global database about fish" alt="FishBase Logo">
            <p class="claim"><a href="{{ url('about') }}" title="About FishBase">The global encyclopedia about fish</a></p>
            <form action="{{ url('search') }}" method="GET" id="main-search">
    <div class="form-group">
        <input type="text" name="q" id="main-search-input" placeholder="Search a fish ..." autofocus>
        <button type="submit"><svg class="icon invert">
            <use xlink:href="#icon-magnify" />
        </svg></button>
    </div>
</form>
           <p style="padding:5px 0;">
            <a href="/" class="button-round">
            <!-- <svg class="icon" style="vertical-align: middle;">
                <use xlink:href="#icon-magnify" />
            </svg> -->
            <b>Advanced Search</b>
            </a>
        </p>

{{--            <details id="languages">
    <summary>
        <svg class="icon">
            <use xlink:href="#icon-language" />
        </svg>
        Read FishBase in your language
    </summary>
    <div class="summary-content">
        <div><p><a href="/en" title="English">English</a></p></div>
        <div><p><a href="/es" title="Spanish">Español</a></p></div>
        <div><p><a href="/pt" title="Portuguese">Português</a></p></div><!-- (Br , Pt) [pt-BR] [pt-PT] -->
        <div><p><a href="/fr" title="French">Français</a></p></div>
        <div><p><a href="/de" title="German">Deutsch</a></p></div>
        <div><p><a href="/it" title="Italian">Italiano</a></p></div>
        <div><p><a href="/nl" title="Dutch">Nederlands</a></p></div>
        <div><p><a href="/zh-Hans" title="Simplified Chinese">简体中文</a></p></div>
        <div><p><a href="/zh-Hant" title="Traditional Chinese">繁體中文</a></p></div>
        <div><p><a href="/ja" title="Japanese">日本語</a></p></div>
        <div><p><a href="/id" title="Bahasa Malay/Indonesian">بهاس ملايو‎</a></p></div>
        <div><p><a href="/el" title="Greek">Ελληνικά</a></p></div>
        <div><p><a href="/sv" title="Swedish">Svenska</a></p></div>
        <div><p><a href="/ru" title="Russian">русский</a></p></div>
        <div><p><a href="/fa" title="Farsi/Persian">فارسی</a></p></div>
        <div><p><a href="/vi" title="Vietnamese">Tiếng Việt</a></p></div>
        <div><p><a href="/th" title="Thai">ไทย</a></p></div>
        <div><p><a href="/lo" title="Lao">ພາສາລາວ</a></p></div>
        <div><p><a href="/hi" title="Hindi">हिन्दी, हिंदी</a></p></div>
        <div><p><a href="/bn" title="Bengali/Bangla">বাংলা</a></p></div>
        <div><p><a href="/ar" title="Arabic">العربية</a></p></div>
        <div><p><a href="/tr" title="Turkish">Türkçe</a></p></div>
        <div><p><a href="/my" title="Myanmar">ဗမာစာ</a></p></div>
    </div>
</details> --}}
            <br><br><br>
            
            <nav role="navigation">
               <a href="/donate/donate.php" class="image-link" ><img src="/images/gifs/DonateButton.gif" alt="Donate" width="70"></a>
                
                <ul>
                    <li>
                        <a href="{{ url('about') }}">About FishBase</a>
                    </li>
                    {{-- <li>
                        <a href="/donate/donate.php">Donate</a>
                    </li> --}}
                </ul>
            </nav>

        </main>
@include('layout.footer')
<!-- 
        <footer class="clearfix">
            <p><b>FishBase v4.0</b></p>
            <p>
                For web site technical issues only: <a href="/technical-issues">Webmaster</a><br>
                For comments: <a href="/contact">Comments & Corrections</a>
            </p>
            <ul class="social">
                <li ><a href="https://www.facebook.com/FishBase" target="_blank" rel="noopener" title="FishBase on Facebook"><img src="{{ asset('assets/gfx/Facebook.svg') }}" alt="Facebook Logo"></a></li>
                <li ><a href="https://twitter.com/fishbaseproject" target="_blank" rel="noopener" title="FishBase on Twitter"><img src="{{ asset('assets/gfx/Twitter.svg') }}" alt="Twitter Logo"></a></li>
            </ul>
        </footer>
@include('shared/icons')
    </body>
</html>
-->


