<?php
// include_once("header.html");
$Page='Emp';
include("navigation.php");
include_once("dbs/user.php");
include_once("dbs/ftp.php");
$email=$password=$username=$type=$pic="";
$errorEmail=$errorUser=$errorPass=$errorType=$errorfile=$ftpres="";
$i=0;
if(isset($_POST['addEmp'])=="add")
{
    // echo "<pre>";
    // print_r($_POST);
    $email=$_POST["employee_email"];
	if(empty($email))
	{
		$errorEmail="Email is required";
	}
	else
	{
		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			$errorEmail="Invalid email format";
        }
        else
        {
           $i++;
        }
    }
    $username=$_POST["employee_username"];
	if(empty($username))
	{
		$errorUser="Username is required";
	}
	else
	{
        if(strlen($username)>5)
        {
		if(!preg_match("/^[a-zA-z\_]{6,}$/", $username))
		{
			$errorUser="Only alphabets allowed with _";
        }
        else
        {
            $i++;
        }
        }
        else
        {
            $errorUser="user name should be contain 6 character";
        }
    }
    $password=$_POST["emp_password"];
	if(empty($password))
	{
		$errorPass="password is required";
	}
	else
	{
        if(strlen($password)>5)
        {
		if(!preg_match("/^[A-Za-z_0-9]{6,}$/", $password))
		{
			$errorPass="password should be contain capital,small and special character";
        }
        else
        {
            $i++;
        }
        }
        else
        {
            $errorPass="password should be contain 6 character";
        }
    }

    $type=$_POST['employee_type'];
    if(empty($type))
    {
        $errorType="type not seleced";
    }
    else
    {
        if(!filter_var($type,FILTER_VALIDATE_INT))
		{
			$errorType="Invalid email format";
        }
        else
        {
            $i++;
        }   
    }
    $pic=$_FILES["emp_pic"]["tmp_name"];
    if(empty($pic))
    {
        $errorfile="file is not selected";
    }
    else{
        $ftp=new ftp();
        $ftpres=$ftp->putfile($_FILES["emp_pic"]["name"],$pic);
        if($ftpres=="FTP_upload_has_failed!")
        {
            $errorfile="file not uploaded";
        }
        else
        {
            $i++;
        }
    }
    
        if($i==5)
        {
        $user = new user();
        $res= $user->create_member($email,$username,$password,$type,$ftpres);
        if($res == "sucess")
        {header("location:". domain."view_employee.php");
        }
        else if($res == "Email_already_registed")
        {
            $ftp->delpic($_FILES["emp_pic"]["name"]);
            $errorEmail="Email already registed";
        }
        else if($res== "Username_already_registed")
        {
            $ftp->delpic($_FILES["emp_pic"]["name"]);
            $errorUser="Username already registed";
        }
        }
        else
        {
            $ftp->delpic($_FILES["emp_pic"]["name"]);
        }
}

if(isset($_POST["back"]))
{
    header("location:". domain."view_employee.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<div, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/view_css.css">
</head>
<body>
    <div id="masterTable">
    <form  method="post" enctype="multipart/form-data">
        <table>
        <tr>
                <h1>add Employee</h1>
            </tr>
            <tr>
                <td>Employee Email</td>
                <td><input type="email" name="employee_email" id="employee_email" value="<?php echo $email;?>"></td>
                <td><span><?php echo $errorEmail;?></span></td>
            </tr>
            <tr>
                <td>Employee Username</td>
                <td><input type="text" name="employee_username" id="employee_username" value="<?php echo $username;?>"></td>
                <td><span><?php echo $errorUser;?></span></td>
            </tr>
            <tr>
                <td>employee type</td>
                <td>
                    <div class="custom-select">
                    <select name="employee_type" id="employee_type" >
                        <option value="" seleced>select type</option>
                       <option value="1" <?php if($type=1) echo "selected";?>>admin</option>
                       <option value="2" <?php if($type=2) echo "selected";?>>cashier</option>
                       <!-- <option value="3">biller</option> -->
                   </select>
                    </div>
                   
                </td>
                <td><span><?php echo $errorType;?></span></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="emp_password" id="emp_password" value="<?php echo $password;?>" ></td>
                <td><span><?php echo $errorPass;?></span></td>
            </tr>
            <tr>
                <td>picture</td>
                <td><input type="file" name="emp_pic" id="emp_pic" accept="image/*" value="<?php echo $pic;?>" ></td>
                <td><span><?php echo $errorfile;?></span></td>
            </tr>
            <tr>
                <td>
                    <button id="add" name="addEmp" value="add">add</button>
                </td>
                <td>
                    <button name="back" id="back"> back</button>
                </td>
            </tr>
        </table>
        </form>
    </div>
   
</body>
</html>