

<?php 
session_start();
include 'config.php';
include 'header.php';
include 'sidebar.php';

$user_id = $_SESSION['user_id'];

$id= $_GET['id'];



if (isset($_POST['update'])) 
{
   
    $question = $_POST['question'];
    $desc = $_POST['description'];
    $answer = $_POST['answer'];

    

    $photo= $_FILES['photo']['name'];
    $path="dist/img/" . $photo;
    $tmpname= $_FILES['photo']['tmp_name'];
    $isuploded= move_uploaded_file($tmpname,$path);
    
    $errors = array();
    $maxsize = 2097152; // 2 MB
    $acceptable = array
       ('application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
        );

        $targetDir = "dist/img/";
        $uploadedFiles = array();
    
       
        if (empty($errors))
        {
           $pvotes = isset($_POST['public_votes']) ? $_POST['public_votes'] : 0;
           $mvotes = isset($_POST['multiple']) ? $_POST['multiple'] : 0;
           $ctime = $_POST['set_close_time'];
           $privacy = $_POST['privacy'];
   
        $qry="UPDATE polls SET questions='$question',description='$desc',photo='$photo',public_votes='$pvotes',multiple_choice='$mvotes',close_time='$ctime',privacy='$privacy' WHERE id='$id'";
        $run= mysqli_query($conn,$qry);

        $delete="DELETE FROM poll_answer WHERE poll_id=$id";
        $qry=mysqli_query($conn,$delete);
        // if($qry){

        // }

        foreach ($answer as $ans) {
            $sql = "INSERT INTO poll_answer  
                    (poll_id,user_id,answer) VALUES('$id','$user_id','$ans')";
            mysqli_query($conn, $sql);
        }
        if($run){
            echo "update data";
        }else{
            echo "error";
        }
}
}
$sql="SELECT * FROM polls WHERE id= $id ";
$result=mysqli_query($conn,$sql);

if($result){
    $data=$result->fetch_assoc();
}

    // print_r($data1);die;

?>







<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">

            <div class="card-header">
              <ul style="display: flex;
    justify-content: space-between; list-style: none;">

                <li>
                  <h3 class="card-title">Update Poll</h3>
                </li>
                <li><a href="poll.php" class="close-icon">x</i></a></li>
              </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">

              <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail1">Questions</label>
                  <input type="text" class="form-control" value="<?php echo $data['questions']; ?>" name="question" id="e" placeholder="">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Description</label>
                  <textarea class="form-control" name="description" id="exampleInputPassword1" row="4" cols="4"
                    placeholder=""><?php echo $data['description']; ?></textarea></div>
                    <div class="form-group">
                  <label>Answers</label>
                  <div id="answers">
                    <div class="input-group mb-3 add-remove">

                        <?php
                        $sql1="SELECT * FROM poll_answer WHERE poll_id=$id";
                        $result1=mysqli_query($conn,$sql1);
                        
                            // $data1=$result1->fetch_array();
                        ?>
                    <?php foreach($result1 as $dat){ ?>


                      <input type="text" value="<?php echo $dat['answer']; ?>" class="form-control" id="answer[]" name="answer[]" required>
                    <?php } ?>
                      <div>
                        <button class="btn remove-answer btn-danger" type="button">Remove</button>
                        <button type="button" class="btn btn-primary  btn-theme" id="add-answer">Add Answer</button>

                      </div>
                    </div>
                  </div>
                 
                  
             
                <div class="input-group mt-2">
                  <div class="custom-file">
                    <label class="custom-file-label"   for="exampleInputFile">Photo</label>

                    <input type="file" value="<?php echo $data['photo']; ?>"  name="photo" class="custom-file-input" id="exampleInputFile">
                    

                    <!--<button class="btn remove-answer" type="button">Remove</button> -->
                  </div>
                  <div>
                  <img width='80' src='<?php echo BASE_URL.'dist/img/'. $data['photo']; ?>'>
                  </div>
</div>
                  <div class="input-group mt-2">
                  <div class="custom-file">
                    <label class="custom-file-label" for="exampleInputFile">Attach files</label>

                    <input type="file" name="image[]" multiple class="custom-file-input" id="exampleInputFile">
                    <!--<button class="btn remove-answer" type="button">Remove</button> -->
                  </div>


                </div>
                <!-- <div class="input-group-append">

                        <span class="input-group-text">Add</span>
                        <input class="form-control"  type="file" name="image" >
                      </div>
                  </div> -->
                <div class="form-check mt-2">
                  <input type="checkbox" name="public_votes" value="1" class="form-check-input" id="public_votes">
                  <label class="form-check-label" for="public_votes">Public Votes</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" name="multiple" value="2" class="form-check-input" id="multiple">
                  <label class="form-check-label" for="multiple">Multiple Choises</label>
                </div>
            
            <div class="form-group">
    <label for="set_close_time">Set Close Time</label>
    <?php
    // Format the date from the database
    $closeTime = date("Y-m-d\TH:i", strtotime($row['close_time']));
    ?>
    <input type="set_close_time" value="<?php echo htmlspecialchars($closeTime); ?>" class="form-control" id="set_close_time" name="set_close_time">
</div>

            <div class="form-group">
              <label for="privacy">Privacy</label>
              <select class="form-control"   id="privacy" name="privacy">
                <option value="public">Public</option>
                <option value="private">Private</option>
              </select>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <input type="submit" name="update" value="Update" class="btn btn-primary">
            </div>
            </form>
            </div>
          </div>
          <!-- /.card -->


  </section>
  <!-- /.content -->
</div>

</body>

<?php  include 'footer.php'; ?>