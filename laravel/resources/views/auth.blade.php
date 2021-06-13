<!DOCTYPE html>
<html>
<head>
	<title>Авторизация</title>
	<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
</head>
<body>
	<p id="msg"></p>
	<form action="auth" method="POST">
		@csrf
		<label>Auth token:</label>
		<input name="auth_token"><br>
		<label>Client ID:</label>
		<input name="client_id" value="{{ session('client_id') ?? '' }}"><br>
		<label>Client secret:</label>
		<input name="client_secret" value="{{ session('client_secret') ?? '' }}"><br>
		<input type="submit" value="Авторизоваться">
	</form>
</body>
</html>