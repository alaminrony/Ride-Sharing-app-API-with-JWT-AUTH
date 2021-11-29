<?php echo 'hello';exit;?>
<p>
	Hello {{$data['name']}}, <br>
	Your registration is successful,<br><br>
	Your login info: <br>
	Email : {{$data['email']}} <br>
	Password : {{$data['password']}} <br>

	click the bellow link to active your account.<br>

	<a href="{{$data['link'] }}">{{ $data['link']}}</a> <br>
	Regards, <br>

	Fare Trim

	
</p>