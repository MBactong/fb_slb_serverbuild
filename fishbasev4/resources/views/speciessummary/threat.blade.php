@isset($speciessummary['Threat']['Dangerous'])
@push('page-link')
<li>
        <a href="#threat" data-summary-open="#threat">Threat to humans</a>
</li>
@endpush

<details id="threat">
                 <summary><div>
                        <div class="title">Threat to humans</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
<p>
	 {!! FishBase::trafficLight($speciessummary['Threat']['Dangerous']) !!} {{ ucfirst($speciessummary['Threat']['Dangerous']) }}
        @isset($speciessummary['Threat']['DangerousRef'])
               {!! FishBase::text('(Ref. '.$speciessummary['Threat']['DangerousRef'].')') !!}
        @endisset
</p>
                    </div>
</details>
@endisset