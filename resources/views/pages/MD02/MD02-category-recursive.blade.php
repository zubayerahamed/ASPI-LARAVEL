@foreach ($categoryTree as $m)
    @php
        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $count);
    @endphp
    <option value="{{ $m['id'] }}" {{ $category->parent_category_id == $m['id'] ? 'selected' : '' }}>{!! $indent . $m['name'] !!}</option>
    @if (!empty($m['children']))
        @include('pages.MD02.MD02-category-recursive', [
            'categoryTree' => $m['children'],
            'count' => $count + 1
        ])
    @endif
@endforeach