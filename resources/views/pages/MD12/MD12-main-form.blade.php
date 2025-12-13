<form id="mainform" action="{{ $product->id == null ? route('MD12.create') : route('MD12.update', ['id' => $product->id]) }}" method="POST">
    @csrf
    @if ($product->id != null)
        @method('PUT')
        <input type="hidden" name="id" id="product_id" value="{{ $product->id }}">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="type">Category</label>
                                <select class="form-control select2bs4" id="category_id" name="category_id">
                                    <option value="">-- Select Category --</option>
                                    @include('pages.MD12.MD12-category-recursive', [
                                        'categoryTree' => $categoryTree,
                                        'count' => 0,
                                    ])
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="brand_id">Brand</label>
                                <select class="form-control select2bs4" id="brand_id" name="brand_id">
                                    <option value="">-- Select Brand --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                    <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <!-- Details -->
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

                    <!-- Thumbnail Upload -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div id="thumbnail-dropzone" class="dropzone"></div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-5">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_item_active" name="is_item_active">
                                    <label for="is_item_active" class="custom-control-label form-label">Is Item Active?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_downloadable" name="is_downloadable" {{ $product->is_downloadable ? 'checked' : '' }}>
                                    <label for="is_downloadable" class="custom-control-label form-label">Is Downloadable?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_listed" name="is_listed">
                                    <label for="is_listed" class="custom-control-label form-label">Display for Sell?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_featured" name="is_featured">
                                    <label for="is_featured" class="custom-control-label form-label">Is Featured?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_trending" name="is_trending">
                                    <label for="is_trending" class="custom-control-label form-label">Is Trending?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_highlighted" name="is_highlighted">
                                    <label for="is_highlighted" class="custom-control-label form-label">Is Highlighted?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_for_purchase" name="is_for_purchase">
                                    <label for="is_for_purchase" class="custom-control-label form-label">Is For Purchase?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_for_sell" name="is_for_sell">
                                    <label for="is_for_sell" class="custom-control-label form-label">Is For Sell?</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Pricing -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5 class="text-primary">Pricing & Discount</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="price">Cost Price</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="cost_price"
                                    name="cost_price"
                                    min="0"
                                    value="{{ $product->cost_price ?? 0 }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="price">MRP Price</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="price"
                                    name="price"
                                    min="0"
                                    value="{{ $product->price ?? 0 }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="tax_category_id">Tax Category</label>
                                <select
                                        class="form-control select2bs4"
                                        id="tax_category_id"
                                        name="tax_category_id"
                                        required>
                                    <option value="">-- Select Tax Category --</option>
                                    @foreach ($taxCategories as $taxCategory)
                                        <option value="{{ $taxCategory->id }}" {{ $product->tax_category_id == $taxCategory->id ? 'selected' : '' }}>{{ $taxCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="selling_price">Selling Price</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="selling_price"
                                    name="selling_price"
                                    min="0"
                                    value="{{ $product->selling_price ?? 0 }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="discount_type">Discount Type</label>
                                        <select
                                                class="form-control select2bs4"
                                                id="discount_type"
                                                name="discount_type"
                                                required>
                                            <option value="">-- Select Discount Type --</option>
                                            @foreach ($discountTypes as $discountType)
                                                <option value="{{ $discountType->xcode }}" {{ $product->discount_type == $discountType->xcode ? 'selected' : '' }}>{{ $discountType->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="selling_price">Discount Amount</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="discount_amt"
                                            name="discount_amt"
                                            min="0"
                                            value="{{ $product->discount_amt ?? 0 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="discount_start_date">Discount Start</label>
                                        <div class="input-group date datetimepicker" id="discount_start_date" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#discount_start_date" />
                                            <div class="input-group-append" data-target="#discount_start_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="discount_end_date">Discount End</label>
                                        <div class="input-group date datetimepicker" id="discount_end_date" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#discount_end_date" />
                                            <div class="input-group-append" data-target="#discount_end_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5 class="text-primary">Inventory</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="sku">SKU</label>
                                <input
                                       type="text"
                                       class="form-control"
                                       id="sku"
                                       name="sku"
                                       value="{{ $product->sku }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="barcode">Barcode (ISBN, UPC, GTIN, etc.)</label>
                                <input
                                       type="text"
                                       class="form-control"
                                       id="barcode"
                                       name="barcode"
                                       value="{{ $product->barcode }}">
                                <small class="text-muted font-italic">Must be unique for each product</small>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="stock_track" name="stock_track">
                                    <label for="stock_track" class="custom-control-label form-label">Manage Stock?</label>
                                </div>
                                <small class="text-muted font-italic">For Stock Management, You must enter opening stock from Inventory</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="backorder_type">Back Order Type</label>
                                <select
                                        class="form-control select2bs4"
                                        id="backorder_type"
                                        name="backorder_type">
                                    <option value="">-- Select Back Order Type --</option>
                                    @foreach ($backOrderTypes as $type)
                                        <option value="{{ $type->xcode }}" {{ $product->backorder_type == $type->xcode ? 'selected' : '' }}>{{ $type->description }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted font-italic">Allow customer checkout when out of stock</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="reorder_point">Stock Reorder Point</label>
                                <input
                                       type="number"
                                       class="form-control"
                                       id="reorder_point"
                                       name="reorder_point"
                                       min="0"
                                       value="{{ $product->reorder_point ?? 0 }}">
                                <small class="text-muted font-italic">Notify when stock is below</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="stock_status">Stock Status</label>
                                <select
                                        class="form-control select2bs4"
                                        id="stock_status"
                                        name="stock_status">
                                    <option value="">-- Select Stock Status --</option>
                                    @foreach ($stockStatus as $status)
                                        <option value="{{ $status->xcode }}" {{ $product->stock_status == $status->xcode ? 'selected' : '' }}>{{ $status->description }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted font-italic">Current stock status of the product</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="max_order_qty">Max Quantity per Order</label>
                                <input
                                       type="number"
                                       class="form-control"
                                       id="max_order_qty"
                                       name="max_order_qty"
                                       min="0"
                                       value="{{ $product->max_order_qty ?? 0 }}">
                                <small class="text-muted font-italic">Limit purchases items per order</small>
                            </div>
                        </div>
                    </div>


                    <!-- Units and Conversions -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5 class="text-primary">Units and Conversions</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="base_unit">Base Unit</label>
                                        <select
                                                class="form-control select2bs4"
                                                id="base_unit"
                                                name="base_unit"
                                                required>
                                            <option value="">-- Select Base Unit --</option>
                                            @foreach ($uoms as $baseUnit)
                                                <option value="{{ $baseUnit->xcode }}">{{ $baseUnit->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="consumption_type">Consumption Type</label>
                                        <select
                                                class="form-control select2bs4"
                                                id="consumption_type"
                                                name="consumption_type"
                                                required>
                                            <option value="">-- Select Consumption Type --</option>
                                            @foreach ($consumptionTypes as $consumptionType)
                                                <option value="{{ $consumptionType->xcode }}">{{ $consumptionType->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="purchase_unit">Purchase Unit</label>
                                        <select
                                                class="form-control select2bs4"
                                                id="purchase_unit"
                                                name="purchase_unit">
                                            <option value="">-- Select Purchase Unit --</option>
                                            @foreach ($uoms as $purchaseUnit)
                                                <option value="{{ $purchaseUnit->xcode }}" {{ $product->purchase_unit == $purchaseUnit->xcode ? 'selected' : '' }}>{{ $purchaseUnit->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="purchase_conversion">Purchase Conversion</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="purchase_conversion"
                                            name="purchase_conversion"
                                            value="{{ $product->purchase_conversion ?? 1 }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="sell_unit">Sell Unit</label>
                                        <select
                                                class="form-control select2bs4"
                                                id="sell_unit"
                                                name="sell_unit">
                                            <option value="">-- Select Sell Unit --</option>
                                            @foreach ($uoms as $sellUnit)
                                                <option value="{{ $sellUnit->xcode }}" {{ $product->sell_unit == $sellUnit->xcode ? 'selected' : '' }}>{{ $sellUnit->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="sell_conversion">Sell Conversion</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="sell_conversion"
                                            name="sell_conversion"
                                            value="{{ $product->sell_conversion ?? 1 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Dimensions & Shipping -->
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h5 class="text-primary">Dimensions & Shipping</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="free_shipping" name="free_shipping">
                                    <label for="free_shipping" class="custom-control-label form-label">Free Shipping?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                                                id="global-attribute"
                                                required>
                                            <option value="-1">-- Add Global Attribute --</option>
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted font-italic">You can save attribute selections for this product.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button data-reloadurl="{{ route('MD12.attribute-selection-form') }}" data-reloadid="attribute-list-container" class="btn btn-default btn-add-global-attribute">Add Global Attribute</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="#" data-submiturl="{{ route('MD12.save-product-attribute') }}" class="btn btn-primary d-flex justify-content-center align-items-center gap-2 btn-save-attributes" title="Save">
                                <i class="ph ph-floppy-disk"></i> 
                                <span>Save Attributes</span>
                            </a>
                        </div>
                    </div>

                    <!-- Attribute List -->
                    <div class="attribute-list-container">
                        @foreach ($productAttributes as $attribute)
                            @include('pages.MD12.MD12-attribute-list', [
                                'attribute' => $attribute,
                                'initscript' => false,
                            ])
                        @endforeach
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


            <!-- Category Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Display Categories</h3>
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


            <!-- Product Collections Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Product Collections</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        @foreach ($productCollections as $pc)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="pc_{{ $pc->id }}" name="product_collections[]">
                                        <label for="pc_{{ $pc->id }}" class="custom-control-label form-label">{{ $pc->name }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        
            <!-- Product Labels Column -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Labels</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-lg fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        @foreach ($productLabels as $pl)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="pl_{{ $pl->id }}" name="product_labels[]">
                                        <label for="pl_{{ $pl->id }}" class="custom-control-label form-label">{{ $pl->name }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>


            <!-- Gallery Images -->
            <div class="card card-dark card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title text-dark">Gallery Images</h3>
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
                                <div class="row">
                                    @if ($product->productItems != null && $product->productItems->first() != null && $product->productItems->first()->thumbnail != null)
                                        <div class="col-md-12 mb-3 thumbnail-image-container">
                                            <img class="border mb-3" src="{{ $product->productItems->first()->thumbnail->originalFile }}" width="100%" />
                                            <a href="#" class="btn btn-default col-12 remove-thumbnail-btn d-flex align-items-center justify-content-center gap-2"><i class="ph ph-trash"></i> <span>Remove Image</span></a>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <input  type="file" 
                                                class="filepond" 
                                                name="thumbnail" 
                                                id="thumbnail"
                                                data-multiple-upload="Y" 
                                                data-max-file-size="2MB" 
                                                data-accepted-file-types="image/*"
                                                data-instant-upload="true" 
                                                data-allow-image-edit="true"
                                                data-allow-image-preview="true"
                                            >
                                    </div>
                                </div>
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

        $("div.dropzone").dropzone({ url: "/file/post" });

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


        $('.btn-add-global-attribute').off('click').on('click', function(e) {
            e.preventDefault();
            let attributeId = $('#global-attribute').val();
            if (attributeId == -1) {
                showMessage("error", 'Please select a valid attribute to add.');
                return;
            }

            // Check attribute already added and in array
            var found = false;
            $('input[name="attributes[]"]').each(function() {
                if ($(this).val() == attributeId) {
                    found = true;
                    return; // break loop
                }
            });
            if (found) {
                showMessage("error", 'Attribute already added.');
                return;
            }

            sectionAppendAjaxReq({
                id: $(this).data('reloadid'),
                url: $(this).data('reloadurl') + '?attribute_id=' + attributeId
            }, () => {
                $('#global-attribute').val(-1).trigger('change');
                $('#global-attribute option[value="' + attributeId + '"]').prop('disabled', true);
            });
        });

        $('.attribute-list-container').on('click', '.btn-remove-attribute', function(e) {
            e.preventDefault();
            let attributeId = $(this).data('attribute-id');
            // Remove attribute item
            $(this).closest('.attribute-item-' + attributeId).remove();
            $('#global-attribute').val(-1).trigger('change');
            $('#global-attribute option[value="' + attributeId + '"]').prop('disabled', false);
        });

        $('.btn-save-attributes').off('click').on('click', function(e) {
            e.preventDefault();

            var submiturl = $(this).data('submiturl');

            let attributesData = {};
            attributesData['product_id'] = $('#product_id').val();
            $('.attributes-field').each(function() {
                let fieldName = $(this).attr('name');
                if ($(this).is(':checkbox')) {
                    attributesData[fieldName] = $(this).is(':checked') ? 1 : 0;
                } else if ($(this).is('select')) {
                    attributesData[fieldName] = $(this).val();
                } else {
                    // Handle same field names (like attributes[])
                    if (fieldName.endsWith('[]')) {
                        if (!(fieldName in attributesData)) {
                            attributesData[fieldName] = [];
                        }
                        attributesData[fieldName].push($(this).val());
                    } else {
                        attributesData[fieldName] = $(this).val();
                    }
                }                
            });

            console.log(attributesData);
            actionPostRequest(submiturl, attributesData);
        });

    })
</script>
