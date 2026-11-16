@isset($speciessummary['Cites'])

<details id="cites">
                    <summary><div>
                        <div class="title">CITES <small>({!! FishBase::text('Ref. '.$speciessummary['Cites']['CITES_Ref']) !!})</small></div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
                        <p>
                        {!! $speciessummary['Cites']['CITES_Code'] !!}
                        </p>
                    </div>
                </details>
@endisset
