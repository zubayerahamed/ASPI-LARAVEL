<form id="mainform" action="{{ $product->id == null ? route('MD12.create') : route('MD12.update', ['id' => $product->id]) }}" method="POST">
    @csrf
    @if ($product->id != null)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $product->id }}">
    @endif


    <div class="row">
        <div class="col-md-9">
            <div class="card card-default">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Name</label>
                                <div class="input-group">
                                    <input type="text"
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



                        <div class="col-md-4">
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

                        

                    </div>

                    


                </div>
            </div>


            




        </div>

        
        <div class="col-md-3">
            <!-- Publish Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Publish</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>     
                        </button>
                    </div>
                </div>
                <div class="card-body">
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
                </div>
            </div>


            <!-- Status Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Status</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>     
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                    <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_featured" name="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                                    <label for="is_featured" class="custom-control-label form-label">Is Featured?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_trending" name="is_trending" {{ $product->is_trending ? 'checked' : '' }}>
                                    <label for="is_trending" class="custom-control-label form-label">Is Trending?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_highlighted" name="is_highlighted" {{ $product->is_highlighted ? 'checked' : '' }}>
                                    <label for="is_highlighted" class="custom-control-label form-label">Is Highlighted?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_for_purchase" name="is_for_purchase" {{ $product->is_for_purchase ? 'checked' : '' }}>
                                    <label for="is_for_purchase" class="custom-control-label form-label">Is For Purchase?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_for_sell" name="is_for_sell" {{ $product->is_for_sell ? 'checked' : '' }}>
                                    <label for="is_for_sell" class="custom-control-label form-label">Is For Sell?</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Category Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Category</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>     
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="type">Primary Category</label>
                                <select class="form-control select2bs4" id="parent_category_id" name="parent_category_id">
                                    <option value="">-- Select Primary Category --</option>
                                    @include('pages.MD12.MD12-category-recursive', [
                                        'categoryTree' => $categoryTree,
                                        'count' => 0,
                                    ])
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="type">Display Categories</label>
                                <select class="form-control select2bs4" id="display_category_id" name="display_category_id[]" multiple="multiple">
                                    <option value="">-- Select Display Categories --</option>
                                    @include('pages.MD12.MD12-category-recursive', [
                                        'categoryTree' => $categoryTree,
                                        'count' => 0,
                                    ])
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="type">Display Categories</label>
                                <select class="duallistbox" multiple="multiple" id="display_category_id" name="display_category_id[]">
                                    @include('pages.MD12.MD12-category-recursive', [
                                        'categoryTree' => $categoryTree,
                                        'count' => 0,
                                    ])
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Brand Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Brand</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>     
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control select2bs4" id="brand" name="brand">
                                    <option value="">-- Select Brand --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>




        </div>

    </div>

</form>

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
