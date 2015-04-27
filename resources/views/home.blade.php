@extends('app')

@section('content')
<style>
 	#chatMessages{ width: 100%; border: 1px solid #ddd; min-height: 100px; list-style: none; padding-left: 0px; }
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

	function addMessageToChatBox(message)
	{
		$("#chatMessages").append('<li>'+message+'</li>');
	}

	$(document).ready(function(){

		var conn = new WebSocket('ws://localhost:8080');

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
