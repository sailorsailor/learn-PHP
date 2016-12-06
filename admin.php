<!DOCTYPE html>
<html>
	<head>
		<title>Guitar Wars - High Score Administration</title>
		<meta charset="utf-8">
		<link rel="stylesheet" style="text/css" href="style.css">
	</head>
	<body>
		<h2>Guitar Wars - High Scores Administration</h2>
		<p>Below is a list of all Guitar Wars high scores. Use this page to remove scores as needed.</p>
		<?php
			require_once('appvars.php');
			require_once('connectvars.php');

			// Connect to the database
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			// Retrieve the score data from MySQL
			$query = "SELECT * FROM guitarwars ORDER BY score DESC, data ASC";
			$data = mysqli_query($dbc, $query);

			// Loop through the array of score data, formatting it as HTML
			echo '<table>';
			while ($row = mysqli_fetch_array($data)) {
				// Display the score data
				echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong></td>';
				echo '<td>' . $row['data'] . '</td>';
				echo '<td>' . $row['score'] . '</td>';
				echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;date=' . $row['data'].
					'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot='.
					$row['screenshot'] . '">Remove</a></td></tr>';
			}
			echo '</table>';

			mysqli_close($dbc);
		?>
	</body>
</html>
