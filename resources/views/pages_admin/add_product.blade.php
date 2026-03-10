@extends('admin_layout')
@section('add_product')
<h1 class="h3 mb-2 text-gray-800" id="h1_themdanhmuc">Thêm Sản Phẩm</h1>
<div id="form_add">
    <form action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <!-- Input -->
        <div class="form-group">
            <label for="category-name">Tên sản phẩm:</label>
            <input type="text" id="category-name" name="product_name" placeholder="Nhập tên sản phẩm" required>
        </div>
        <div class="form-group">
            <label for="category-name">Giá:</label>
            <input type="text" id="category-name" name="product_price" placeholder="Giá" required>
        </div>
        <div class="form-group">
            <label for="category-name">Hình ảnh:</label>
            <input type="file" id="category-name" name="product_image" placeholder="thêm hình ảnh" required>
        </div>
        <div class="form-group">
            <label for="category-name">Mô tả sản phẩm:</label>
            <textarea placeholder="Mô tả sản phẩm" name="product_desc"> </textarea>
        </div>
        <div class="form-group">
            <label for="category-name">Nội dung sản phẩm:</label>
            <textarea placeholder="Mô tả sản phẩm" name="product_content"> </textarea>
        </div>
        <div class="form-group">
            <label for="category-type">Danh mục:</label>
            <select id="category-type" name="category_product" required>
                <option value="">-- Chọn loại --</option>
                @foreach ($all_oder as $key => $oder )
                <option value="{{$oder ->category_id}}">{{$oder ->category_name}}</option>
                @endforeach
            </select>
        </div>

        <!-- Select -->
        {{-- <div class="form-group">
            <label for="category-type">Chế độ:</label>
            <select id="category-type" name="category_product_status" required>
                <option value="">-- Chọn loại --</option>
                <option value="0">Ẩn</option>
                <option value="1">Hiện</option>
            </select>
        </div> --}}

        <!-- Button -->
        <div class="form-group">
            <button type="submit" name="add_category_product">Thêm sản phẩm</button>
        </div>
    </form>
</div>
@endsection
