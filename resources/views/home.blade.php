@extends('app')

@section('content')
<style>
 	#chatMessages{ width: 100%; border: 1px solid #ddd; min-height: 100px; list-style: none; padding-left: 0px; height: 400px; overflow-y: auto;}
 	#chatMessages li { width: 100%; padding: 10px;}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Chat</div>

				<div class="panel-body">
					<ul id="chatMessages">
					</ul>
					<div style="display:table; width: 100%;">
						<span style="display:table-cell; width: 65px;">Write here</span>
						<input style="display:table-cell; width: 100%;"type="text" name="chatText" id="chatText" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	var userName = "<?= Auth::user()->name ?>";
	var port = "<?= $chatPort ?>";
	var uri = "<?= explode(':', str_replace('http://', '', str_replace('https://', '', App::make('url')->to('/'))))[0]; ?>";
	port = port.length == 0 ? '9090' : port;

	function addMessageToChatBox(message)
	{
		$("#chatMessages").append('<li>'+message+'</li>');
		$("#chatMessages").scrollTop($("#chatMessages")[0].scrollHeight);
	}

	$(document).ready(function(){

		var conn = new WebSocket('ws://'+uri+':'+port);

		conn.onclose = function (event) {
	        var reason;

	        if (event.code == 1000)
	            reason = "Normal closure, meaning that the purpose for which the connection was established has been fulfilled.";
	        else if(event.code == 1001)
	            reason = "An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.";
	        else if(event.code == 1002)
	            reason = "An endpoint is terminating the connection due to a protocol error";
	        else if(event.code == 1003)
	            reason = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
	        else if(event.code == 1004)
	            reason = "Reserved. The specific meaning might be defined in the future.";
	        else if(event.code == 1005)
	            reason = "No status code was actually present.";
	        else if(event.code == 1006)
	           reason = "Abnormal error, e.g., without sending or receiving a Close control frame";
	        else if(event.code == 1007)
	            reason = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [http://tools.ietf.org/html/rfc3629] data within a text message).";
	        else if(event.code == 1008)
	            reason = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This reason is given either if there is no other sutible reason, or if there is a need to hide specific details about the policy.";
	        else if(event.code == 1009)
	           reason = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
	        else if(event.code == 1010) // Note that this status code is not used by the server, because it can fail the WebSocket handshake instead.
	            reason = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake. <br /> Specifically, the extensions that are needed are: " + event.reason;
	        else if(event.code == 1011)
	            reason = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
	        else if(event.code == 1015)
	            reason = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
	        else
	            reason = "Unknown reason";

	       addMessageToChatBox("Connection closed: " + reason);
	    };

		conn.onopen = function(e)
		{
		    addMessageToChatBox("Connection established!");
		};

		conn.onmessage = function(e)
		{
		    addMessageToChatBox(e.data);
		};

		$('#chatText').keyup(function(e){
			if (e.keyCode == 13) // enter was pressed
			{
				var message = $(this).val();
				conn.send(userName+": "+message);
				addMessageToChatBox("Me: " + message);
				$(this).val("");
			}
		});
	});
</script>
@endsection
