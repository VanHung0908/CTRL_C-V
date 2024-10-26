<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Chiều cao toàn bộ màn hình */
            margin: 0; /* Đặt margin thành 0 */
            background-color: #f8f9fa; /* Màu nền nhẹ nhàng */
            font-family: Arial, sans-serif;
            color: #343a40; /* Màu chữ tối */
        }

        .container {
            text-align: center;
            position: absolute; /* Thay đổi thành absolute */
            top: 50%; /* Căn giữa theo chiều dọc */
            left: 50%; /* Căn giữa theo chiều ngang */
            transform: translate(-50%, -50%); /* Căn giữa chính xác */
        }

        .error-content {
            max-width: 600px;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 80px;
            font-weight: bold;
            color: #dc3545; /* Màu đỏ */
        }

        h2 {
            font-size: 24px;
            margin: 20px 0;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Màu xanh dương */
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-home:hover {
            background-color: #0056b3; /* Màu xanh đậm khi hover */
        }
    </style>
    <title>404 - Không tìm thấy trang</title>
</head>
<body>
    <div class="container">
        <div class="error-content">
            <h1>404</h1>
            <h2>Không tìm thấy trang</h2>
            <p>Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <a href="/QLBV" class="btn-home">Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>
