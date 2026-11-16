@if(isset($speciessummary['Reproduction']['AddInfos']) && trim($speciessummary['Reproduction']['AddInfos']) != '')
@push('page-link')
<li>
        <a href="#lifecycle" data-summary-open="#lifecycle">Life cycle</a>
</li>
@endpush

<details id="lifecycle">
                    <summary><div>
                        <div class="title">Life cycle and mating behavior</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
                        <p>
 {!! FishBase::text($speciessummary['Reproduction']['AddInfos']) !!}
                        </p>
                    </div>
                </details>
@endif