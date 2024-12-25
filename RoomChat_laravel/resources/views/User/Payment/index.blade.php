@extends('User.Layout.layout')
@section('main')
<div class="premium-container">
    <div class="premium-card">
        <h1 class="premium-title">Nâng cấp lên Premium</h1>
        <p class="premium-description">Khám phá sức mạnh không giới hạn! </p>
        <ul class="premium-benefits">
            <li>Tạo nhóm không giới hạn</li>
            <li>Trải nghiệm tất cả tính năng cao cấp</li>
        </ul>
        <div class="premium-price-box">
            <h2 class="premium-price">Chỉ 299,000 VNĐ</h2>
            <p class="premium-note">Đăng ký ngay để trải nghiệm tối ưu nhất!</p>
        </div>
        <form action="{{ route('user.payment.create') }}" method="POST" class="premium-form">
            @csrf
            <input type="text" name="userid" hidden value="{{ Auth::id() }}" />
            <input type="text" name="amount" hidden value="299000" />
            <button type="submit" class="btn btn-premium">Thanh toán ngay qua VNPay</button>
        </form>
        <div class="premium-logo">
            <img src="/template/assets/img/vnpay.png" alt="VNPay Logo">
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Container chính */
    .premium-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
        padding: 20px;
    }

    /* Thẻ nội dung chính */
    .premium-card {
        background: #ffffff;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        width: 600px;
        text-align: center;
        padding: 30px;
    }

    /* Tiêu đề */
    .premium-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #0056b3;
        margin-bottom: 15px;
    }

    /* Mô tả */
    .premium-description {
        font-size: 1.2rem;
        color: #555555;
        margin-bottom: 20px;
    }

    /* Danh sách lợi ích */
    .premium-benefits {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .premium-benefits li {
        font-size: 1rem;
        color: #333333;
        margin: 5px 0;
    }

    /* Hộp giá */
    .premium-price-box {
        background: #f9f9f9;
        border: 1px solid #dddddd;
        border-radius: 10px;
        padding: 15px;
        margin: 20px 0;
    }

    .premium-price {
        font-size: 1.8rem;
        font-weight: bold;
        color: #28a745;
    }

    .premium-note {
        font-size: 0.9rem;
        color: #666666;
    }

    /* Nút thanh toán */
    .btn-premium {
        position: relative;
        background: linear-gradient(90deg, #ff7eb3, #ff758c);
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: bold;
        text-transform: uppercase;
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(255, 94, 108, 0.5);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-premium:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(255, 94, 108, 0.7);
    }

    /* Hiệu ứng hạt bùng nổ */
    .btn-premium::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0));
        opacity: 0;
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        z-index: 1;
        transition: transform 0.5s, opacity 0.5s;
        pointer-events: none;
    }

    .btn-premium:hover::after {
        transform: translate(-50%, -50%) scale(2);
        opacity: 1;
    }

    /* Hiệu ứng hạt phân tán */
    .btn-premium span {
        position: relative;
        z-index: 2;
    }

    .btn-premium::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        box-shadow:
            0 0 5px rgba(255, 255, 255, 0.6),
            10px 10px 15px rgba(255, 255, 255, 0.5),
            -10px -10px 15px rgba(255, 255, 255, 0.5),
            15px -15px 10px rgba(255, 255, 255, 0.5),
            -15px 15px 10px rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%) scale(0);
        opacity: 0;
        z-index: 1;
        animation: explosion 1s ease-in-out infinite;
        pointer-events: none;
    }

    /* Hiệu ứng động cho hạt */
    @keyframes explosion {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
        }

        50% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        100% {
            transform: translate(-50%, -50%) scale(1.5);
            opacity: 0;
        }
    }

    /* Logo VNPay */
    .premium-logo img {
        margin-top: 20px;
        width: 150px;
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    .premium-logo img:hover {
        opacity: 1;
        transform: scale(1.1);
    }
</style>
@endsection