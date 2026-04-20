@extends('admin_layout')
@section('add_product')
<style>
    #form_add {
    max-width: 100%;
    background: #fff;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #eee;
}

/* Title */
#h1_themdanhmuc {
    font-weight: 600;
    margin-bottom: 20px;
}

/* Form group */
#form_add .form-group {
    margin-bottom: 18px;
}

/* Label */
#form_add label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
    color: #333;
}

/* Input + Select + Textarea */
#form_add input,
#form_add select,
#form_add textarea {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    transition: all 0.2s ease;
}

/* Focus effect giống Shopee */
#form_add input:focus,
#form_add select:focus,
#form_add textarea:focus {
    border-color: #ee4d2d;
    box-shadow: 0 0 0 2px rgba(238,77,45,0.1);
    outline: none;
}

/* Textarea */
#form_add textarea {
    min-height: 100px;
    resize: vertical;
}

/* File input */
#form_add input[type="file"] {
    padding: 6px;
    background: #fafafa;
}

/* Button Shopee style */
#form_add button {
    width: 100%;
    padding: 12px;
    background: #ee4d2d;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    transition: 0.2s;
}

/* Hover */
#form_add button:hover {
    background: #d73211;
}

/* Nhẹ nhàng hơn */
body {
    background: #f5f5f5;
}
</style>
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
