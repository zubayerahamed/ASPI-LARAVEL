@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of Codes & Parameters</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 SA07-datatable-fragment">
                <thead>
                    <tr>
                        <th>Code Type</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Symbol</th>
                        <th class="text-center">Sequence</th>
                        <th class="text-center">Is Active?</th>
                        <th class="text-right" data-no-sort="Y">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                {{ $x->type }}
                            </td>
                            <td>
                                <a data-reloadurl="{{ route('SA07', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->xcode }}</a>
                            </td>
                            <td>{{ $x->description }}</td>
                            <td class="text-center">{{ $x->symbol }}</td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td class="text-center">
                                @if ($x->is_active)
                                    <i class="ph ph-check-circle text-success"></i>
                                @else
                                    <i class="ph ph-x-circle text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('SA07.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('SA07-datatable-fragment');

            $('.SA07-datatable-fragment').on('click', 'a.detail-dataindex', function(e){
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.SA07-datatable-fragment').on('click', 'button.btn-table-delete', function(e){
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
