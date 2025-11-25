<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $productOption->id == null ? route('MD07.create') : route('MD07.update', ['id' => $productOption->id]) }}" method="POST">
            @csrf
            @if ($productOption->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $productOption->id }}">
            @endif

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name</label>
                        <div class="input-group">
                            <input  type="text" 
                                    class="form-control searchsuggest2" 
                                    name="name" 
                                    value="{{ $productOption->name }}"
                                    required>
                            <div class="input-group-append btn-search"
                                data-reloadurl="{{ route('search.index', ['fragmentcode' => 'LMD07', 'suffix' => 0]) . '?hint=' }}"
                                data-reloadid="search-suggest-results-container"
                                data-fieldid="name"
                                data-mainscreen=true
                                data-mainreloadurl="{{ route('MD07', ['id' => '']) }}"
                                data-mainreloadid="main-form-container"
                                data-detailreloadurl="{{ route('MD07.detail-table', ['id' => 'RESET', 'product_option_id' => '']) }}"
                                data-detailreloadid="detail-table-container">
                                <div class="input-group-text">
                                    <i class="ph ph-magnifying-glass"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="type">Type</label>
                        <select class="form-control select2bs4" id="type" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="dropdown" {{ $productOption->type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                            <option value="radio" {{ $productOption->type == 'radio' ? 'selected' : '' }}>Radio</option>
                            <option value="checkbox" {{ $productOption->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_required" name="is_required" {{ $productOption->is_required ? 'checked' : '' }}>
                            <label for="is_required" class="custom-control-label form-label">Is Required?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD07', ['id' => 'RESET']) }}"
                            data-detailreloadid="detail-table-container"
                            data-detailreloadurl="{{ route('MD07.detail-table', ['id' => 'RESET', 'product_option_id' => 'RESET']) }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($productOption->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD07.delete', ['id' => $productOption->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
