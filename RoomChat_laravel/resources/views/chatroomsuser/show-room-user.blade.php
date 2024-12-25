<!DOCTYPE html>
<html>
<head>
    <title>{{ $room->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Phòng: {{ $room->name }}</h2>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Hình ảnh -->
                    <div class="col-md-4 text-center">
                        <img src="{{ $room->path_image ? asset('/' . $room->path_image) : 'https://via.placeholder.com/300' }}" 
                             alt="{{ $room->name }}" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    </div>
                    <!-- Thông tin -->
                    <div class="col-md-8">
                        <h4 class="text-muted">Thông Tin Chi Tiết</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>ID phòng:</strong> {{ $room->id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Tên phòng:</strong> {{ $room->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Mô tả:</strong> 
                                {{ $room->description ?? 'Mô tả trống!' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Sức chứa:</strong> {{ $room->capacity }}
                            </li>
                            <li class="list-group-item">
                                <strong>ID trưởng phòng:</strong> {{ $room->leader_id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Mã tham gia:</strong> {{ $room->invitecode }}
                            </li>
                            <li class="list-group-item">
                                <strong>Ngày tạo phòng:</strong> {{ $room->created_at }}
                            </li>
                            <li class="list-group-item">
                                <strong>Ngày cập nhật:</strong> {{ $room->updated_at }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
            <a href="{{ route('user.chat') }}" class="btn btn-secondary" style="background-color: red;">Quay lại</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
