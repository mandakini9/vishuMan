<?php
include 'header.php';
?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your Payment has Submitted",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<main id="main">
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">

            <h2 class="text-success">SUCCESS</h2>

        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-lg-7 border border-3  border-success" data-aos="fade-up" data-aos-delay="200">


                    <h2 class="text-center">Your Payment has successfully Submit</h2>

                    <h1 class="text-center">You Can Check your Email </h1>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>