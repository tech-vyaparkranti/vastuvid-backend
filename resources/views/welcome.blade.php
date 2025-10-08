{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyaparkranti Animated Box</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        
        .vyaparkranti-box {
            width: 250px;
            height: 250px;
            border-radius: 15px;
            background: linear-gradient(45deg, #0d6efd, #6610f2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }
        
        .vyaparkranti-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        
        .logo-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }
        
        .company-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 5px;
            position: relative;
        }
        
        .company-name::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 50%;
            background-color: #ffffff;
            transition: all 0.5s ease;
        }
        
        .vyaparkranti-box:hover .company-name::after {
            width: 100%;
            left: 0;
        }
        
        .tagline {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            animation: float 4s infinite;
        }
        
        .particle:nth-child(1) {
            width: 15px;
            height: 15px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .particle:nth-child(2) {
            width: 10px;
            height: 10px;
            top: 20%;
            right: 20%;
            animation-delay: 1s;
        }
        
        .particle:nth-child(3) {
            width: 7px;
            height: 7px;
            bottom: 15%;
            left: 15%;
            animation-delay: 2s;
        }
        
        .particle:nth-child(4) {
            width: 12px;
            height: 12px;
            bottom: 25%;
            right: 15%;
            animation-delay: 3s;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(20px);
                opacity: 0;
            }
        }
        
        .btn-custom {
            background-color: white;
            color: #6610f2;
            border: none;
            margin-top: 15px;
            font-weight: bold;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .vyaparkranti-box:hover .btn-custom {
            opacity: 1;
            transform: translateY(0);
        }
        
        .spin-effect {
            animation: spin 10s linear infinite;
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 30%, rgba(255, 255, 255, 0.1) 70%);
            z-index: 0;
        }
        
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="vyaparkranti-box">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="spin-effect"></div>
        
        <div class="logo-icon">
            <i class="fas fa-bolt"></i>
        </div>
        <div class="company-name">VYAPAR KRANTI</div>
        <div class="tagline">Empowering Business Growth</div>
        
    </div>
    @if (Route::has('login'))
    <div style="position: fixed; top: 20px; right: 20px; z-index: 999;">
        @auth
            <a href="{{ url('/new-dashboard') }}" 
               style="color: rgb(244, 238, 238); background-color: rgb(124, 145, 223); font-size: 16px; font-weight: 700; text-decoration: none; padding: 12px 20px; display: inline-block; text-align: center; border-radius: 8px; transition: background-color 0.3s;">
               Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" 
               style="color: rgb(247, 238, 238); background-color: rgb(149, 152, 235); font-size: 16px; font-weight: 700; text-decoration: none; padding: 12px 20px; display: inline-block; text-align: center; border-radius: 8px; transition: background-color 0.3s;">
               Log in
            </a>
        @endauth
    </div>
