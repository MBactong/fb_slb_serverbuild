@isset($speciessummary['Biology']['Comments'])
@push('page-link')
<li>
        <a href="#biology" data-summary-open="#biology">Biology</a>
</li>
@endpush

<details id="biology">
                 <summary><div>
                        <div class="title">Biology</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                 <use xlink:href="#icon-arrow-down"></use> 
                            </svg>
                        </div>
                    </div></summary>
                    <div>
<p>
{!! FishBase::text($speciessummary['Biology']['Comments']) !!}
</p>
                    </div>
                </details>
@endisset