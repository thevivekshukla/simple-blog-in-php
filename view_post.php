<?php

include('includes/session.php');

if (!isset($admin_username) && !isset($admin_id))
	header("location: admin_login.php");

include('includes/convars.php');
$dbc = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error());

//for pagination
$num_of_posts = 5;
$initial_col = 0;
if (isset($_GET['p']))
	$p = mysqli_real_escape_string($dbc, trim($_GET['p']));
else
	$p = 1;
$initial_col = ($p * $num_of_posts) - $num_of_posts;

function pagination($category)
{
	global $dbc, $num_of_posts, $p;
	//counting num of posts
	$query = "SELECT COUNT(post_id) AS num_rows FROM $category";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_object($result);
	$count = $row->num_rows;
	
	//calculating num of tabs required
	$tabs = ceil($count / $num_of_posts);

	if ($tabs > 1)
	{
		echo '<ul class="pagination">';
		for ($i=1; $i<=$tabs; $i++)
		{
			echo '<li';
			if ($p == $i)
				echo ' class="active"';
			echo '><a href="view_post.php?';
			if ($category === 'blog_draft')
				echo 'draft=true&amp;';
			echo 'p='.$i.'">'.$i.'</a></li>';
		}
		echo '</ul>';
	}
}
?>

<!DOCTYPE>
<html>

<head>
<title>Posts - MyBlog</title>

<?php include('includes/bootstrap.php'); ?>

</head>

<body class="fluid-container bottom">

<div class="row">

<div class="col-md-10">
<div class="page-header bottom">
<h1>All Posts</h1>
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

<ul class="nav nav-tabs">
<li <?php if(!isset($_GET['draft'])) echo 'class="active"'; ?>><a href="view_post.php">Blog posts</a></li>
<li <?php if(isset($_GET['draft'])) echo 'class="active"'; ?>><a href="view_post.php?draft=true">Draft</a></li>
</ul>

<?php

if (!isset($_GET['draft']))
{
	//code for blog post nav
	$query = "SELECT post_id, post_title, post_date FROM blog_post LIMIT $initial_col, $num_of_posts";
	$result = mysqli_query($dbc, $query);

	$counter = 1; //serial no for posts
	echo '<table class="table table-striped">';
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '<tr>';
		echo '<td>'. $counter .'</td>';
		echo '<td><p><a href="edit_post.php?pid='.$row['post_id'].'">'. $row['post_title'] .'</a></p></td>';
		echo '<td>'. $row['post_date'] .'</td>';
		echo '</tr>';
		$counter++;
	}
	echo '</table>';
	pagination('blog_post');
	mysqli_close($dbc);
	
}
else if (isset($_GET['draft']) && mysqli_real_escape_string($dbc, trim($_GET['draft'])) === 'true')
{
	//code for draft nav
	$query = "SELECT post_id, post_title, post_date FROM blog_draft LIMIT $initial_col, $num_of_posts";
	$result = mysqli_query($dbc, $query);

	$counter = 1; //serial no for posts
	echo '<table class="table table-striped">';
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '<tr>';
		echo '<td>'. $counter .'</td>';
		echo '<td><p><a href="edit_post.php?did='.$row['post_id'].'">'. $row['post_title'] .'</a></p></td>';
		echo '<td>'. $row['post_date'] .'</td>';
		echo '</tr>';
		$counter++;
	}
	echo '</table>';
	
	pagination('blog_draft');
	mysqli_close($dbc);
}

?>

</body>
</html>