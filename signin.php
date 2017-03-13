<?php
//signin.php
include 'code/connect.php';
include 'header.php';
 
echo '<h3>Sign in</h3>';
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		echo '<form method="post" action="">
			Username: <input type="text" name="user_name" class="form-control" minlength="6" maxlength="30"/><br>
			Password: <input type="password" name="password" class="form-control" minlength="6" maxlength="30"/><br>	
			<input type="submit" value="login" class="btn btn-primary">
			</form>';
	}	
	else
	{
		$errors = array();

		if(!isset($_POST['user_name']))
		{
			$errors[] = 'The username field is empty';
		}

		if(!isset($_POST['password']))
		{
			$errors[] = 'The password field is empty';
		}	

		if(!empty($errors))
		{
			echo "there are errors, please correct them!";
			echo "<ul>";
			foreach($errors as $key => $value)
			{
				echo "<li>" . $value . "</li>";
			}	
			echo "</ul>";
		}	

		else
		{
			$username = mysql_real_escape_string($_POST['user_name']);
        	$password = sha1($_POST['password']);
        	$result = mysqli_query($dbc,"CALL login_user_sp('$username', '$password')");
			$row_count = $result->num_rows;
        	if(!$result)
			{
				echo "Something went wrong, please try again later";
			}
			else
			{
				if($row_count == 0) 
				{
					echo "You have supplied the wrong username / password combination, please try again";
				}	

				else
				{
					$_SESSION['signed_in'] = TRUE;
					while($row = mysqli_fetch_array($result))
					{
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['user_name'] = $row['user_name'];
						$_SESSION['user_email'] = $row['user_email'];
						$_SESSION['user_level'] = $row['user_level'];
					}	

					echo '<h2>Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to forum</a>.</h2>';
				}	
			}
		}	
	}	
}
include 'footer.php';
?>