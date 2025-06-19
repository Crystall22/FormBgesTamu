<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Welcome | Telkom Indonesia</title>
  <meta content="Landing Page" name="description">
  <meta content="Landing Page" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets2/img/apple-touch-icon.png') }}">

  <!-- Main CSS -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    body {
      font-family: 'Gotham Rounded', sans-serif;
      background-color: #ffffff;
      color: #212529;
      margin: 0;
      padding: 0;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ffffff;
      padding: 15px 50px;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 4px solid #e42613;
    }

    .logo-container {
      display: flex;
      align-items: center;
    }

    .logo-container img {
      max-height: 60px;
      margin-right: 10px;
    }

    /* Font untuk Telkom Indonesia pada navbar */
    .brand-name {
        font-family: 'Gotham Rounded', sans-serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: #2d465e;
        margin: 0;
    }

    .navbar ul {
      display: flex;
      list-style-type: none;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    .navbar a {
      font-size: 16px;
      color: #212529;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .navbar a:hover {
      color: #e42613;
    }

    .bumn-button-link {
      position: absolute;
      top: 90px;
      right: 30px;
      display: inline-block;
      z-index: 999;
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .bumn-button-link img {
      display: block;
      max-height: 100px;
      transition: transform 0.3s ease;
    }

    .bumn-button-link:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .banner-content h2 {
      font-size: 1.5rem;
      margin-bottom: 5px;
      font-weight: bold;
      line-height: 1.2;
      color: #000000;
    }

    .footer {
      background-color: #fff;
      padding: 10px;
      text-align: center;
      color: #000;
      width: 100%;
    }

    .feature-box {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(44,62,80,0.08);
      padding: 32px 20px;
      margin-bottom: 24px;
      text-align: center;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .feature-box:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 8px 32px rgba(44,62,80,0.16);
      background: #f8f9fa;
    }

    .feature-box i {
      font-size: 2.5rem;
      color: #e42613;
      margin-bottom: 16px;
    }

    .btn-danger {
      background: linear-gradient(90deg, #e42613 0%, #ff6a00 100%);
      border: none;
      color: #fff;
      font-weight: 600;
      transition: background 0.3s, box-shadow 0.2s;
      box-shadow: 0 2px 8px rgba(228,38,19,0.08);
    }

    .btn-danger:hover {
      background: linear-gradient(90deg, #ff6a00 0%, #e42613 100%);
      box-shadow: 0 4px 16px rgba(228,38,19,0.16);
    }

    @media (max-width: 768px) {
      .header {
        flex-direction: column;
        align-items: flex-start;
      }

      .navbar ul {
        flex-direction: column;
        align-items: flex-start;
        padding-top: 10px;
      }

      .brand-name {
        font-size: 1.8rem;
      }

      .hero h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d465e;
      }

      /* Font untuk Telkom Indonesia pada banner */
      .hero h1 {
        font-family: 'Gotham Rounded', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d465e;
      }

      .hero p {
        font-size: 1.1rem;
        color: #333;
        line-height: 1.6;
      }

      .hero .btn {
        font-weight: 500;
        padding: 10px 24px;
        border-radius: 30px;
      }

      .bumn-button-link {
        top: 120px;
        right: 10px;
      }

      .bumn-button-link img {
        max-height: 70px;
      }
    }
  </style>
</head>

<body>

  {{-- ======= Header ======= --}}
  <header id="header" class="header">
    <div class="logo-container">
      <img src="{{ asset('images/telkomhand.png') }}" alt="Logo">
      <h4 class="brand-name">Telkom Indonesia</h4>
    </div>
    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
        <li><a class="nav-link scrollto" href="#about">About</a></li>
        <li><a class="nav-link scrollto" href="#features">Features</a></li>
        <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        <li><a class="getstarted scrollto" href="{{ route('login') }}">Login</a></li>
      </ul>
    </nav>
  </header>

  {{-- ======= Logo BUMN sebagai tombol antrian ======= --}}
  <a href="{{ route('queue.create') }}" class="bumn-button-link" title="Klik untuk ambil nomor antrian">
    <img src="{{ asset('images/bumn.png') }}" alt="BUMN Logo">
  </a>

  {{-- ======= Hero Section ======= --}}
  <section id="hero" class="hero" style="background-color: #f5f8fd; padding: 80px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <img src="{{ asset('images/telkom.png') }}" alt="Telkom Logo" class="img-fluid mb-4" style="max-width: 220px;">
                <h1 class="mb-3">Welcome to Telkom Indonesia</h1>
                <p class="mb-4">
                    Mulai perjalanan digital Anda bersama PT Telkom Indonesia.<br>
                    Dapatkan akses mudah ke layanan komunikasi dan teknologi terbaru<br>
                    yang mendukung kemajuan bisnis dan kehidupan digital Anda.
                </p>
                <a href="#about" class="btn btn-danger">Get Started</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('assets2/img/illustration-1.webp') }}" class="img-fluid" alt="Illustration" style="max-height: 400px;">
            </div>
        </div>
    </div>
  </section>

  {{-- ======= About Section ======= --}}
  <section id="about" class="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 order-1 order-lg-2">
          <img src="{{ asset('assets2/img/about-2.webp') }}" class="img-fluid" alt="About Us">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
          <h3>About Us</h3>
          <p>
            PT Telkom Indonesia adalah perusahaan teknologi terkemuka di Indonesia yang menyediakan solusi telekomunikasi, internet cepat, dan layanan cloud untuk memenuhi kebutuhan komunikasi dan teknologi digital Anda.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- ======= Features Section ======= --}}
  <section id="features" class="features">
    <div class="container">
      <div class="section-title">
        <h2>Kenapa Memilih Telkom Indonesia?</h2>
        <p>
          Dengan jaringan yang luas, kami memberikan teknologi terbaik untuk Indonesia, tim kami siap memberikan pelayanan terbaik kapan saja Anda membutuhkannya.
        </p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="feature-box">
            <i class="bi bi-laptop"></i>
            <h4>Internet Cepat dan Stabil</h4>
            <p>
              Nikmati koneksi internet berkecepatan tinggi yang handal, mendukung aktivitas Anda.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="bi bi-graph-up"></i>
            <h4>Solusi Cloud Terintegrasi</h4>
            <p>
              Kelola data bisnis dengan mudah dan aman melalui solusi cloud Telkom Indonesia.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="bi bi-person-circle"></i>
            <h4>Layanan Telekomunikasi Bisnis</h4>
            <p>
              Meningkatkan produktivitas perusahaan dengan layanan komunikasi bisnis efisien.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ======= Contact Section ======= --}}
  <section id="contact" class="contact">
    <div class="container">
      <div class="section-title">
        <h2>Hubungi Kami</h2>
        <p>
          Kami siap membantu Anda dengan solusi teknologi yang tepat. Hubungi kami sekarang.
        </p>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <form action="{{ route('contact.send') }}" method="post" class="php-email-form">
            @csrf
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row">
              <div class="col form-group">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
              </div>
              <div class="col form-group">
                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" name="subject" class="form-control" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
              <textarea name="message" rows="5" class="form-control" placeholder="Message" required></textarea>
            </div>
            <div class="text-center mt-3"><button type="submit">Send Message</button></div>
          </form>
        </div>
        <div class="col-lg-6">
          <img src="{{ asset('assets2/img/services.jpg') }}" class="img-fluid" alt="Contact Services">
        </div>
      </div>
    </div>
  </section>

  {{-- ======= Footer ======= --}}
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; {{ date('Y') }} <strong><span>Affiliation with Telkom Indonesia | Created by Muhyi Haadi Sewithto</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer>

  <!-- JS Scripts -->
  <script src="{{ asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets2/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets2/js/main.js') }}"></script>
  <script>
    document.querySelectorAll('a.scrollto').forEach(link => {
      link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
          e.preventDefault();
          document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
        }
      });
    });
  </script>
</body>
</html>
