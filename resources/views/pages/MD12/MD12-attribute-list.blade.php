<div class="col-md-12 border rounded p-3 mt-2">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5>Attribute Name</h5>
            <div class="form-group mt-3">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="is_for_variation" name="is_for_variation">
                    <label for="is_for_variation" class="custom-control-label form-label">Use for variations?</label>
                </div>
            </div>
        </div>
        <a href="#" class="text-danger"><i class="ph ph-trash"></i></a>
    </div>
    <div class="form-group mb-0">
        <select
                class="form-control select2bs4"
                id="attribute_value_id"
                name="attribute_value_id[]"
                multiple="multiple"
                data-placeholder="-- Select Attribute Values --"
                required>
            @foreach ($selectedAttributes as $pType)
                <option value="{{ $pType->xcode }}" {{ $product->product_type == $pType->xcode ? 'selected' : '' }}>{{ $pType->description }}</option>
            @endforeach
        </select>
    </div>
</div>
