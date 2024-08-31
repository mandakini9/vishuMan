<?php
session_start();
include 'header.php';

?>
<main class="main">

    
   
    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Login</h2>
        
      </div><!-- End Section Title -->
          
      <div class="container">
   
        <div class="row justify-content-center gy-4">

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
              <i class="bi bi-person-circle"></i>
              <h4><a href="student_login.php" class="stretched-link">Student Login</a></h4>
              
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <i class="bi bi-person-circle"></i>
              <h4><a href="guardian_login.php" class="stretched-link">Guardian Login</a></h4>
              
            </div>
          </div><!-- End Service Item -->

<!--          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <i class="bi bi-calendar4-week"></i>
              <h4><a href="teacher_login.php" class="stretched-link">Teacher Login</a></h4>
              
            </div>
          </div> End Service Item -->

          

        </div>

      
   </div>
    </section><!-- /Services Section -->

   

    

    

      
  </main>

<?php
include 'footer.php';
?>