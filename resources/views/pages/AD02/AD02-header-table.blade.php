@if (isset($detailList) && count($detailList) > 0)
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Menu page allocations</h3>
        </div>

        <div class="card-body datatable-fragment">
            @foreach ($detailList as $x)
                <p style="font-size: 20px; font-weight: bold">{{ $x['xmenu'] . ' - ' . $x['title'] }}</p>
                <!-- Print assigned screens -->
                @foreach ($x['menu_screens'] as $screen)
                    <p style="margin-left: 50px;">
                        <a class="detail-dataindex" href="#" data-reloadid="main-form-container" data-reloadurl="{{ route('AD02', ['id' => $screen['id']]) }}">{{ $screen['screen_xscreen'] }}</a> - {{ $screen['alternate_title'] }}
                        @if ($screen['screen_type'] == 'Screen')
                            <span class="ml-2 badge bg-primary">{!! $screen['screen_type'] !!}</span>
                        @else
                            <span class="ml-2 badge bg-success">{!! $screen['screen_type'] !!}</span>
                        @endif
                        <span class="ml-2 badge bg-warning">{!! 'SN. ' . $screen['seqn'] !!}</span>
                        <a href="" class="ml-2 badge bg-danger btn-table-delete" data-url="{{ route('AD02.delete', ['id' => $screen['id']]) }}"><i class="ph ph-trash"></i></a>
                    </p>
                @endforeach

                <!-- Print Child Menus recursively -->
                @if (isset($x['children']) && count($x['children']) > 0)
                    @include('pages.AD02.AD02-header-table-children', ['children' => $x['children'], 'margin' => 50])
                @endif
            @endforeach
        </div>


    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.datatable-fragment').on('click', 'a.btn-table-delete', function(e) {
                e.preventDefault();
                if (!confirm("Are you sure, to delete this?")) {
                    return;
                }
                deleteRequest($(this).data('url'));
            });
        })
    </script>
@endif
