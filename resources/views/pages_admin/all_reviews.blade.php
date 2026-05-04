@extends('admin_layout')
@section('all_reviews')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Quản lý đánh giá</h1>

        </div>
    </div>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Khách hàng</th>
                            <th>Số sao</th>
                            <th>Đánh giá</th>
                            <th>Phản hồi admin</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>#{{ $review->review_id }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $review->product_name }}</div>
                                    <div class="small text-muted">Đơn hàng #{{ $review->order_id }}</div>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $review->user_name }}</div>
                                    <div class="small text-muted">{{ $review->user_email }}</div>
                                </td>
                                <td><span class="badge badge-warning text-dark">{{ $review->rating }}/5 sao</span></td>
                                <td style="min-width: 260px;">{{ $review->review_content }}</td>
                                <td style="min-width: 320px;">
                                    @if($review->admin_reply)
                                        <div class="border rounded p-3 bg-light mb-3">{{ $review->admin_reply }}</div>
                                    @endif
                                    <form method="POST" action="{{ url('/reply-review/' . $review->review_id) }}">
                                        @csrf
                                        <textarea name="admin_reply" rows="3" class="form-control mb-2" placeholder="Nhập phản hồi cho đánh giá này..."></textarea>
                                        <button type="submit" class="btn btn-sm btn-primary">Gửi phản hồi</button>
                                    </form>
                                </td>
                                <td>
                                    <div>{{ $review->created_at }}</div>
                                    @if($review->admin_replied_at)
                                        <div class="small text-muted mt-2">Phản hồi: {{ $review->admin_replied_at }}</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Chưa có đánh giá nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
