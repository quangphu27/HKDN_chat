<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Chatbox Room</title>
    </head>

    <body>
        <header>
            <img src="your-company-logo.png" alt="Test Company Logo" width="150" height="50">
            <h1>Chatbox Room</h1>
        </header>

        <body>
            <p>Xin chào ,{{ $user->name }}</p>
            <p>Cảm ơn bạn đã đăng ký với Chatbox Room! Để mở khóa tất cả các tính năng của tài khoản, vui lòng xác minh địa chỉ email của bạn bằng cách nhấp vào nút
                bên dưới.</p>
            <a href="{{ $url }}"
                style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none;">Xác minh địa chỉ email của bạn</a>
            <p>Sau khi xác minh email, bạn sẽ có thể [liệt kê một số lợi ích của việc xác minh, ví dụ: truy cập nội dung độc quyền, tham gia thảo luận].
            </p>
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi theo địa chỉ [địa chỉ email hỗ trợ] hoặc truy cập trang Câu hỏi thường gặp của chúng tôi: [liên kết đến trang Câu hỏi thường gặp].</p>
        </body>
        <footer>
            <p>&copy; Chatbox Room {{ date('Y') }}</p>
            <p><a href="[unsubscribe link]">Hủy đăng ký</a> từ email của chúng tôi.</p>
        </footer>
    </body>

</html>