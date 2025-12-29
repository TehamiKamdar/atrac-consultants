<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Maintenance in Progress</title>
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/bambino-2">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

        :root {
            --primary: #2BB673;
            --primary-light: rgba(255, 255, 255, 0.15);
            --primary-lighter: rgba(255, 255, 255, 0.25);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary);
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            overflow: hidden;
        }

        .container {
            max-width: 800px;
            padding: 3rem 2rem;
            position: relative;
            z-index: 2;
        }

        h1 {
            font-size: 3.25rem;
            font-weight: 700;
            font-family: 'Bambino-Bold', Arial, Helvetica, sans-serif;
            background: linear-gradient(90deg, white, #e6ffe6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        h2 {
            font-size: 1.45rem;
            font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
            font-weight: 400;
            opacity: 0.9;
        }

        p {
            font-size: 1rem;
            max-width: 600px;
            font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
            line-height: 1.6;
            opacity: 0.85;
        }

        .progress-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto 3rem;
            background-color: var(--primary-light);
            border-radius: 50px;
            height: 12px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            width: 65%;
            background-color: white;
            border-radius: 50px;
            position: relative;
            animation: progress-pulse 2.5s ease-in-out infinite;
        }

        @keyframes progress-pulse {
            0% { opacity: 0.8; }
            50% { opacity: 1; }
            100% { opacity: 0.8; }
        }

        .maintenance-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            max-width: 400px;
            margin: 0 auto 3rem;
        }

        .maintenance-cell {
            height: 40px;
            background-color: var(--primary-light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-family: 'Bambino-Light', Arial, Helvetica, sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
            animation: cell-float 4s ease-in-out infinite;
        }

        @keyframes cell-float {
            0%, 100% { transform: translateY(0); opacity: 0.7; }
            50% { transform: translateY(-5px); opacity: 1; }
        }

        /* Individual cell animations */
        .maintenance-cell:nth-child(1) { animation-delay: 0s; }
        .maintenance-cell:nth-child(2) { animation-delay: 0.2s; }
        .maintenance-cell:nth-child(3) { animation-delay: 0.4s; }
        .maintenance-cell:nth-child(4) { animation-delay: 0.6s; }
        .maintenance-cell:nth-child(5) { animation-delay: 0.8s; }
        .maintenance-cell:nth-child(6) { animation-delay: 1s; }
        .maintenance-cell:nth-child(7) { animation-delay: 1.2s; }
        .maintenance-cell:nth-child(8) { animation-delay: 1.4s; }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 15s linear infinite;
        }

        .shape--1 {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 5%;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }

        .shape--2 {
            width: 150px;
            height: 150px;
            bottom: 15%;
            right: 5%;
            background: white;
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
        }

        .shape--3 {
            width: 60px;
            height: 60px;
            top: 60%;
            left: 20%;
            background: white;
            border-radius: 50%;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(10deg); }
            50% { transform: translate(100px, 0) rotate(20deg); }
            75% { transform: translate(50px, -50px) rotate(10deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .maintenance-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            animation: spin 3s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 1.2rem;
            }

            .maintenance-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape shape--1"></div>
        <div class="shape shape--2"></div>
        <div class="shape shape--3"></div>
    </div>

    <div class="container">
        <div class="maintenance-icon">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 7L18 3M18 3L21 6M18 3L15 10M10 5L4 19L6.5 21.5L20 14L17 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 21L9 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1>System Maintenance</h1>
        <h2>We're upgrading our systems to serve you better</h2>
        <p>Our website is currently undergoing scheduled maintenance. We're working hard to improve your experience and will be back online shortly.</p>

        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <div class="maintenance-grid">
            <div class="maintenance-cell">SERVER</div>
            <div class="maintenance-cell">DATABASE</div>
            <div class="maintenance-cell">SECURITY</div>
            <div class="maintenance-cell">UPDATE</div>
            <div class="maintenance-cell">BACKUP</div>
            <div class="maintenance-cell">OPTIMIZE</div>
            <div class="maintenance-cell">TESTING</div>
            <div class="maintenance-cell">DEPLOY</div>
        </div>
    </div>
</body>
</html>