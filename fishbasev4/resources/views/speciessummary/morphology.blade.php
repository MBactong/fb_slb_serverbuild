@if($speciessummary['Morphology'])
@php
$data = [];

if (!is_null($speciessummary['Morphology']['dorsalspinesmin']) || !is_null($speciessummary['Morphology']['dorsalspinesmax'])) {
    $tmp = '<a href="/glossary/Glossary.php?q=dorsal%20fin&language=english&sc=is">Dorsal</a> <a href="/glossary/Glossary.php?q=spine&language=english&sc=is">spines</a> (total): ';
    if (!is_null($speciessummary['Morphology']['dorsalspinesmin'])) {
        $tmp .= $speciessummary['Morphology']['dorsalspinesmin'];
    }
    if (!is_null($speciessummary['Morphology']['dorsalspinesmax']) && $speciessummary['Morphology']['dorsalspinesmin'] != $speciessummary['Morphology']['dorsalspinesmax']) {
        if (!is_null($speciessummary['Morphology']['dorsalspinesmin'])) {
            $tmp .= ' - ';
        }
        $tmp .= $speciessummary['Morphology']['dorsalspinesmax'];
    }
    $data[] = $tmp;
}

if (!is_null($speciessummary['Morphology']['dorsalsoftraysmin']) || !is_null($speciessummary['Morphology']['dorsalsoftraysmax'])) {
    $tmp = '<a href="/glossary/Glossary.php?q=dorsal%20fin&language=english&sc=is">Dorsal</a> <a href="/glossary/Glossary.php?q=soft%20ray&language=english&sc=is">soft rays</a> (total): ';
    if (!is_null($speciessummary['Morphology']['dorsalsoftraysmin'])) {
        $tmp .= $speciessummary['Morphology']['dorsalsoftraysmin'];
    }
    if (!is_null($speciessummary['Morphology']['dorsalsoftraysmax']) && $speciessummary['Morphology']['dorsalsoftraysmin'] != $speciessummary['Morphology']['dorsalsoftraysmax']) {
        if (!is_null($speciessummary['Morphology']['dorsalsoftraysmin'])) {
            $tmp .= ' - ';
        }
        $tmp .= $speciessummary['Morphology']['dorsalsoftraysmax'];
    }
    $data[] = $tmp;
}

if (!is_null($speciessummary['Morphology']['analfinspinesmin']) || !is_null($speciessummary['Morphology']['analfinspinesmax'])) {
    $tmp = '<a href="/glossary/Glossary.php?q=anal%20fin&language=english&sc=is">Anal</a> <a href="/glossary/Glossary.php?q=spine&language=english&sc=is">spines</a>: ';
    if (!is_null($speciessummary['Morphology']['analfinspinesmin'])) {
        $tmp .= $speciessummary['Morphology']['analfinspinesmin'];
    }
    if (!is_null($speciessummary['Morphology']['analfinspinesmax']) && $speciessummary['Morphology']['analfinspinesmin'] != $speciessummary['Morphology']['analfinspinesmax']) {
        if (!is_null($speciessummary['Morphology']['analfinspinesmin'])) {
            $tmp .= ' - ';
        }
        $tmp .= $speciessummary['Morphology']['analfinspinesmax'];
    }
    $data[] = $tmp;
}

if (!is_null($speciessummary['Morphology']['araymin']) || !is_null($speciessummary['Morphology']['araymax'])) {
    $tmp = '<a href="/glossary/Glossary.php?q=anal%20fin&language=english&sc=is">Anal</a> <a href="/glossary/Glossary.php?q=soft%20ray&language=english&sc=is">soft rays</a>: ';
    if (!is_null($speciessummary['Morphology']['araymin'])) {
        $tmp .= $speciessummary['Morphology']['araymin'];
    }
    if (!is_null($speciessummary['Morphology']['araymax']) && $speciessummary['Morphology']['araymin'] != $speciessummary['Morphology']['araymax']) {
        if (!is_null($speciessummary['Morphology']['araymin'])) {
            $tmp .= ' - ';
        }
        $tmp .= $speciessummary['Morphology']['araymax'];
    }
    $data[] = $tmp;
}

if (!is_null($speciessummary['Morphology']['Vertebraetotalmin']) || !is_null($speciessummary['Morphology']['Vertebraetotalmax'])) {
    $tmp = '<a href="/glossary/Glossary.php?q=vertebrae&language=english&sc=is">Vertebrae</a>: ';
    if (!is_null($speciessummary['Morphology']['Vertebraetotalmin'])) {
        $tmp .= $speciessummary['Morphology']['Vertebraetotalmin'];
    }
    if (!is_null($speciessummary['Morphology']['Vertebraetotalmax']) && $speciessummary['Morphology']['Vertebraetotalmin'] != $speciessummary['Morphology']['Vertebraetotalmax']) {
        if (!is_null($speciessummary['Morphology']['Vertebraetotalmin'])) {
            $tmp .= ' - ';
        }
        $tmp .= $speciessummary['Morphology']['Vertebraetotalmax'];
    }
    $data[] = $tmp;
}

@endphp
@if(count($data))
@push('page-link')
<li>
        <a href="#description" data-summary-open="#description">Short description</a>
</li>
@endpush

<details id="description">
                 <summary><div>
                        <div class="title">Short description</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
<p>

    {!! join('; ', $data) !!}@if(count($data)).@endif {!! FishBase::text($speciessummary['Morphology']['addchars']) !!}
</p>
                    </div>
                </details>
@endif
@endif