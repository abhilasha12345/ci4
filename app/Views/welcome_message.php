<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<style>
.form-check{
	padding-left:0px;
}
</style>

<div class="container mt-3">
<div class="col-md-7">
  <h2>Stacked form</h2>
  <form action="/action_page.php">
    
	<div class="mb-3 mt-3">
      <label for="first_name">First Name:</label>
      <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
    </div>
	<div class="mb-3">
      <label for="last_name">Last Name:</label>
      <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
    </div>
	<div class="mb-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" >
    </div>	
    <div class="mb-3">
      <label for="dob">DOB:</label>
      <input type="text" class="form-control" id="dob" name="dob" placeholder="Enter dob" >
    </div>
	<div class="form-check mb-3">
		<label for="gender" style="width:150px;">Gender:</label>
       <label class="form-check-label" style="width:150px;">
        <input class="form-check-input" type="checkbox" name="gender"> Male
       </label>
	   <label class="form-check-label" style="width:150px;">
        <input class="form-check-input" type="checkbox" name="gender"> Female
       </label>	  
    </div>
	<div class="mb-3">
      <label for="profile_pic">Profile Pic:</label>
      <input type="file" class="form-control" id="profile_pic" name="profile_pic" placeholder="Enter profile pic" >
    </div>
	

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div>
</div>

</body>
</html>
