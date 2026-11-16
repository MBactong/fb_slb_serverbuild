@php
    $data = [];
    $GetLm = null;
    if ($speciessummary['LengthMaturity']) {
        
        if ($speciessummary['LengthMaturity']['Count']) {
            $GetLm = $speciessummary['LengthMaturity']['SumLm'] / $speciessummary['LengthMaturity']['Count'];
        }
        $tmp = 'Maturity: L<sub>m</sub> <a href="/Reproduction/MaturityList.php?ID='.urlencode($speciessummary['Species']['SpecCode']).'">'.($GetLm ? number_format($GetLm, 1) : '?').'</a>';
        $tmp .= ', range '.(!empty($speciessummary['LengthMaturity']['LmMin']) ? number_format($speciessummary['LengthMaturity']['LmMin']) : '?').' - '.(!empty($speciessummary['LengthMaturity']['LmMax']) ? number_format($speciessummary['LengthMaturity']['LmMax']) : '?').' cm';
        $data[] = $tmp;
    }
    $dataL = [];
    if ($speciessummary['Species']['Length']) {
        $tmp = 'max length: '.($speciessummary['Species']['Length'] < 100 ? number_format($speciessummary['Species']['Length'], 1) : number_format($speciessummary['Species']['Length'])).' cm '.$speciessummary['Species']['LTypeMaxM'].' male/unsexed';
        if ($speciessummary['Species']['MaxLengthRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Species']['MaxLengthRef'].')';
        }
        $dataL[] = $tmp;
    }
    if ($speciessummary['Species']['LengthFemale']) {
        $tmp = 'max length: '.($speciessummary['Species']['LengthFemale'] < 100 ? number_format($speciessummary['Species']['LengthFemale'], 1) : number_format($speciessummary['Species']['LengthFemale'])).' cm '.$speciessummary['Species']['LTypeMaxF'].' (female)';
        $dataL[] = $tmp;
    }
    if ($speciessummary['Species']['CommonLength']) {
        $tmp = 'common length: '.($speciessummary['Species']['CommonLength'] < 100 ? number_format($speciessummary['Species']['CommonLength'], 1) : number_format($speciessummary['Species']['CommonLength'])).' cm '.$speciessummary['Species']['LTypeComM'].' male/unsexed';
        if ($speciessummary['Species']['CommonLengthRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Species']['CommonLengthRef'].')';
        }
        $dataL[] = $tmp;
    }
    if ($speciessummary['Species']['CommonLengthF']) {
        $tmp = 'common length: '.($speciessummary['Species']['CommonLengthF'] < 100 ? number_format($speciessummary['Species']['CommonLengthF'], 1) : number_format($speciessummary['Species']['CommonLengthF'])).' cm '.$speciessummary['Species']['LTypeComF'].' (female)';
        $dataL[] = $tmp;
    }
    if ($speciessummary['Species']['Weight']) {
        $tmp = 'max. published weight: '.FishBase::formatWeight($speciessummary['Species']['Weight']);
        if ($speciessummary['Species']['MaxWeightRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Species']['MaxWeightRef'].')';
        }
        $dataL[] = $tmp;
    }
    if ($speciessummary['Species']['WeightFemale']) {
        $tmp = 'max. published weight: '.FishBase::formatWeight($speciessummary['Species']['WeightFemale']);
        $dataL[] = $tmp;
    }
    if ($speciessummary['Species']['LongevityWild']) {
        $tmp = 'max. reported age: '.number_format($speciessummary['Species']['LongevityWild']).' years';
        if ($speciessummary['Species']['LongevityWildRef']) {
            $tmp .= ' (Ref. '.$speciessummary['Species']['LongevityWildRef'].')';
        }
        $dataL[] = $tmp;
    }

    if (count($dataL)) {
        $data[] = ucfirst(trim(join('; ', $dataL)));
    }

@endphp
@if(count($data))
@push('page-link')
<li>
    <a href="#size" data-summary-open="#size">
        @if($GetLm || (!empty($speciessummary['LengthMaturity']['LmMin'])))
            Length <small>/ Size / Weight / Age</small>
        @else
            Size <small>/ Weight / Age</small>
        @endif
    </a>    
</li>
@endpush

<details id="size">
    <summary><div>
        <div class="title">
        @if($GetLm || (!empty($speciessummary['LengthMaturity']['LmMin'])))
        Length at first maturity <small>/ Size / Weight / Age</small>
        @else
        Size <small>/ Weight / Age</small>
        @endif
        </div>
        <div class="arrow">
            <svg class="icon small middle">
                <use xlink:href="#icon-arrow-down"></use>
            </svg>
        </div>
    </div></summary>
    <div>
        <p>

    {!! FishBase::text(join('<br>', $data)) !!}.
        </p>
    </div>
</details>
@endif