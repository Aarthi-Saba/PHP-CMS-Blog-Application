<form action="" method="post">
    <div class="form-group">
       <label for="category_title">Edit Category</label>
       <?php
        if(isset($_GET['edit']))
        {
            $editid = Escape($_GET['edit']);
            $editquery = "SELECT * FROM CATEGORY WHERE CategoryId=$editid";
            $updatedrows = mysqli_query($sqlconnection,$editquery);
            while($row = mysqli_fetch_assoc($updatedrows))
            {
                $editid = $row['CategoryId'];
                $edittitle = $row['CategoryTitle'];
                ?>
                <input class="form-control" type="text" name="category_title" 
                value="<?php if(isset($edittitle)){ echo $edittitle;} ?>">
           <?php }

        }
       ?>
       <?php
        if(isset($_POST['update_category']))
        {
            $updatetitle = Escape($_POST['category_title']);
            $updatequery = "UPDATE CATEGORY SET CategoryTitle='$updatetitle' WHERE CategoryId = $editid";
            $updated = mysqli_query($sqlconnection,$updatequery);
            if($updated){
                echo "Category Updated";
                header("Location: Categories.php");
                exit;
            }
            else{
                die("Update query failed".mysqli_error($sqlconnection));
            }                                    
        }
        ?>                               
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>                        