<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vignan Dhara - Branch Resources</title>
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
        }

        /* Header with flexbox to accommodate logo and centered title */
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

        /* Logo styling: absolute positioning at top left */
        #logo {
            height: 50px;
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }

        /* Centers the header title while allowing logo space */
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
        }

        .container h2 {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 2rem;
            color: #6b5b95;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }

        .branch-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            animation: fadeIn 0.9s ease-out;
        }

        .branch-card {
            background: linear-gradient(135deg, #ffffff, #e0f7fa);
            border: 1px solid #d0d0d0;
            border-radius: 10px;
            padding: 1.8rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06) inset;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .branch-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 6px 16px rgba(107, 91, 149, 0.2), 0 2px 4px rgba(0, 0, 0, 0.06) inset;
        }

        .branch-card a {
            text-decoration: none;
            color: #424242;
            font-size: 1.2rem;
            font-weight: 600;
            display: block;
            padding: 0.5rem 0;
            transition: color 0.3s ease, text-shadow 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .branch-card a:hover {
            color: #ff6f61;
            text-shadow: 0 0 8px rgba(255, 111, 97, 0.3);
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
            font-size: 0.95rem;
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
            header h1 {
                font-size: 1.6rem;
            }

            /* Responsive logo size for mobile */
            #logo {
                height: 40px;
                top: 0.8rem;
                left: 0.8rem;
            }

            nav a {
                margin: 0 1rem;
                font-size: 1rem;
            }

            .branch-grid {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 1.5rem auto;
                padding: 0 0.5rem;
            }

            .container h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <!-- Vignan logo positioned at top left -->
        <img id="logo" src="./images/vignan_logo.png" alt="Vignan Logo">
        <!-- Wrapper to center the title while logo is absolute -->
        <div class="header-title">
            <h1>Vignan Dhara Online Portal</h1>
        </div>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="container">
        <h2>Academic Branches</h2>
        <div class="branch-grid">
            <div class="branch-card">
                <a href="branch.php?branch=BSH">Basic Sciences & Humanities (BSH)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=CSE">Computer Science & Engineering (CSE)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=ECE">Electronics & Communication Engineering (ECE)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=EEE">Electrical & Electronics Engineering (EEE)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=CE">Civil Engineering (CE)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=MECH">Mechanical Engineering (MECH)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=EIE">Electronics & Instrumentation Engineering (EIE)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=IT">Information Technology (IT)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=CSE_AIML">CSE (Artificial Intelligence & Machine Learning)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=CSE_DS">CSE (Data Science)</a>
            </div>
            <div class="branch-card">
                <a href="branch.php?branch=AIDS">Artificial Intelligence & Data Science (AI&DS)</a>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 Vignan Dhara Library. All rights reserved.</p>
    </footer>
</body>

</html>