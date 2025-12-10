<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $productCollection->id == null ? route('MD14.create') : route('MD14.update', ['id' => $productCollection->id]) }}" method="POST">
            @csrf
            @if ($productCollection->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $productCollection->id }}">
            @endif

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name</label>
                        <div class="input-group">
                            <input  type="text" 
                                    class="form-control searchsuggest2" 
                                    name="name" 
                                    value="{{ $productCollection->name }}"
                                    placeholder="Create or Open Existing..."
                                    required>
                            <div class="input-group-append btn-search"
                                data-reloadurl="{{ route('search.index', ['fragmentcode' => 'LMD14', 'suffix' => 0]) . '?hint=' }}"
                                data-reloadid="search-suggest-results-container"
                                data-fieldid="name"
                                data-mainscreen=true
                                data-mainreloadurl="{{ route('MD14', ['id' => '']) }}"
                                data-mainreloadid="main-form-container"
                                data-detailreloadurl="{{ route('MD14.detail-table', ['id' => 'RESET', 'product_collection_id' => '']) }}"
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
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="1">{{ $productCollection->description }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-12"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_featured" name="is_featured" {{ $productCollection->is_featured ? 'checked' : '' }}>
                            <label for="is_featured" class="custom-control-label form-label">Is Featured?</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $productCollection->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD14', ['id' => 'RESET']) }}"
                            data-detailreloadid="detail-table-container"
                            data-detailreloadurl="{{ route('MD14.detail-table', ['id' => 'RESET', 'product_collection_id' => 'RESET']) }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($productCollection->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD14.delete', ['id' => $productCollection->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
