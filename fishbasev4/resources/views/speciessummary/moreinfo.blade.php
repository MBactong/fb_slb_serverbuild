
@push('header-css')
<style type="text/css">
ul.moreinfo {
	list-style: none;
	columns: 2;
  	-webkit-columns: 2;
  	-moz-columns: 2;
	padding: 0;
	margin: 1em 0;	
}
ul.moreinfo li {	
	margin-bottom: 5px;
	white-space: nowrap;
}
@media (min-width: 640px) {
	ul.moreinfo {
		columns: 3;
		-webkit-columns: 3;
		-moz-columns: 3;
	}
}
@media (min-width: 768px) {
	ul.moreinfo {
		columns: 4;
		-webkit-columns: 4;
		-moz-columns: 4;
	}
}
@media (min-width: 960px) {
	ul.moreinfo {
		columns: 3;
		-webkit-columns: 3;
		-moz-columns: 3;
	}
}
@media (min-width: 1280px) {
	ul.moreinfo {
		columns: 5;
		-webkit-columns: 5;
		-moz-columns: 5;
	}
}
/*@media (min-width: 1400px) {
	ul.moreinfo {
		columns: 5;
		-webkit-columns: 5;
		-moz-columns: 5;
	}
}*/
</style>
@endpush

@push('page-link')
<li>
        <a href="#moreinfo" data-summary-open="#moreinfo">More information</a>
</li>
@endpush

@php
$moreinfo = []; 
if (isset($speciessummary['MoreInfo']) && is_array($speciessummary['MoreInfo'])) {
	$moreinfo = $speciessummary['MoreInfo'];
}
@endphp
<details id="moreinfo">
                    <summary><div>
                        <div class="title">More information</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div>
		</summary>
                <div>   
<ul class="moreinfo">
	<li>{!! FishBase::links($speciessummary, 'countries_lnk', 'Countries', $moreinfo['country']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'faoareas_lnk', 'FAO areas', $moreinfo['faoareas']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'ecosystems_lnk', 'Ecosystems', $moreinfo['ecosystem']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'occurrences_lnk', 'Occurrences', $moreinfo['occurrence']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'introductions_lnk', 'Introductions', $moreinfo['intrcase']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'stocks_lnk', 'Stocks', $moreinfo['stockcode']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'ecology_lnk', 'Ecology', $moreinfo['ecology']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'diet_lnk', 'Diet', $moreinfo['diet']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'fooditems_lnk', 'Food items', $moreinfo['fooditems']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'foodconsumption_lnk', 'Food consumption', $moreinfo['popqb']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'ration_lnk', 'Ration', $moreinfo['ration']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'commonnames_lnk', 'Common names', $moreinfo['comnames']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'synonyms_lnk', 'Synonyms', $moreinfo['synonyms']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'metabolism_lnk', 'Metabolism', $moreinfo['oxygen']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'predators_lnk', 'Predators', $moreinfo['predats']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'ecotoxicology_lnk', 'Ecotoxicology', $moreinfo['cl50']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'reproduction_lnk', 'Reproduction', $moreinfo['reproduc']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'maturity_lnk', 'Maturity', $moreinfo['maturity']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'spawning_lnk', 'Spawning', $moreinfo['spawning']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'spawnaggregation_lnk', 'Spawning aggregation', $moreinfo['spawnagg']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'fecundity_lnk', 'Fecundity', $moreinfo['fecundity']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'eggs_lnk', 'Eggs', $moreinfo['eggs']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'eggsdev_lnk', 'Egg development', $moreinfo['eggdev']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'agesize_lnk', 'Age/Size', $moreinfo['popchar']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'growth_lnk', 'Growth', $moreinfo['popgrowth']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'lw_lnk', 'Length-weight', $moreinfo['poplw']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'll_lnk', 'Length-length', $moreinfo['popll']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'lf_lnk', 'Length-frequencies', $moreinfo['poplf']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'morphometrics_lnk', 'Morphometrics', $moreinfo['morphmet']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'morphology_lnk', 'Morphology', $moreinfo['morphdat']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'larvae_lnk', 'Larvae', $moreinfo['larvae']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'larvaldynamics_lnk', 'Larval dynamics', $moreinfo['larvdyn']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'recruitment_lnk', 'Recruitment', $moreinfo['recruitment']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'abundance_lnk', 'Abundance', $moreinfo['abundance']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'references_lnk', 'References', true) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'aquaculture_lnk', 'Aquaculture', $moreinfo['cultsys']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'aquacultureprof_lnk', 'Aquaculture profile', $moreinfo['profile']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'strains_lnk', 'Strains', $moreinfo['strains']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'genetics_lnk', 'Genetics', $moreinfo['genetics']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'allelefreq_lnk', 'Allele frequencies', $moreinfo['elecstudies']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'heritability_lnk', 'Heritability', $moreinfo['genedat']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'diseases_lnk', 'Diseases', $moreinfo['diseases']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'processing_lnk', 'Processing', $moreinfo['proxims']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'massConversion_lnk', 'Mass conversion', $moreinfo['massconversion']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'vision_lnk', 'Vision', $moreinfo['vision']) !!}</li>
	{{-- <li>{!! FishBase::links($speciessummary, 'collaborators_lnk', 'Collaborators', true) !!}</li> --}}
	<li>{!! FishBase::links($speciessummary, 'pictures_lnk', 'Pictures', true) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'stamps_lnk', 'Stamps, Coins Misc.', $moreinfo['stamps']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'sounds_lnk', 'Sounds', $moreinfo['sounds']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'ciguatera_lnk', 'Ciguatera', $moreinfo['ciguafb']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'speed_lnk', 'Speed', $moreinfo['speed']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'swimtype_lnk', 'Swim. type', $moreinfo['swimming']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'gillarea_lnk', 'Gill area', $moreinfo['gillarea']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'otoliths_lnk', 'Otoliths', $moreinfo['otoliths']) !!}</li>
	<li>{!! FishBase::links($speciessummary, 'brains_lnk', 'Brains', $moreinfo['brains']) !!}</li>
</ul>
</div>
</details>

	
