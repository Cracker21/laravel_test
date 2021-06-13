<!DOCTYPE html>
<html>
<head>
	<title>Авторизация</title>
</head>
<body>
	<form action="auth" method="POST">
		@csrf
		<label>Auth token:</label>
		<input name="auth_token"><br>
		<label>Client ID:</label>
		<input name="client_id" value="{{ $_SESSION['client_id'] ?? '' }}"><br>
		<label>Client secret:</label>
		<input name="client_secret" value="{{ $_SESSION['client_secret'] ?? '' }}"><br>
		<input type="submit" value="Авторизоваться">
		<button><a href="logout">Logout</a></button>
	</form>
</body>
</html>