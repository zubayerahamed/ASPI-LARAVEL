<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $business->id == null ? route('SA10.create') : route('SA10.update', ['id' => $business->id]) }}" method="POST">
            @csrf
            @if ($business->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $business->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="business_category_id">Business Category</label>
                        <select class="form-control select2bs4" id="business_category_id" name="business_category_id" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($businessCategories as $bc)
                                <option value="{{ $bc->id }}" {{ $business->business_category_id == $bc->id ? 'selected' : '' }}>{{ $bc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Business name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $business->name }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="email">Business email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $business->email }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="mobile">Business Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $business->mobile }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="country">Business Country</label>
                        <select class="form-control select2bs4" id="country" name="country" required>
                            <option value="">-- Select Country --</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country['code'] }}" {{ $business->country == $country['code'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="currency">Business Currency</label>
                        <select class="form-control select2bs4" id="currency" name="currency" required>
                            <option value="">-- Select Currency --</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency['code'] }}" {{ $business->currency == $currency['code'] ? 'selected' : '' }}>{{ $currency['name'] }} ({{ $currency['symbol'] }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label d-block" for="is_active">Is Active?</label>
                        <input type="checkbox" id="is_active" name="is_active" {{ $business->is_active ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <h4 class="m-0">Select Services</h4>
                    <span class="text-muted">Atleast one service must be selected</span>
                    <hr>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label d-block" for="is_inhouse">Is Inhouse?</label>
                        <input type="checkbox" id="is_inhouse" name="is_inhouse" {{ $business->is_inhouse ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label d-block" for="is_pickup">Is Pickup?</label>
                        <input type="checkbox" id="is_pickup" name="is_pickup" {{ $business->is_pickup ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label d-block" for="is_delivery">Is Delivery?</label>
                        <input type="checkbox" id="is_delivery" name="is_delivery" {{ $business->is_delivery ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button 
                        data-reloadid="main-form-container" 
                        data-reloadurl="{{ route('SA10', ['id' => 'RESET']) }}" 
                        data-detailreloadid="header-table-container" 
                        data-detailreloadurl="{{ route('SA10.header-table') }}"
                        type="reset" 
                        class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($business->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('SA10.delete', ['id' => $business->id]) }}" type="button"  class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
            if (!confirm("Are you sure, to delete this?")) {
                return;
            }
            deleteRequest($(this).data('url'));
        });
    })
</script>
