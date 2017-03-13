<?php
//signin.php
include 'code/connect.php';
include 'header.php';
 
echo '<h2>Create Topic</h2>';
if(isset($_GET['cat_id']))
{
	$cat_id = $_GET['cat_id'];
}
if(!isset($_SESSION['user_name']))
{
    //the user is not signed in
    echo 'Sorry, you have to be <a href="/forum/signin.php">signed in</a> to create a topic.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
    	$result = mysqli_query($dbc,"CALL categories_sp()");         
		$row_count = $result->num_rows; 
		if(!$result)
		{
		    echo 'The categories could not be displayed, please try again later.';
		}
		else
		{
		    if($row_count == 0)
		    {
		        echo 'No categories defined yet.';
		    }
		    else
		    {
		    	echo '<form action="" method="POST">
		    	Subject: <input type="text" name="topic_subject" class="form-control" /><br>
		    	Category:'; 
                echo '<select name="topic_cat" class="form-control">';
                echo '<option value=""></option>';
                while($row = mysqli_fetch_array($result))
        		{
        			$selected = "";
        			if($cat_id == $row['cat_id'])
        			{
        				$selected = "selected";
        			}
        			echo '<option value="'. $row['cat_id'] .'"' .$selected . '>' . $row['cat_name'] . '</option>';
        		}	
        		echo "</select><br>";
        		$dbc->next_result();
        		echo '<input type="submit" value="Create Topic" class="btn btn-primary">';
		    }
		}
	}

	else
	{
		$topic_subject = mysql_real_escape_string($_POST['topic_subject']);
		$topic_cat = mysql_real_escape_string($_POST['topic_cat']);
		$user_id = $_SESSION['user_id'];
		$result = mysqli_query($dbc,"CALL create_topic_sp('$topic_subject', '$topic_cat', '$user_id')");
		if(!$result)
		{
			echo "There was a Problem, Please Try Again Later!";
		}	
		else
		{
			$dbc->next_result();
			$result = mysqli_query($dbc,"CALL last_topic_sp('$topic_subject', '$topic_cat', '$user_id')");
			$topic_id = 0;
			if(!$result)
			{
				echo "There was a Problem, Please Try Again Later!";
				$topic_id=0;
			}
			else
			{
				$row_count = $result->num_rows; 
				if($row_count > 0)
				{
					while($row = mysqli_fetch_array($result))
        			{
        				$topic_id = $row['topic_id'];	
        			}	
				}
			}	


			echo 'You have successfully created topic <a href="topic.php?id=' . $topic_id . '">' . $topic_subject . '</a>';
		}	
	}		
}	
include 'footer.php';
?>