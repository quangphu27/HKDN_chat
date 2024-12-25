<div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
        @csrf <!-- Đảm bảo có token CSRF cho form -->
        <input type="text" name="query" placeholder="Search group" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
</div>
<ul class="sidebar-nav" id="sidebar-nav" style="flex: 1; overflow-y: auto; padding: 0; margin: 0;">
    @foreach($chatRooms as $chatRoom)
        <li id="chatroom_{{$chatRoom['id']}}" class="nav-item"
            style="position: relative; padding-top: 1px; border-bottom: 1px solid #eeeeee; margin-bottom: 0; width: 100%;">
            <a class="nav-link {{ request()->route('chatRoomId') == $chatRoom['id'] ? 'hover' : '' }}"
                href="{{ route('user.chat', ['chatRoomId' => $chatRoom['id']]) }}"
                style="display: flex; align-items: center; text-decoration: none; box-sizing: border-box;">
                <img src="/uploads/chatrooms/{{$chatRoom['image']}}"
                    style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px; " />
                <div class="group_chat_content" style="flex: 1; display: flex; flex-direction: column;">
                    <p
                        style="margin: 0; font-weight: bold; color: #555; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$chatRoom['name']}}</p>
                    <p
                        style="margin: 0; font-weight:normal; color: #888; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 150px;">
                        {{$chatRoom['latest_message_sender']}}: {{$chatRoom['latest_message']}}</p>
                </div>
                <span style="font-size: 12px; color: #888;">
                    {{$chatRoom['latest_message_time'] ? $chatRoom['latest_message_time']->format('H:i') : 'N/A'}}
                </span>
            </a>
            @if($chatRoom['unread_messages_count'] > 0)
                <span class="badge-unread" style="font-size: 10px; position: absolute; top: 20%; right: 5px; transform: translateY(-50%); 
                             background-color: #dc3545; color: white; border-radius: 12px; padding: 2px 8px; 
                             font-size: 12px; font-weight: bold; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    {{$chatRoom['unread_messages_count']}}
                </span>
            @endif
        </li>
    @endforeach
</ul>