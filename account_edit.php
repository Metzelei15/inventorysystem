<?php include_once('dbconn.php');
include_once('session_handling.php');?>
<?php include('account_edit_query.php')?>
<html>
<head>
    <title>Create New Account</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="inventory_style_sheet.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo">Logo</div>
        <ul>
            <li><a href="../inventorysystem/adminhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <div class="main-content-container">
    <div class="main-content">
    <h2 class="form-header">Create New Account</h2>

    <form action="account_edit_formhandler.php" method="POST">
        <input type="hidden" name="INTaccntid" value="<?= $INTaccntid; ?>">

        <div class="form-group">
            <label for="STRusername">Username</label>
            <input type="text" name="STRusername" value="<?= $result1->STRusername; ?>" required><br>
        </div>

        <div class="form-group">
            <label for="STRpassword">Password</label>
            <input type="password" name="STRpassword" value="<?= $result1->STRpassword; ?>" required><br>
        </div>

        <div class="form-group">
            <label for="STRfirstname">Firstname</label>
            <input type="test" name="STRfirstname" value="<?= $result1->STRfirstname; ?>" required><br>
        </div>

        <div class="form-group">
            <label for="STRlastname">Lastname</label>
            <input type="text" name="STRlastname" value="<?= $result1->STRlastname; ?>" required><br>
        </div>

        <button class="submitjm" type="submit">Submit</button>
    </form>
</div>
</div>
</body>
</html>