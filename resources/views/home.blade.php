@extends('app')

@section('content')
<style>
 	#chatMessages{ width: 100%; border: 1px solid #ddd; min-height: 100px; list-style: none; padding-left: 0px; height: 400px; overflow-y: auto;}
 	#chatMessages li { width: 100%; padding: 10px;}

 	li.message.system span.who { color: red; }
 	li.message.user span.who   { color: blue; }
 	li.message.mine span.who   { font-weight: bold; }
</style>

<div class="container">
	
	<div class="row">

		<div class="col-md-10 col-md-offset-1">
			
			<div class="panel panel-default">
				
				<div class="panel-heading">Chat</div>

				<div class="panel-body" id="chat">
					
					<div style="display:table; width: 100%; margin-bottom: 10px;">
						
						<span style="display:table-cell; width: 100px;">
							Your name:
						</span>

						<input style="display:table-cell; width: 100%;"
							   type="text" 
							   v-model="userName"
						/>
					</div>

					<ul id="chatMessages">

						<li v-for="message in messages" class="message" :class="message.class">
							<span class="who">@{{ message.who }}: </span>@{{ message.msg }}
						</li>

					</ul>

					<div style="display:table; width: 100%;">
						
						<span style="display:table-cell; width: 100px;">
							Say something:
						</span>

						<input style="display:table-cell; width: 100%;"
							   type="text" 
							   v-model="newMessage"
							   @keyup.enter="sendMessage"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Latest Vue JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.min.js"></script>

<script>
	
	var vue = new Vue({
		el: '#chat',
		data : {
			messages: [],
			newMessage: "",
			userName: "John Doe",
			port: "{{ $chatPort }}",
			uri: "{{ explode(':', str_replace('http://', '', str_replace('https://', '', App::make('url')->to('/'))))[0] }}",
			conn: false,
		},
		ready : function(){
			
			// default port
			this.port = this.port.length == 0 ? '9090' : this.port;
			
			// init connection
			this.conn = new WebSocket('ws://'+this.uri+':'+this.port);

			var me = this;

			this.conn.onclose = function (event) {
		        
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

		        me.addSystemMessage("Connection closed: " + reason);
	   	 	};

			this.conn.onopen = function(event) {
			    me.addSystemMessage("Connection established! Be cool...");
			};

			this.conn.onmessage = function(event) {
			  	me.addServerMessage(event.data);
			};
		},
		methods : {
			addSystemMessage : function(message){
				this.addMessage({
					"msg" 	: message,
					"class"	: "system",
					"who"	: "System"
				});
			},
			addServerMessage : function(message){
				this.addMessage({
					"msg" 	: message.split(':')[1].trim(),
					"class"	: "user",
					"who"	: message.split(':')[0].trim()
				});
			},
			addMeAmessage : function(message){
				this.addMessage({
					"msg" 	: message,
					"class"	: "mine",
					"who"	: "Me"
				});
			},
			addMessage : function(message) {
				
				this.messages.push(message);
				
				// allow the DOM to get updated
				Vue.nextTick(function () {
					this.scrollMessagesDown();
				}.bind(this));
			},
			scrollMessagesDown : function(){
				var chatMessages = document.getElementById('chatMessages');
				chatMessages.scrollTop = 1000000;
			},
			sendMessage : function() {
				
				if (!this.newMessage.length)
					return;

				var msgToSend = this.userName+":"+ this.newMessage;

				this.conn.send(msgToSend);

				this.addMeAmessage(this.newMessage);

				this.newMessage = "";
			} 
		}
	});
</script>
@endsection
