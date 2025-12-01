<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $product->id == null ? route('MD12.create') : route('MD12.update', ['id' => $product->id]) }}" method="POST">
            @csrf
            @if ($product->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
            @endif

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name</label>
                        <div class="input-group">
                            <input  type="text" 
                                    class="form-control searchsuggest2" 
                                    name="name" 
                                    value="{{ $product->name }}"
                                    placeholder="Create or Open Existing..."
                                    required>
                            <div class="input-group-append btn-search"
                                data-reloadurl="{{ route('search.index', ['fragmentcode' => 'LMD12', 'suffix' => 0]) . '?hint=' }}"
                                data-reloadid="search-suggest-results-container"
                                data-fieldid="name"
                                data-mainscreen=true
                                data-mainreloadurl="{{ route('MD12', ['id' => '']) }}"
                                data-mainreloadid="main-form-container"
                                data-detailreloadurl="{{ route('MD12.detail-table', ['id' => 'RESET', 'product_id' => '']) }}"
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
                        <label class="form-label" for="type">Item Group</label>
                        <select class="form-control select2bs4" id="item_group" name="item_group" required>
                            <option value="">-- Select Item Group --</option>
                            @foreach ($itemGroups as $ig)
                                <option value="{{ $ig->xcode }}" {{ $product->item_group == $ig->xcode ? 'selected' : '' }}>{{ $ig->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD12', ['id' => 'RESET']) }}"
                            data-detailreloadid="detail-table-container"
                            data-detailreloadurl="{{ route('MD12.detail-table', ['id' => 'RESET', 'product_option_id' => 'RESET']) }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($product->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD12.delete', ['id' => $product->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
