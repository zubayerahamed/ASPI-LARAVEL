@foreach ($menuTree as $m)
    @php
        $indent = str_repeat('|&nbsp;&nbsp;&nbsp;&nbsp;', $count) . '|--';
    @endphp
    <option value="{{ $m['id'] }}" {{ $menu->parent_menu_id == $m['id'] ? 'selected' : '' }}>{!! $indent . $m['xmenu'] . ' - ' . $m['title'] !!}</option>
    @if (!empty($m['children']))
        @include('pages.SA05.SA05-category-recursive', [
            'menuTree' => $m['children'],
            'count' => $count + 1
        ])
    @endif
@endforeach