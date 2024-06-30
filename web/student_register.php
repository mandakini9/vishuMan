<?php
session_start();
include 'header.php';

?>
<main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Student Registration</h2>
        <!--<p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>-->
      </div><!-- End Section Title -->

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

           <div class="row justify-content-center">

          <div class="col-lg-7">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="500">
              <div class="row gy-4">

                <div class="col-md-6">
                  <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" value="<?= @$first_name ?>" placeholder="First Name" required>
                                <span class="text-danger"><?= @$message['first_name'] ?></span>
                </div>

                <div class="col-md-6 ">
                  <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
                                <span class="text-danger"><?= @$message['first_name'] ?></span>
                </div>

                <div class="col-md-6">
                      <label for="last_name">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" required>
                                
                </div>
                  
                <div class="col-md-6">
                      <label for="last_name">NIC</label>
                                <input type="text" class="form-control" name="nic" id="nic" placeholder="National ID" required>
                                
                </div>
                  
                  <div class="col-md-6">
                       
                   <label>Select Gender</label>
              
                   <br><!-- comment -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male"  value="male">
                                <label class="form-check-label" for="male">
                                    Male
                                </label>
                            </div>
                 
                  
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" >
                                <label class="form-check-label" for="female">
                                    Female
                                </label>
                            </div>
                            <div class="text-danger mt-4"><?= @$message['gender'] ?></div>
       
                  </div>
                  
                  <div class="col-md-6">
                       <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
                            <span class="text-danger"><?= @$message['email'] ?></span>
                      
                  </div>
                  
                   <div class="col-md-6">
                       <label for="email">School</label>
                            <input type="text" class="form-control" name="school" id="school" placeholder="School Name" required>
                           
            
                  </div>
                  <div class="col-md-6">
                       <label for="address_line1">Address Line 1</label>
                            <input type="text" class="form-control" name="address_line1" id="address_line1" placeholder="Address Line 1" required>
            
                  </div>
                  <div class="col-md-6">
                       <label for="address_line2">Address Line 2</label>
                            <input type="text" class="form-control " name="address_line2" id="address_line2" placeholder="Address Line 2" required>
                           
            
                  </div>
                  <div class="col-md-6">
                       <label for="email">City</label>
                            <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
                           
                  </div>
                   <div class="col-md-6">
                   
                       <label for="district">District</label>
                            <select name="district" id="district"  class="form-select" aria-label="Large select example">
                                <option value="" >--</option>
                                
                            </select>    
                  </div>
                  
                  <div class="col-md-6">
                       <label for="telno">Tel. No.(Home)</label>
                            <input type="text" class="form-control" name="telno" id="telno" placeholder="Tel. No." required>
                           
                  </div>
                  
                  <div class="col-md-6">
                       <label for="telno">Mobile No.</label>
                            <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" required>
                  </div>
                     
                  <div class="col-md-6">
                       <label for="user_name">User Name</label>
                            <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Username" required>
                            <span class="text-danger"><?= @$message['user_name'] ?></span>
                           
                  </div>
                  
                  <div class="col-md-6">
                       <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <span class="text-danger"><?= @$message['password'] ?></span>
                           
                  </div>
                  
                  
                  <div class="col-md-6">
                       <label for="repassword">Retype Password</label>
                            <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Retype Password" required>
                            
                           
                  </div>
                  
                  
                  
                
                  
              

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Submit</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>
        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

      <?php
include 'footer.php';
?>