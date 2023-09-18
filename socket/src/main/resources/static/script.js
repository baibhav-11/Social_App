var stompClient = null;
var notificationCount = 0;

$(document).ready(function() {
    console.log("Index page is ready");
    connect();

    $("#send").click(function() {
        sendMessage();
    });
	$("#like").click(function() {
	    sendLike();
	});
});
    
function connect() {
    var socket = new SockJS('/Social_App-websocket');
    stompClient = Stomp.over(socket);
    stompClient.connect({}, function (frame) {
        console.log('Connected: ' + frame);
    stompClient.subscribe('/topic/comments', function (message) {
			var parsedJSON=JSON.parse(message.body).comments;
            showMessage(parsedJSON[0].comment);
        });
	stompClient.subscribe('/topic/likes', function (message) {
            showLike(message)
        });

    });
}

function showMessage(message) {
    $("#messages").append("<tr><td>" + message + "</td></tr>");
}
function showLike(message) {  
    $("#like").html(message);
}


function sendMessage() {
    console.log("sending message");

    stompClient.send("/social_app/comment", {}, JSON.stringify({
	"comments":[{"id":1,"post_id":1,"user_id":1,"parent_id":0,"comment":$("#message").val(),
	"created_at":"2022-02-10T13:25:39.000000Z","updated_at":"2022-02-10T13:25:39.000000Z"}]}));
}
function sendLike() {
    console.log("sending likes");
    stompClient.send("/social_app/like", {}, JSON.stringify({'like': 1,'id':"12"}));
}