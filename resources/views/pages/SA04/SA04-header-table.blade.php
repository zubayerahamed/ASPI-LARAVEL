@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of pages</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 datatable-fragment">
                <thead>
                    <tr>
                        <th>Page Code</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th class="text-center">Sequence</th>
                        <th>Icon</th>
                        <th data-nosort='Y'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('SA04', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->xscreen }}</a>
                            </td>
                            <td>{{ $x->title }}</td>
                            <td>
                                <span class="badge bg-{{ $x->type == 'SCREEN' ? 'primary' : ($x->type == 'REPORT' ? 'success' : ($x->type == 'SYSTEM' ? 'info' : 'warning')) }}">{{ $x->type }}</span>
                            </td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td>{{ $x->icon }}</td>
                            <td class="d-flex justify-content-start gap-2">
                                <button data-url="{{ route('SA04.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
                                    <i class="ph ph-trash"></i>
                                </button>
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
