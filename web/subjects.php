<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
?>


<main class="main">
     <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Find Your Subjects </h2>
       
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <?php
            extract($_GET);
            $db = dbConn();
            $sql = "SELECT Id as subjectID, Name FROM  subjects";
            $result = $db->query($sql);
            
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-xl-4 col-md-6 d-flex rounded-3" data-aos="fade-up" data-aos-delay="100">
            <div class="col-md-12 service-item position-relative text-center subjimg">
                <!--<img src="" alt=""/>-->
              <!--<i class="bi bi-activity"></i>-->
              <h4><a href="timetable.php?gradeID=<?= $gradeID; ?>&subjectID=<?= $row['subjectID'] ?>" class="stretched-link"><?= $row['Name'] ?></a></h4>
            </div>
               
          </div><!-- End Service Item -->
 <?php
            }
            ?>
          
         

        </div>

      </div>

    </section><!-- /Services Section -->
     </main>
<?php
include 'footer.php';
?>