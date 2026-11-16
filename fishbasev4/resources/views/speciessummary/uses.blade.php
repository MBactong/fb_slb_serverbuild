@isset($speciessummary['Uses'])
@php
    $data = [];

    if($speciessummary['Uses']['Importance']) {
        $tmp = 'fisheries: '.$speciessummary['Uses']['Importance'];
        /*if($speciessummary['Uses']['Importance'] && $speciessummary['Uses']['Importance'] !=== "of no interest") {
            $tmp .= 'fisheries';
        }*/
        $data[] = $tmp;
    }
    
    if($speciessummary['Uses']['UsedforAquaculture'] && $speciessummary['Uses']['UsedforAquaculture'] !== "never/rarely") {
        $tmp = 'aquaculture: '.$speciessummary['Uses']['UsedforAquaculture'];
        $data[] = $tmp;
    }

    if ($speciessummary['Uses']['GameFish'] != 0) {
        $tmp = 'gamefish: yes';
        $data[] = $tmp;
    }

    if($speciessummary['Uses']['Aquarium'] && $speciessummary['Uses']['Aquarium'] !== "never/rarely") {
        $tmp = 'aquarium: '.$speciessummary['Uses']['Aquarium'];
        $data[] = $tmp;
    }

    if($speciessummary['Uses']['UsedasBait'] && $speciessummary['Uses']['UsedasBait'] !== "never/rarely") {
        $tmp = 'bait: '.$speciessummary['Uses']['UsedasBait'];
        $data[] = $tmp;
    }

    
    $FAO = '<br>FAO - ';

    if($speciessummary['Uses']['Stats_Aquaculture'] && $speciessummary['Uses']['Stats_Aquaculture'] <> 0 OR $speciessummary['Uses']['FS_CulturedSumm'] && $speciessummary['Uses']['FS_CulturedSumm'] <> 0) {
        $FAO .= 'Aquaculture: ';
        
        if($speciessummary['Uses']['Stats_Aquaculture'] <> 0){
            $FAO .= '<a href="/report/fao/FAOAquacultureList.php?scientific=' . $speciessummary["Uses"]["genus"] . '+' . $speciessummary["Uses"]["species"] . '" target="_blank">production</a>, ';
            
        }
        if($speciessummary['Uses']['FS_CulturedSumm'] <> 0){
            $FAO .= '<a href="http://www.fao.org/fishery/culturedspecies/' . $speciessummary["Uses"]["genus"] . '_' . $speciessummary["Uses"]["species"] . '/en" target="_blank">species profile</a>; ';
            
        }
    }

    if($speciessummary['Uses']['Stats_Catch'] && $speciessummary['Uses']['Stats_Catch'] <> 0 OR $speciessummary['Uses']['FS_AquaticSumm'] && $speciessummary['Uses']['FS_AquaticSumm'] <> 0) {
        $FAO .= 'Fisheries: ';
        
        if($speciessummary['Uses']['Stats_Catch'] <> 0){
            $FAO .= '<a href="/report/fao/FAOCatchList.php?scientific=' . $speciessummary["Uses"]["genus"] . '+' . $speciessummary["Uses"]["species"] . '" target="_blank">landings</a>, ';
           
        }
        if($speciessummary['Uses']['FS_AquaticSumm'] <> 0){
            $FAO .= '<a href="http://www.fao.org/fishery/species/' . $speciessummary["Uses"]["ISSCAAP.figis_id"] . '/en" target="_blank">species profile</a>; ';
            
        }
    }
    $FAO .= 'Publication: ';
    $FAO .= '<a href="https://www.fao.org/fishery/en/global-search?page=1&q=' . $speciessummary["Uses"]["genus"] . ' ' . $speciessummary["Uses"]["species"] . '&lang=en&tab=all&children=#global-search" target="_blank">search</a> ';


    if($speciessummary['Uses']['AlphaCode']) {
        $FAO .= '| FIRMS - ';
        $FAO .= '<a href="http://firms.fao.org/firms/search/species/' . $speciessummary["Uses"]["AlphaCode"] . '" target="_blank">Stock assessments</a> | ';
    }

    $FAO .= '<a href="https://www.fishsource.org/fishbase_query?genus=' . $speciessummary["Uses"]["genus"] . '&specific_descriptor=' .  $speciessummary["Uses"]["species"] . '" target="_blank">FishSource</a> | ';

    if($speciessummary['Uses']['saup_id']) {
        $FAO .= '<a href="http://www.seaaroundus.org/data/#/taxa/' . $speciessummary["Uses"]["saup_id"] . '" target="_blank">Sea Around Us</a>';
    }


    
@endphp
@if(count($data))
@push('page-link')
<li>
        <a href="#uses" data-summary-open="#uses">Human uses</a>
</li>
@endpush

<details id="uses">
                 <summary><div>
                        <div class="title">Human uses</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
<p>

{!! FishBase::text(ucfirst(trim(join('; ',$data)))) !!}.
{!! FishBase::text($FAO) !!}
</p>
                    </div>
                </details>
@endif
@endisset