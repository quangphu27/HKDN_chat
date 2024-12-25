<!DOCTYPE html>
<html lang="en" style="width: 99vw; height: 90vh;">
<head>
    @include('header')
    <title>@yield('title', '')</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/template/assets/css/chat.css">
    @vite(['resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')
    <style>
        /* Chat container */
        #backgroundchat {
            background-color: #f8f9fa;
            height: 90vh;
            overflow-y: auto;
            padding: 10px;
        }

        /* Sidebar toggle button */
        .sidebar-toggle {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background-color: #888;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar-toggle i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .sidebar-toggle.rotated i {
            transform: rotate(180deg);
        }

        /* Sidebar collapse animations */
        .ultogle {
            max-height: 500px;
            overflow: hidden;
            transition: max-height 0.5s ease, padding 0.5s ease;
        }

        .ultogle.collapsed {
            max-height: 0;
            padding: 0;
        }

        /* Chat message container */
        .msg_cotainer {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 10px;
            max-width: 75%;
            word-wrap: break-word;
        }

        .msg_cotainer_send {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 10px;
            max-width: 75%;
            word-wrap: break-word;
        }

        /* Avatar styling */
        .user_img_msg {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* Message timestamps */
        .msg_time, .msg_time_send {
            font-size: 0.8rem;
            color: #888;
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('User.Layout.header')
    <!-- End Header -->

    <!-- ======= ListRoom ======= -->
    @include('User.Layout.listroom')
    <!-- End ListRoom -->

    <!-- ======= Main Chat Content ======= -->
    <main id="main" class="main" style="padding: 0;">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('main')
    </main>

    <!-- Footer -->
    @include('footer')

    @yield('script')

    <script>
        const list_mess_body = document.querySelector('#list_mess_body');
        list_mess_body.scrollTop = list_mess_body.scrollHeight;

        // Sidebar toggle
        function toggleSidebar() {
            const toggleButton = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.ultogle');
            const isCollapsed = sidebar.classList.contains('collapsed');
            if (isCollapsed) {
                sidebar.classList.remove('collapsed');
                localStorage.setItem('sidebarState', 'open');
                toggleButton.classList.toggle('rotated');
            } else {
                sidebar.classList.add('collapsed');
                localStorage.setItem('sidebarState', 'closed');
                toggleButton.classList.toggle('rotated');
            }
        }

        window.onload = function () {
            const savedState = localStorage.getItem('sidebarState');
            const sidebar = document.querySelector('.ultogle');
            if (savedState === 'closed') {
                sidebar.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
            }
        }
    </script>

    <script>
        // Dynamic update for chat rooms
        async function updateListRoom() {
            try {
                const response = await fetch("/user/room/getrooms");
                const data = await response.json();
                const sidebarNav = document.getElementById('sidebar-nav');
                sidebarNav.innerHTML = '';

                data.forEach(chatRoom => {
                    const li = document.createElement('li');
                    li.id = `chatroom_${chatRoom.id}`;
                    li.classList.add('nav-item');
                    li.style = "position: relative; padding-top: 1px; border-bottom: 1px solid #eeeeee;";

                    const a = document.createElement('a');
                    a.classList.add('nav-link');
                    a.href = `/user/chat/${chatRoom.id}`;
                    a.style = "display: flex; align-items: center; text-decoration: none; box-sizing: border-box;";

                    const img = document.createElement('img');
                    img.src = `/uploads/chatrooms/${chatRoom.image}`;
                    img.style = "width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;";
                    a.appendChild(img);

                    const groupChatContent = document.createElement('div');
                    groupChatContent.classList.add('group_chat_content');
                    groupChatContent.style = "flex: 1; display: flex; flex-direction: column;";

                    const name = document.createElement('p');
                    name.textContent = chatRoom.name;
                    groupChatContent.appendChild(name);

                    const latestMessage = document.createElement('p');
                    latestMessage.textContent = `${chatRoom.latest_message_sender}: ${chatRoom.latest_message}`;
                    groupChatContent.appendChild(latestMessage);

                    a.appendChild(groupChatContent);

                    const time = document.createElement('span');
                    time.textContent = chatRoom.latest_message_time ? new Date(chatRoom.latest_message_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'N/A';
                    a.appendChild(time);

                    if (chatRoom.unread_messages_count > 0) {
                        const unreadBadge = document.createElement('span');
                        unreadBadge.classList.add('badge-unread');
                        unreadBadge.style = "position: absolute; top: 20%; right: 5px; background-color: #dc3545; color: white;";
                        unreadBadge.textContent = chatRoom.unread_messages_count;
                        a.appendChild(unreadBadge);
                    }

                    li.appendChild(a);
                    sidebarNav.appendChild(li);
                });
            } catch (error) {
                console.error('Error updating chat rooms list:', error);
            }
        }

        async function initializeChatRoom() {
            const roomId = {{ request()->route('chatRoomId') }};
            await setChatRoom(roomId);
            updateListRoom();
        }

        document.addEventListener('DOMContentLoaded', function () {
            initializeChatRoom();
        });

        // Function to format the time correctly
        function formatTime(dateTime) {
            const date = new Date(dateTime);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }
    </script>

</body>
</html>
