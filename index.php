<!-----------------Start DB Connection----------------------->
<?php
$db_host="localhost";
$db_user="root";
$db_pass="";
$db_name="todolist";
$conn=mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(!$conn)
{
    die("connection Failed");
}
?>

<!-----------------End DB Connection------------------------->

<!-------------------Start Data Insert Code------------------->
<?php
if(isset($_REQUEST['rAdd']))
{
    if(($_REQUEST['rTitle']==""))
    {
        $msg='<div class="alert alert-warning mt-3 text-center">Please Fill All The Fields</div>';
    }
    else
    {
        $rTitle=$_REQUEST['rTitle'];
    }
    $sql="INSERT INTO usertodolist(rTitle) VALUES ('$rTitle')";
    if(mysqli_query($conn,$sql))
    {
        $msg='<div class="alert alert-success mt-3 text-center">To-Do-List Added Successfully</div>';
    }
    else
    {
        $msg='<div class="alert alert-warning mt-3 text-center">Unable To Add To-Do-List</div>';
    }
}
?>
<!-------------------End Data Insert Code--------------------->

<!---------------------Start to-do-list form--------------------> 
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

   <title>ToDoList.com</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
   <div class="container">
       <div class="row">
           <div class="col-md-6">
              <?php
               if(isset($_REQUEST['Edit']))
               {
                   $Srno=$_REQUEST['Srno'];
                   $sql="SELECT *FROM usertodolist WHERE Srno='".$Srno."'";
                   $result=mysqli_query($conn,$sql);
                   $row=mysqli_fetch_assoc($result);
                   
               }
               ?>
               
               <form action="" method="POST" class="shadow-lg p-5">
                   <h5 class="text-success">Welcome To ToDoList.com</h5>
                   <br/>
                   <br/>
                   <div class="form-group">
                      <i class="fa fa-list-ul text-success" aria-hidden="true"></i>
                       <label for="Title">Title</label>
                       <input type="text" placeholder="Write Your Title Here" name="rTitle" class="form-control"
                       value="<?php if(isset($row['rTitle'])) {echo $row['rTitle'];} ?>">
                   </div>
                   <br/>
                
                   <input type="submit" value="Add" name="rAdd" class="btn btn-success">
                   <input type="hidden" name="Srno" value="<?php if(isset($row['Srno'])) 
                   {echo $row['Srno'];} ?>">
                   <input type="submit" value="Update" name="Update" class="btn btn-success">
                   <?php if(isset($msg)) {echo $msg;} ?>
               </form>
           </div>
       </div>
   </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>
<!---------------------End To-do-list form------------------->
<br/>
<br/>
<br/>
<!-------------------Start PHP Code for data fetching------------->
<div class="container-fluid" style="margin-top:60px;">
<div class="row">
<div class="col-md-6 offset-sm-3 mb-4">
<?php
$sql="SELECT *FROM usertodolist";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    echo '<table>';
    echo "<tr>";
    echo "<thead>";
    echo "<th>Title</th>";
    echo "<th>Mark As Done</th>";
    echo "<th>Edit</th>";
    echo "</thead>";
    echo "</tr>";
    echo "<tbody>";
    while($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";
        echo "<td>".$row['rTitle']."</td>";
        echo '<td><form action="" method="POST">
        <input type="hidden" name="Srno" value='.$row['Srno'].'>
        <input type="submit" value="Mark As Done" name="rMark">
        </td></form>';
        
        echo '<td><form action="" method="POST">
        <input type="hidden" name="Srno" value='.$row['Srno'].'>
        <input type="submit" value="Edit" name="Edit">
        </td></form>';
        
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
else
{
    echo '<div class="alert alert-warning mt-3 text-center">To-Do Items Not Found</div>';
}
?>
    </div>
    </div>
</div>
<!-------------------End PHP Code for data fetching--------------->

<!------------------Start PHP Code for mark as done button------------>
<?php
if(isset($_REQUEST['rMark']))
{
    $Srno=$_REQUEST['Srno'];
    $sql="DELETE FROM usertodolist WHERE Srno='".$Srno."'";
    if(mysqli_query($conn,$sql))
    {
        echo '<div class="alert alert-success mt-3 text-center">Marked As Done</div>';
    }
    else
    {
        echo '<div class="alert alert-warning mt-3 text-center">Unable To Mark As Done</div>';
    }
}
?>
<!-----------------End PHP Code for mark as done button---------------->

<!-----------------Start PHP Code for Update button-------------------->
<?php
if(isset($_REQUEST['Update']))
{
    if(($_REQUEST['rTitle']==""))
    {
        echo '<div class="alert alert-warning mt-3 text-center">Please Fill All The Fields</div>';
    }
    else
    {
        $Srno=$_REQUEST['Srno'];
        $rTitle=$_REQUEST['rTitle'];
        $sql="UPDATE usertodolist SET rTitle='$rTitle' WHERE Srno='".$Srno."'";
        if(mysqli_query($conn,$sql))
        {
            echo '<div class="alert alert-success mt-3 text-center">Data Updated Successfully</div>';
        }
        else
        {
            echo '<div class="alert alert-warning mt-3 text-center">Unable To Update Data</div>';
        }
    }
}
?>
<!-----------------End PHP Code for Update button---------------------->