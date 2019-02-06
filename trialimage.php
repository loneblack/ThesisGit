<?php
include();

if(isset($_POST['submit']))
{
    $name=$_POST['name'];
    $image=$_FILES['image']['name'];
    
    $insert = "INSERT INTO VALUES ('NULL', '$name', '$img')";
    if(mysql_query($insert))
    {
        move_uploaded_file($_FILES['image']['tmp_name'], "ThesisGit/requests/$img");
        echo "<script>alert ('Image has been uploaded')</script>"
    }
    
    else{
        echo "<script>alert('Failed')</script>"
    }
}


?>

<html>
    <body>
        <form>
        <label>Name</label>
        <br>
        <label>Select Image to Upload</label>
        <input type="file" name="image">
        
        <input type="submit" name="submit" value="Upload the Image">
        </form>
    </body>

</html>