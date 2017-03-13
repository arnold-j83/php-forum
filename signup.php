<?php
//signup.php
include 'code/connect.php';
include 'header.php';
 
echo '<h3>Sign up</h3>';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="">
        Username: <input type="text" name="user_name" class="form-control" minlength="6" maxlength="30" /><br>
        Password: <input type="password" name="user_pass" class="form-control" minlength="6" maxlength="30"><br>
        Password again: <input type="password" name="user_pass_check" class="form-control" minlength="6" maxlength="30"><br>
        E-mail: <input type="email" name="user_email" class="form-control" minlength="6" maxlength="50"><br>
        <input type="submit" value="Add category" class="btn btn-primary" /><br>
     </form>';
}

else
{
	$errors = array();

	if(isset($_POST['user_name']))	
	{
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'The Username Can Only Contain Letters and Numbers';
		}

		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'Ths user name can not be more than 30 characters';
		}
	}	
	else
	{
		$errors[] = 'The User Name Field must not be empty';
	}

	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'The two passwords do not match';
		}
	}

	else
	{
		$errors[] = 'The password fields can not be empty';
	}	

	if(!empty($errors))
	{
		echo "One or More Fields Are NOT Filled in Correctly!";
		echo "<ul>";
		foreach($errors as $key => $value)
		{
			echo "<li>" . $value . "</li>";
		}
		echo "</ul>";
	}
	else
	{
		/*$sql = "INSERT INTO users(user_name, user_pass, user_email, user_date, user_level)
				VALUES ('" . mysql_real_escape_string($_POST['user_name']) . "',
				'" . SHA1($_POST['user_pass']) . "',
				'" .mysql_real_escape_string($_POST['user_email']) ."',
				NOW(), 0)";*/
		$sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysql_real_escape_string($_POST['user_email']) . "',
                        NOW(),
                        0)";
        //new_user_sp                		
		//$result = mysql_query($sql);
        $username = mysql_real_escape_string($_POST['user_name']);
        $password = sha1($_POST['user_pass']);
        $useremail = mysql_real_escape_string($_POST['user_email']);
        //$userdate = NOW();
        $userlevel = 0;
        $result = mysqli_query($dbc,"CALL new_user_sp('$username', '$password', '$useremail', 'NOW()', '$userlevel')");
		if(!$result)
		{
			echo "Something went wrong, please try again later";
		}
		else
		{
			echo 'Successfully registered! You can now <a href="signin.php">Sign IN</a> ';
		}		
	}
}	
include 'footer.php';
?>