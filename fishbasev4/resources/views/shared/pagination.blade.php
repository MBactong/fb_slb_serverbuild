@php
	$pagination['needed'] = true;
	$pagination['steps'] = 5;
        if (isset($pagination['params']) && is_array($pagination['params']) && count($pagination['params'])) {
		$params = '';
		foreach($pagination['params'] as $k => $v) {
			$params .= '&'.$k.'='.urlencode($v);
		}
		$pagination['params'] = $params;
	}
	if ($pagination['count'] <= $pagination['size']) {
            		$pagination['needed'] = false;
            		$pagination['current'] = 1;
			//return $opts;
	}
	else {
		if ($pagination['count'] % $pagination['size'] === 0) {
			$maxpages  = floor($pagination['count']/$pagination['size']);
		}
		else {
			$maxpages  = floor($pagination['count']/$pagination['size']) + 1;
		}
		if ($maxpages < $pagination['page']) {
			$pagination['page'] = $maxpages;
		}
		$page = $pagination['page'];
		$pagination['current'] = $pagination['page'];
		$numright = floor($pagination['steps']/2);
		if ($pagination['steps'] % 2 === 0) {
			$numleft = ($pagination['steps']/2) -1;
		}
		else {
			$numleft = floor($pagination['steps']/2);
		}
		if ($page <= $numleft) {
			$numright = $numright + ($numleft-$page)+1;
			$numleft  = $numleft - ($numleft-$page)-1;
		}
		if ($page > $maxpages-$numright) {
			$numright = $maxpages-$page;
			$numleft = $pagination['steps'] - $numright - 1;
			if ($page - $numleft < 0) {
				$numleft = $page - 1;
			}
		}
		$pagination['pages'] = array();
		$pagination['next'] = 0;
		$pagination['prev'] = 0;
		$pagination['first'] = 0;
		$pagination['last'] = 0;

		$num = $page - $numleft;
		if ($num < 1) {
			$num = 1;
		}
		$numto = $page + $numright;
		while ($num <= $numto) {
			$pagination['pages'][$num] = $num;
			$num++;
		}
		if (!isset($pagination['pages'][$maxpages])) {
			$pagination['last'] = $maxpages;
		}
		if (!isset($pagination['pages'][1])) {
			$pagination['first'] = 1;
		}
		if ($page - 1 > 0) {
			$pagination['prev'] = $page - 1;
		}
		if ($page + 1 <= $maxpages) {
			$pagination['next'] = $page + 1;
		}
		$pagination['from'] = $pagination['size'] * $page - $pagination['size'] + 1;
		$pagination['to'] = $pagination['size'] * $page;
		if ($pagination['to'] > $pagination['count']) {
			$pagination['to'] = $pagination['count'];
		}
        if ($pagination['count'] <= $pagination['size']) {
            $pagination['needed'] = false;
        }
}
@endphp

@push('pagination-showing')
@if ($pagination['needed'])
<p>Show {{ $pagination['from'] }} to {{ $pagination['to'] }} of {{ $pagination['count'] }} entries.</p>
@endif
@endpush

@push('pagination-pages')
@if ($pagination['needed'])
<div class="pagination">
    <ul>
	@if ($pagination['prev'])
        <li class="previous">
            <a href="?{!! $pagination['params'] !!}&page={{ $pagination['prev'] }}" title="previous page"><b>«</b> <span>previous</span></a>
        </li>
	@else
	<li class="previous disabled">
            <a onclick="return false;" href="" title="previous page"><b>«</b> <span>previous</span></a>
        </li>
	@endif

	@if ($pagination['first'])
	<li class="first">
		<a href="?{!! $pagination['params'] !!}&page={{ $pagination['first'] }}" title="Page {{ $pagination['first'] }}">{{ $pagination['first'] }}@if (!isset($pagination['pages'][2])) <span>&hellip;</span>@endif</a>
	</li>
	@endif

	@foreach ($pagination['pages'] as $page)
	<li class="@if($page == $pagination['current']) active @endif">
            <a href="?{!! $pagination['params'] !!}&page={{ $page }}" title="Page {{ $page }}">{{ $page }}</a>
        </li>
	@endforeach

	@if ($pagination['last'])
        <li class="last">
                <a href="?{!! $pagination['params'] !!}&page={{ $pagination['last'] }}" title="Page {{ $pagination['last'] }}">@if (!isset($pagination['pages'][$pagination['last'] - 1])) <span>&hellip;</span> @endif{{ $pagination['last'] }}</a>
        </li>
        @endif

	@if ($pagination['next'])
        <li class="next">
            <a href="?{!! $pagination['params'] !!}&page={{ $pagination['next'] }}" title="next page"><span>next</span> <b>»</b></a>
        </li>
        @else
        <li class="next disabled">
            <a onclick="return false;" href="" title="next page"><span>next</span> <b>»</b></a>
        </li>
        @endif
    </ul>
</div>
@endif
@endpush
