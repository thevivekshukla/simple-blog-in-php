<?php

include('includes/session.php');

if (!isset($admin_id) && !isset($admin_username))
	header('location: admin_login.php');

//including connection variables
include('includes/convars.php');
$dbc = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error());

//checking if post or draft is set
if (isset($_POST['post']))
{
	$table_name = 'blog_post';
} else if (isset($_POST['draft'])) {
	$table_name = 'blog_draft';
}

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

//performing subsequent process after post or draft is set
if (isset($table_name) && $table_name !== '')
{
	$title = validate($_POST['post_title'], 'Title');
	$content = validate($_POST['post_content'], 'Main content');
	if (strlen($content) < 350)
		$errors[] = 'Content should be at least 350 characters long';
	$tag = validate($_POST['post_tag'], 'Post tag');
	$description = validate($_POST['post_description'], 'Description');

	//saving post into database
	if (empty($errors) || $table_name === 'blog_draft')
	{
		$query = "INSERT INTO $table_name(post_title, post_content, post_description, post_tag) VALUES('$title', '$content', '$tag', '$description')";

		$result = mysqli_query($dbc, $query);
		mysqli_close($dbc);

		if ($result)
		{
			if ($table_name === 'blog_post')
				echo '<p class="alert alert-success">Post has been sent to the blog.</p>';
			else if ($table_name === 'blog_draft')
				echo '<p class="alert alert-info">Post has been saved as draft.</p>';

			$title = '';
			$content = '';
			$description = '';
			$tag = '';
		}
		else
		{
			echo '<p class="alert alert-danger">Sorry some error has occured. Post is not saved.</p>';
		}
	}

	//showing error if any
	if(!empty($errors) && $table_name !== 'blog_draft')
	{
		echo '<p class="alert alert-danger">';
		foreach ($errors as $error)
			echo $error .'<br/>';
		echo '</p>';
	}	
	
}

?>


<!DOCTYPE>
<html>

<head>
<title>Add new post</title>

<?php include('includes/bootstrap.php'); ?>

</head>

<body>
<div class="bottom">

<div class="row">

<div class="col-md-10">
<div class="page-header bottom">
<h1>Add new post</h1>
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
<input type="submit" class="btn btn-success" name="post" id="post" value="Post"/>
<input type="submit" class="btn btn-warning" name="draft" id="draft" value="Save as Draft"/>
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
</div>
</body>

</html>