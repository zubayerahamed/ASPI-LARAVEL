@foreach ($children as $x)
    <p style="margin-left: {{ $margin }}px; font-size: 20px; font-weight: bold">{{ $x['xmenu'] . ' - ' . $x['title'] }}</p>
    <!-- Print assigned screens -->
    @foreach ($x['menu_screens'] as $screen)
        <p style="margin-left: {{ $margin + 50 }}px;">
            <a class="detail-dataindex" href="#" data-reloadid="main-form-container" data-reloadurl="{{ route('SA06', ['id' => $screen['id']]) }}">{{ $screen['screen_xscreen'] }}</a> - {{ $screen['alternate_title'] }}
            @if ($screen['screen_type'] == 'Screen')
                <span class="ml-2 badge bg-primary">{!! $screen['screen_type'] !!}</span>
            @else
                <span class="ml-2 badge bg-success">{!! $screen['screen_type'] !!}</span>
            @endif
            <span class="ml-2 badge bg-warning">{!! 'SN. ' . $screen['seqn'] !!}</span>
            <a href="" class="ml-2 badge bg-danger btn-table-delete" data-url="{{ route('SA06.delete', ['id' => $screen['id']]) }}"><i class="ph ph-trash"></i></a>
        </p>
    @endforeach

    <!-- Print Child Menus recursively -->
    @if (isset($x['children']) && count($x['children']) > 0)
        @include('pages.SA06.SA06-header-table-children', ['children' => $x['children'], 'margin' => $margin + 50])
    @endif
@endforeach
