<div class="form-group">
    <label class="form-label" for="type">Product Behaviour</label>
    <select class="form-control select2bs4" id="product_behaviour" name="product_behaviour" required>
        <option value="">-- Select Product Behaviour --</option>
        @foreach (productBehaviours($productType) as $p)
            <option value="{{ $p->xcode }}">{{ $p->description }}</option>
        @endforeach
    </select>
</div>
@if ($initscript ?? true)
    <script>
        $(document).ready(function() {
            kit.ui.init();
        });
    </script>
@endif
