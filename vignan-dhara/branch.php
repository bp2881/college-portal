<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Resources</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            line-height: 1.6;
            color: #424242;
            background: #f5f5f0 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAJElEQVQYV2NkYGD4z8DAwMgAB//z7P8QAAgMDAwMAAAEZAN+3AAAAAElFTkSuQmCC') repeat;
            background-size: 100px 100px;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(90deg, #ff6f61, #6b5b95);
            color: #ffffff;
            padding: 1rem 0;
            display: flex;
            align-items: center;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        #logo {
            height: 50px;
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }

        .header-title {
            flex: 1;
            text-align: center;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        nav {
            background: linear-gradient(90deg, #42a5f5, #26a69a);
            padding: 0.8rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffd700;
        }

        .container {
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 0 1rem;
            padding-bottom: 3rem;
        }

        .container h2 {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 2rem;
            color: #6b5b95;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }

        .box-container {
            display: flex;
            justify-content: center;
            gap: 4rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .resource-box {
            background: linear-gradient(45deg, #42a5f5, #26a69a);
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .resource-box:hover {
            background: linear-gradient(45deg, #2196f3, #00897b);
            color: #ff8c00;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 20px rgba(66, 165, 245, 0.4);
        }

        .resource-box.highlighted {
            background: linear-gradient(45deg, #0288d1, #00695c);
            color: #ffd700;
            box-shadow: 0 8px 20px rgba(66, 165, 245, 0.6);
            transform: scale(1.05);
        }

        .nested-box-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .nested-resource-box {
            background: linear-gradient(45deg, #42a5f5, #26a69a);
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 600;
            width: 150px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nested-resource-box:hover {
            background: linear-gradient(45deg, #2196f3, #00897b);
            color: #ff8c00;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 20px rgba(66, 165, 245, 0.4);
        }

        .nested-resource-box.highlighted {
            background: linear-gradient(45deg, #0288d1, #00695c);
            color: #ffd700;
            box-shadow: 0 8px 20px rgba(66, 165, 245, 0.6);
            transform: scale(1.05);
        }

        .resource-content {
            display: none;
            /* Initially hidden */
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }

        .resource-content.active {
            display: block;
            /* Show when active */
            opacity: 1;
        }

        .nested-resource-content {
            display: none;
            /* Initially hidden */
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }

        .nested-resource-content.active {
            display: block;
            /* Show when active */
            opacity: 1;
        }

        .book-list {
            display: grid;
            gap: 1rem;
            opacity: 0;
            animation: fadeIn 0.9s ease-out forwards;
            animation-delay: 0.2s;
        }

        .book-item {
            background: #f0f7ff;
            border: 1px solid #d0e7ff;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .book-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .book-item span {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
        }

        .book-item a {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            color: #ffffff;
            background: #ff8c00;
            text-decoration: none;
            font-weight: 500;
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .book-item a:hover {
            background: #e07b00;
            transform: scale(1.05);
        }

        .book-item a::before {
            content: '↓';
            font-size: 1rem;
        }

        .error-message {
            text-align: center;
            color: #800000;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 1.5rem;
            background: #ffffff;
            border: 1px solid #d0d0d0;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .error-message a {
            color: #ff6f61;
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .error-message a:hover {
            text-decoration: underline;
            color: #6b5b95;
        }

        footer {
            background: linear-gradient(90deg, #42a5f5, #26a69a);
            color: #ffffff;
            text-align: center;
            padding: 1.2rem;
            margin-top: 2.5rem;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        footer p {
            font-size: 0.85rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .resource-box {
                width: 150px;
                height: 150px;
                font-size: 1.2rem;
            }

            .nested-resource-box {
                width: 120px;
                height: 120px;
                font-size: 1rem;
            }

            .box-container {
                gap: 2rem;
            }

            .nested-box-container {
                gap: 1.5rem;
            }

            .book-item {
                flex-direction: column;
                gap: 0.8rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <a href="../">
            <img id="logo" src="../images/vignan_logo.png" alt="Vignan Logo">
        </a>
        <div class="header-title">
            <h1>Vignan Dhara Online Portal</h1>
        </div>
    </header>

    <nav>
        <a href="index.php"><img src="../images/arrow_left.png" alt="<-"></a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="container">
        <h2 id="branch-title">Branch Resources</h2>

        <?php
        function listFiles($dir, $relativePath = '')
        {
            $items = scandir($dir);
            $files = [];
            foreach ($items as $item) {
                if ($item === '.' || $item === '..')
                    continue;
                $fullPath = "$dir/$item";
                $relPath = $relativePath ? "$relativePath/$item" : $item;
                if (is_file($fullPath)) {
                    $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                    if (in_array($ext, ['pdf', 'doc', 'docx'])) {
                        $files[] = ['title' => $item, 'url' => "books/" . str_replace('%2F', '/', $relPath)];
                    }
                }
            }
            return $files;
        }

        $branch = isset($_GET['branch']) ? strtoupper($_GET['branch']) : null;
        $baseDir = __DIR__ . '/books';
        $validBranches = array_filter(scandir($baseDir), function ($item) use ($baseDir) {
            return $item !== '.' && $item !== '..' && is_dir("$baseDir/$item");
        });

        if ($branch && in_array(strtolower($branch), array_map('strtolower', $validBranches))) {
            $branchDir = "$baseDir/" . strtolower($branch);
            echo "<script>document.getElementById('branch-title').textContent = '$branch Resources';</script>";

            if (strtolower($branch) === 'bsh') {
                // For BSH, directly display files
                $files = listFiles($branchDir, 'bsh');
                echo "<div class='book-list'>";
                foreach ($files as $file) {
                    echo "<div class='book-item'>";
                    echo "<span>" . htmlspecialchars($file['title']) . "</span>";
                    echo "<a href='{$file['url']}' target='_blank'>Download</a>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                // For other branches, display years and semesters
                echo "<div class='box-container'>";
                $years = ['2', '3', '4'];
                foreach ($years as $year) {
                    $yearDir = "$branchDir/$year";
                    if (is_dir($yearDir)) {
                        echo "<div class='resource-box' data-period='year-$year'>Year $year</div>";
                    }
                }
                echo "</div>";

                foreach ($years as $year) {
                    $yearDir = "$branchDir/$year";
                    if (is_dir($yearDir)) {
                        echo "<div class='resource-content' id='year-$year'>";
                        echo "<div class='nested-box-container'>";
                        echo "<div class='nested-resource-box' data-sem='year-$year-sem-1'>Semester 1</div>";
                        echo "<div class='nested-resource-box' data-sem='year-$year-sem-2'>Semester 2</div>";
                        echo "</div>";

                        foreach (['sem-1', 'sem-2'] as $sem) {
                            $semDir = "$yearDir/$sem";
                            if (is_dir($semDir)) {
                                $files = listFiles($semDir, strtolower($branch) . "/$year/$sem");
                                echo "<div class='nested-resource-content' id='year-$year-$sem'>";
                                echo "<div class='book-list'>";
                                if (empty($files)) {
                                    echo "<p style='color: red;'>Materials are not available yet </p>";
                                } else {
                                    foreach ($files as $file) {
                                        echo "<div class='book-item'>";
                                        echo "<span>" . htmlspecialchars($file['title']) . "</span>";
                                        echo "<a href='{$file['url']}' target='_blank'>Download</a>";
                                        echo "</div>";
                                    }
                                }
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            }
        } else {
            echo "<div class='error-message'>";
            echo "Invalid branch or no resources available. <a href='index.php'>Return to Home</a>";
            echo "</div>";
        }
        ?>
    </div>

    <footer style="padding: 20px; background-color: #f2f2f2; font-family: Arial, sans-serif;">
        <p style="text-align: center;">© 2025 Vignan Dhara Library. All rights reserved.</p>
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <div id="about" style="width: 45%;">
                <p><b>About:</b><br>
                    Vignan Dhara is a library where students can find their course-related materials.
                </p>
            </div>
            <div id="contact" style="width: 45%; text-align: right;">
                <p><b>Contact:</b><br>
                    Email: info@vignandhara.edu<br>
                    Phone: +91-12345-67890
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const yearBoxes = document.querySelectorAll('.resource-box');
            yearBoxes.forEach(box => {
                box.addEventListener('click', () => {
                    const year = box.getAttribute('data-period');
                    const content = document.getElementById(year);

                    if (!content) {
                        console.error(`Year content not found for ID: ${year}`);
                        return;
                    }

                    const isActive = content.classList.contains('active');

                    yearBoxes.forEach(b => b.classList.remove('highlighted'));
                    box.classList.add('highlighted');

                    document.querySelectorAll('.resource-content').forEach(c => c.classList.remove('active'));
                    document.querySelectorAll('.nested-resource-content').forEach(c => c.classList.remove('active'));

                    if (!isActive) {
                        content.classList.add('active');
                    }
                });
            });

            const semBoxes = document.querySelectorAll('.nested-resource-box');
            semBoxes.forEach(box => {
                box.addEventListener('click', () => {
                    const sem = box.getAttribute('data-sem');
                    const content = document.getElementById(sem);

                    if (!content) {
                        console.error(`Semester content not found for ID: ${sem}`);
                        return;
                    }

                    const isActive = content.classList.contains('active');

                    const year = sem.split('-')[0] + '-' + sem.split('-')[1];
                    document.querySelectorAll(`#${year} .nested-resource-box`).forEach(c => c.classList.remove('highlighted'));
                    box.classList.add('highlighted');

                    document.querySelectorAll(`#${year} .nested-resource-content`).forEach(c => c.classList.remove('active'));

                    if (!isActive) {
                        content.classList.add('active');
                        console.log(`Activated semester content for ID: ${sem}`);
                    }
                });
            });
        });
    </script>
</body>

</html>