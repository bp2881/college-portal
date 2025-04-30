<?php
$year = null;
$branch = null;
$jsonFile = "C:\\xampp\\htdocs\\college-portal\\student\\session.json";
if (file_exists($jsonFile)) {
    $json = file_get_contents($jsonFile);
    $data = json_decode($json, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $logged_in = $data['logged'];
        if ((time() - $logged_in) > 1800) {
            unlink($jsonFile);
            header("Location: ../student_login.php");
        }
        $year = htmlspecialchars($data['year']);
        $branch = htmlspecialchars($data['branch']);
    } else {
        $error = "Error decoding JSON: " . json_last_error_msg();
    }
} else {
    header("Location: ../student_login.php");
}

function getDocuments($basePath, $branch, $year, $semester)
{
    $dirPath = $basePath . '/' . $branch . '/' . $year . '/' . $semester;
    $documents = [];

    if (is_dir($dirPath)) {
        $files = scandir($dirPath);
        foreach ($files as $file) {
            // Skip . and .. directories
            if ($file != "." && $file != "..") {
                $filePath = $dirPath . '/' . $file;
                $fileInfo = pathinfo($filePath);
                $documents[] = [
                    'name' => $file,
                    'path' => $filePath,
                    'extension' => isset($fileInfo['extension']) ? $fileInfo['extension'] : '',
                    'size' => filesize($filePath),
                    'modified' => date("F d Y H:i:s", filemtime($filePath))
                ];
            }
        }
    }

    return $documents;
}

// Base path for documents
$basePath = "C:\\xampp\\htdocs\\college-portal\\vignan-dhara\\books";

// Get documents from sem-1 and sem-2
$sem1Documents = getDocuments($basePath, $branch, $year, 'sem-1');
$sem2Documents = getDocuments($basePath, $branch, $year, 'sem-2');

