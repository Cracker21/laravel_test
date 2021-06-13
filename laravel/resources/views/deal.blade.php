<!DOCTYPE html>
<html>
<head>
	<title>Create deal</title>
	<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
</head>
<body>
	<p id='msg'></p>
	<form method="POST" action="create">
		@csrf
		<div class="it">
			<b>Create deal</b><br>
			<label>Deal Owner</label>
			<input name="Deal_Owner"><br>
			<label>*Deal Name</label>
			<input name="Deal_Name" required><br>
			<label>Account Name</label>
			<input name="Account_Name"><br>
			<label>*Stage</label>
			<input name="Stage" required><br>
			<label>Amount</label>
			<input name="Amount"><br>
			<label>Lead Source</label>
			<input name="Lead_Source"><br>
			<label>Closing Date</label>
			<input name="Closing_Date"><br>
			<label>Probability</label>
			<input name="Probability"><br>
			<input type="submit" value="Create deal">
		</div>
		<div class="it">
			<b>Associated task</b><br>
			<label>*Subject</label>
			<input name="Subject" required><br>
			<label>Status</label>
			<input name="Status"><br>
			<label>Priority</label>
			<input name="Priority"><br>
			<label>Reminder</label>
			<input name="Reminder"><br>
		</div>
	</form>
	<style>
		.it{
			display: inline-table;
		}
	</style>
</body>
</html>