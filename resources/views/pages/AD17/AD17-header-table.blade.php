@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of TAX Components</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 AD17-datatable-fragment">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-center">Is Recoverable?</th>
                        <th class="text-right" data-no-sort="Y">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('AD17', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->code }}</a>
                            </td>
                            <td>{{ $x->name }}</td>
                            <td>{{ $x->description }}</td>
                            <td class="text-center">
                                @if ($x->is_recoverable)
                                    <i class="ph ph-check-circle text-success"></i>
                                @else
                                    <i class="ph ph-x-circle text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('AD17.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('AD17-datatable-fragment');

            $('.AD17-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            
            $('.AD17-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
