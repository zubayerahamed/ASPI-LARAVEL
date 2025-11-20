@foreach ($menuTree as $m)
    @php
        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $count);
    @endphp
    <option value="{{ $m['id'] }}" {{ $menuScreen->menu_id == $m['id'] ? 'selected' : '' }}>{!! $indent . $m['xmenu'] . ' - ' . $m['title'] !!}</option>
    @if (!empty($m['children']))
        @include('pages.SA06.SA06-menu-recursive', [
            'menuTree' => $m['children'],
            'count' => $count + 1
        ])
    @endif
@endforeach