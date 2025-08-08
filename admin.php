<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// Save content if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['title'])) {
        file_put_contents('content/title.txt', $_POST['title']);
    }

    if (!empty($_POST['paragraph'])) {
        file_put_contents('content/paragraph.txt', $_POST['paragraph']);
    }

    if (!empty($_POST['menu'])) {
        file_put_contents('content/menu.txt', json_encode($_POST['menu']));
    }

    // Handle file upload
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'img/';
        $uploadFile = $uploadDir . basename($_FILES['banner']['name']);
        
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $validExtensions)) {
            if (move_uploaded_file($_FILES['banner']['tmp_name'], $uploadFile)) {
                // Save the banner filename in banner.txt
                file_put_contents('content/banner.txt', $_FILES['banner']['name']);
                echo "<script>alert('Banner uploaded successfully!');</script>";
            } else {
                echo "<script>alert('Failed to upload banner. Please check permissions or try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, PNG, and GIF are allowed.');</script>";
        }
    }

    // Handle image selection from existing images
    if (!empty($_POST['selected_banner'])) {
        file_put_contents('content/banner.txt', $_POST['selected_banner']);
        echo "<script>alert('Banner selected successfully!');</script>";
    }
}

// Load current content
$title = file_exists('content/title.txt') ? file_get_contents('content/title.txt') : 'Default Title';
$paragraph = file_exists('content/paragraph.txt') ? file_get_contents('content/paragraph.txt') : 'Default paragraph content.';
$banner = file_exists('content/banner.txt') ? file_get_contents('content/banner.txt') : 'default-banner.jpg';

// Get a list of available images from the img/ directory
$availableImages = array_diff(scandir('img/'), array('.', '..'));

?>
    <!-- Disable right-click -->
    <script>
        document.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Content</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background: linear-gradient(135deg, #2a2a5a, #4a4a8a);
            color: #fff;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: #2d2d4b;
            padding: 20px;
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            bottom: 0;
            color: #f0f0f0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 24px;
            color: #fff;
        }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav ul li {
            margin-bottom: 20px;
        }

        .sidebar nav ul li a {
            display: block;
            padding: 12px;
            font-size: 18px;
            font-weight: 500;
            color: #f0f0f0;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .sidebar nav ul li a:hover {
            background-color: #56567e;
            transform: translateX(5px);
        }

        .save-btn, .logout-btn {
            width: 100%;
            padding: 12px;
            text-align: center;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .save-btn {
            background-color: #25d366;
            color: #fff;
        }

        .save-btn:hover {
            background-color: #20b357;
        }

        .logout-btn {
            background-color: #d9534f;
            color: #fff;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            padding: 40px;
            width: calc(100% - 280px);
            background-color: #40405e;
            color: #f0f0f0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            overflow-y: auto;
            max-height: 100vh;
        }

        form {
            max-width: 800px;
            background-color: #525285;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 20px;
            font-size: 22px;
            color: #d3d3e1;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
            color: #d3d3e1;
        }

        textarea, input[type="text"], input[type="url"] {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #666;
            background-color: #616179;
            color: #fff;
            font-size: 16px;
        }

        textarea:focus, input[type="text"]:focus, input[type="url"]:focus {
            outline: none;
            border-color: #25d366;
        }

        input[type="file"] {
            margin-top: 20px;
        }

        /* Standard Image Styling */
        img {
            max-width: 100%;
            height: auto;
            max-height: 500px; /* Maintain standard max height */
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        select {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 8px;
            background-color: #616179;
            color: #fff;
            font-size: 16px;
        }

        select:focus {
            outline: none;
            border-color: #25d366;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </nav>
        <form method="POST">
            <input type="submit" value="Save Changes" class="save-btn">
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Edit Website Content</h2>

        <!-- Show the current banner image -->
        <h3>Current Banner Image</h3>
        <img src="img/<?php echo htmlspecialchars($banner); ?>" alt="Current Banner">

        <form method="POST" enctype="multipart/form-data">
            <label for="title">Page Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">

            <label for="paragraph">Main Paragraph:</label>
            <textarea id="paragraph" name="paragraph" rows="10"><?php echo htmlspecialchars($paragraph); ?></textarea>

            <h3>Edit Menu Items</h3>
            <?php foreach ($menu as $index => $menuItem): ?>
                <label for="menu-name-<?php echo $index; ?>">Menu Item Name:</label>
                <input type="text" id="menu-name-<?php echo $index; ?>" name="menu[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($menuItem['name']); ?>">

                <label for="menu-link-<?php echo $index; ?>">Menu Item Link:</label>
                <input type="url" id="menu-link-<?php echo $index; ?>" name="menu[<?php echo $index; ?>][link]" value="<?php echo htmlspecialchars($menuItem['link']); ?>">
            <?php endforeach; ?>

            <h3>Upload Banner Image</h3>
            <input type="file" name="banner" accept="image/*">
            <input type="submit" value="Upload Image" class="save-btn" style="margin-top: 10px;">

            <h3>Or Choose from Available Images</h3>
            <select name="selected_banner">
                <?php foreach ($availableImages as $image): ?>
                    <option value="<?php echo htmlspecialchars($image); ?>" <?php if ($image == $banner) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($image); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Select Image" class="save-btn" style="margin-top: 10px;">
        </form>
    </div>

</body>
</html>
