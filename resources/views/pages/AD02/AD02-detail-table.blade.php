@if ($detailList != null && count($detailList) > 0)
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Profile Details</h3>
        </div>

        <div class="card-body datatable-fragment">
           @foreach ($detailList as $x)
                <p style="font-size: 20px; font-weight: bold">{{ $x['xmenu'] . ' - ' . $x['title'] }}</p>
                <!-- Print assigned screens -->
                @foreach ($x['menu_screens'] as $screen)
                    <div class="form-group" style="margin-left: 50px;">
                        <div class="custom-control custom-checkbox">
                            <input  class="custom-control-input profiledt-checkbox" 
                                    type="checkbox" 
                                    data-profileid="{{ $screen['profile_id'] }}"
                                    data-menuscreenid="{{ $screen['id'] }}"
                                    {{ $screen['is_active'] ? 'checked' : '' }}>
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
                    @include('pages.AD02.AD02-detail-table-children', ['children' => $x['children'], 'margin' => 50])
                @endif
            @endforeach
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // kit.ui.config.initDatatable('datatable-fragment');

            $('.datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
