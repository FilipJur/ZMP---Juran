<head>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<?php
	$title = "Sekce Administrátora";
?>
<div class="container">
	<div class="row mt-2">
		<div class="col-5-right">
			<form class="form-horizontal" method="post" action="admin_verify.php">
				<div class="mb-2">
					<label for="adminlogin" class="control-label col-md-4">Login</label>
					<div class="col-md-4">
						<input type="text" name="adminlogin" class="form-control">
					</div>
				</div>
				<div class="mb-2">
					<label for="adminheslo" class="control-label col-md-4">Heslo</label>
					<div class="col-md-4">
						<input type="password" name="adminheslo" class="form-control">
					</div>
				</div>
				<input type="submit" name="submit" class="btn btn-primary">
			</form>
		</div>
	</div>
</div>
        



<?php
	require_once "footer.php";
	echo '<a id="footer-right" href="index.php?section=catalog">Home Page</a>'
?>