@if ($detailList != null && count($detailList) > 0)
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Profile Details</h3>
        </div>

        <div class="card-body AD02-datatable-fragment">
           @foreach ($detailList as $x)
                <p style="font-size: 20px; font-weight: bold">{{ $x['xmenu'] . ' - ' . $x['title'] }}</p>
                <!-- Print assigned screens -->
                @foreach ($x['menu_screens'] as $screen)
                    <div class="form-group" style="margin-left: 50px;">
                        <div class="custom-control custom-checkbox">
                            <input  class="custom-control-input profiledt-checkbox cursor-pointer" 
                                    id="profiledt-{{ $screen['profile_id'] }}-{{ $screen['id'] }}"
                                    type="checkbox" 
                                    data-profileid="{{ $screen['profile_id'] }}"
                                    data-menuscreenid="{{ $screen['id'] }}"
                                    {{ $screen['is_active'] ? 'checked' : '' }}>
                            <label for="profiledt-{{ $screen['profile_id'] }}-{{ $screen['id'] }}" class="custom-control-label form-label">
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
            kit.ui.init();

            $('.AD02-datatable-fragment').on('click', '.profiledt-checkbox', function(e) {
                //e.preventDefault();

                $thisCheckbox = $(this);
                let profileId = $thisCheckbox.data('profileid');
                let menuScreenId = $thisCheckbox.data('menuscreenid');
                let isActive = $thisCheckbox.is(':checked') ? 1 : 0;

                console.log('Profile ID: ' + profileId + ', Menu Screen ID: ' + menuScreenId + ', Is Active: ' + isActive);

                var data = {
                        profile_id: profileId,
                        menu_screen_id: menuScreenId,
                        is_active: isActive
                    };

                actionPostRequest("{{ route('AD02.detail-table.create') }}", data);
            });

        })
    </script>
@endif
