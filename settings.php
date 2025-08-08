<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// Load current menu items
$menu = file_exists('content/menu.txt') ? json_decode(file_get_contents('content/menu.txt'), true) : [
    ['name' => 'Home', 'link' => '/'],
    ['name' => 'Web Design', 'link' => 'https://jrispace.net/product/businesswebsite/'],
    ['name' => 'Digital Marketing', 'link' => 'https://jrispace.net/product/smmonetime/'],
];

// Load current copyright text
$copyright = file_exists('content/copyright.txt') ? file_get_contents('content/copyright.txt') : '© 2024 Your Website Name';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save menu items
    if (isset($_POST['menu'])) {
        $menuData = [];
        foreach ($_POST['menu'] as $index => $menuItem) {
            if (!empty($menuItem['name']) && !empty($menuItem['link'])) {
                $menuData[] = [
                    'name' => htmlspecialchars($menuItem['name']),
                    'link' => htmlspecialchars($menuItem['link'])
                ];
            }
        }
        file_put_contents('content/menu.txt', json_encode($menuData));
        echo "<script>alert('Menu updated successfully!');</script>";
    }

    // Save copyright text
    if (!empty($_POST['copyright'])) {
        file_put_contents('content/copyright.txt', htmlspecialchars($_POST['copyright']));
        echo "<script>alert('Copyright updated successfully!');</script>";
    }
}

// Reload updated content after saving
$menu = file_exists('content/menu.txt') ? json_decode(file_get_contents('content/menu.txt'), true) : [];
$copyright = file_exists('content/copyright.txt') ? file_get_contents('content/copyright.txt') : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background: linear-gradient(135deg, #2a2a5a, #4a4a8a);
            color: #fff;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #0f0c29, #3c3b63);
            padding: 20px;
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            bottom: 0;
            color: #fff;
        }

        .sidebar h2 {
            text-align: center;
            color: #f0f0f0;
            margin-bottom: 30px;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            margin-bottom: 20px;
        }

        .sidebar nav ul li a {
            text-decoration: none;
            color: #f0f0f0;
            font-weight: bold;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .sidebar nav ul li a:hover {
            background: #555575;
        }

        .save-btn, .logout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-btn {
            background-color: #25D366;
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
            margin-left: 270px;
            padding: 40px;
            flex: 1;
            background: #33334d;
            color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        form {
            max-width: 800px;
            background: #444466;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #f0f0f0;
        }

        textarea, input[type="text"], input[type="url"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #666;
            background-color: #555;
            color: #fff;
        }

        textarea:focus, input[type="text"]:focus, input[type="url"]:focus {
            outline: none;
            border-color: #25D366;
        }

        .menu-item {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
        }

        .menu-item input {
            flex: 1;
        }

        .add-menu-item-btn {
            background-color: #25D366;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .add-menu-item-btn:hover {
            background-color: #20b357;
        }

        .save-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        .save-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <script>
        function addMenuItem() {
            const menuList = document.getElementById('menu-list');
            const index = document.querySelectorAll('.menu-item').length;
            const newItem = document.createElement('div');
            newItem.classList.add('menu-item');
            newItem.innerHTML = `
                <input type="text" name="menu[${index}][name]" placeholder="Menu Name" required>
                <input type="url" name="menu[${index}][link]" placeholder="Menu Link" required>
            `;
            menuList.appendChild(newItem);
        }
    </script>
</head>

<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="admin.php">Back to Admin</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </nav>
        <form method="POST">
            <input type="submit" value="Save Changes" class="save-btn">
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Website Settings</h2>

        <form method="POST">
            <!-- Menu Settings -->
            <h3>Menu Settings</h3>
            <div id="menu-list">
                <?php foreach ($menu as $index => $menuItem): ?>
                    <div class="menu-item">
                        <input type="text" name="menu[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($menuItem['name']); ?>" required>
                        <input type="url" name="menu[<?php echo $index; ?>][link]" value="<?php echo htmlspecialchars($menuItem['link']); ?>" required>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="add-menu-item-btn" onclick="addMenuItem()">Add New Menu Item</button>

            <!-- Copyright Settings -->
            <h3>Footer Settings</h3>
            <label for="copyright">Copyright Text:</label>
            <textarea name="copyright" id="copyright" rows="3" required><?php echo htmlspecialchars($copyright); ?></textarea>

            <!-- Save Button -->
            <button type="submit" class="save-btn">Save Settings</button>
        </form>
    </div>

</body>
</html>
