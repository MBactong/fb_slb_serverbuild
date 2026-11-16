@isset($speciessummary['CMS'])

<details id="cms">
                    <summary><div>
                        <div class="title">CMS <small>({!! FishBase::text('Ref. 116361') !!})</small></div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div></summary>
                    <div>
                        <p>
                        {!! $speciessummary['CMS'] !!}
                        </p>
                    </div>
                </details>
@endisset
