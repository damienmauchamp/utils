<!DOCTYPE html>
<html>
<head>
	<script
		src="https://code.jquery.com/jquery-3.4.1.js"
		integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
		crossorigin="anonymous"></script>
	<style>
		#result {
			cursor: default;
		}
	</style>
</head>
<body>
	<select id="action">
		<option value="consolelog">Générateur console.log()</option>
		<option value="consolelog_functions">Générateur de console.log() pour fonctions</option>
	</select>
	<textarea id="content" name="content"></textarea>
	<textarea type="text" id="result" name="result" onClick="this.select();"></textarea>
	<!--input type="text" id="result" name="result" onClick="this.select();"/-->
	<button id="submit">Valider</button>

	<script>
		$(function() {
			$('#content').focus();
			$('#submit').on('click', function() {
				$.ajax({
					url: './ajax',
					method: 'POST',
					data: {
						action: $('#action').val(),
						content: $('#content').val()
					},
					success: function(data) {
						$('#result').val(data);
						$('#result').focus().select();
					}
				});
			});
		});
	</script>
</body>
</html>