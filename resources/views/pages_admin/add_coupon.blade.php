@extends('admin_layout')
@section('add_coupon')
<style>
.coupon-container {
    position: relative;
    width: 650px;
    margin-left: 40px;
}

/* ===== CHUNG CHO 3 BẢNG ===== */
#user-table,
#rank-table,
#product-table {
    position: absolute;
    left: calc(100% + 20px);

    width: calc(87vw - 720px);
    height: 33%; /* chia đều */

    overflow-y: auto;

    background: #fff;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

/* ===== CHIA ĐỀU THEO CHIỀU CAO ===== */
#user-table {
    top: 0%;
}

#rank-table {
    top: 33.33%;
}

#product-table {
    top: 66.66%;
}

/* TABLE */
.coupon-container table {
    width: 100%;
    border-collapse: collapse;
}

.coupon-container th {
    background: #f5f5f5;
    position: sticky;
    top: 0;
}

.coupon-container th,
.coupon-container td {
    padding: 8px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

/* INPUT */
.coupon-container input,
.coupon-container select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

/* BUTTON */
.btn-submit {
    background: linear-gradient(45deg, #4CAF50, #2ecc71);
    border: none;
    color: white;
    padding: 10px;
    border-radius: 8px;
    font-weight: bold;
}

/* tránh tràn */
body {
    overflow-x: auto;
}

</style>
<div class="coupon-container">

    <div class="coupon-title">🎁 Thêm mã giảm giá</div>

    <form class="coupon-form" action="{{URL::to('/save-coupon')}}" method="POST">
    @csrf

    <label>Mã giảm giá</label>
    <input type="text" name="coupon_code" placeholder="VD: SALE50">

    <label>Loại giảm</label>
    <select name="coupon_type" id="coupon_type">
        <option value="1">Giảm %</option>
        <option value="2">Giảm tiền</option>
    </select>

    <label>Giá trị</label>
    <input type="number" name="coupon_value" id="coupon_value" placeholder="VD: 20 hoặc 50000">

    <!-- Áp dụng cho khách hàng -->
    <label>Áp dụng cho khách hàng</label>
    <select name="customer_scope" id="customer_scope">
    <option value="all">Toàn bộ khách hàng</option>
    <option value="select">Chọn khách hàng cụ thể</option>
</select>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerScope = document.getElementById('customer_scope');
    const userTable = document.getElementById('user-table');
    customerScope.addEventListener('change', function() {
        if (this.value === 'select') {
            userTable.style.display = '';
        } else {
            userTable.style.display = 'none';
        }
    });
    // Hiển thị đúng khi reload
    if (customerScope.value === 'select') userTable.style.display = '';
});
</script>

    </select>
    <div id="user-table" style="display:none; margin-bottom:10px;">
        <table class="user-table">
             <div class="coupon-title">🎁 Danh sách khách hàng</div>
            <tr>
                <th><input type="checkbox" id="check_all_user"></th>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
            </tr>
            <!-- @foreach($users as $user) -->
            <!-- <tr>
                <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr> -->
            <!-- @endforeach -->
            @foreach($users as $user)
<tr>
    <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
</tr>
@endforeach
        </table>
    </div>

    <!-- Áp dụng theo rank -->
    <label>Áp dụng theo xếp hạng</label>
    <select name="rank_scope_select" id="rank_scope_select">
        <option value="all">Toàn bộ rank</option>
        <option value="select">Chọn rank cụ thể</option>
    </select>
    <div id="rank-table" style="display:none; margin-bottom:10px;">
        <table class="rank-table">
             <div class="coupon-title">🎁 Danh sách xếp hạng</div>
            <tr>
                <th><input type="checkbox" id="check_all_rank"></th>
                <th>Rank</th>
            </tr>
            <tr><td><input type="checkbox" name="rank_scope[]" value="Thường"></td><td>Thường</td></tr>
            <tr><td><input type="checkbox" name="rank_scope[]" value="Bạc"></td><td>Bạc</td></tr>
            <tr><td><input type="checkbox" name="rank_scope[]" value="Vàng"></td><td>Vàng</td></tr>
            <tr><td><input type="checkbox" name="rank_scope[]" value="Kim cương"></td><td>Kim cương</td></tr>
        </table>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const rankScope = document.getElementById('rank_scope_select');
        const rankTable = document.getElementById('rank-table');
        rankScope.addEventListener('change', function() {
            if (this.value === 'select') {
                rankTable.style.display = '';
            } else {
                rankTable.style.display = 'none';
            }
        });
        if (rankScope.value === 'select') rankTable.style.display = '';
        // Check all ranks
        document.getElementById('check_all_rank').addEventListener('change', function() {
            const checkboxes = rankTable.querySelectorAll('input[type=checkbox][name="rank_scope[]"]');
            for (const cb of checkboxes) cb.checked = this.checked;
        });
    });
    </script>
    <br/>

    <!-- Điều kiện đơn hàng -->
    <label>Điều kiện đơn hàng</label>
    <div style="margin-bottom:10px;">
        <input type="number" name="min_order_value" placeholder="Giá trị tối thiểu (VND)">
        <input type="number" name="min_order_quantity" placeholder="Số lượng sản phẩm tối thiểu">
    </div>

    <label>Phạm vi áp dụng</label>
    <select name="coupon_scope" id="coupon_scope">
        <option value="1">Toàn bộ sản phẩm</option>
        <option value="2">Chọn sản phẩm</option>
    </select>

    <!-- Chọn sản phẩm cụ thể -->
    <div id="product-table" style="display:none;">
        <table class="product-table">
             <div class="coupon-title">🎁 Danh sách sản phẩm</div>
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Sau giảm</th>
            </tr>
            @foreach($products as $pro)
            <tr>
                <td>
                    <input type="checkbox" name="product_ids[]" value="{{ $pro->product_id }}">
                </td>
                <td>{{ $pro->product_id }}</td>
                <td>{{ $pro->product_name }}</td>
                <td>{{ number_format($pro->product_price) }}đ</td>
                <td class="preview-price" data-price="{{ $pro->product_price }}">0</td>
            </tr>
            @endforeach
        </table>
    </div>

    <label>Số lần dùng</label>
    <input type="number" name="coupon_usage_limit" placeholder="VD: 100">

    <label>Mỗi khách được dùng</label>
    <select name="coupon_user_usage_mode">
        <option value="0">Nhiều lần</option>
        <option value="1">1 lần</option>
    </select>

    <label>Ngày hết hạn</label>
    <input type="date" name="coupon_expiry">

    <button type="submit" class="btn-submit">Tạo mã</button>

</form>

<script>
// Hiện bảng chọn user khi chọn "Chọn khách hàng cụ thể"
document.getElementById('customer_scope').addEventListener('change', function() {
    document.getElementById('user-table').style.display = this.value === 'select' ? '' : 'none';
});
// Hiện bảng chọn sản phẩm khi chọn "Chọn sản phẩm"
document.getElementById('coupon_scope').addEventListener('change', function() {
    document.getElementById('product-table').style.display = this.value == 2 ? '' : 'none';
});
</script>

</div>

@endsection
