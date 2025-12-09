<div class="col-md-12 border rounded p-3 mt-2 attribute-item-{{ $attribute->id }}">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5>{{ $attribute->name }}</h5>
            <input type="hidden" class="attributes-field" name="attributes[]" value="{{ $attribute->id }}" />
            <div class="form-group mt-3">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input attributes-field" type="checkbox" id="use_in_variation_{{ $attribute->id }}" name="use_in_variation_{{ $attribute->id }}">
                    <label for="use_in_variation_{{ $attribute->id }}" class="custom-control-label form-label">Use for variations?</label>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end gap-2">
            <a href="#" class="text-danger btn-remove-attribute" data-attribute-id="{{ $attribute->id }}" title="Remove"><i class="ph ph-trash"></i></a>
        </div>
    </div>
    <div class="form-group mb-0">
        <select
                class="form-control select2bs4 attributes-field"
                id="terms_{{ $attribute->id }}"
                name="terms_{{ $attribute->id }}[]"
                multiple="multiple"
                data-placeholder="-- Select Attribute Values --"
                required>
            @foreach ($attribute->terms as $term)
                <option value="{{ $term->id }}">{{ $term->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@if ($initscript ?? true)
    <script>
        $(document).ready(function() {
            kit.ui.init();
        });
    </script>
@endif