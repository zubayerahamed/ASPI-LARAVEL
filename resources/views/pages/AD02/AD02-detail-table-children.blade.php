@foreach ($children as $x)
    <p style="margin-left: {{ $margin }}px; font-size: 20px; font-weight: bold">{{ $x['xmenu'] . ' - ' . $x['title'] }}</p>
    <!-- Print assigned screens -->
    @foreach ($x['menu_screens'] as $screen)
        <div class="form-group" style="margin-left: {{ $margin + 50 }}px;">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="is_inhouse" name="is_inhouse" {{ $screen['is_active'] ? 'checked' : '' }}>
                <label for="is_inhouse" class="custom-control-label form-label">
                    {{ $screen['screen_xscreen'] }} - {{ $screen['alternate_title'] }}
                    @if ($screen['screen_type'] == 'Screen')
                        <span class="ml-2 badge bg-primary">{!! $screen['screen_type'] !!}</span>
                    @else
                        <span class="ml-2 badge bg-success">{!! $screen['screen_type'] !!}</span>
                    @endif
                    <span class="ml-2 badge bg-warning">{!! 'SN. ' . $screen['seqn'] !!}</span>
                </label>
            </div>
        </div>
    @endforeach

    <!-- Print Child Menus recursively -->
    @if (isset($x['children']) && count($x['children']) > 0)
        @include('pages.AD02.AD02-detail-table-children', ['children' => $x['children'], 'margin' => $margin + 50])
    @endif
@endforeach
