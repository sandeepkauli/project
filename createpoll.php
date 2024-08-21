<?php 
session_start();
include 'config.php';
include 'header.php';
include 'sidebar.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) 
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

    foreach ($_FILES['image']['name'] as $key => $value)
     {
        $fileType = $_FILES['image']['type'][$key];
        $fileSize = $_FILES['image']['size'][$key];
        $fileName = basename($_FILES['image']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;
        $tmpName = $_FILES['image']['tmp_name'][$key];
        
        // Validate file size
        if ($fileSize > $maxsize || $fileSize == 0) 
        {
            $errors[] = "File '$fileName' is too large or empty. File must be less than 2 megabytes.";
            continue;
        }

        // Validate file type
        if (!in_array($fileType, $acceptable))
         {
            $errors[] = "File '$fileName' is of invalid type. Only PDF, JPG, GIF, and PNG types are accepted.";
            continue;
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmpName, $targetFilePath))
         {
            $uploadedFiles[] = $fileName;
        } else {
            $errors[] = "Error uploading file '$fileName'.";
        }
    }

    // Check if there are no errors before proceeding with database operations
    if (empty($errors))
     {
        $pvotes = isset($_POST['public_votes']) ? $_POST['public_votes'] : 0;
        $mvotes = isset($_POST['multiple']) ? $_POST['multiple'] : 0;
        $ctime = $_POST['set_close_time'];
        $privacy = $_POST['privacy'];

        // Insert poll data
        $sql = "INSERT INTO polls (questions, description,photo, public_votes, multiple_choice, close_time, privacy) 
                VALUES ('$question', '$desc','$photo', '$pvotes', '$mvotes', '$ctime', '$privacy')";
        $result = mysqli_query($conn, $sql);
        $poll_id = mysqli_insert_id($conn);   // last id poll id hovegi

        // Insert answers
        foreach ($answer as $ans) {
            $sql = "INSERT INTO poll_answer (poll_id, user_id, answer) 
                    VALUES ('$poll_id', '$user_id', '$ans')";
            mysqli_query($conn, $sql);
        }

        // Insert file attachments
        foreach ($uploadedFiles as $file) {
            $sql = "INSERT INTO poll_attachment (poll_id, user_id, file_name) 
                    VALUES ('$poll_id', '$user_id', '$file')";
            mysqli_query($conn, $sql);
        }

        if ($result) {
            echo "Data inserted successfully";
        } else {
            echo "Something went wrong.";
        }
    } else {
        // Output errors if any
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
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
                  <h3 class="card-title">Create Poll</h3>
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
                  <input type="text" class="form-control" name="question" id="e" placeholder="">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Description</label>
                  <textarea class="form-control" name="description" id="exampleInputPassword1" row="4" cols="4"
                    placeholder=""></textarea>
                </div>
                <div class="form-group">
                  <label>Answers</label>
                  <div id="answers">
                    <div class="input-group mb-3 add-remove">
                      <input type="text" class="form-control" id="answer[]" name="answer[]" required>
                      <div>
                        <button class="btn remove-answer btn-danger" type="button">Remove</button>
                        <button type="button" class="btn btn-primary  btn-theme" id="add-answer">Add Answer</button>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="input-group mt-2">
                  <div class="custom-file">
                    <label class="custom-file-label" for="exampleInputFile">Photo</label>

                    <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                    <!--<button class="btn remove-answer" type="button">Remove</button> -->
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
              <input type="datetime-local" class="form-control" id="set_close_time" name="set_close_time" value=""
                required>
            </div>
            <div class="form-group">
              <label for="privacy">Privacy</label>
              <select class="form-control" id="privacy" name="privacy">
                <option value="public">Public</option>
                <option value="private">Private</option>
              </select>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <input type="submit" name="submit" value="Submit" class="btn btn-primary">
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