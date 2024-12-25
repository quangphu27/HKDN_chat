import "./bootstrap";

window.Echo.channel("notifications").listen("UserSessionChanged", (event) => {
    console.log(event);
});
