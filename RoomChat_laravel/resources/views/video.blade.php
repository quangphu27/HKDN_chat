<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jitsi Video Call</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #meet {
            height: 100vh;
            width: 100%;
        }
    </style>
    <script src="https://meet.jit.si/external_api.js"></script>
</head>
<body>
    <div id="meet"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const domain = "meet.jit.si";
            const options = {
                roomName: "{{ $roomName }}",
                width: "100%",
                height: "100%",
                parentNode: document.querySelector('#meet'),
                userInfo: {
                    displayName: "{{ Auth::user()->name }}"
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);

            // Thêm sự kiện hoặc tùy chỉnh tại đây nếu cần
        });
    </script>
</body>
</html>
