@extends('User.Layout.layout')
@section('title', 'Chat with Gemini')
@section('main')
@section('styles')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<style>
    .input-group button {
        all: unset;
        /* Xóa mọi kiểu CSS mặc định của button */
        display: inline-block;
        /* Tương tự div */
        padding: 0;
        /* Đặt lại padding nếu cần */
        margin: 0;
        /* Đặt lại margin nếu cần */
        border: none;
        /* Xóa border mặc định */
        background: none;
        /* Xóa màu nền mặc định */
        cursor: pointer;
        /* Để giữ chức năng nhấn */
    }
</style>
@endsection
@php
$avatar= (Auth::user() && Auth::user()->avatar ? Auth::user()->avatar : 'avatar-default.png')
@endphp
<div class="container-fluid ">
    <div class="row justify-content-center ">
        <div class="col-md-12 col-xl-12 chat" style='height:90vh'>
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="/template/assets/img/Gemini.png" class="rounded-circle user_img">
                            <span class="online_icon"></span>
                        </div>
                        <div class="user_info">
                            <span>Chat with Gemini</span>
                        </div>
                    </div>
                </div>
                <div class="card-body msg_card_body list_mess">
                    <div class="mess d-flex justify-content-start mb-4">
                        <div class="img_cont_msg">
                            <img src="/template/assets/img/Gemini.png" class="rounded-circle user_img_msg">
                        </div>
                        <div class="msg_cotainer">
                            Xin chào {{ (Auth::user() && Auth::user()->name ? Auth::user()->name : '') }}, tôi có thể giúp gì cho bạn?
                            <span class="msg_time"></span>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <form class="input-group">
                        <button type="button" class="input-group-append" style="border-color:aquamarine">
                            <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                        </button>
                        <textarea id="message" name="message" class="form-control type_msg" placeholder="Type your message..."></textarea>
                        <button type="submit" id="send_message" class="input-group-append" style="border-color: aqua;">
                            <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const timeElement = document.querySelector(".msg_time"); // Chọn phần tử chứa thời gian
        if (timeElement) {
            const now = new Date(); // Lấy thời gian hiện tại
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const ampm = hours >= 12 ? "PM" : "AM"; // Xác định AM/PM
            const formattedTime = `${hours % 12 || 12}:${minutes.toString().padStart(2, "0")} ${ampm} Today`;
            timeElement.textContent = formattedTime; // Thay nội dung phần tử
        }
    });
    // Gửi tin nhắn
    $("form").submit(function(event) {
        event.preventDefault();

        //Stop empty messages
        if ($("form #message").val().trim() === '') {
            $("form #message").focus();
            return;
        }
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedTime = `${(hours % 12 || 12)}:${minutes.toString().padStart(2, '0')} ${ampm}, Today`;
        //Disable form
        $("form #message").prop('disabled', true);
        $("form #send_message").prop('disabled', true);
        $(".list_mess > .mess").last().after(
            '<div class="mess d-flex justify-content-end mb-4">' +
            '<div class="msg_cotainer_send">' +
            $("form #message").val() +
            '<span class="msg_time_send">' + formattedTime + '</span>' +
            '</div>' +
            '<div class="img_cont_msg">' +
            '<img src="/template/assets/img/avatar/{{ $avatar }}"class="rounded-circle user_img_msg">' +
            '</div>' +
            '</div>'
        );
        $(".list_mess > .mess").last().after(
            '<div class="mess d-flex justify-content-start mb-4">' +
            '<div class="img_cont_msg">' +
            '<img src="/template/assets/img/Gemini.png" class="rounded-circle user_img_msg">' +
            '</div>' +
            '<div class="msg_cotainer">' + '<div class="typing-indicator">' +
            '<span></span>' +
            '<span></span>' +
            '<span></span>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
        $('.list_mess').scrollTop($(document).height());
        $.ajax({
            url: "/user/chatAI",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: {
                "content": $("form #message").val()
            }
        }).done(function(res) {
            $(".list_mess > .mess").last().remove();
            // Thêm tin nhắn nhận
            $(".list_mess > .mess").last().after(
                '<div class="mess d-flex justify-content-start mb-4">' +
                '<div class="img_cont_msg">' +
                '<img src="/template/assets/img/Gemini.png" class="rounded-circle user_img_msg">' +
                '</div>' +
                '<div class="msg_cotainer">' +
                res +
                '<span class="msg_time">' + formattedTime + '</span>' +
                '</div>' +
                '</div>'
            );

            // Xoá giá trị trong textarea và scroll xuống cuối

            $('.list_mess').scrollTop($(document).height());

            // Kích hoạt lại form
            $("form #message").prop('disabled', false);
            $("form #send_message").prop('disabled', false);

            $("form #message").val('');
            $("form #message").focus();
        });

    });
</script>
@endsection