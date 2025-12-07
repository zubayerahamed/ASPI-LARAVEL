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
                                <label class="form-label" for="type">Product Type</label>
                                <select
                                        class="form-control select2bs4"
                                        data-reloadid="product-behaviour-dropdown-container"
                                        data-reloadurl="{{ route('MD12.product-behaviour-dropdown') }}"
                                        id="product_type"
                                        name="product_type"
                                        required>
                                    <option value="">-- Select Product Type --</option>
                                    @foreach ($productTypes as $pType)
                                        <option value="{{ $pType->xcode }}" {{ $product->product_type == $pType->xcode ? 'selected' : '' }}>{{ $pType->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 product-behaviour-dropdown-container">
                            @include('pages.MD12.MD12-product-behaviour-dropdown', [
                                'productType' => $product->product_type,
                                'initscript' => false,
                            ])
                        </div>




                    </div>




                </div>
            </div>


            <!-- Attribute -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Details</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Identification -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5>Identification</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="sku">SKU</label>
                                <input
                                       type="text"
                                       class="form-control"
                                       id="sku"
                                       name="sku"
                                       value="{{ $product->sku }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="barcode">Barcode</label>
                                <input
                                       type="text"
                                       class="form-control"
                                       id="barcode"
                                       name="barcode"
                                       value="{{ $product->barcode }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="manufacturer_sku">Manufacturer SKU</label>
                                <input
                                       type="text"
                                       class="form-control"
                                       id="manufacturer_sku"
                                       name="manufacturer_sku"
                                       value="{{ $product->manufacturer_sku }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="country_of_origin">Country of Origin</label>
                                <select
                                        class="form-control select2bs4"
                                        id="country_of_origin"
                                        name="country_of_origin"
                                        required>
                                    <option value="">-- Select Country of Origin --</option>
                                    @foreach ($countriesOfOrigins as $countryOfOrigin)
                                        <option value="{{ $countryOfOrigin->xcode }}" {{ $product->country_of_origin == $countryOfOrigin->xcode ? 'selected' : '' }}>{{ $countryOfOrigin->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Units and Conversions -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5>Units and Conversions</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="base_unit">Base Unit</label>
                                <select
                                        class="form-control select2bs4"
                                        id="base_unit"
                                        name="base_unit"
                                        required>
                                    <option value="">-- Select Base Unit --</option>
                                    @foreach ($uoms as $baseUnit)
                                        <option value="{{ $baseUnit->xcode }}" {{ $product->base_unit == $baseUnit->xcode ? 'selected' : '' }}>{{ $baseUnit->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="purchase_unit">Purchase Unit</label>
                                <select
                                        class="form-control select2bs4"
                                        id="purchase_unit"
                                        name="purchase_unit"
                                        required>
                                    <option value="">-- Select Purchase Unit --</option>
                                    @foreach ($uoms as $purchaseUnit)
                                        <option value="{{ $purchaseUnit->xcode }}" {{ $product->purchase_unit == $purchaseUnit->xcode ? 'selected' : '' }}>{{ $purchaseUnit->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="purchase_conversion">Purchase Conversion</label>
                                <input
                                       type="number"
                                       class="form-control"
                                       id="purchase_conversion"
                                       name="purchase_conversion"
                                       value="{{ $product->purchase_conversion ?? 1 }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="sell_unit">Sell Unit</label>
                                <select
                                        class="form-control select2bs4"
                                        id="sell_unit"
                                        name="sell_unit"
                                        required>
                                    <option value="">-- Select Sell Unit --</option>
                                    @foreach ($uoms as $sellUnit)
                                        <option value="{{ $sellUnit->xcode }}" {{ $product->sell_unit == $sellUnit->xcode ? 'selected' : '' }}>{{ $sellUnit->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="sell_conversion">Sell Conversion</label>
                                <input
                                       type="number"
                                       class="form-control"
                                       id="sell_conversion"
                                       name="sell_conversion"
                                       value="{{ $product->sell_conversion ?? 1 }}"
                                       required>
                            </div>
                        </div>
                    </div>


                    <!-- Dimensions & Shipping -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5>Dimensions & Shipping</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="weight_unit">Weight Unit</label>
                                <select
                                        class="form-control select2bs4"
                                        id="weight_unit"
                                        name="weight_unit">
                                    <option value="">-- Select Weight Unit --</option>
                                    @foreach ($uoms as $weightUnit)
                                        <option value="{{ $weightUnit->xcode }}" {{ $product->weight_unit == $weightUnit->xcode ? 'selected' : '' }}>{{ $weightUnit->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="weight">Weight</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="weight"
                                            name="weight"
                                            value="{{ $product->weight ?? 0 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="dimension_unit">Dimension Unit</label>
                                <select
                                        class="form-control select2bs4"
                                        id="dimension_unit"
                                        name="dimension_unit">
                                    <option value="">-- Select Dimension Unit --</option>
                                    @foreach ($uoms as $dimensionUnit)
                                        <option value="{{ $dimensionUnit->xcode }}" {{ $product->dimension_unit == $dimensionUnit->xcode ? 'selected' : '' }}>{{ $dimensionUnit->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="length">Length</label>
                                        <input
                                               type="number"
                                               class="form-control"
                                               id="length"
                                               name="length"
                                               value="{{ $product->length ?? 0 }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="width">Width</label>
                                        <input
                                               type="number"
                                               class="form-control"
                                               id="width"
                                               name="width"
                                               value="{{ $product->width ?? 0 }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="height">Height</label>
                                        <input
                                               type="number"
                                               class="form-control"
                                               id="height"
                                               name="height"
                                               value="{{ $product->height ?? 0 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="volumetric_weight">Volumetric Weight</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="volumetric_weight"
                                        name="volumetric_weight"
                                        value="{{ $product->volumetric_weight ?? 0 }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="shipping_charge">Shipping Charge</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        id="shipping_charge"
                                        name="shipping_charge"
                                        value="{{ $product->shipping_charge ?? 0 }}">
                            </div>
                        </div>
                    </div>





                </div>
            </div>


            <!-- Attribute -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Attributes</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select
                                                class="form-control select2bs4"
                                                id="attribute_id"
                                                name="attribute_id"
                                                required>
                                            <option value="">-- Add Global Attribute --</option>
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-default">Add Global Attribute</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            {{-- <button class="btn btn-default">Create & Add new attribute</button> --}}
                        </div>
                    </div>

                    <!-- Attribute List -->
                    <div class="attribute-list-container">
                        @include('pages.MD12.MD12-attribute-list', [
                            'selectedAttributes' => $productTypes,
                        ])
                    </div>


                </div>
            </div>


            <!-- Description Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Description</h3>
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
                                <textarea class="summernote" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Short Description Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Short Description</h3>
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
                                <textarea class="summernote" id="short_description" name="short_description" rows="4" data-height="100">{{ $product->short_description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>






        <div class="col-md-3">
            <!-- Publish Column -->
            <div class="card">
                
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
                                    <input class="custom-control-input" type="checkbox" id="is_listed" name="is_listed" {{ $product->is_listed ? 'checked' : '' }}>
                                    <label for="is_listed" class="custom-control-label form-label">Display for Sell?</label>
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
                                <select class="form-control select2bs4" id="brand_id" name="brand_id">
                                    <option value="">-- Select Brand --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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

        $('#product_type').on('change', function(e) {
            console.log($(this).data('reloadid'));

            sectionReloadAjaxReq({
                id: $(this).data('reloadid'),
                url: $(this).data('reloadurl') + '?product_type=' + $(this).val()
            });
        });
    })
</script>
