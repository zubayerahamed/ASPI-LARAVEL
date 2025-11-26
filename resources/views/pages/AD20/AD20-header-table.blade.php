@if (!$detailList->isEmpty())
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">List of TAX Rules</h3>
        </div>

        <div class="table-responsive data-table-responsive">
            <table class="table table-hover table-bordered p-0 m-0 AD20-datatable-fragment">
                <thead>
                    <tr>
                        <th>TAX Category</th>
                        <th class="text-center">Transaction Type</th>
                        <th>Rules Components</th>
                        <th class="text-center">Effective From</th>
                        <th class="text-center">Effective To</th>
                        <th class="text-right" data-no-sort="Y">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $x)
                        <tr>
                            <td>
                                <a data-reloadurl="{{ route('AD20', ['id' => $x->id]) }}" class="detail-dataindex" data-reloadid="main-form-container" href="#">{{ $x->taxCategory->name }}</a>
                            </td>
                            <td class="text-center">
                                @if ($x->transaction_type == 'sales')
                                    <span class="badge badge-success">{{ ucfirst($x->transaction_type) }}</span>    
                                @else
                                    <span class="badge badge-primary">{{ ucfirst($x->transaction_type) }}</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    @foreach ($x->taxRuleComponents as $tc)
                                        <p class="p-0 m-0 text-sm text-muted">
                                            {{ $tc->seqn . ' - ' . $tc->taxComponent->code . ' ' . $tc->rate . '%' . ' ' . ucfirst($tc->calc_type) . ' ' . ($tc->is_recoverable ? '(Recoverable)' : '') }}
                                        </p>
                                    @endforeach
                                </div>
                                <a href="{{ route('AD21', ['tax_rule_id' => $x->id]) }}" class="text-sm screen-item" data-screen="AD21?tax_rule_id={{ $x->id }}">Configure Rule Components</a>
                            </td>
                            <!-- Effective From date with formatting like 26, Nov 2025 -->
                            <td class="text-center">{{ \Carbon\Carbon::parse($x->effective_from)->format('j, M Y') }}</td>
                            <td class="text-center">{{ $x->effective_to != null ? \Carbon\Carbon::parse($x->effective_to)->format('j, M Y') : '' }}</td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button data-url="{{ route('AD20.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
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
            kit.ui.config.initDatatable('AD20-datatable-fragment');

            $('.AD20-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            $('.AD20-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
