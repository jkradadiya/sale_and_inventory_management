<?php
// include_once("header.html");
$Page='Order_view';
include("navigation.php");
include_once("dbs/order.php");

$data=new order();

if(isset($_POST["search"]))
{
    $rows=$data->getbillserchdata($_POST["p_search"]);
}
else
{
    $rows=$data->getbills();
}
if(isset($_POST["view"]))
{
    $_SESSION['view']=$_POST['view'];
    header("location:". domain."view_order_details.php");
}

?>

<body>
<link rel="stylesheet" href="css/view_css.css">
    <div id="masterTable">
    <form action="" method="post">
    <table>
        <tr>
            <td>search orders</td>
            <td>
                <input type="text" name="p_search" id="p_search">
            </td>
            <td>
                <button name="search" value="search" id="search"> search</button>
            </td>
        </tr>
        <tr>
            <table border="1">
            <tr>
                    <th>bill ID</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>billcollector</th>
                    <th>Order date</th>
                    <th>total payment</th>
                    <th>action</th>
                </tr>
                <?php
                if($rows!="Some_error")
                {
                    foreach($rows as $key) {
                ?>
                
                <tr>
                <form method="post">
                    <td>&nbsp;&nbsp;<?php echo $key[0]?></td>
                    <td>&nbsp;&nbsp;<?php echo $key[1]?></td>
                    <td>&nbsp;&nbsp;<?php echo $key[2]?></td>
                    <td>&nbsp;&nbsp;<?php echo $key[3]?></td>
                    <td>&nbsp;&nbsp;<?php echo $key[4]?></td>
                    <td>&nbsp;&nbsp;<?php echo $key[5]?></td>
                    <td>
                        <!-- <a href="edit_employee.php"><button id="edit">edit</button></a> -->
                        <button id="view" name="view"  value="<?php echo $key[0];?>" >view</button>
                        <!-- <a href="#"><button id="delete">delete</button></a></td> -->
                        </form>
                </tr>
                
                <?php    }
                 }
                 else
                 {?>
                     <span id="error">no <?php echo "NO PRODUCT INSERTED";?></span>
                 <?php 
                 }
                 
                ?>
            </table>
        </tr>
    </table>
    </form>
</div>
</body>