@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of Codes & Parameters</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 datatable-fragment">
                <thead>
                    <tr>
                        <th>Code Type</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th class="text-center">Sequence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('SA07', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->type }}</a>
                            </td>
                            <td>{{ $x->xcode }}</td>
                            <td>{{ $x->description }}</td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td class="d-flex justify-content-start gap-2">
                                <button data-url="{{ route('SA07.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
                if (!confirm("Are you sure, to delete this?")) {
                    return;
                }
                deleteRequest($(this).data('url'));
            });
        })
    </script>
@endif