@endif



    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vastu Vid - Coming Soon</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            position: relative;
            color: #a8568d;
        }

        .cosmic-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, #f8f0f5 0%, #ffffff 100%);
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #d4a5c3;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.6; }
        }

        .sacred-geometry {
            position: absolute;
            width: 800px;
            height: 800px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.15;
        }

        .rotating-square {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid #c47ba7;
            animation: rotateSquare 30s linear infinite;
        }

        .rotating-square:nth-child(2) {
            animation-delay: -10s;
            border-color: #a8568d;
        }

        .rotating-square:nth-child(3) {
            animation-delay: -20s;
            border-color: #8b4873;
        }

        @keyframes rotateSquare {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .container {
            text-align: center;
            z-index: 10;
            padding: 40px 20px;
            max-width: 1000px;
            width: 100%;
            position: relative;
        }

        .logo-container {
            width: 180px;
            height: 180px;
            margin: 0 auto 40px;
            animation: floatLogo 6s ease-in-out infinite;
            position: relative;
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 0 30px rgba(168, 86, 141, 0.4));
        }

        .logo-glow {
            position: absolute;
            width: 120%;
            height: 120%;
            top: -10%;
            left: -10%;
            background: radial-gradient(circle, rgba(168, 86, 141, 0.2) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
            pointer-events: none;
        }

        h1 {
            font-size: clamp(3rem, 8vw, 5rem);
            color: #a8568d;
            margin-bottom: 20px;
            font-weight: 700;
            letter-spacing: 12px;
            text-transform: uppercase;
            animation: fadeIn 2s ease-out;
            text-shadow: 0 0 20px rgba(168, 86, 141, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .tagline {
            font-size: clamp(1.2rem, 3vw, 1.6rem);
            color: #8b4873;
            margin-bottom: 60px;
            letter-spacing: 4px;
            animation: fadeIn 2s ease-out 0.5s both;
            font-style: italic;
            font-weight: 500;
        }

        .divider {
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #a8568d, transparent);
            margin: 40px auto;
            animation: expandWidth 2s ease-out 1s both;
        }

        @keyframes expandWidth {
            from { width: 0; }
            to { width: 200px; }
        }

        .launch-text {
            font-size: clamp(1.5rem, 4vw, 2rem);
            color: #c47ba7;
            margin-bottom: 50px;
            letter-spacing: 3px;
            animation: fadeIn 2s ease-out 1.5s both;
            font-weight: 700;
        }

        .vastu-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(70px, 100px));
            gap: 3px;
            margin: 0 auto 60px;
            background: #a8568d;
            padding: 3px;
            animation: fadeIn 2s ease-out 2s both;
            box-shadow: 0 0 30px rgba(168, 86, 141, 0.3);
            justify-content: center;
        }

        .vastu-cell {
            aspect-ratio: 1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            color: #a8568d;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .vastu-cell::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(168, 86, 141, 0.3), transparent);
            transform: translateX(-100%);
            animation: shine 3s infinite;
        }

        .vastu-cell:nth-child(1)::before { animation-delay: 0s; }
        .vastu-cell:nth-child(2)::before { animation-delay: 0.3s; }
        .vastu-cell:nth-child(3)::before { animation-delay: 0.6s; }
        .vastu-cell:nth-child(4)::before { animation-delay: 0.9s; }
        .vastu-cell:nth-child(5)::before { animation-delay: 1.2s; }
        .vastu-cell:nth-child(6)::before { animation-delay: 1.5s; }
        .vastu-cell:nth-child(7)::before { animation-delay: 1.8s; }
        .vastu-cell:nth-child(8)::before { animation-delay: 2.1s; }
        .vastu-cell:nth-child(9)::before { animation-delay: 2.4s; }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            50%, 100% { transform: translateX(100%); }
        }

        .vastu-cell:hover {
            background: #f8f0f5;
            color: #8b4873;
            box-shadow: inset 0 0 20px rgba(168, 86, 141, 0.5);
        }

        .email-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto 50px;
            animation: fadeIn 2s ease-out 2.5s both;
            padding: 0 20px;
        }

        .email-input {
            padding: 20px 28px;
            border: 2px solid #a8568d;
            background: rgba(248, 240, 245, 0.8);
            color: #8b4873;
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Arial', 'Helvetica', sans-serif;
            width: 100%;
        }

        .email-input::placeholder {
            color: #c47ba7;
        }

        .email-input:focus {
            background: rgba(248, 240, 245, 1);
            box-shadow: 0 0 20px rgba(168, 86, 141, 0.3);
            border-color: #8b4873;
        }

        .subscribe-btn {
            padding: 20px 45px;
            border: 2px solid #a8568d;
            background: transparent;
            color: #a8568d;
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 3px;
            font-family: 'Arial', 'Helvetica', sans-serif;
            width: 100%;
        }

        .subscribe-btn:hover {
            background: #a8568d;
            color: #ffffff;
            box-shadow: 0 0 30px rgba(168, 86, 141, 0.5);
            transform: translateY(-2px);
        }

        .footer-text {
            color: #c47ba7;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            letter-spacing: 3px;
            animation: fadeIn 2s ease-out 3s both;
            font-weight: 600;
        }

        .energy-lines {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .energy-line {
            position: absolute;
            background: linear-gradient(90deg, transparent, rgba(168, 86, 141, 0.2), transparent);
            animation: energyFlow 5s linear infinite;
        }

        .energy-line:nth-child(1) {
            width: 100%;
            height: 2px;
            top: 20%;
            animation-delay: 0s;
        }

        .energy-line:nth-child(2) {
            width: 100%;
            height: 2px;
            top: 50%;
            animation-delay: 1.5s;
        }

        .energy-line:nth-child(3) {
            width: 100%;
            height: 2px;
            top: 80%;
            animation-delay: 3s;
        }

        @keyframes energyFlow {
            0% { transform: translateX(-100%); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%); opacity: 0; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .email-container {
                flex-direction: row;
            }

            .email-input {
                flex: 1;
            }

            .subscribe-btn {
                width: auto;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 15px;
            }

            .logo-container {
                width: 140px;
                height: 140px;
                margin-bottom: 30px;
            }

            h1 {
                letter-spacing: 6px;
            }

            .tagline {
                letter-spacing: 2px;
                margin-bottom: 40px;
            }

            .launch-text {
                letter-spacing: 2px;
                margin-bottom: 40px;
            }

            .vastu-grid {
                grid-template-columns: repeat(3, minmax(60px, 80px));
                margin-bottom: 40px;
            }

            .footer-text {
                letter-spacing: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="cosmic-bg"></div>
    
    <div class="stars" id="stars"></div>

    <div class="energy-lines">
        <div class="energy-line"></div>
        <div class="energy-line"></div>
        <div class="energy-line"></div>
    </div>

    <div class="sacred-geometry">
        <div class="rotating-square"></div>
        <div class="rotating-square"></div>
        <div class="rotating-square"></div>
    </div>

    <div class="container">
        <div class="logo-container">
            <div class="logo-glow"></div>
            <img src="assets/images/vatuVidLogo.png" alt="Vastu Vid Logo">
        </div>

        <h1>VASTU VID</h1>
        <p class="tagline">Ancient Wisdom for Modern Living</p>

        <div class="divider"></div>

        <p class="launch-text">LAUNCHING SOON</p>

        <div class="vastu-grid">
            <div class="vastu-cell">NW</div>
            <div class="vastu-cell">N</div>
            <div class="vastu-cell">NE</div>
            <div class="vastu-cell">W</div>
            <div class="vastu-cell">C</div>
            <div class="vastu-cell">E</div>
            <div class="vastu-cell">SW</div>
            <div class="vastu-cell">S</div>
            <div class="vastu-cell">SE</div>
        </div>

        
        <p class="footer-text">BALANCE • HARMONY • PROSPERITY</p>
    </div>

    <script>
        // Create stars
        const starsContainer = document.getElementById('stars');
        for (let i = 0; i < 200; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            star.style.animationDuration = (Math.random() * 2 + 2) + 's';
            starsContainer.appendChild(star);
        }

        
    </script>
</body>
</html>