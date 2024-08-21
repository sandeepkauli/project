<?php  
session_start();
include('config.php');
$user_id=$_SESSION['user_id'];
  
  if(isset($_POST['submit'])){
    // print_r($_POST);die('hello');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $exp = $_POST['exp'];
    $skills = $_POST['skills'];
    

    $query="UPDATE user SET name='$name', email='$email', experience='$exp', skiils='$skills' WHERE id=$user_id";
    $run= mysqli_query($conn,$query);
    if($run){
      
      echo "data update ";
    }else{
      echo "Update Failed";
    }
  }

  $user_id=$_SESSION['user_id'];
  
  if(isset($_POST['add'])){
    // print_r($_FILES);die('hello22');


      $errors  = array();
      $maxsize  = 2097152;
      $acceptable = array(
          'application/pdf',
          'image/jpeg',
          'image/jpg',
          'image/gif',
          'image/png'
      );
  
      // $img="";

        $image = $_FILES['image']['name'];
        $path="dist/img/" . $image;
        $tmpname=$_FILES['image']['tmp_name'];
        
      if(($_FILES['image']['size'] >= $maxsize) || ($_FILES["image"]["size"] == 0)) {
        $errors[] = 'File too large. File must be less than 2 megabytes.';
    }

    if((!in_array($_FILES['image']['type'], $acceptable)) && (!empty($_FILES["image"]["type"]))) {
        $errors[] = 'Invalid file type. Only PDF, JPG, GIF and PNG types are accepted.';
    }

    if(count($errors) === 0) {
          $isuploaded=move_uploaded_file($tmpname,$path);

            $query1="UPDATE user SET photo='$image' WHERE id=$user_id";
            $run1= mysqli_query($conn,$query1);
            if($run1){
              
              echo "image update ";
            }else{
              echo "Update Failed";
            }
      }else{
        // print_r($errors);die();
     echo " * please check file size Or Extension ";
    }
    
  }
  
  // else{
  
  // }

 include('header.php'); ?>
<?php   include('sidebar.php'); ?>


<?php 
if(isset($_SESSION['user_id'])){

}else{
  
  header("location:login.php");
}


$sql="SELECT * FROM user where id=$user_id";
$result= mysqli_query($conn,$sql);
if($result==true){
  $data=$result->fetch_assoc();

?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->

            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
               
                <div class="text-center">
                  <?php
                  if(!empty($data['photo'])){
                    ?>
                     <img class="profile-user-img img-fluid img-circle"
                       src="dist/img/<?php echo $data['photo']; ?>"
                       alt="User profile picture">
                    <?php
                  }else{
                  ?>
                  <img class="profile-user-img img-fluid img-circle"
                       src="./dist/img/user4-128x128.jpg"
                       alt="User profile picture">
                       <?php }?>
                </div>

                <h3 class="profile-username text-center"><?php echo $data['name']; ?>
                </h3>
                <form method="post" enctype="multipart/form-data">
                <input type="file" class="form-control" name="image">
                <button type="submit" class="form-control btn-primary" name="add">Add</button>
                
              <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Edit</button> -->
              </form>

              

             
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Experience</strong>

                <p class="text-muted">
                  <p> <?php echo $data['experience']; ?></p>
                </p>

               

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p> <?php echo $data['skiils']; ?></p>


                <hr>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#settings" >Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div style="padding-left:20px;"class="tab-pane" id="settings">

                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                        <input type="hidden" class="form-control" name="id" id="inputName" value="<?php echo $data['id']; ?>" >

                          <input type="text" class="form-control"  name="name" id="inputName" value="<?php echo $data['name']; ?>" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" id="inputEmail" value="<?php echo $data['email']; ?>"  placeholder="Email">
                        </div>
                      </div>
                     
                      <div class="form-group row">
                        <label for="inputExperience"  class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="exp" id="inputExperience" value="<?php echo $data['experience']; ?>" placeholder="Experience">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills"  class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="skills" id="inputSkills" value="<?php echo $data['skiils']; ?>" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                    <?php } ?>
                  </div>
              <div class="card-body">
                <div class="tab-content">
                  
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
      <div class="modal-footer">
        <!-- <form method="post" enctype="mulipart/form-data"> -->
       
          <input type="file" name="image">
          <button type="submit"  name="add" class="btn btn-default">Add</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
  
</div>



  <?php   include('footer.php'); ?>

