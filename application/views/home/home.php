<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/Logo_Smartedu.svg'); ?>">
    <title>Dashboard - Smartedu</title>
    <!-- Favicons -->
    <!-- <link href="<?= base_url('assets_dashboard/img/favicon.png') ?>" rel="icon"> -->
    <!-- <link href="<?= base_url('assets_dashboard/img/apple-touch-icon.png') ?>" rel="apple-touch-icon"> -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('assets_dashboard/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets_dashboard/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets_dashboard/vendor/aos/aos.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets_dashboard/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets_dashboard/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?= base_url('assets_dashboard/css/main.css') ?>" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Day
  * Template URL: https://bootstrapmade.com/day-multipurpose-html-template-for-free/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header fixed-top">

        <!-- <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a
                            href="mailto:contact@example.com">contact@example.com</a></i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div> -->
        <!-- End Top Bar -->

        <div class="branding d-flex align-items-center">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.html" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="<?= base_url('assets/img/Logo_Smartedu.svg') ?>" alt="">
                    <h1 class="sitename">Smartedu</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="" class="active">Home</a></li>
                        <li><a href="<?= base_url('panduan')?>">Panduan</a></li>
                        <li><a href="<?= base_url('materi')?>">Materi</a></li>
                        <li><a href="<?= base_url('proyek')?>">Proyek</a></li>
                        <li><a href="<?= base_url('ujian')?>">Ujian</a></li>
                        <li><a href="<?= base_url('kalender')?>">Kalender</a></li>
                        <?php if($this->session->userdata('role') == 1 ){?>
                        <li class="dropdown"><a href="#"><span>Master Data</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="<?= base_url('guru')?>">Data Guru</a></li>
                                <li><a href="<?= base_url('siswa')?>">Data Siswa</a></li>
                                <li><a href="<?= base_url('mapel')?>">Data Mata Pelajaran</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li class="dropdown">
                            <a href="#"><span>Hai, <?= $this->session->userdata('nama');?></span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                            <ul>
                                <li><a href="<?= base_url('logout');?>">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="assets_dashboard/img/bg.jpg" alt="" data-aos="fade-in">

            <div class="container py-5" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-start">
                    <div class="col-lg-8">
                        <h2>Welcome to Smartedu</h2>
                        <h6>TERSTRUKTUR, EFISIEN, MUDAH DIAKSES </h6>
                        <br>
                        <p>Sebuah platform digital berbasis web yang dirancang khusus untuk mendukung
                            kegiatan pembelajaran project-based learning di lingkungan sekolah</p>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->
    </main>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets_dashboard/vendor/php-email-form/validate.js') ?>"></script>
    <script src="<?= base_url('assets_dashboard/vendor/aos/aos.js') ?>"></script>
    <script src="<?= base_url('assets_dashboard/vendor/swiper/swiper-bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets_dashboard/vendor/glightbox/js/glightbox.min.js') ?>"></script>
    <script src="<?= base_url('assets_dashboard/vendor/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('assets_dashboard/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>

    <!-- Main JS File -->
    <script src="<?= base_url('assets_dashboard/js/main.js') ?>"></script>

</body>

</html>