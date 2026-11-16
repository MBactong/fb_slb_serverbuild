@isset($speciessummary['Distribution']['Distribution'])
@push('page-link')
<li>
        <a href="#distribution" data-summary-open="#distribution">Distribution</a>
</li>
@endpush

<details id="distribution">
                    <summary><div>
                        <div class="title">Distribution</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
			<p>
			{!! FishBase::text($speciessummary['Distribution']['Distribution']) !!}
			</p>
                    </div>
                </details>
@if(app('request')->input('data'))
    {{ dd($speciessummary) }}
@endif
@endisset
