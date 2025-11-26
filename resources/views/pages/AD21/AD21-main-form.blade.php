<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $taxRuleComponent->id == null ? route('AD21.create') : route('AD21.update', ['id' => $taxRuleComponent->id]) }}" method="POST">
            @csrf
            @if ($taxRuleComponent->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $taxRuleComponent->id }}">
            @endif

            <input type="hidden" name="tax_rule_id" value="{{ $taxRuleComponent->tax_rule_id }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="tax_component_id">TAX Component</label>
                        <select class="form-control select2bs4" id="tax_component_id" name="tax_component_id" required>
                            <option value="">-- Select TAX Component --</option>
                            @foreach ($taxComponents as $tc)
                                <option value="{{ $tc->id }}" {{ $taxRuleComponent->tax_component_id == $tc->id ? 'selected' : '' }}>{{ $tc->code . ' - ' . $tc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="rate">Rate(%)</label>
                        <input type="number" class="form-control" id="rate" name="rate" value="{{ $taxRuleComponent->rate }}" min="0" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="calc_type">Calc Type</label>
                        <select class="form-control select2bs4" id="calc_type" name="calc_type" required>
                            <option value="">-- Select Calc Type --</option>
                            <option value="exclusive" {{ $taxRuleComponent->calc_type == 'exclusive' ? 'selected' : '' }}>Exclusive</option>
                            <option value="inclusive" {{ $taxRuleComponent->calc_type == 'inclusive' ? 'selected' : '' }}>Inclusive</option>
                            <option value="compound" {{ $taxRuleComponent->calc_type == 'compound' ? 'selected' : '' }}>Compound</option>
                            <option value="exempt" {{ $taxRuleComponent->calc_type == 'exempt' ? 'selected' : '' }}>Exempt</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $taxRuleComponent->seqn }}" min="0" required>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD21', ['id' => 'RESET', 'tax_rule_id' => $taxRuleComponent->tax_rule_id]) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD21.header-table', ['tax_rule_id' => $taxRuleComponent->tax_rule_id]) }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($taxRuleComponent->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD21.delete', ['id' => $taxRuleComponent->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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

        $('.remove-thumbnail-btn').off('click').on('click', function(e) {
            e.preventDefault();
            $('.thumbnail-image-container').remove();
            $('input[name="remove_thumbnail"]').val('YES');
        });
    })
</script>
