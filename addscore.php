<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Guitar Wars - Add Your High Score</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h2>Guitar Wars - Add Your High Score</h2>

		<?php
			if (isset($_POST['submit'])) {
				// Grab the score data from the POST
				$name = $_POST['name'];
				$score = $_POST['score'];
				include_once('appvars.php');
				require_once('connectvars.php');
				$screenshot = $_FILES['screenshot']['name'];
				$screenshot_type = $_FILES['screenshot']['type'];
				$screenshot_size = $_FILES['screenshot']['size'];

				if (!empty($name) && !empty($score) && !empty($screenshot)) {
					if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') ||
						($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')) &&
						($screenshot_size > 0) && ($screenshot_size < GW_MAXFILESIZE)) {
						if ($_FILES['file']['error'] == 0) {
							// Move the file to the target upload folder
							$target = $gw_uploadpath . $screenshot;
			
							if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
								// Connect to the database
								$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
									or die('Error, cannot connect to the database.');

								// Write the data to the database
								$query = "INSERT INTO guitarwars VALUES (0, NOW(), '$name', '$score', '$screenshot')";
								mysqli_query($dbc, $query)
									or die('Error, cannot insert data to the database.');
			
								// Confirm success with the user
								echo '<p>Thanks for adding your new high score!</p>';
								echo '<p><strong>Name: </strong>' . $name . '<br>';
								echo '<strong>Score: </strong>' . $score . '<br>';
								echo '<img src="' . $gw_uploadpath . $screenshot . '" alt="Score image"></p>';
								echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';

								// Clear the score data to clear the form
								$name = "";
								$score = "";
								$screenshot = "";

								mysqli_close($dbc);
							} else {
								echo '<p class="error">Sorry, there was a problem uploading your screen' .
									' shot image.</p>';
							}
						}
					} else {
						echo GW_MAXFILESIZE;
						echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file, ' .
							'and no greater than ' . (GW_MAXFILESIZE / 1024) . ' KB in size.</p>';
					}

					// Try to delete the temporary screen shot image file
					@unlink($_FILES['screenshot']['tmp_name']);
				} else {
					echo '<p class="error">Please enter all of the information to add your high ' .
						'score.</p>';
				}
			}
		?>

	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="32768">
		<div class="tableRow">
		<p><label for="name">Name: </label></p>
		<p>
		  <input type="text" name="name" id="name" value="<?php if (!empty($name)) {echo $name;} ?>"></p>
		</div>
		<div class="tableRow">
		<p><label for="score">Score: </label></p>
		<p>
		<input type="text" name="score" id="score" value="<?php if (!empty($score)) {echo $score;} ?>"></p>
		</div>
		<div class="tableRow">
		   <P><label for="screenshot">Screen shot: </label></P>
		   <P><input type="file" id="screenshot" name="screenshot"></P>
		</div>
		<div class="tableRow">
		  <p></p>
		  <p><input type="submit" name="submit"></p>
		</div>
		</form>
	</body>
</html>
