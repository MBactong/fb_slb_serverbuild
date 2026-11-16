@isset($speciessummary['Reference']['author'])
@push('page-link')
<li>
        <a href="#reference" data-summary-open="#reference">Main reference</a>
</li>
@endpush

<details id="reference">
                    <summary><div>
                        <div class="title">Main reference</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
                        <p>
<b>   {!! FishBase::text($speciessummary['Reference']['author']) !!}</b>  {!! FishBase::text($speciessummary['Reference']['year']) !!}
{!! FishBase::text($speciessummary['Reference']['title']) !!} {!! FishBase::text($speciessummary['Reference']['source']) !!}
(Ref. <a href="/references/FBRefSummary.php?ID={!! FishBase::text($speciessummary['Reference']['refno']) !!}" target="_blank">{!! FishBase::text($speciessummary['Reference']['refno']) !!}</a>)
                        </p>
                    </div>
                </details>
@endisset