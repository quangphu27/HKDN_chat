@extends('User.Layout.layout')

@section('main')
@if($chatRoom)
  <div class="container-fluid" id="backgroundchat" style="background-color: #f9f9f9; padding-top: 20px;">
    <div class="row justify-content-center">
      <div class="col-md-12 col-xl-12 chat" style="height: 90vh;">
        <div class="card" style="border-radius: 15px; border: none; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
          <div class="card-header msg_head" style="background-color: #007bff; color: #fff; border-radius: 15px 15px 0 0;">
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="/uploads/chatrooms/{{ $chatRoom && $chatRoom['path_image'] ? $chatRoom['path_image'] : 'image_default.png' }}" 
                     class="rounded-circle user_img" style="border: 2px solid #fff;">
              </div>
              <div class="user_info">
                <span style="font-weight: bold; font-size: 1.2rem;">{{ $chatRoom ? $chatRoom['name'] : 'Không có tên nhóm' }}</span>
                <p>{{ $chatRoom ? $chatRoom['description'] : 'Không có mô tả' }}</p>
              </div>
              <div class="video_cam">
                <span onclick="location.href='{{ route('user.video.call', ['roomName' => $chatRoom->id]) }}'" style="cursor: pointer;">
                    <i class="fas fa-video" style="font-size: 20px;"></i>
                </span>
                <span><i class="fas fa-phone" style="font-size: 20px;"></i></span>
            </div>
            
            </div>
            <span id="action_menu_btn"><i class="fas fa-ellipsis-v" style="font-size: 20px;"></i></span>
            <div class="action_menu">
              <ul>
                @if($chatRoom && $chatRoom->leader_id == auth()->id())
                  <li><i class="fas fa-ban"></i> Giải tán nhóm</li>
                @else
                  <li><i class="fas fa-ban"></i> Rời khỏi nhóm</li>
                @endif
                <li><i class="fas fa-invite"></i> Mã giới thiệu: {{ $chatRoom ? $chatRoom['invitecode'] : ""}}</li>
              </ul>
            </div>
          </div>

          <div class="card-body msg_card_body" id="list_mess_body" style="background-color: #ffffff; padding: 20px; overflow-y: scroll; height: 70vh;">
            @foreach($messages as $message)
              <!-- Tin nhắn của người khác -->
              @if($message->user_id != auth()->id())
                <div class="d-flex justify-content-start mb-4" id="message-{{ $message->id }}">
                  <div class="img_cont_msg">
                    <img src="/template/assets/img/avatar/{{ $message->user->avatar ?? 'avatar-default.png' }}" 
                         class="rounded-circle user_img_msg" style="border: 2px solid #007bff;">
                  </div>
                  <div class="msg_cotainer">
                    {{ $message->message_text }}
                    <span class="msg_time">{{ $message->created_at->format('H:i A') }}</span>
                    <span class="delete_msg_btn" data-message-id="{{ $message->id }}" style="color: red; cursor: pointer; margin-left: 10px;">
                      <i class="fas fa-trash-alt"></i>
                    </span>
                  </div>
                </div>
              @else
                <!-- Tin nhắn của người dùng hiện tại -->
                <div class="d-flex justify-content-end mb-4" id="message-{{ $message->id }}">
                  <div class="msg_cotainer_send" style="background-color: #007bff; color: #fff; border-radius: 15px; padding: 10px;">
                    {{ $message->message_text }}
                    <span class="msg_time_send">{{ $message->created_at->format('H:i A') }}</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="/template/assets/img/avatar/{{ $message->user->avatar ?? 'avatar-default.png' }}" 
                         class="rounded-circle user_img_msg" style="border: 2px solid #007bff;">
                  </div>
                </div>
              @endif
            @endforeach
          </div>

          <div class="card-footer" style="background-color: #f1f1f1; border-radius: 0 0 15px 15px;">
            <div class="input-group">
              <div class="input-group-append">
                <label for="file_input" class="input-group-text attach_btn" style="cursor: pointer; height: 40px; background-color: #007bff; color: #fff;">
                  <i class="fas fa-paperclip" style="font-size: 20px;"></i>
                </label>
                <input type="file" id="file_input" style="display: none;">
              </div>
              <textarea name="message" class="form-control type_msg" placeholder="Viết tin nhắn..." style="border-radius: 18px;"></textarea>
              <div class="input-group-append">
                <span class="input-group-text send_btn" style="height: 40px; background-color: #007bff; color: #fff;">
                  <i class="fas fa-location-arrow" style="font-size: 20px;"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
@endsection

@section('script')
<script>
  // Gửi tin nhắn
  document.querySelector('.send_btn').addEventListener('click', function () {
    const message = document.querySelector('.type_msg').value;
    const chatRoomId = '{{ $chatRoom ? $chatRoom["id"] : null }}';
    if (message.trim() === '') {
      alert('Vui lòng nhập tin nhắn!');
      return;
    }

    fetch('{{route("user.chat.send")}}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: JSON.stringify({
        message: message,
        chatRoomId: chatRoomId
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        console.log('Tin nhắn đã được gửi');
        document.querySelector('.type_msg').value = '';
      } else {
        console.error('Gửi tin nhắn thất bại');
      }
    })
    .catch(error => console.error('Lỗi:', error));
  });

  // Xóa tin nhắn
  document.querySelectorAll('.delete_msg_btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const messageId = this.getAttribute('data-message-id');

      if (confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')) {
        const url = '{{ route("user.chat.delete", ":messageId") }}'.replace(':messageId', messageId);

        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: JSON.stringify({ messageId: messageId } ),
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            console.log('Tin nhắn đã được xóa');
            document.querySelector(`#message-${messageId}`).remove();
          } else {
            console.error('Xóa tin nhắn thất bại');
          }
        })
        .catch(error => console.error('Lỗi:', error));
      }
    });
  });

  // Thêm người dùng vào phòng
  document.querySelectorAll('.add-user-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const userId = this.getAttribute('data-user-id');
      const chatRoomId = '{{ $chatRoom ? $chatRoom["id"] : null }}';

      fetch('{{ route("user.chat.addUser", ":chatRoomId") }}'.replace(':chatRoomId', chatRoomId), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ user_id: userId })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Người dùng đã được thêm vào phòng!');
          location.reload();
        } else {
          alert('Thêm người dùng thất bại!');
        }
      })
      .catch(error => console.error('Lỗi:', error));
    });
  });

  // Xóa người dùng khỏi phòng
  document.querySelectorAll('.remove-user-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const userId = this.getAttribute('data-user-id');
      const chatRoomId = '{{ $chatRoom ? $chatRoom["id"] : null }}';

      if (confirm('Bạn có chắc chắn muốn xóa người dùng này khỏi phòng?')) {
        fetch('{{ route("user.chat.removeUser", ":chatRoomId") }}'.replace(':chatRoomId', chatRoomId), {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert('Người dùng đã bị xóa khỏi phòng!');
            location.reload();
          } else {
            alert('Xóa người dùng thất bại!');
          }
        })
        .catch(error => console.error('Lỗi:', error));
      }
    });
  });
</script>
@endsection
