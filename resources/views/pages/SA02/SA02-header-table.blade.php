@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Businesses List</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 datatable-fragment">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Business Category</th>
                        <th>Country</th>
                        <th class="text-center">Currency</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Services</th>
                        <th class="text-center">Active</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('SA02', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                            </td>
                            <td>{{ $x->businessCategory->name }}</td>
                            <td>{{ $x->country }}</td>
                            <td class="text-center">{{ $x->currency }}</td>
                            <td>{{ $x->email }}</td>
                            <td>{{ $x->mobile }}</td>
                            <td>
                                <!-- Display service icons based on boolean fields -->
                                <div class="d-flex align-items-center gap-3">
                                    @if ($x->is_inhouse)
                                        <div class="d-flex align-items-center gap-1"><i class="ph ph-check text-success"></i><span>Inhouse</span></div>
                                    @else
                                        <div class="d-flex align-items-center gap-1"><i class="ph ph-x text-danger"></i><span>Inhouse</span></div>
                                    @endif
                                    @if ($x->is_pickup)
                                        <div class="d-flex align-items-center gap-1"><i class="ph ph-check text-success"></i><span>Pickup</span></div>
                                    @else
                                        <div class="d-flex align-items-center gap-1"><i class="ph ph-x text-danger"></i><span>Pickup</span></div>
                                    @endif
                                    @if ($x->is_delivery)
                                        <div class="d-flex align-items-center gap-1"><i class="ph ph-check text-success"></i><span>Delivery</span></div>
                                    @else
                                        <div class="d-flex align-items-center gap-1"><i class="ph ph-x text-danger"></i><span>Delivery</span></div>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">{{ $x->is_active ? 'Y' : 'N' }}</td>
                            <td class="">
                                <div class="d-flex justify-content-end gap-2">
                                    <button data-url="{{ route('SA02.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            kit.ui.config.initDatatable('datatable-fragment');

            $('.datatable-fragment').on('click', 'a.detail-dataindex', function(e){
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.datatable-fragment').on('click', 'button.btn-table-delete', function(e){
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
