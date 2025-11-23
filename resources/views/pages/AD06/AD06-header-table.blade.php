@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of Users</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 AD06-datatable-fragment">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profiles</th>
                        <th>Other Businesses</th>
                        <th class="text-center">Status</th>
                        <th class="text-right" data-no-sort="Y">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('AD06', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                            </td>
                            <td>{{ $x->email }}</td>
                            <td>
                                @foreach ($x->profiles as $profile)
                                    <span class="badge bg-primary">{{ $profile->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($x->businesses as $business)
                                    @if (getBusinessId() !== $business->id)
                                        <span class="badge bg-secondary">{{ $business->name }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if ($x->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('AD06.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('AD06-datatable-fragment');

            $('.AD06-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            
            $('.AD06-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
