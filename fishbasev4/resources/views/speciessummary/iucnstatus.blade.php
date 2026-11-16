@isset($speciessummary['IucnStatus'])



<details id="iucn">
                    <summary><div>
                        <div class="title">IUCN Red List Status <small>({!! FishBase::text('Ref. 125652') !!})</small></div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
                        <p>
@php
    $data = [];
    $dataL = [];
    $tmp = trim(FishBase::IUCN($speciessummary['IucnStatus']['IUCN_Code']));
    if ($speciessummary['IucnStatus']['IUCN_Code'] !== 'NL') {
        if ($speciessummary['IucnStatus']['IUCN_ID']) {
            $tmp = '<a href="https://www.iucnredlist.org/details/'.$speciessummary['IucnStatus']['IUCN_ID'].'/'.$speciessummary['IucnStatus']['IUCN_IDAssess'].'" target="_blank">'.$tmp.'</a>';
        }
        else {
            $tmp = '<a href="https://www.iucnredlist.org" target="_blank">'.$tmp.'</a>';
        }
    }
    $dataL[] = trim($tmp);
    
    if ($speciessummary['IucnStatus']['IUCN_Assessment']) {
        $tmp = $speciessummary['IucnStatus']['IUCN_Assessment'];
        $dataL[] = trim($tmp);
    }

    if (count($dataL)) {
        $data[] = ucfirst(join(', ', $dataL));
    }
    
    if($speciessummary['IucnStatus']['IUCN_DateAssessed']) {
        $data[] = 'date assessed: '.date('F d Y', strtotime($speciessummary['IucnStatus']['IUCN_DateAssessed']));
    }
@endphp
{!! FishBase::trafficLight($speciessummary['IucnStatus']['IUCN_Code']) !!} {!! join('; ', $data) !!}
                        </p>
                    </div>
                </details>
@endisset
