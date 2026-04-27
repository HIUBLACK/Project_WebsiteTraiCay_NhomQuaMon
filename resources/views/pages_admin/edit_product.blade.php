@extends('admin_layout')
@section('edit_product')
<h1 class="h3 mb-2 text-gray-800" id="h1_themdanhmuc">Sửa Sản Phẩm</h1>
<div id="form_add">
    <form action="{{URL::to('/update-product/'.$edit_product->product_id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="category-name">Tên sản phẩm:</label>
            <input type="text" id="category-name" value="{{ $edit_product->product_name }}" name="product_name" required>
        </div>

        <div class="form-group">
            <label for="category-name">Giá:</label>
            <input type="text" id="category-name" value="{{ $edit_product->product_price }}" name="product_price" required>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Tồn kho:</label>
            <input type="number" id="stock_quantity" value="{{ $edit_product->stock_quantity ?? 0 }}" name="stock_quantity" min="0" required>
        </div>

        <div class="form-group">
            <label for="product_image">Hình ảnh:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">

            <div class="mt-2">
                <p><strong>Tên ảnh:</strong> <span id="image-name">{{ $edit_product->product_image }}</span></p>
                <img id="preview-image"
                    src="{{ asset('upload/product/' . $edit_product->product_image) }}"
                    alt="Hình sản phẩm"
                    style="max-width: 150px; height: 150px; object-fit: fill;">
            </div>
        </div>

        <div class="form-group">
            <label for="product_desc">Mô tả sản phẩm:</label>
            <textarea name="product_desc">{{ $edit_product->product_desc }}</textarea>
        </div>

        <div class="form-group">
            <label for="product_content">Nội dung sản phẩm:</label>
            <textarea name="product_content">{{ $edit_product->product_content }}</textarea>
        </div>

        <div class="form-group">
            <label for="category-type">Danh mục:</label>
            <select id="category-type" name="category_product" required class="form-control">
                <option value="">-- Chọn loại --</option>
                @foreach($all_category as $cate)
                    <option value="{{ $cate->category_id }}"
                        {{ $cate->category_id == $edit_product->category_id_joined ? 'selected' : '' }}>
                        {{ $cate->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category-type">Chế độ:</label>
            <select id="category-type" name="product_status" required>
                <option value="">-- Chọn loại --</option>
                <option value="0" {{ $edit_product->product_status == 0 ? 'selected' : '' }}>Ẩn</option>
                <option value="1" {{ $edit_product->product_status == 1 ? 'selected' : '' }}>Hiện</option>
            </select>
            <small class="form-text text-muted">
                Khi tồn kho bằng 0, hệ thống sẽ tự động chuyển sản phẩm sang trạng thái ẩn.
            </small>
        </div>

        <div class="form-group">
            <button type="submit" name="add_category_product">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>
@endsection
