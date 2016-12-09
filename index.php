<!DOCTYPE html>
<html>
	<head>
		<title>Guitar Wars - High Scores</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h2>Guitar Wars - High Scores</h2>
		<p>
			Welcome, Guitar Warrior, do you have what it takes to crack the
			high score list? If so, just <a href="addscore.php">add your 
			own score</a>.
		</p>
		<p>
			Administrate this application, visit <a href="admin.php">admin this application</a>.
		</p>

		<?php
			require_once('appvars.php');
			// Connect to the databasse
			$dbc = mysqli_connect('localhost', 'root', 'qwe@898635', 'gwdb')
				or die('Error, cannot connect to gwba database.');

			$query = "SELECT * FROM guitarwars WHERE approved=1 ORDER BY score DESC";
			$data = mysqli_query($dbc, $query)
				or die('Error, cannot query guitarwars table.');

			// Loop through the array of score data, formatting it as HTML
			echo '<table>';
			$i = 0;
			while ($row = mysqli_fetch_array($data)) {
				// Display the score data
				if ($i == 0) {
					echo '<tr><td colspan="2" class="topscoreheader">Top Score:' .
						$row['score'] . '</td></tr>';
				}

				echo '<tr><td class="scoreinfo">';
				echo '<span class="score">' . $row['score'] . '</span><br>';
				echo '<strong>Name: </strong>' . $row['name'] . '<br>';
				echo '<strong>Date: </strong>' . $row['data'] . '</td>';
				if (is_file($gw_uploadpath . $row['screenshot']) && 
					filesize($gw_uploadpath . $row['screenshot']) > 0) {
					echo '<td><img src= "' . $gw_uploadpath . $row['screenshot'] . '" alt="Score image"></td></tr>';
				} else {
					echo '<td><img src="./images/unverified.gif" alt="Unverified score"></td></tr>';
				}
				$i++;
			}
			echo '</table>';

			mysqli_close($dbc);
		?>
	</body>
</html>
