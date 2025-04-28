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

        .year-section {
            margin-bottom: 2rem;
        }

        .year-section h3 {
            font-size: 1.5rem;
            color: #6b5b95;
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
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(255, 202, 40, 0.5);
        }

        .book-item a::before {
            content: '↓';
            font-size: 1.1rem;
            margin-right: 0.3rem;
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
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out, opacity 0.5s ease-out;
            opacity: 0;
        }

        .resource-content.active {
            max-height: 600px;
            opacity: 1;
        }

        .nested-resource-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out, opacity 0.5s ease-out;
            opacity: 0;
        }

        .nested-resource-content.active {
            max-height: 500px;
            opacity: 1;
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

        .loader {
            display: none;
            border: 4px solid #d0d0d0;
            border-top: 4px solid #ffca28;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
            margin: 1.5rem auto;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #f5f5f0;
            padding: 0.5rem;
            text-align: center;
            color: #424242;
            font-size: 0.9rem;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
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

            #logo {
                height: 40px;
                top: 0.8rem;
                left: 0.8rem;
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
                padding-bottom: 3rem;
            }

            .container h2 {
                font-size: 1.8rem;
            }

            .year-section h3 {
                font-size: 1.3rem;
            }

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
        }
    </style>
</head>

<body>
    <header>
        <img id="logo" src="./images/vignan_logo.png" alt="Vignan Logo">
        <div class="header-title">
            <h1>Vignan Dhara Online Portal</h1>
        </div>
    </header>

    <nav>
        <a href="books.php"><img src="./images/arrow_left.png" alt="<-"></a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="container">
        <h2 id="branch-title">Branch Resources</h2>
        <div class="loader" id="loader"></div>
        <div class="book-list" id="book-list"></div>
    </div>

    <footer class="footer">
        <p>© 2025 Vignan Dhara Library. All rights reserved.</p>
    </footer>

    <script>
        const books = {
            BSH: {
                'sem-1': [
                    { title: "Engineering Mathematics", url: "books/bsh/sem1/math.pdf" },
                    { title: "Engineering Physics", url: "books/bsh/sem1/physics.pdf" }
                ],
                'sem-2': [
                    { title: "Technical English", url: "books/bsh/sem2/english.pdf" }
                ]
            },
            CSE: {
                'year-2': {
                    'sem-1': [
                        { title: "Data Structures", url: "books/cse/2/ds.pdf" }
                    ],
                    'sem-2': [
                        { title: "Object-Oriented Programming", url: "books/cse/2/oop.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Operating Systems", url: "books/cse/3/os.pdf" },
                        { title: "Database Management Systems", url: "books/cse/3/dbms.pdf" }
                    ],
                    'sem-2': [
                        { title: "Machine Learning", url: "books/cse/4/ml.pdf" },
                        { title: "Cloud Computing", url: "books/cse/4/cloud.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Operating Systems", url: "books/cse/3/os.pdf" },
                        { title: "Database Management Systems", url: "books/cse/3/dbms.pdf" }
                    ],
                    'sem-2': [
                        { title: "Machine Learning", url: "books/cse/4/ml.pdf" },
                        { title: "Cloud Computing", url: "books/cse/4/cloud.pdf" }
                    ]
                }
            },
            ECE: {
                'year-2': {
                    'sem-1': [
                        { title: "Digital Electronics", url: "books/ece_2/digital.pdf" }
                    ],
                    'sem-2': [
                        { title: "Circuit Theory", url: "books/ece_2/circuit.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Signals and Systems", url: "books/ece_3/signals.pdf" },
                        { title: "Microprocessors", url: "books/ece_3/micro.pdf" }
                    ],
                    'sem-2': [
                        { title: "VLSI Design", url: "books/ece_4/vlsi.pdf" },
                        { title: "Wireless Communication", url: "books/ece_4/wireless.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Signals and Systems", url: "books/ece_3/signals.pdf" },
                        { title: "Microprocessors", url: "books/ece_3/micro.pdf" }
                    ],
                    'sem-2': [
                        { title: "VLSI Design", url: "books/ece_4/vlsi.pdf" },
                        { title: "Wireless Communication", url: "books/ece_4/wireless.pdf" }
                    ]
                }
            },
            EEE: {
                'year-2': {
                    'sem-1': [
                        { title: "Electrical Circuits", url: "books/eee_2/circuits.pdf" }
                    ],
                    'sem-2': [
                        { title: "Electromagnetic Fields", url: "books/eee_2/emf.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Power Electronics", url: "books/eee_3/power_elec.pdf" },
                        { title: "Control Systems", url: "books/eee_3/control.pdf" }
                    ],
                    'sem-2': [
                        { title: "High Voltage Engineering", url: "books/eee_4/high_voltage.pdf" },
                        { title: "Renewable Energy", url: "books/eee_4/renewable.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Power Electronics", url: "books/eee_3/power_elec.pdf" },
                        { title: "Control Systems", url: "books/eee_3/control.pdf" }
                    ],
                    'sem-2': [
                        { title: "High Voltage Engineering", url: "books/eee_4/high_voltage.pdf" },
                        { title: "Renewable Energy", url: "books/eee_4/renewable.pdf" }
                    ]
                }
            },
            CE: {
                'year-2': {
                    'sem-1': [
                        { title: "Strength of Materials", url: "books/ce_2/som.pdf" }
                    ],
                    'sem-2': [
                        { title: "Fluid Mechanics", url: "books/ce_2/fluid.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Structural Analysis", url: "books/ce_3/structures.pdf" },
                        { title: "Geotechnical Engineering", url: "books/ce_3/geotech.pdf" }
                    ],
                    'sem-2': [
                        { title: "Construction Management", url: "books/ce_4/construction.pdf" },
                        { title: "Environmental Engineering", url: "books/ce_4/env.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Structural Analysis", url: "books/ce_3/structures.pdf" },
                        { title: "Geotechnical Engineering", url: "books/ce_3/geotech.pdf" }
                    ],
                    'sem-2': [
                        { title: "Construction Management", url: "books/ce_4/construction.pdf" },
                        { title: "Environmental Engineering", url: "books/ce_4/env.pdf" }
                    ]
                }
            },
            MECH: {
                'year-2': {
                    'sem-1': [
                        { title: "Thermodynamics", url: "books/mech_2/thermo.pdf" }
                    ],
                    'sem-2': [
                        { title: "Mechanics of Solids", url: "books/mech_2/solids.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Machine Design", url: "books/mech_3/design.pdf" },
                        { title: "Heat Transfer", url: "books/mech_3/heat.pdf" }
                    ],
                    'sem-2': [
                        { title: "CAD/CAM", url: "books/mech_4/cadcam.pdf" },
                        { title: "Robotics", url: "books/mech_4/robotics.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Machine Design", url: "books/mech_3/design.pdf" },
                        { title: "Heat Transfer", url: "books/mech_3/heat.pdf" }
                    ],
                    'sem-2': [
                        { title: "CAD/CAM", url: "books/mech_4/cadcam.pdf" },
                        { title: "Robotics", url: "books/mech_4/robotics.pdf" }
                    ]
                }
            },
            EIE: {
                'year-2': {
                    'sem-1': [
                        { title: "Instrumentation", url: "books/eie_2/instru.pdf" }
                    ],
                    'sem-2': [
                        { title: "Sensors", url: "books/eie_2/sensors.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Process Control", url: "books/eie_3/process.pdf" },
                        { title: "Biomedical Instrumentation", url: "books/eie_3/biomed.pdf" }
                    ],
                    'sem-2': [
                        { title: "Industrial Automation", url: "books/eie_4/automation.pdf" },
                        { title: "Advanced Control Systems", url: "books/eie_4/advanced.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Process Control", url: "books/eie_3/process.pdf" },
                        { title: "Biomedical Instrumentation", url: "books/eie_3/biomed.pdf" }
                    ],
                    'sem-2': [
                        { title: "Industrial Automation", url: "books/eie_4/automation.pdf" },
                        { title: "Advanced Control Systems", url: "books/eie_4/advanced.pdf" }
                    ]
                }
            },
            IT: {
                'year-2': {
                    'sem-1': [
                        { title: "Computer Networks", url: "books/it_2/networks.pdf" }
                    ],
                    'sem-2': [
                        { title: "Web Technologies", url: "books/it_2/web.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Software Engineering", url: "books/it_3/software.pdf" },
                        { title: "Cyber Security", url: "books/it_3/security.pdf" }
                    ],
                    'sem-2': [
                        { title: "Cloud Computing", url: "books/it_4/cloud.pdf" },
                        { title: "Big Data Analytics", url: "books/it_4/bigdata.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Software Engineering", url: "books/it_3/software.pdf" },
                        { title: "Cyber Security", url: "books/it_3/security.pdf" }
                    ],
                    'sem-2': [
                        { title: "Cloud Computing", url: "books/it_4/cloud.pdf" },
                        { title: "Big Data Analytics", url: "books/it_4/bigdata.pdf" }
                    ]
                }
            },
            CSE_AIML: {
                'year-2': {
                    'sem-1': [
                        { title: "Python Programming", url: "books/cse_aiml_2/python.pdf" }
                    ],
                    'sem-2': [
                        { title: "Mathematics for AI", url: "books/cse_aiml_2/math.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Machine Learning Basics", url: "books/cse_aiml_3/ml_basics.pdf" },
                        { title: "Deep Learning", url: "books/cse_aiml_3/deep.pdf" }
                    ],
                    'sem-2': [
                        { title: "Natural Language Processing", url: "books/cse_aiml_4/nlp.pdf" },
                        { title: "AI Ethics", url: "books/cse_aiml_4/ethics.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Machine Learning Basics", url: "books/cse_aiml_3/ml_basics.pdf" },
                        { title: "Deep Learning", url: "books/cse_aiml_3/deep.pdf" }
                    ],
                    'sem-2': [
                        { title: "Natural Language Processing", url: "books/cse_aiml_4/nlp.pdf" },
                        { title: "AI Ethics", url: "books/cse_aiml_4/ethics.pdf" }
                    ]
                }
            },
            CSE_DS: {
                'year-2': {
                    'sem-1': [
                        { title: "Statistics", url: "books/cse_ds_2/stats.pdf" }
                    ],
                    'sem-2': [
                        { title: "Data Structures", url: "books/cse_ds_2/ds.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "Data Mining", url: "books/cse_ds_3/mining.pdf" },
                        { title: "Machine Learning", url: "books/cse_ds_3/ml.pdf" }
                    ],
                    'sem-2': [
                        { title: "Big Data", url: "books/cse_ds_4/bigdata.pdf" },
                        { title: "Data Visualization", url: "books/cse_ds_4/vis.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "Data Mining", url: "books/cse_ds_3/mining.pdf" },
                        { title: "Machine Learning", url: "books/cse_ds_3/ml.pdf" }
                    ],
                    'sem-2': [
                        { title: "Big Data", url: "books/cse_ds_4/bigdata.pdf" },
                        { title: "Data Visualization", url: "books/cse_ds_4/vis.pdf" }
                    ]
                }
            },
            AIDS: {
                'year-2': {
                    'sem-1': [
                        { title: "Introduction to AI", url: "books/aids_2/ai_intro.pdf" }
                    ],
                    'sem-2': [
                        { title: "Data Science Basics", url: "books/aids_2/ds_basics.pdf" }
                    ]
                },
                'year-3': {
                    'sem-1': [
                        { title: "AI Algorithms", url: "books/aids_3/ai_algo.pdf" },
                        { title: "Data Analysis", url: "books/aids_3/analysis.pdf" }
                    ],
                    'sem-2': [
                        { title: "Advanced AI", url: "books/aids_4/advanced_ai.pdf" },
                        { title: "Big Data Applications", url: "books/aids_4/bigdata_app.pdf" }
                    ]
                },
                'year-4': {
                    'sem-1': [
                        { title: "AI Algorithms", url: "books/aids_3/ai_algo.pdf" },
                        { title: "Data Analysis", url: "books/aids_3/analysis.pdf" }
                    ],
                    'sem-2': [
                        { title: "Advanced AI", url: "books/aids_4/advanced_ai.pdf" },
                        { title: "Big Data Applications", url: "books/aids_4/bigdata_app.pdf" }
                    ]
                }
            }
        };

        function loadBooks() {
            const loader = document.getElementById('loader');
            const bookList = document.getElementById('book-list');
            const branchTitle = document.getElementById('branch-title');
            loader.style.display = 'block';
            bookList.style.display = 'none';
            bookList.innerHTML = '';

            const urlParams = new URLSearchParams(window.location.search);
            const branch = urlParams.get('branch');

            if (branch && books[branch]) {
                branchTitle.textContent = `${branch.replace('_', ' ')} Resources`;
                if (branch === 'BSH') {
                    const boxContainer = document.createElement('div');
                    boxContainer.className = 'box-container';
                    const periods = ['sem-1', 'sem-2'];
                    const labels = ['Semester 1', 'Semester 2'];
                    boxContainer.innerHTML = `
                        <div class="resource-box" data-period="${periods[0]}">${labels[0]}</div>
                        <div class="resource-box" data-period="${periods[1]}">${labels[1]}</div>
                    `;
                    bookList.appendChild(boxContainer);

                    periods.forEach(period => {
                        const contentDiv = document.createElement('div');
                        contentDiv.className = 'resource-content';
                        contentDiv.id = period;
                        const periodList = document.createElement('div');
                        periodList.className = 'book-list';
                        books[branch][period].forEach(book => {
                            const bookItem = document.createElement('div');
                            bookItem.className = 'book-item';
                            bookItem.innerHTML = `
                                <span>${book.title}</span>
                                <a href="${book.url}" target="_blank">Download PDF</a>
                            `;
                            periodList.appendChild(bookItem);
                        });
                        contentDiv.appendChild(periodList);
                        bookList.appendChild(contentDiv);
                    });

                    const boxes = document.querySelectorAll('.resource-box');
                    boxes.forEach(box => {
                        box.addEventListener('click', () => {
                            const period = box.getAttribute('data-period');
                            const content = document.getElementById(period);
                            const isActive = content.classList.contains('active');

                            boxes.forEach(b => b.classList.remove('highlighted'));
                            box.classList.add('highlighted');

                            document.querySelectorAll('.resource-content').forEach(c => {
                                c.classList.remove('active');
                            });

                            if (!isActive) {
                                requestAnimationFrame(() => {
                                    content.classList.add('active');
                                });
                            }
                        });
                    });
                } else {
                    const boxContainer = document.createElement('div');
                    boxContainer.className = 'box-container';
                    const years = ['year-2', 'year-3', 'year-4'];
                    const yearLabels = ['Year 2', 'Year 3', 'Year 4'];
                    boxContainer.innerHTML = years
                        .map((year, index) => `<div class="resource-box" data-period="${year}">${yearLabels[index]}</div>`)
                        .join('');
                    bookList.appendChild(boxContainer);

                    years.forEach(year => {
                        if (books[branch][year]) {
                            const contentDiv = document.createElement('div');
                            contentDiv.className = 'resource-content';
                            contentDiv.id = year;
                            const nestedBoxContainer = document.createElement('div');
                            nestedBoxContainer.className = 'nested-box-container';
                            const semesters = ['sem-1َّ', 'sem-2'];
                            const semLabels = ['Semester 1', 'Semester 2'];
                            nestedBoxContainer.innerHTML = `
                                <div class="nested-resource-box" data-sem="${year}-sem-1">${semLabels[0]}</div>
                                <div class="nested-resource-box" data-sem="${year}-sem-2">${semLabels[1]}</div>
                            `;
                            contentDiv.appendChild(nestedBoxContainer);

                            semesters.forEach(sem => {
                                if (books[branch][year][sem]) {
                                    const nestedContentDiv = document.createElement('div');
                                    nestedContentDiv.className = 'nested-resource-content';
                                    nestedContentDiv.id = `${year}-${sem}`;
                                    const semList = document.createElement('div');
                                    semList.className = 'book-list';
                                    books[branch][year][sem].forEach(book => {
                                        const bookItem = document.createElement('div');
                                        bookItem.className = 'book-item';
                                        bookItem.innerHTML = `
                                            <span>${book.title}</span>
                                            <a href="${book.url}" target="_blank">Download PDF</a>
                                        `;
                                        semList.appendChild(bookItem);
                                    });
                                    nestedContentDiv.appendChild(semList);
                                    contentDiv.appendChild(nestedContentDiv);
                                }
                            });

                            bookList.appendChild(contentDiv);
                        }
                    });

                    const yearBoxes = document.querySelectorAll('.resource-box');
                    yearBoxes.forEach(box => {
                        box.addEventListener('click', () => {
                            const year = box.getAttribute('data-period');
                            const content = document.getElementById(year);
                            const isActive = content && content.classList.contains('active');

                            yearBoxes.forEach(b => b.classList.remove('highlighted'));
                            box.classList.add('highlighted');

                            document.querySelectorAll('.resource-content').forEach(c => {
                                c.classList.remove('active');
                            });
                            document.querySelectorAll('.nested-resource-content').forEach(c => {
                                c.classList.remove('active');
                            });

                            if (content && !isActive) {
                                requestAnimationFrame(() => {
                                    content.classList.add('active');
                                });
                            }
                        });
                    });

                    const semBoxes = document.querySelectorAll('.nested-resource-box');
                    semBoxes.forEach(box => {
                        box.addEventListener('click', () => {
                            const sem = box.getAttribute('data-sem');
                            const content = document.getElementById(sem);
                            const isActive = content && content.classList.contains('active');

                            const year = sem.split('-')[0] + '-' + sem.split('-')[1];
                            document.querySelectorAll(`#${year} .nested-resource-box`).forEach(c => {
                                c.classList.remove('highlighted');
                            });
                            box.classList.add('highlighted');

                            document.querySelectorAll(`#${year} .nested-resource-content`).forEach(c => {
                                c.classList.remove('active');
                            });

                            if (content && !isActive) {
                                requestAnimationFrame(() => {
                                    content.classList.add('active');
                                });
                            }
                        });
                    });
                }
            } else {
                branchTitle.textContent = 'Error';
                bookList.innerHTML = `
                    <p class="error-message">
                        Invalid branch or no resources available.
                        <a href="books.php">Return to Home</a>
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