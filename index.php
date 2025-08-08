<?php
// Load current content
$title = file_exists('content/title.txt') ? file_get_contents('content/title.txt') : 'Default Title';
$paragraph = file_exists('content/paragraph.txt') ? file_get_contents('content/paragraph.txt') : 'Default paragraph content.';

// Load banner image from banner.txt, use a default image if no file exists
$banner = file_exists('content/banner.txt') ? file_get_contents('content/banner.txt') : 'default-banner.jpg';

// Load the menu from menu.txt, use a default menu if no file exists
$menu = file_exists('content/menu.txt') ? json_decode(file_get_contents('content/menu.txt'), true) : [
    ['name' => 'Web Design', 'link' => 'https://jrispace.net/product/businesswebsite/'],
    ['name' => 'Digital Marketing', 'link' => 'https://jrispace.net/product/smmonetime/'],
    ['name' => 'Contact Us', 'link' => 'https://wa.link/shamasavvysupport'],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shama Savvy Support</title>
    <link rel="icon" href="/img/logo.png" type="image/png">

    <!-- Google Translate Code -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'fr,es,ht,en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: true
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Disable right-click -->
    <script>
        document.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1F1C2C 0%, #928DAB 50%, #1D2671 100%);
            color: #fff;
        }

        /* Header and Menu */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(135deg, #0D3B66 0%, #0F4C75 50%, #1B264F 100%);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background-color 0.3s ease, opacity 0.3s ease;
        }

        /* Transparent header on scroll */
        .scrolled {
            background-color: rgba(13, 59, 102, 0.9); /* Slight transparency */
        }

        header img {
            max-width: 50px;
            cursor: pointer;
        }

        /* Navigation */
        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #1DB954; /* New Accent Color - Green */
        }

        /* Mobile menu styles */
        .menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 25px;
            height: 25px;
            cursor: pointer;
        }

        .menu-toggle div {
            width: 100%;
            height: 3px;
            background-color: #fff;
        }

        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(29, 38, 113, 0.95);
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }

        .mobile-nav.active {
            display: flex;
        }

        .mobile-nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .mobile-nav ul li a {
            color: #fff;
            font-size: 24px;
            text-decoration: none;
        }

        /* Banner */
        .banner {
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            display: block;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        /* Professional Dark Gradient Login Button */
        .login-btn {
            background: linear-gradient(135deg, #2C3E50, #4C5C68);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #1A252F, #3B4D5C);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        /* Container */
        .container {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            background: linear-gradient(135deg, #2B2E4A 0%, #49C6E5 50%, #1D2671 100%);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);
        }

        h1 {
            color: #ffffff;
            font-size: 42px;
            margin-bottom: 20px;
        }

        p {
            font-size: 20px;
            color: #F0EDE5;
            margin: 20px 0;
            line-height: 1.8;
        }

        /* WhatsApp Button */
        .whatsapp-btn {
            background: linear-gradient(135deg, #006400, #228B22); /* Dark Green Gradient */
            color: white;
            padding: 15px 35px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 30px;
        }

        .whatsapp-btn:hover {
            background: linear-gradient(135deg, #004B23, #1A7306);
        }

        /* Footer */
        footer {
            margin-top: 50px;
            padding: 20px;
            background: linear-gradient(135deg, #14213D 0%, #0A2F44 50%, #1F1C2C 100%);
            color: white;
            font-size: 14px;
            text-align: center;
        }

        footer a {
            color: #4A90E2;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .email-contact {
            margin-top: 10px;
            font-size: 16px;
            color: #cccccc;
        }

        .email-contact a {
            color: #4A90E2;
            text-decoration: none;
        }

        .email-contact a:hover {
            text-decoration: underline;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .banner {
                width: 90%;
            }

            .container {
                padding: 40px 10px;
            }

            h1 {
                font-size: 32px;
            }

            p {
                font-size: 18px;
            }
        }
    </style>

    <script>
        function toggleMenu() {
            const mobileNav = document.querySelector('.mobile-nav');
            mobileNav.classList.toggle('active');
        }

        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>

</head>

<body>

<header>
    <a href="/"><img src="/img/logo.png" alt="Shama Savvy Support Logo"></a>

    <nav>
        <ul>
            <?php foreach ($menu as $menuItem): ?>
                <li><a href="<?php echo htmlspecialchars($menuItem['link']); ?>" target="_blank"><?php echo htmlspecialchars($menuItem['name']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Hamburger Menu -->
    <div class="menu-toggle" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <a href="admin.php" class="login-btn">Login</a>
</header>

<!-- Mobile Nav -->
<div class="mobile-nav">
    <ul>
        <?php foreach ($menu as $menuItem): ?>
            <li><a href="<?php echo htmlspecialchars($menuItem['link']); ?>" target="_blank"><?php echo htmlspecialchars($menuItem['name']); ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<a href="https://wa.link/shamasavvysupport" target="_blank"><img src="/img/<?php echo htmlspecialchars($banner); ?>" alt="Banner" class="banner"></a>

<div class="container">
    <h1><?php echo htmlspecialchars($title); ?></h1>
    <p><?php echo htmlspecialchars($paragraph); ?></p>
    <a href="https://wa.me/12676781263" target="_blank" class="whatsapp-btn">Contact Us on WhatsApp</a>
</div>

<p align="center">
<script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>

<stripe-buy-button
  buy-button-id="buy_btn_1QP95JK74IE6sopgsklKGcKP"
  publishable-key="pk_live_51PSjQIK74IE6sopgfIzRccfsIVogwCMJSs1Hr6syg9Q0TYrOi8HmdXcHGqGA0sD82CDG3YHs58m1pVTaKrJajaaE00RlZAg3TT"
>
</stripe-buy-button>
</p>

<footer>
    Powered by <a href="https://jrispace.net" target="_blank">JRiSpace</a>
    <div class="email-contact">
        Contact us: <a href="mailto:sales@shamasavvysupport.com">sales@shamasavvysupport.com</a>
    </div>
</footer>

</body>

</html>
