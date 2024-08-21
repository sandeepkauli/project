
<?php 
// session_start();
$id=$_SESSION['user_id'];
include 'config.php'; ?>
<?php

// $qry= "SELECT * FROM poll_answer WHERE user_id='$id'";

//  $apply= mysqli_query($conn,$qry);
//  if($apply){

$sql= "SELECT * FROM polls";

 $result= mysqli_query($conn,$sql);

 if($result){
  $data=mysqli_fetch_array($result);

 
  ?>

    <!-- Main content -->
    <section class="content">

     
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th>
                         Poll Id
                      </th>
                      <th>
                         Questions
                      </th>
                      <th>
                       Photo
                      </th>
                      <th>
                      Privacy
                      </th>
                      <th>
                      Answers
                      </th>
                     
                    
                  </tr>
              </thead>
              <tbody>
                <?php foreach($result as $row){ 
                    $ans= $row['id'];
                    
                    
$qry= "SELECT * FROM poll_answer WHERE poll_id='$ans'";

 $apply= mysqli_query($conn,$qry);
 if($apply){?> 
                  <tr>
                      <td>
                          #
                      </td>
                      <td>
                        
                             <?php echo  $row['id']; ?>
                          
                        
                      </td>
                      <td>
                          <ul class="list-inline">
                          <?php echo  $row['questions']; ?>

                      </td>
                      <td class="project_progress">
                          
                          <img width='120' height='100' src='<?php echo BASE_URL.'dist/img/'.$row['photo']; ?>'>
                            
                        
                          
                      </td>
                      <td class="project-state">
                      <?php echo  $row['privacy']; ?>

                      </td>
                      <td class="project-state">
                        <?php

                        $str = null;
                         foreach($apply as $row1){
                            if($str){
                            $str.=','.ucfirst($row1['answer']);  // multiple answer vichkar , lgana hove
                        }else{
                            $str=ucfirst($row1['answer']);

                        }
                        }
                        echo $str;
                    ?>

                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="edit.php?id=<?php echo $row['id']; ?>">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                      </td>
                  </tr>
                
                 
                  </tr>
                  <?php }} ?>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php 


}else{
  echo "Error";
 }
?>
  