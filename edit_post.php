<?php

include('includes/session.php');

if (!isset($admin_id) && !isset($admin_username))
	header('location: admin_login.php');

//including connection variables
include('includes/convars.php');
$dbc = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error());




//----------------------------------------------------------------------------
//retriving data from database
if (isset($_GET['pid']) && is_numeric($_GET['pid']))
{
	$pid = mysqli_real_escape_string($dbc, trim($_GET['pid']));
	$_GET = array();
}
else if (isset($_GET['did']) && is_numeric($_GET['did']))
{
	$did = mysqli_real_escape_string($dbc, trim($_GET['did']));
	$_GET = array();
}

if (isset($pid))
	$ret_query = "SELECT * FROM blog_post WHERE post_id = $pid";
else if (isset($did))
	$ret_query = "SELECT * FROM blog_draft WHERE post_id = $did";

if (isset($ret_query))
{
	$ret_result = mysqli_query($dbc, $ret_query);
	$row = mysqli_fetch_array($ret_result, MYSQLI_ASSOC);
	$title = $row['post_title'];
	$content = $row['post_content'];
	$description = $row['post_description'];
	$tag = $row['post_tag'];
}
//----------------------------------------------------------------------------




//initializing errors array
$errors = array();




//function for filtering data
function validate($data, $name)
{
	global $errors, $dbc;

	if (isset($data) && $data != '')
		return mysqli_real_escape_string($dbc, trim($data));
	else
		$errors[] = '<b>'. $name .' cannot be empty.';
}




//when any of POST button is clicked
if (isset($_POST['update_post']) || isset($_POST['update_draft']))
{
	if (isset ($_POST['update_draft']))
		$table_name = 'blog_draft';
	else if (isset($_POST['update_post']))
		$table_name = 'blog_post';

	$id = trim($_POST['post_id']);
	$title = validate($_POST['post_title'], 'Title');
	$content = validate($_POST['post_content'], 'Main content');
	$description = validate($_POST['post_description'], 'Description');
	$tag = validate($_POST['post_tag'], 'Tag');

	if (empty($errors))
	{
		$query = "UPDATE $table_name SET post_title='$title', post_content='$content', post_description='$description', post_tag='$tag' WHERE post_id=$id";
		$result = mysqli_query($dbc, $query) or die(mysqli_error());
		if ($result)
		{
			echo '<p class="alert alert-success">Post has been updated.</p>';
			$title = '';
			$content = '';
			$description = '';
			$tag = '';
			$id = '';
			$success = true;	//for changing page title and heading
		}
		else
			echo '<p class="alert alert-danger">Post cannot be updated. Some error has occured.</p>';
	}


}//end of update post and update draft
else if (isset($_POST['move_draft']) || isset($_POST['move_post']))
{
	if (isset($_POST['move_draft']))
	{
		$master_table = 'blog_post';
		$slave_table = 'blog_draft';
	}
	else if (isset($_POST['move_post']))
	{
		$master_table = 'blog_draft';
		$slave_table = 'blog_post';
	}


	$id = trim($_POST['post_id']);
	$title = validate($_POST['post_title'], 'Title');
	$content = validate($_POST['post_content'], 'Main content');
	$description = validate($_POST['post_description'], 'Description');
	$tag = validate($_POST['post_tag'], 'Tag');


	if (empty($errors))
	{


		$query = "INSERT INTO $slave_table(post_title, post_content, post_description, post_tag) VALUES('$title', '$content', '$description', '$tag')";
		$result = mysqli_query($dbc, $query) or die(mysqli_error());
		if ($result)
		{
			$del_query = "DELETE FROM $master_table WHERE post_id=$id";
			$res = mysqli_query($dbc, $del_query) or die(mysqli_error());
			if ($res)
			{
				echo '<p class="alert alert-success">Success!</p>';
				$id = 0;
				$title = '';
				$content = '';
				$description = '';
				$tag = '';
				$success = true;
			}

		}
		else
			$errors[] = 'Some error has occured.';

	}
	else
		$did = $_POST['post_id'];

}

if (!empty($errors))
{
	foreach ($errors as $error)
		echo '<p class="alert alert-danger">'. $error .'</p>';
}
?>


<!DOCTYPE>
<html>

<head>
<title><?php if(!isset($success)) echo 'Edit post'; else echo 'Add new Post'; ?></title>

<?php include('includes/bootstrap.php'); ?>

</head>

<body class="bottom">

<div class="row">

<div class="col-md-10">
<div class="page-header bottom">
<h1><?php if(!isset($success)) echo 'Edit post'; else echo 'Add new Post'; ?></h1>
</div>
</div>
<div class="col-md-2">
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Menu <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="add_post.php">Add new post</a></li>
    <li><a href="view_post.php">View post</a></li>
    <li><a href="index.php" target="_blank">View Blog</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>
</div>

</div>

<!--post form here-->
<form action="<?php if(!isset($success)) echo $_SERVER['PHP_SELF']; else echo 'add_post.php'; ?>" method="POST">
<div class="row">

<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">
<div class="form-group">
<label for="post_title">Title:</label>
<input type="text" class="form-control" name="post_title" id="post_title" value="<?php if(isset($title)) echo $title; ?>"/>
</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xm-12">
<br/>
<div class="form-group">
<?php
if (isset($pid))
{
	echo '<input type="hidden" name="post_id" id="post_id" value="'. $pid .'" />';
	echo '<input type="submit" class="btn btn-success" name="update_post" id="update_post" value="Update"/>';
	echo ' ';
	echo '<input type="submit" class="btn btn-warning" name="move_draft" id="move_draft" value="Move to Draft"/>';
}
else if (isset($did) || isset($did2))
{
	echo '<input type="hidden" name="post_id" id="post_id" value="'. $did .'" />';
	echo '<input type="submit" class="btn btn-success" name="move_post" id="move_post" value="Post on blog"/>';
	echo ' ';
	echo '<input type="submit" class="btn btn-warning" name="update_draft" id="update_draft" value="Update Draft"/>';
}
else if (isset($success) && $success===true)
{
	echo '<input type="submit" class="btn btn-success" name="post" id="post" value="Post"/>';
	echo ' ';
	echo '<input type="submit" class="btn btn-warning" name="draft" id="draft" value="Save as Draft"/>';
}
?>
</div>
</div>


</div>

<div class="row">
<div class="col-lg-8 col-md-8 col-sm-12 col-xm-12">
<div class="form-group">
<label for="post_content">Content:</label>
<textarea class="form-control" name="post_content" id="post_content" rows="20"><?php if(isset($content)) echo $content; ?></textarea>
</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">
<div class="form-group">
<label for="post_tag">Tags: </label>
<textarea type="text" class="form-control" name="post_tag" id="post_tag" rows="3"><?php if(isset($tag)) echo $tag; ?></textarea>
</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">
<div class="form-group">
<label for="post_description">Description: </label>
<textarea type="text" class="form-control" name="post_description" id="post_description" rows="8"><?php if(isset($description)) echo $description; ?></textarea>
</div>
</div>

</div> <!--for second row -->

</div>	<!--for bottom class -->
</form>
</body>

</html>