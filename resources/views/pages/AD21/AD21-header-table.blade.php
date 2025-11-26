@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of Componenets for TAX Rule : <a href="{{ route('AD20', ['id' => $taxRule->id]) }}" class="screen-item" data-screen="AD20?id={{ $taxRule->id }}">{{ $taxRule->taxCategory->name }} - {{ ucfirst($taxRule->transaction_type) }}</a></h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 AD21-datatable-fragment">
                <thead>
                    <tr>
                        <th>TAX Component</th>
                        <th>Rate(%)</th>
                        <th>Calc Type</th>
                        <th class="text-center">Sequence</th>
                        <th class="text-right" data-no-sort="Y">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('AD21', ['id' => $x->id, 'tax_rule_id' => $x->tax_rule_id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->taxComponent->code . ' - ' . $x->taxComponent->name }}</a>
                            </td>
                            <td>
                                {{ $x->rate }}
                            </td>
                            <td>
                                {{ ucfirst($x->calc_type) }}
                            </td>
                            <td class="text-center">{{ $x->seqn }}</td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('AD21.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('AD21-datatable-fragment');

            $('.AD21-datatable-fragment').on('click', 'a.detail-dataindex', function(e){
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.AD21-datatable-fragment').on('click', 'button.btn-table-delete', function(e){
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
