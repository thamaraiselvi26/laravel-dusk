<div class="mb-3">
    <label for="name" class="form-label">Product Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="image" class="form-label">Product Image</label>
    <input type="file" name="image" id="image" class="form-control">
    @if(isset($product->imageUrl))
        <img src="{{ $product->imageUrl }}" alt="{{ $product->name }}" class="img-thumbnail mt-2" style="width: 100px;">
    @endif
</div>

<button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
