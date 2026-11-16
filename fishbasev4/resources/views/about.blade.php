@extends('layout/body')

@section('title', 'Welcome to the world of fishes!')

@push('header-css')
    <style type="text/css">
        #news {
            display:block;
            margin-top:1.5em;
            
        }
        #news h2 {
            font:var(--w5-strong);
            margin-bottom:0.2em;
            color:#505050;
        }
        #news article {
            border-top: 1px solid #D9D9D9;
        }
        #news article h1 {
            font:var(--h5-serif);
            margin-bottom:0.2em;
        }
        #news article p.date {
            margin-top:0;
            font-style:italic;
        }
    </style>
@endpush

@section('content')

<main>
            <article>
                <h1>Welcome to the world of fishes!</h1>

<img src="{{ asset('images/jpgs/hp_dvd.jpg') }}" style="max-width:50%;height:100%;max-height:250px; margin: 0 0 20px 20px;" align="right"><p>FishBase is a global biodiversity information system on finfishes. From its initial goal to provide key facts on population dynamics for 200 major commercial species, FishBase has now grown to having a wide range of information on all species currently known in the world: taxonomy, biology, trophic ecology, life history, and uses, as well as historical data reaching back to 250 years.</p>

<p>At present, FishBase covers >{{number_format($searchpagestats['Species']['DisplayCount'])}} fish species compiled from >{{number_format($searchpagestats['References']['DisplayCount'])}} references in partnership with {{number_format($searchpagestats['Collaborators']['DisplayCount'])}} collaborators, >{{number_format($searchpagestats['Common names']['DisplayCount'])}} common names and >{{number_format($searchpagestats['Pictures']['DisplayCount'])}} pictures. Our website gathers more than {{number_format($searchpagestats['Pictures']['Sessions'])}} visits monthly.</p>

<p>The breadth and depth of information in the database, combined with the analytical and graphical tools available in the web, cater to different needs of diverse groups of stakeholders (scientists, researchers, policy makers, fisheries managers, donors, conservationists, teachers and students). Its various applications aim for sustainable fisheries management, biodiversity conservation and environmental protection.</p>

<p>FishBase is currently hosted by the <a href="https://q-quatics.org" target="_blank">Quantitative Aquatics, Incorporated</a> (Q-quatics), a non-stock, non-profit, non-governmental organization engaged in the development and management of global databases on aquatic organisms, including their distribution and ecology. It is scientifically guided by a Consortium of 12 international members.</p>
            </article>
            <section id="news">
            <h2>News</h2>
            
            <article>
            @foreach ($searchpagestats['News'] as $News)
                <h1>{{ $News->title }}</h1>
                <p class="date">{{ $News->date }}</p>
                @php 
                    $message = $News->message; 
                    $message = strip_tags($message, '<a>'); 
                    echo "<p>" . $message . "</p>";
                @endphp
            @endforeach
        </article>
            <!-- <p class="date"></p> -->
            
            <br>

            <!--   <article>
                
                         <h1><a href="https://www.q-quatics.org/2020/10/14/cornelia-nauen-on-how-she-helped-make-fishbase-a-reality/" target="_blank">Cornelia Nauen on how she helped make FishBase a reality</a></h1>
            <p class="date">October 14, 2020</p>
            <p>On the fourth episode of the <a href="https://anchor.fm/sea-around-us/episodes/Cornelia-Nauen---FishBase-and-SeaLifeBase-Anniversary-Podcast-ei0v0k" target="_blank">FishBase and SeaLifeBase Anniversary Podcast</a>, Dr Cornelia Nauen (President of Mundus Maris) shares the other side of the <a hreF="https://www.youtube.com/watch?v=liMFPgJvPjA&feature=youtu.be" target="_blank">FishBase story</a>, that is, the effort that had to be done to gather some seed money and bring the project to life.</p>
            {{-- <p><a href="https://www.q-quatics.org/2020/10/14/cornelia-nauen-on-how-she-helped-make-fishbase-a-reality/" class="button" target="_blank">Continue reading ></a></p> --}}
            </article>
            <article>
            <h1><a href="https://www.q-quatics.org/2020/05/14/kicking-off-the-fishbase-and-sealifebase-anniversary-celebrations/" target="_blank">Kicking off the FishBase and SeaLifeBase anniversary celebrations</a></h1>
            <p class="date">May 14, 2020</p>
            <p>The year 2020 marks the 30th anniversary of <a href="http://www.fishbase.org">FishBase</a> and 15th anniversary of <a href="http://www.sealifebase.org">SeaLifeBase</a>, two online global biodiversity information systems that, together, provide biological and ecological information on more than 110,000 marine species.</p>
            {{-- <p><a href="https://www.q-quatics.org/2020/05/14/kicking-off-the-fishbase-and-sealifebase-anniversary-celebrations/" class="button" target="_blank">Continue reading ></a></p> --}}
            </article>-->
            </section>
@include('ConsortiumLogos')
        </main>

@endsection


