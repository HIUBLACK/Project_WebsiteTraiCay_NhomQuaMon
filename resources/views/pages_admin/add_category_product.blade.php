@extends('admin_layout')
@section('add_category_product')
<h1 class="h3 mb-2 text-gray-800" id="h1_themdanhmuc">Thêm Danh Mục</h1>
<div id="form_add">
    <form action="{{URL::to('/save-category-product')}}" method="POST">
        {{ csrf_field() }}
        <!-- Input -->
        <div class="form-group">
            <label for="category-name">Tên danh mục:</label>
            <input type="text" id="category-name" name="category_product_name" placeholder="Nhập tên danh mục" required>
        </div>


        <!-- Select -->
        <div class="form-group">
            <label for="category-type">Chế độ:</label>
            <select id="category-type" name="category_product_status" required>
                <option value="">-- Chọn loại --</option>
                <option value="0">Ẩn</option>
                <option value="1">Hiện</option>
            </select>
        </div>

        <!-- Button -->
        <div class="form-group">
            <button type="submit" name="add_category_product">Thêm danh mục</button>
        </div>
    </form>
</div>
@endsection
