@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of Business Admins</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 datatable-fragment">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Businesses</th>
                        <th class="text-center">Status</th>
                        <th class="text-right" data-no-sort="Y">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('SA03', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->email }}</a>
                            </td>
                            <td>{{ $x->name }}</td>
                            <td>
                                @foreach ($x->businesses as $business)
                                    <span class="badge bg-primary">{{ $business->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">{{ $x->status }}</td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('SA03.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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

            $('a.detail-dataindex').off('click').on('click', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.btn-table-delete').off('click').on('click', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
