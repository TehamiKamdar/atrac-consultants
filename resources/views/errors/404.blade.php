<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #2BB673;
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
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        h1 {
            font-size: 6rem;
            margin: 0;
            line-height: 1;
            font-weight: 700;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2rem;
            margin: 1rem 0;
            font-weight: 600;
        }

        p {
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 2rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .btn {
            display: inline-block;
            padding: 12px 32px;
            background-color: white;
            color: #2BB673;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .illustration {
            width: 300px;
            height: 300px;
            margin: 0 auto 2rem;
        }

        .bubble {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: -1;
        }

        .bubble-1 {
            width: 150px;
            height: 150px;
            top: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite;
        }

        .bubble-2 {
            width: 250px;
            height: 250px;
            bottom: -100px;
            right: -50px;
            animation: float 12s ease-in-out infinite;
        }

        .bubble-3 {
            width: 80px;
            height: 80px;
            top: 30%;
            right: 10%;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 4rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .illustration {
                width: 200px;
                height: 200px;
            }

            .bubble {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Decorative bubbles -->
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>

    <div class="container">
        <!-- Main illustration -->
        <svg class="illustration" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <!-- Background circle -->
            <circle cx="100" cy="100" r="90" fill="none" stroke="white" stroke-width="4" stroke-dasharray="10,5" opacity="0.3"/>

            <!-- Magnifying glass -->
            <circle cx="130" cy="70" r="40" fill="none" stroke="white" stroke-width="8"/>
            <path d="M170 110 L200 140" stroke="white" stroke-width="8" stroke-linecap="round"/>

            <!-- Floating elements -->
            <circle cx="60" cy="60" r="10" fill="white" opacity="0.8">
                <animateTransform attributeName="transform" type="translate" values="0,0; 0,-10; 0,0" dur="5s" repeatCount="indefinite"/>
            </circle>

            <rect x="40" y="120" width="20" height="20" rx="4" fill="white" opacity="0.6" transform="rotate(45 50 130)">
                <animateTransform attributeName="transform" type="rotate" values="45 50 130; 55 50 130; 45 50 130" dur="7s" repeatCount="indefinite"/>
            </rect>

            <!-- 404 text inside magnifying glass -->
            <text x="130" y="80" font-family="Poppins" font-size="24" font-weight="bold" fill="white" text-anchor="middle" opacity="0.8">404</text>
        </svg>

        <h1>Oops!</h1>
        <h2>We can't find that page</h2>
        <p>The page you're looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="/" class="btn">Back to Homepage</a>
    </div>
</body>
</html>
