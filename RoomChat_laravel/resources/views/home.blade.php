<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

  <title>ROOM CHAT</title>

  <!-- Bootstrap core CSS -->
  <link href="/template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/template/assets/css/templatemo-chain-app-dev.css">
  <link rel="stylesheet" href="/template/assets/css/animated.css">
</head>

<body>

  <!-- Header Area -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">

            <ul class="nav">
              <li><div class="gradient-button"><a href="{{ route('formRegister') }}" style="padding: 0 20px;"><i class="fa fa-sign-in-alt"></i> Đăng Ký</a></div></li>
              <li><div class="gradient-button"><a href="{{ route('formLogin') }}"><i class="fa fa-sign-in-alt"></i> Đăng Nhập</a></div></li>
            </ul>
            <a class="menu-trigger">
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Banner -->
  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
            <h2>Room Chat - Momota!</h2>
            <p>Chat room - kết nối với tôi</p>
            <div class="cta-button">
              <a href="#">Get Started</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
            <!-- Placeholder for image -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Section -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <!-- About Us Section -->
        <div class="col-lg-4">
          <div class="footer-widget">
            <h4>About Room Chat</h4>
            <p>Room Chat provides a fast and seamless chat experience. Connect with friends or strangers in real-time. Instant messaging, minimal distractions.</p>
          </div>
        </div>

        <!-- Useful Links Section -->
        <div class="col-lg-4">
          <div class="footer-widget">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Features</a></li>
              <li><a href="#">Pricing</a></li>
              <li><a href="#">Blog</a></li>
            </ul>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="col-lg-4">
          <div class="footer-widget">
            <h4>Contact Us</h4>
            <p><i class="fas fa-map-marker-alt"></i> 123 Chat Street, San Francisco, CA</p>
            <p><i class="fas fa-phone"></i> <a href="tel:+1234567890">+1 234 567 890</a></p>
            <p><i class="fas fa-envelope"></i> <a href="mailto:info@roomchat.com">info@roomchat.com</a></p>
            <ul class="social-icons">
              <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12 text-center">
          <div class="copyright-text">
            <p>&copy; 2024 Room Chat. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="/template/vendor/jquery/jquery.min.js"></script>
  <script src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/template/assets/js/animation.js"></script>
  <script src="/template/assets/js/imagesloaded.js"></script>
  <script src="/template/assets/js/popup.js"></script>
  <script src="/template/assets/js/custom.js"></script>
</body>

</html>
