<?php 
	
	$errors = "";
	$servername = "localhost"; 
	$username ="root";
	$password = '';
	$dbname = 'attendance';

	// connect to database
	$conn = mysqli_connect( $servername,$username ,$password);

	// check connection 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error().'<br>');
	}

	// Create database
	$sql = "CREATE DATABASE IF NOT EXISTS attendance";
	if (mysqli_query($conn, $sql)) {
	echo " ".'<br>';
	} else {
	echo "Error creating database: " . mysqli_error($conn).'<br>';
	}
	
	// Create table
	$sql = "CREATE TABLE IF NOT EXISTS register(
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		firstname VARCHAR(255),
		surname VARCHAR(255),
		logged_in DATETIME DEFAULT CURRENT_TIMESTAMP
	)";
	
    $conn = mysqli_connect($servername, $username, $password, $dbname);
	if (mysqli_query($conn, $sql)){
	  echo  " ";
	} else {
	echo "Error creating table: " . mysqli_error($conn).'<br>';
	}

	
	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {

		if (empty($_POST['firstname'] & $_POST['surname'])) {
			$errors = "Kindly fill in all the details ";
		}else{
			$firstname = $_POST['firstname'];			
			$surname = $_POST['surname'];			
			$query = "INSERT INTO register(firstname, surname) VALUES('$firstname','$surname')";

			if (mysqli_query($conn, $query)){
				echo 'attendance logged to database <br>';
			}else {
				echo 'error logging task:'.mysqli_error($conn).'<br>';
			};
			header('location: attendance.php');
		}
	}	

	// delete task
	if (isset($_GET['del_attend'])) {
		$id = $_GET['del_attend'];

		mysqli_query($conn, "DELETE FROM register WHERE id=".$id);
		header('location: attendance.php');
	}

	// select all tasks if page is visited or refreshed
	// $tasks = mysqli_query($conn, "SELECT * FROM register");


	// mysqli_close($conn);

?>
<!DOCTYPE html>
<html>

<head>
	<title>ToDo List Application PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Student attendance register App Using PHP and MySQL database</h2>
	</div>


	<form method="post" action="attendance.php" class="input_form">
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		
		<input type="text" name="firstname" class="attend_input" placeholder='Enter name'><span>
		<input type="text" name="surname" class="attend_input" placeholder='Enter surname'>
		<button type="submit" name="submit" id="add_btn" class="add_btn">Take Attendance</button>
		</span>
	</form>

		<?php 
		$sql = "SELECT id, firstname, surname , logged_in FROM register  ";
		$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		
		?>
		<table>
			<tr>
				<th>Index</th>
				<th>Firstname</th>
				<th>Surname</th>
				<th>Log-in Time</th>
				<th>Cancel attendance</th>
			</tr>
		<?php  
		while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){ 			
		?>
			<?php echo '<tr>'?>	
					<?php echo '<td>'. $row['id']. '</td>' ?> 
					<?php echo '<td>'.  $row['firstname'].'</td>' ?> 
					<?php echo '<td>'.  $row['surname'] .'</td>' ?> 
					<?php echo '<td>'.  $row['logged_in'] .'</td>'?> 
				   <td>
						<span class="delete">
							<a href="attendance.php?del_attend=
							<?php echo $row['id'] ?>">x</a> 
							</span>
			  		</td>
			 <?php echo '</tr>'?>							
			 <?php }  ?> 
		</table>				
			<?php mysqli_close($conn);  ?> 	
	
	</body>
</html>