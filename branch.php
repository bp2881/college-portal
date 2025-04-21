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
        }

        header {
            background: linear-gradient(90deg, #ff6f61, #6b5b95);
            /* Coral to Purple gradient */
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        nav {
            background: linear-gradient(90deg, #42a5f5, #26a69a);
            /* Blue to Teal gradient */
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
            /* Gold hover */
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
            /* Purple for title */
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }

        .year-section {
            margin-bottom: 2rem;
        }

        .year-section h3 {
            font-size: 1.5rem;
            color: #6b5b95;
            /* Purple for year titles */
            margin-bottom: 1rem;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }

        .book-list {
            display: grid;
            gap: 1.5rem;
            opacity: 0;
            animation: fadeIn 0.9s ease-out forwards;
            animation-delay: 0.2s;
        }

        .book-item {
            background: linear-gradient(135deg, #ffffff, #e0f7fa);
            /* Light Blue to White gradient */
            border: 1px solid #d0d0d0;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06) inset;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .book-item:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 6px 16px rgba(107, 91, 149, 0.2), 0 2px 4px rgba(0, 0, 0, 0.06) inset;
            /* Purple shadow */
        }

        .book-item span {
            font-size: 1.1rem;
            font-weight: 600;
            color: #424242;
        }

        .book-item a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ffffff;
            background: linear-gradient(45deg, #ffca28, #ff7043);
            /* Yellow to Orange gradient */
            text-decoration: none;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .book-item a:hover {
            background: linear-gradient(45deg, #f9a825, #f4511e);
            /* Darker Yellow to Red gradient */
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(255, 202, 40, 0.5);
        }

        .book-item a::before {
            content: '↓';
            font-size: 1.1rem;
            margin-right: 0.3rem;
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
            /* Coral for links */
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .error-message a:hover {
            text-decoration: underline;
            color: #6b5b95;
            /* Purple hover */
        }

        .loader {
            display: none;
            border: 4px solid #d0d0d0;
            border-top: 4px solid #ffca28;
            /* Yellow loader */
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
            margin: 1.5rem auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

            nav a {
                margin: 0 1rem;
                font-size: 1rem;
            }

            .book-item {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .container {
                margin: 1.5rem auto;
                padding: 0 0.5rem;
            }

            .container h2 {
                font-size: 1.8rem;
            }

            .year-section h3 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Vignan Dhara Online Portal</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="container">
        <h2 id="branch-title">Branch Resources</h2>
        <div class="loader" id="loader"></div>
        <div class="book-list" id="book-list"></div>
    </div>

    <footer>
        <p>© 2025 Vignan Dhara Library. All rights reserved.</p>
    </footer>

    <script>
        const books = {
            BSH: [
                { title: "Engineering Mathematics", url: "pdfs/bsh/math.pdf" },
                { title: "Engineering Physics", url: "pdfs/bsh/physics.pdf" },
                { title: "Technical English", url: "pdfs/bsh/english.pdf" }
            ],
            CSE: [
                { year: 2, title: "Data Structures", url: "pdfs/cse_2/ds.pdf" },
                { year: 2, title: "Object-Oriented Programming", url: "pdfs/cse_2/oop.pdf" },
                { year: 3, title: "Operating Systems", url: "pdfs/cse_3/os.pdf" },
                { year: 3, title: "Database Management Systems", url: "pdfs/cse_3/dbms.pdf" },
                { year: 4, title: "Machine Learning", url: "pdfs/cse_4/ml.pdf" },
                { year: 4, title: "Cloud Computing", url: "pdfs/cse_4/cloud.pdf" }
            ],
            ECE: [
                { year: 2, title: "Digital Electronics", url: "pdfs/ece_2/digital.pdf" },
                { year: 2, title: "Circuit Theory", url: "pdfs/ece_2/circuit.pdf" },
                { year: 3, title: "Signals and Systems", url: "pdfs/ece_3/signals.pdf" },
                { year: 3, title: "Microprocessors", url: "pdfs/ece_3/micro.pdf" },
                { year: 4, title: "VLSI Design", url: "pdfs/ece_4/vlsi.pdf" },
                { year: 4, title: "Wireless Communication", url: "pdfs/ece_4/wireless.pdf" }
            ],
            EEE: [
                { year: 2, title: "Electrical Circuits", url: "pdfs/eee_2/circuits.pdf" },
                { year: 2, title: "Electromagnetic Fields", url: "pdfs/eee_2/emf.pdf" },
                { year: 3, title: "Power Electronics", url: "pdfs/eee_3/power_elec.pdf" },
                { year: 3, title: "Control Systems", url: "pdfs/eee_3/control.pdf" },
                { year: 4, title: "High Voltage Engineering", url: "pdfs/eee_4/high_voltage.pdf" },
                { year: 4, title: "Renewable Energy", url: "pdfs/eee_4/renewable.pdf" }
            ],
            CE: [
                { year: 2, title: "Strength of Materials", url: "pdfs/ce_2/som.pdf" },
                { year: 2, title: "Fluid Mechanics", url: "pdfs/ce_2/fluid.pdf" },
                { year: 3, title: "Structural Analysis", url: "pdfs/ce_3/structures.pdf" },
                { year: 3, title: "Geotechnical Engineering", url: "pdfs/ce_3/geotech.pdf" },
                { year: 4, title: "Construction Management", url: "pdfs/ce_4/construction.pdf" },
                { year: 4, title: "Environmental Engineering", url: "pdfs/ce_4/env.pdf" }
            ],
            MECH: [
                { year: 2, title: "Thermodynamics", url: "pdfs/mech_2/thermo.pdf" },
                { year: 2, title: "Mechanics of Solids", url: "pdfs/mech_2/solids.pdf" },
                { year: 3, title: "Machine Design", url: "pdfs/mech_3/design.pdf" },
                { year: 3, title: "Heat Transfer", url: "pdfs/mech_3/heat.pdf" },
                { year: 4, title: "CAD/CAM", url: "pdfs/mech_4/cadcam.pdf" },
                { year: 4, title: "Robotics", url: "pdfs/mech_4/robotics.pdf" }
            ],
            EIE: [
                { year: 2, title: "Instrumentation", url: "pdfs/eie_2/instru.pdf" },
                { year: 2, title: "Sensors", url: "pdfs/eie_2/sensors.pdf" },
                { year: 3, title: "Process Control", url: "pdfs/eie_3/process.pdf" },
                { year: 3, title: "Biomedical Instrumentation", url: "pdfs/eie_3/biomed.pdf" },
                { year: 4, title: "Industrial Automation", url: "pdfs/eie_4/automation.pdf" },
                { year: 4, title: "Advanced Control Systems", url: "pdfs/eie_4/advanced.pdf" }
            ],
            IT: [
                { year: 2, title: "Computer Networks", url: "pdfs/it_2/networks.pdf" },
                { year: 2, title: "Web Technologies", url: "pdfs/it_2/web.pdf" },
                { year: 3, title: "Software Engineering", url: "pdfs/it_3/software.pdf" },
                { year: 3, title: "Cyber Security", url: "pdfs/it_3/security.pdf" },
                { year: 4, title: "Cloud Computing", url: "pdfs/it_4/cloud.pdf" },
                { year: 4, title: "Big Data Analytics", url: "pdfs/it_4/bigdata.pdf" }
            ],
            CSE_AIML: [
                { year: 2, title: "Python Programming", url: "pdfs/cse_aiml_2/python.pdf" },
                { year: 2, title: "Mathematics for AI", url: "pdfs/cse_aiml_2/math.pdf" },
                { year: 3, title: "Machine Learning Basics", url: "pdfs/cse_aiml_3/ml_basics.pdf" },
                { year: 3, title: "Deep Learning", url: "pdfs/cse_aiml_3/deep.pdf" },
                { year: 4, title: "Natural Language Processing", url: "pdfs/cse_aiml_4/nlp.pdf" },
                { year: 4, title: "AI Ethics", url: "pdfs/cse_aiml_4/ethics.pdf" }
            ],
            CSE_DS: [
                { year: 2, title: "Statistics", url: "pdfs/cse_ds_2/stats.pdf" },
                { year: 2, title: "Data Structures", url: "pdfs/cse_ds_2/ds.pdf" },
                { year: 3, title: "Data Mining", url: "pdfs/cse_ds_3/mining.pdf" },
                { year: 3, title: "Machine Learning", url: "pdfs/cse_ds_3/ml.pdf" },
                { year: 4, title: "Big Data", url: "pdfs/cse_ds_4/bigdata.pdf" },
                { year: 4, title: "Data Visualization", url: "pdfs/cse_ds_4/vis.pdf" }
            ],
            AIDS: [
                { year: 2, title: "Introduction to AI", url: "pdfs/aids_2/ai_intro.pdf" },
                { year: 2, title: "Data Science Basics", url: "pdfs/aids_2/ds_basics.pdf" },
                { year: 3, title: "AI Algorithms", url: "pdfs/aids_3/ai_algo.pdf" },
                { year: 3, title: "Data Analysis", url: "pdfs/aids_3/analysis.pdf" },
                { year: 4, title: "Advanced AI", url: "pdfs/aids_4/advanced_ai.pdf" },
                { year: 4, title: "Big Data Applications", url: "pdfs/aids_4/bigdata_app.pdf" }
            ]
        };

        function loadBooks() {
            const loader = document.getElementById('loader');
            const bookList = document.getElementById('book-list');
            const branchTitle = document.getElementById('branch-title');
            loader.style.display = 'block';
            bookList.style.display = 'none';

            const urlParams = new URLSearchParams(window.location.search);
            const branch = urlParams.get('branch');

            if (branch && books[branch]) {
                branchTitle.textContent = `${branch.replace('_', ' ')} Resources`;
                if (branch === 'BSH') {
                    books[branch].forEach(book => {
                        const bookItem = document.createElement('div');
                        bookItem.className = 'book-item';
                        bookItem.innerHTML = `
                            <span>${book.title}</span>
                            <a href="${book.url}" target="_blank">Download PDF</a>
                        `;
                        bookList.appendChild(bookItem);
                    });
                } else {
                    const years = [2, 3, 4];
                    years.forEach(year => {
                        const yearBooks = books[branch].filter(book => book.year === year);
                        if (yearBooks.length > 0) {
                            const yearSection = document.createElement('div');
                            yearSection.className = 'year-section';
                            yearSection.innerHTML = `<h3>${year === 2 ? '2nd' : year === 3 ? '3rd' : '4th'} Year</h3>`;
                            const yearList = document.createElement('div');
                            yearList.className = 'book-list';
                            yearBooks.forEach(book => {
                                const bookItem = document.createElement('div');
                                bookItem.className = 'book-item';
                                bookItem.innerHTML = `
                                    <span>${book.title}</span>
                                    <a href="${book.url}" target="_blank">Download PDF</a>
                                `;
                                yearList.appendChild(bookItem);
                            });
                            yearSection.appendChild(yearList);
                            bookList.appendChild(yearSection);
                        }
                    });
                }
            } else {
                branchTitle.textContent = 'Error';
                bookList.innerHTML = `
                    <p class="error-message">
                        Invalid branch or no resources available.
                        <a href="index.php">Return to Home</a>
                    </p>
                `;
            }

            loader.style.display = 'none';
            bookList.style.display = 'block';
        }

        window.onload = loadBooks;
    </script>
</body>

</html>