<!DOCTYPE html>
<html>
<head>
	<title>Staff Dashboard</title>
<style>
	ul {
  	list-style-type: none;
 	margin: 0;
  	padding: 0;
  	width: 10%;
  	background-color: #f1f1f1;
  	position: fixed;
  	height: 100%;
  	overflow: auto;
	}

	li a {
  	display: block;
  	color: #000;
  	padding: 8px 16px;
  	text-decoration: none;
	}

	li a.active {
	  background-color: #04AA6D;
	  color: white;
	}

	li a:hover:not(.active) {
	  background-color: #555;
	  color: white;
	}
</style>
</head>
<body>
	<ul>
		<li>Dashboard</li>
		<li><a href="#product">Product</a></li>
		<li><a href="#material">Material</a></li>
		<li><a href="#report">Report</a></li>
	</ul>
</body>
</html>