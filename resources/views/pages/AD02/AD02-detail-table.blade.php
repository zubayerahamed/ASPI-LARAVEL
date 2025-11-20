@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Business Categories List</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 datatable-fragment">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th class="text-center">Category Code</th>
                        <th class="text-center">Sequence</th>
                        <th class="text-center">Is Active?</th>
                        <th class="text-right" data-no-sort="Y">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('AD02', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->name }}</a>
                            </td>
                            <td class="text-center">{{ $x->xcode }}</td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td class="text-center">{{ $x->is_active ? 'Y' : 'N' }}</td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('AD02.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
