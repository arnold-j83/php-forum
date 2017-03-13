<?php
include 'code/connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
}
else
{
	if(!isset($_SESSION['user_name']))
	{
	    //the user is not signed in
	    echo 'Sorry, you have to be <a href="/forum/signin.php">signed in</a> to post a comment.';
	}

	else
	{
		//create_comment_sp
		$topic_id = mysql_real_escape_string($_GET['id']);
		$user_id = mysql_real_escape_string($_SESSION['user_id']);
		$reply_content = mysql_real_escape_string($_POST['reply-content']);

		echo $reply_content . " " . $topic_id . " " . $user_id;
		$result = mysqli_query($dbc,"CALL create_comment_sp('$reply_content', '$topic_id', '$user_id')");
		if(!$result)
		{
			echo "There was a Problem, Please Try Again Later!";
		}
		else
		{
			echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
		}	
	}	
}
?>


<?php
include 'footer.php';
?>