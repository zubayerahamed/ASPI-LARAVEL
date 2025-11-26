<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $taxRule->id == null ? route('AD20.create') : route('AD20.update', ['id' => $taxRule->id]) }}" method="POST">
            @csrf
            @if ($taxRule->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $taxRule->id }}">
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="tax_category_id">TAX Category</label>
                        <select class="form-control select2bs4" id="tax_category_id" name="tax_category_id" required>
                            <option value="">-- Select TAX Category --</option>
                            @foreach ($taxCategories as $tc)
                                <option value="{{ $tc->id }}" {{ $taxRule->tax_category_id == $tc->id ? 'selected' : '' }}>{{ $tc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="transaction_type">Transaction Type</label>
                        <select class="form-control select2bs4" id="transaction_type" name="transaction_type" required>
                            <option value="">-- Select Transaction Type --</option>
                            <option value="sales" {{ $taxRule->transaction_type == 'sales' ? 'selected' : '' }}>Sales</option>
                            <option value="purchase" {{ $taxRule->transaction_type == 'purchase' ? 'selected' : '' }}>Purchase</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="effective_from">Effective From</label>
                        <div class="input-group date datepicker" id="effective_from" data-target-input="nearest">
                            <input type="text" name="effective_from" class="form-control datetimepicker-input" data-target="#effective_from" value="{{ $taxRule->effective_from }}" required>
                            <div class="input-group-append" data-target="#effective_from" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="effective_to">Effective To</label>
                        <div class="input-group date datepicker" id="effective_to" data-target-input="nearest">
                            <input type="text" name="effective_to" class="form-control datetimepicker-input" data-target="#effective_to" value="{{ $taxRule->effective_to }}" >
                            <div class="input-group-append" data-target="#effective_to" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="notes">Note</label>
                        <textarea name="notes" id="notes" class="form-control" rows="5">{{ $taxRule->notes }}</textarea>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD20', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD20.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($taxRule->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD20.delete', ['id' => $taxRule->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
                            <i class="ph ph-trash"></i> <span>Delete</span>
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Update</span>
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        kit.ui.init();

        $('.btn-reset').off('click').on('click', function(e) {
            e.preventDefault();

            sectionReloadAjaxReq({
                id: $(this).data('reloadid'),
                url: $(this).data('reloadurl')
            });

            sectionReloadAjaxReq({
                id: $(this).data('detailreloadid'),
                url: $(this).data('detailreloadurl')
            });
        });

        $('.btn-submit').off('click').on('click', function(e) {
            e.preventDefault();
            submitMainForm();
        });

        $('.btn-delete').off('click').on('click', function(e) {
            e.preventDefault();
            sweetAlertConfirm(() => {
                deleteRequest($(this).data('url'));
            });
        });
    })
</script>