// Helper function to format file size
function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Helper function to get icon based on file extension
function getFileIcon($extension)
{
    $extension = strtolower($extension);

    switch ($extension) {
        case 'pdf':
            return 'picture_as_pdf';
        case 'doc':
        case 'docx':
            return 'description';
        case 'xls':
        case 'xlsx':
            return 'table_chart';
        case 'ppt':
        case 'pptx':
            return 'slideshow';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'image';
        case 'zip':
        case 'rar':
        case '7z':
            return 'archive';
        default:
            return 'insert_drive_file';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Study Materials | Student Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
    <link rel="shortcut icon" href="./images/logo.png" />
    <link rel="stylesheet" href="style.css" />
    <style>
        /* Fix header positioning */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: var(--color-background);
            padding: 0 1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .materials {
            margin-top: 2rem;
        }

        .semester-section {
            margin-bottom: 2rem;
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .semester-section:hover {
            box-shadow: 0 0.7rem 1.5rem rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .semester-title {
            color: var(--color-primary);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--color-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .documents-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .document-card {
            background: var(--color-background);
            border-radius: 0.7rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid var(--color-light);
        }

        .document-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border-color: var(--color-primary);
        }

        .document-icon {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .document-icon span {
            font-size: 2rem;
            color: var(--color-primary);
            margin-right: 0.5rem;
        }

        .document-info {
            flex-grow: 1;
        }

        .document-name {
            font-weight: 600;
            margin-bottom: 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .document-meta {
            color: var(--color-dark-variant);
            font-size: 0.8rem;
        }

        .document-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.7rem;
        }

        .download-btn {
            display: flex;
            align-items: center;
            background: var(--color-primary);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background: var(--color-primary-variant);
            transform: scale(1.05);
        }

        .download-btn span {
            font-size: 1.2rem;
            margin-right: 0.3rem;
        }

        .no-documents {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem;
            color: var(--color-dark-variant);
        }

        .semester-toggle {
            background: transparent;
            border: none;
            cursor: pointer;
            color: var(--color-primary);
            font-size: 1.5rem;
        }

        /* Main container styles - adjusted for fixed header */
        main {
            margin-top: 4.5rem;
            /* Increased margin to account for fixed header */
            padding: 2rem;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            margin-left: 1rem;
            color: var(--color-primary);
        }

        .header-icon {
            font-size: 2.5rem;
            color: var(--color-primary);
        }

        /* Add breadcrumb styling */
        .breadcrumb {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: var(--color-dark-variant);
        }

        .breadcrumb span {
            margin: 0 0.5rem;
        }
    </style>
</head>

<body>
    <header>
        <a href="../" class="logo" title="Student-Portal">
            <img src="./images/logo.png" alt="">
            <h2>V<span class="danger">I</span>TS</h2>
        </a>
        <div class="navbar">
            <a href="./">
                <span class="material-icons-sharp">home</span>
                <h3>Home</h3>
            </a>
            <a href="timetable.html">
                <span class="material-icons-sharp">today</span>
                <h3>Time Table</h3>
            </a>
            <a href="materials.php" class="active">
                <span class="material-icons-sharp">book</span>
                <h3>Materials</h3>
            </a>
            <a href="password.php">
                <span class="material-icons-sharp">password</span>
                <h3>Change Password</h3>
            </a>
            <a href="../logout.php">
                <span class="material-icons-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
        <div id="profile-btn" style="display: none">
            <span class="material-icons-sharp">person</span>
        </div>
        <div class="theme-toggler">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>
    </header>

    <main>
        <div class="header">
            <span class="material-icons-sharp header-icon">menu_book</span>
            <h1>Study Materials</h1>
        </div>

        <div class="breadcrumb">
            <span>Department: <strong><?php echo strtoupper($branch); ?></strong></span>
            <span>•</span>
            <span>Year: <strong><?php echo $year; ?></strong></span>
        </div>

        <div class="materials">
            <!-- Semester 1 -->
            <div class="semester-section" id="sem1-section">
                <div class="semester-title">
                    <h2>Semester 1</h2>
                    <button class="semester-toggle" id="sem1-toggle" onclick="toggleSemester('sem1')">
                        <span class="material-icons-sharp">expand_more</span>
                    </button>
                </div>
                <div class="documents-list" id="sem1-documents">
                    <?php if (count($sem1Documents) > 0): ?>
                        <?php foreach ($sem1Documents as $doc): ?>
                            <div class="document-card">
                                <div class="document-icon">
                                    <span class="material-icons-sharp">
                                        <?php echo getFileIcon($doc['extension']); ?>
                                    </span>
                                </div>
                                <div class="document-info">
                                    <div class="document-name" title="<?php echo htmlspecialchars($doc['name']); ?>">
                                        <?php echo htmlspecialchars($doc['name']); ?>
                                    </div>
                                    <div class="document-meta">
                                        <?php echo formatFileSize($doc['size']); ?> • <?php echo $doc['extension']; ?>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <a href="download.php?file=<?php echo urlencode($doc['path']); ?>&name=<?php echo urlencode($doc['name']); ?>"
                                        class="download-btn">
                                        <span class="material-icons-sharp">download</span>
                                        Download
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-documents">
                            <span class="material-icons-sharp">info</span>
                            <p>No documents available for Semester 1</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Semester 2 -->
            <div class="semester-section" id="sem2-section">
                <div class="semester-title">
                    <h2>Semester 2</h2>
                    <button class="semester-toggle" id="sem2-toggle" onclick="toggleSemester('sem2')">
                        <span class="material-icons-sharp">expand_more</span>
                    </button>
                </div>
                <div class="documents-list" id="sem2-documents">
                    <?php if (count($sem2Documents) > 0): ?>
                        <?php foreach ($sem2Documents as $doc): ?>
                            <div class="document-card">
                                <div class="document-icon">
                                    <span class="material-icons-sharp">
                                        <?php echo getFileIcon($doc['extension']); ?>
                                    </span>
                                </div>
                                <div class="document-info">
                                    <div class="document-name" title="<?php echo htmlspecialchars($doc['name']); ?>">
                                        <?php echo htmlspecialchars($doc['name']); ?>
                                    </div>
                                    <div class="document-meta">
                                        <?php echo formatFileSize($doc['size']); ?> • <?php echo $doc['extension']; ?>
                                    </div>
                                </div>
                                <div class="document-actions">
                                    <a href="download.php?file=<?php echo urlencode($doc['path']); ?>&name=<?php echo urlencode($doc['name']); ?>"
                                        class="download-btn">
                                        <span class="material-icons-sharp">download</span>
                                        Download
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-documents">
                            <span class="material-icons-sharp">info</span>
                            <p>No documents available for Semester 2</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleSemester(sem) {
            const documentsDiv = document.getElementById(`${sem}-documents`);
            const toggleBtn = document.getElementById(`${sem}-toggle`);

            if (documentsDiv.style.display === 'none') {
                documentsDiv.style.display = 'grid';
                toggleBtn.innerHTML = '<span class="material-icons-sharp">expand_more</span>';
            } else {
                documentsDiv.style.display = 'none';
                toggleBtn.innerHTML = '<span class="material-icons-sharp">chevron_right</span>';
            }
        }
    </script>
    <script src="app.js"></script>
</body>

</html>