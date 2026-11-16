@php
    $data = [];
    $speciessummary['Environment']['Saltwater'] != 0 ? $data[] = 'marine' : null;
    $speciessummary['Environment']['Brack'] != 0 ? $data[] = 'brackish' : null;
    $speciessummary['Environment']['Fresh'] != 0 ? $data[] = 'freshwater' : null;
    $speciessummary['Environment']['DemersPelag'] ? $data[] = $speciessummary['Environment']['DemersPelag'] : null;
    
    if ($speciessummary['Environment']['AnaCat']) {
        $tmp = $speciessummary['Environment']['AnaCat'];
        if ($speciessummary['Environment']['migratref']) {
            $tmp .= ' (Ref. '.$speciessummary['Environment']['migratref'].')';
        }
        $data[] = $tmp;
    }

    if ($speciessummary['Environment']['pHMin'] || $speciessummary['Environment']['pHMax']) {
        $data[] = 'pH range: '
            .($speciessummary['Environment']['pHMin'] ? number_format($speciessummary['Environment']['pHMin'],1) : '?')
            .' - '
            .($speciessummary['Environment']['pHMax'] ? number_format($speciessummary['Environment']['pHMax'],1) : '?');
    }

    if ($speciessummary['Environment']['dHMin'] || $speciessummary['Environment']['dHMax']) {
        $data[] = 'dH range: '
            .($speciessummary['Environment']['dHMin'] ? $speciessummary['Environment']['dHMin'] : '?')
            .' - '
            .($speciessummary['Environment']['dHMax'] ? $speciessummary['Environment']['dHMax'] : '?');
    }

    if (
        $speciessummary['Environment']['DepthRangeShallow'] || 
        $speciessummary['Environment']['DepthRangeDeep'] || 
        $speciessummary['Environment']['DepthRangeComShallow'] || 
        $speciessummary['Environment']['DepthRangeComDeep']
    ) {
        $tmp = 'depth range ';
        if (
            $speciessummary['Environment']['DepthRangeShallow'] || 
            $speciessummary['Environment']['DepthRangeDeep']
        ) {
            $tmp .= (!is_null($speciessummary['Environment']['DepthRangeShallow']) ? $speciessummary['Environment']['DepthRangeShallow'] : '?')
            .' - '
            .(!is_null($speciessummary['Environment']['DepthRangeDeep']) ? $speciessummary['Environment']['DepthRangeDeep'] : '?').' m';
            if ($speciessummary['Environment']['DepthRangeRef']) {
                $tmp .= ' (Ref. '.$speciessummary['Environment']['DepthRangeRef'].')';
            }
        }

        if (
            $speciessummary['Environment']['DepthRangeComShallow'] || 
            $speciessummary['Environment']['DepthRangeComDeep']
        ) {
            $tmp .= ' usually '.(!is_null($speciessummary['Environment']['DepthRangeComShallow']) ? $speciessummary['Environment']['DepthRangeComShallow'] : '?')
            .' - '
            .(!is_null($speciessummary['Environment']['DepthRangeComDeep']) ? $speciessummary['Environment']['DepthRangeComDeep'] : '?').' m';
            if ($speciessummary['Environment']['DepthComRef']) {
                $tmp .= ' (Ref. '.$speciessummary['Environment']['DepthComRef'].')';
            }
        }
        $data[] = $tmp;
    }

    if (
        $speciessummary['Environment']['TempMin'] || 
        $speciessummary['Environment']['TempMax']
    ) {
        
        $tmp = (!is_null($speciessummary['Environment']['TempMin']) ? $speciessummary['Environment']['TempMin'].'&deg;C' : '?')
            .' - '
            .(!is_null($speciessummary['Environment']['TempMax']) ? $speciessummary['Environment']['TempMax'].'&deg;C' : '?');
        
        if ($speciessummary['Environment']['TempRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Environment']['TempRef'].')';
        }

        $tmp .= ' preferred '.(!is_null($speciessummary['Environment']['TempPreferred']) ? $speciessummary['Environment']['TempPreferred'].'&deg;C' : '?');
        
        if ($speciessummary['Environment']['TempPrefRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Environment']['TempPrefRef'].')';
        }

        $data[] = $tmp;
    }

    
    if ($speciessummary['Environment']['Envtemp']) {
        $data[] = $speciessummary['Environment']['Envtemp'];
    }

    if (
        $speciessummary['Environment']['NorthernMost'] || 
        $speciessummary['Environment']['SoutherMost'] ||
        $speciessummary['Environment']['WesternMost'] || 
        $speciessummary['Environment']['EasternMost']
    ) {
        
        $tmp = (!is_null($speciessummary['Environment']['NorthernMost']) ? $speciessummary['Environment']['NorthernMost'].'&deg;'.strtoupper($speciessummary['Environment']['NorthSouthN']) : '')
            .' - '
            .(!is_null($speciessummary['Environment']['SoutherMost']) ? $speciessummary['Environment']['SoutherMost'].'&deg;'.strtoupper($speciessummary['Environment']['NorthSouthS']) : '');
        
        $tmp .= (!is_null($speciessummary['Environment']['WesternMost']) ? $speciessummary['Environment']['WesternMost'].'&deg;'.strtoupper($speciessummary['Environment']['WestEastW']) : '')
            .' - '
            .(!is_null($speciessummary['Environment']['EasternMost']) ? $speciessummary['Environment']['EasternMost'].'&deg;'.strtoupper($speciessummary['Environment']['WestEastE']) : '');
        
        if ($speciessummary['Environment']['boundingRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Environment']['boundingRef'].')';
        }

        $data[] = $tmp;
    }



@endphp
@if(count($data))
@push('page-link')
<li>
        <a href="#environment" data-summary-open="#environment">Environment</a>
</li>
@endpush

<details id="environment">
                    <summary><div>
                        <div class="title">Environment<small> / milieu / depth range / climate zone / distribution range</small></div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div>
		</summary>
                <div>
                <p>                
                {!! FishBase::text(ucfirst(trim(join('; ',$data)))) !!}.
                </p>
                </div>
</details>
@endif