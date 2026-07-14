<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HematCuy - Atur Keuanganmu</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4'/%3E%3Cpath d='M4 6v12c0 1.1.9 2 2 2h14v-4'/%3E%3Cpath d='M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z'/%3E%3C/svg%3E">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #0A0A0A;
            --text-main: #FFFFFF;
            --text-muted: #A1A1AA;
            --accent-blue: #3b82f6;
            --accent-dark: #121212;
            --surface: #111111;
            --border-color: #27272A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Utility */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 5%;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--text-muted);
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.85rem 1.75rem;
            border-radius: 999px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
        }

        .btn-outline {
            background: transparent;
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .btn-outline:hover {
            border-color: var(--text-main);
            background: var(--surface);
        }

        .btn-primary {
            background: var(--text-main);
            color: var(--surface);
        }

        .btn-primary:hover {
            background: var(--accent-blue);
            color: var(--text-main);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }

        .mobile-toggle {
            display: none;
            cursor: pointer;
            z-index: 101;
            color: var(--text-main);
            position: relative;
            width: 32px;
            height: 32px;
        }

        .hamburger-lines {
            width: 24px;
            height: 18px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hamburger-lines .line {
            position: absolute;
            height: 2px;
            width: 100%;
            border-radius: 2px;
            background: var(--text-main);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hamburger-lines .line1 {
            top: 0px;
        }

        .hamburger-lines .line2 {
            top: 8px;
        }

        .hamburger-lines .line3 {
            top: 16px;
        }

        .mobile-toggle.active .line1 {
            transform: translateY(8px) rotate(45deg);
        }

        .mobile-toggle.active .line2 {
            opacity: 0;
        }

        .mobile-toggle.active .line3 {
            transform: translateY(-8px) rotate(-45deg);
        }

        .mobile-menu {
            position: fixed;
            top: 80px;
            left: 0;
            width: 100%;
            height: calc(100vh - 80px);
            background: rgba(10, 10, 10, 0.98);
            backdrop-filter: blur(16px);
            padding: 2rem;
            flex-direction: column;
            gap: 1.5rem;
            z-index: 99;
            overflow-y: auto;

            /* Animation properties */
            display: flex;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .mobile-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .mobile-menu a.menu-link {
            color: var(--text-main);
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: 600;
            padding: 0.5rem 0;
        }

        /* Hero Section */
        .hero {
            padding: 12rem 0 6rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-text h1 {
            font-size: clamp(3rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -2px;
            margin-bottom: 1.5rem;
            color: var(--text-main);
        }

        .hero-text p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 90%;
        }

        .hero-badges {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .badge {
            background: var(--surface);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        /* Hero Visual Composition */
        .hero-visual {
            position: relative;
            height: 600px;
            width: 100%;
        }

        .floating-card {
            position: absolute;
            background: var(--surface);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border-color);
            animation: float 6s infinite ease-in-out;
        }

        /* Card 1: Main Balance */
        .card-main {
            width: 320px;
            top: 20%;
            left: 10%;
            z-index: 3;
            animation-delay: 0s;
        }

        .card-main .label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .card-main .balance {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 1.5rem;
        }

        .chart-mock {
            height: 60px;
            width: 100%;
            background: linear-gradient(90deg, transparent 0%, var(--accent-blue) 50%, transparent 100%);
            border-radius: 12px;
            opacity: 0.8;
            margin-bottom: 1rem;
        }

        /* Card 2: AI Receipt */
        .card-secondary {
            width: 260px;
            bottom: 10%;
            right: 5%;
            z-index: 4;
            background: var(--accent-dark);
            color: white;
            animation-delay: -2s;
        }

        .card-secondary .icon-box {
            background: var(--accent-blue);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        /* Card 3: Wishlist */
        .card-tertiary {
            width: 240px;
            top: 5%;
            right: 0%;
            z-index: 2;
            animation-delay: -4s;
        }

        /* Card 4: Chatbot */
        .card-quaternary {
            width: 250px;
            bottom: -5%;
            left: -2%;
            z-index: 5;
            background: rgba(20, 20, 20, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            animation-delay: -1s;
        }

        .progress-bar-mock {
            height: 8px;
            background: #27272A;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .progress-fill {
            height: 100%;
            width: 65%;
            background: var(--text-main);
            border-radius: 4px;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Brands/Trust */
        .trust-banner {
            padding: 3rem 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            background: var(--surface);
        }

        .trust-grid {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .trust-grid div {
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Bento Features Grid */
        .features {
            padding: 8rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.25rem;
            color: var(--text-muted);
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: auto auto;
            gap: 1.5rem;
        }

        .bento-item {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 32px;
            padding: 3rem;
            transition: all 0.3s;
            overflow: hidden;
            position: relative;
        }

        .bento-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: #3F3F46;
        }

        .bento-item h3 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 1rem;
        }

        .bento-item p {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .bento-icon {
            width: 64px;
            height: 64px;
            background: var(--accent-blue);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            color: white;
        }

        .item-large {
            grid-column: span 2;
            background: var(--accent-dark);
            color: white;
        }

        .item-large h3 {
            color: white;
        }

        .item-large p {
            color: #A1A1AA;
        }

        .item-large .bento-icon {
            background: var(--accent-blue);
            color: white;
        }

        /* About Us Section */
        .about {
            padding: 8rem 0;
            background: var(--bg-color);
            position: relative;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 4rem;
            align-items: center;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-text h2 {
            font-size: 2.8rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .about-text p {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .about-stats {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            justify-content: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--accent-blue);
            margin-bottom: 0.25rem;
        }

        .stat-item span {
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .about-visual {
            position: relative;
            height: 100%;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-panel {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.01) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 4rem 3rem;
            text-align: center;
            backdrop-filter: blur(20px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 60%);
            opacity: 0.5;
            pointer-events: none;
        }

        .glass-content {
            position: relative;
            z-index: 2;
        }

        .glass-content svg {
            margin-bottom: 1.5rem;
        }

        .glass-content h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: white;
        }

        .glass-content p {
            color: var(--text-muted);
        }

        /* CTA Section */
        .cta {
            padding: 4rem 0;
            background: var(--accent-blue);
            text-align: center;
            border-radius: 40px 40px 0 0;
            color: white;
        }

        .cta h2 {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 2rem;
            color: white;
        }

        .cta .btn-primary {
            background: #0A0A0A;
            color: white;
            padding: 1.25rem 3rem;
            font-size: 1.1rem;
        }

        .cta .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            background: #1A1A1A;
            color: white;
        }

        /* Footer */
        footer {
            background: var(--accent-dark);
            padding: 4rem 0 2rem 0;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-col h4 {
            color: var(--text-main);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-top: 1rem;
            max-width: 90%;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
        }

        .footer-col ul li {
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .footer-col ul li a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-col ul li a:hover {
            color: var(--accent-blue);
        }

        .footer-contact {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .footer-links {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--text-main);
        }

        @media (max-width: 1024px) {
            .hero .container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-actions {
                justify-content: center !important;
            }

            .hero-badges {
                justify-content: center;
            }

            .hero-text p {
                margin: 0 auto 2.5rem;
            }

            .hero-visual {
                height: 500px;
            }

            .card-main {
                left: 50%;
                top: 10%;
                animation: floatMobile 6s infinite ease-in-out;
            }

            .card-secondary {
                left: 50%;
                bottom: 0;
                animation: floatMobile 6s infinite ease-in-out reverse;
            }

            .card-tertiary {
                display: none;
            }

            .bento-grid {
                grid-template-columns: 1fr;
            }

            .item-large {
                grid-column: span 1;
            }

            .about-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .about-stats {
                justify-content: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        @keyframes floatMobile {

            0%,
            100% {
                transform: translate(-50%, 0);
            }

            50% {
                transform: translate(-50%, -20px);
            }
        }

        @media (max-width: 768px) {

            .nav-links,
            .nav-buttons {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .hero-visual {
                display: none;
            }

            .hero {
                padding: 10rem 0 4rem;
                min-height: auto;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .cta h2 {
                font-size: 2.5rem;
            }

            .about-text {
                padding: 0 1rem;
            }

            .about-text h2 {
                font-size: 2rem;
            }

            .about-text p {
                font-size: 1rem;
            }

            .bento-item {
                padding: 2rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-400 {
            animation-delay: 400ms;
        }

        .delay-600 {
            animation-delay: 600ms;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            padding: 20px;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: #111111;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            width: 100%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 40px;
            position: relative;
            transform: translateY(20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0) scale(1);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .modal-close:hover {
            background: rgba(244, 63, 94, 0.1);
            color: #f43f5e;
            border-color: rgba(244, 63, 94, 0.2);
            transform: rotate(90deg);
        }

        /* Scrollbar for modal */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body id="top">

    <nav class="animate-fade-in-up">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent-blue)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4" />
                    <path d="M4 6v12c0 1.1.9 2 2 2h14v-4" />
                    <path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z" />
                </svg>
                HematCuy.
            </a>
            <div class="nav-links">
                <a href="#top">Beranda</a>
                <a href="#features">Fitur</a>
                <a href="#about">Tentang Kami</a>
            </div>
            <div class="nav-buttons">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Ke Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @endif
                @endauth
                @endif
            </div>

            <!-- Hamburger Icon -->
            <div class="mobile-toggle" id="mobile-toggle" onclick="toggleMobileMenu()">
                <div class="hamburger-lines">
                    <span class="line line1"></span>
                    <span class="line line2"></span>
                    <span class="line line3"></span>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu" id="mobile-menu">
            <a href="#top" class="menu-link" onclick="toggleMobileMenu()">Beranda</a>
            <a href="#features" class="menu-link" onclick="toggleMobileMenu()">Fitur</a>
            <a href="#about" class="menu-link" onclick="toggleMobileMenu()">Tentang Kami</a>
            <hr style="border: none; border-top: 1px solid var(--border-color); margin: 0.5rem 0;">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="width: 100%;">Ke Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%;">Masuk</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary" style="width: 100%;">Daftar sekarang</a>
                @endif
                @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="hero-text animate-fade-in-up delay-200">
                <div class="hero-badges" style="display: none;">
                </div>
                <h1>Pegang kendali uangmu, tanpa ribet.</h1>
                <p>Mulai kelola keuangan Anda menjadi lebih mudah, efisien, dan terstruktur. HematCuy hadir untuk memberikan transparansi dan kendali penuh atas uang Anda.</p>

                <div class="hero-actions" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    @if(auth()->check())
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Ke Dashboard <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.5rem;">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg></a>
                    @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Mulai Gratis <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.5rem;">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg></a>
                    @endif
                </div>
            </div>

            <div class="hero-visual animate-fade-in-up delay-400">
                <!-- Floating Cards Composition (Bancuip Style) -->

                <div class="floating-card card-main">
                    <div class="label">Total Saldo</div>
                    <div class="balance">Rp 12.500.000</div>
                    <div class="chart-mock"></div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 500;">
                        <span style="color: #10b981;">+ Rp 3.200.000</span>
                        <span style="color: var(--text-muted);">Bulan ini</span>
                    </div>
                </div>

                <div class="floating-card card-secondary">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z" />
                            <path d="M14 8H8" />
                            <path d="M16 12H8" />
                            <path d="M13 16H8" />
                        </svg>
                    </div>
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">Catat Struk</div>
                    <div style="font-size: 0.85rem; color: #A1A1AA; line-height: 1.4;">Scan Struk, Sistem akan mencatat otomatis, Beres</div>
                </div>

                <div class="floating-card card-tertiary">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <div style="font-weight: 600; font-size: 0.95rem;">MacBook Pro M3</div>
                        <span style="font-size: 1.2rem;">💻</span>
                    </div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Target Impian</div>
                    <div class="progress-bar-mock">
                        <div class="progress-fill"></div>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem; text-align: right;">65% tercapai</div>
                </div>

                <div class="floating-card card-quaternary">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                        <div style="background: #25D366; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <div style="font-weight: 600; font-size: 0.95rem;">Bot WA/Telegram</div>
                    </div>
                    <div style="font-size: 0.85rem; color: #A1A1AA; line-height: 1.4; margin-bottom: 0.5rem;">Chat buat catat otomatis!</div>
                    <div style="display: inline-block; background: rgba(59,130,246,0.15); color: #60a5fa; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 99px; border: 1px solid rgba(59,130,246,0.3);">🚀 COMING SOON</div>
                </div>

            </div>
        </div>
    </section>

    <section class="trust-banner animate-fade-in-up delay-600">
        <div class="container trust-grid" style="align-items: flex-start;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1;">
                <div style="display: flex; align-items: center; justify-content: center; height: 40px; font-size: 2.2rem; color: var(--accent-blue); line-height: 1;">
                    10.000+
                </div>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; text-align: center;">Pengguna Aktif</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; height: 40px; font-size: 2.2rem; color: var(--accent-blue); line-height: 1;">
                    4.9/5
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#FBBF24" stroke="#FBBF24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top: -2px;">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; text-align: center;">Rating Pengguna</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; height: 40px; font-size: 2.2rem; color: var(--accent-blue); line-height: 1;">
                    100%
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top: -2px;">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; text-align: center;">Privasi Terjamin</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1;">
                <div style="display: flex; align-items: center; justify-content: center; height: 40px; font-size: 2.2rem; color: var(--accent-blue); line-height: 1;">
                    99,9%
                </div>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; text-align: center;">Keamanan Data</span>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <h2>Semua yang Anda butuhkan, di satu tempat.</h2>
                <p>Fitur mutakhir yang dirancang untuk membuat manajemen keuangan terasa tidak terlihat.</p>
            </div>

            <div class="bento-grid">

                <div class="bento-item item-large">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                        </svg>
                    </div>
                    <h3>Budgeting & Alokasi Pintar</h3>
                    <p>Berhenti menebak ke mana uang Anda pergi. Alokasikan gaji bulanan Anda ke dalam beberapa pos keuangan secara instan. HematCuy akan mengingatkan Anda saat pengeluaran membengkak.</p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z" />
                            <path d="M14 8H8" />
                            <path d="M16 12H8" />
                            <path d="M13 16H8" />
                        </svg>
                    </div>
                    <h3>Pemindai Struk</h3>
                    <p>Cukup foto struk belanja Anda. Sistem akan secara otomatis mengekstrak barang, harga, dan mengelompokkannya. Tidak perlu input manual lagi.</p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 2a10 10 0 0 1 10 10c0 5.5-4.5 10-10 10S2 17.5 2 12 6.5 2 12 2Z" />
                            <path d="M12 12v.01" />
                            <path d="M12 16v.01" />
                            <path d="M12 8v.01" />
                        </svg>
                    </div>
                    <h3>Target Harian</h3>
                    <p>Tetapkan batas pengeluaran harian. Ketahui secara pasti berapa banyak yang bisa Anda belanjakan hari ini tanpa merusak target bulanan.</p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12h4l3-9 5 18 3-9h5" />
                        </svg>
                    </div>
                    <h3>Wishlist</h3>
                    <p>Tambahkan barang impian Anda. Sistem menghitung estimasi hari/bulan tercapai berdasarkan sisa anggaran real-time.</p>
                </div>

                <div class="bento-item">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18" />
                            <path d="M18 17V9" />
                            <path d="M13 17V5" />
                            <path d="M8 17v-3" />
                        </svg>
                    </div>
                    <h3>Laporan</h3>
                    <p>Pantau ringkasan arus kas Anda lewat grafik visual. Evaluasi kesehatan finansial bulanan Anda dengan sangat mudah dan akurat.</p>
                </div>

            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <h2>Misi kami adalah menyederhanakan cara Anda mengelola uang.</h2>
                    <p>HematCuy berawal dari betapa rumitnya mencatat pengeluaran setiap hari.</p>
                    <p>Oleh karena itu, kami merancang HematCuy: sebuah sistem mencatat keuangan, menganalisis pengeluaran, serta mengelola keuangan anda secara terstruktur.</p>

                    <div class="about-stats">
                        <div class="stat-item">
                            <h3>2026</h3>
                            <span>Tahun Berdiri</span>
                        </div>
                        <div class="stat-item">
                            <h3>100%</h3>
                            <span>Transparansi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <h2>Siap mengelola uang lebih teratur?</h2>
            @if(auth()->check())
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Ke Dashboard</a>
            @else
            <a href="{{ route('register') }}" class="btn btn-primary">Bergabung Sekarang</a>
            @endif
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="#" class="logo" style="color: white; font-size: 1.5rem; margin-bottom: 1rem; display: inline-flex;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent-blue)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;">
                            <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4" />
                            <path d="M4 6v12c0 1.1.9 2 2 2h14v-4" />
                            <path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z" />
                        </svg>
                        HematCuy.
                    </a>
                    <p class="footer-desc">HematCuy adalah sistem mengelola keuangan anda secara terstruktur mulai dari pengeluaran harian, target harian, dan wishlist.</p>
                </div>

                <div class="footer-col">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="#top">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#about">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('target.index') }}">Target Harian</a></li>
                        <li><a href="{{ url('/tabungan') }}">Tabungan & Wishlist</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kontak</h4>
                    <div class="footer-contact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span>Purwokerto, Indonesia</span>
                    </div>
                    <div class="footer-contact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <span>hematcuy@gmail.com</span>
                    </div>
                    <div class="footer-contact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <a href="https://faiz-azzahra-portfolio.vercel.app/" target="_blank" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--text-main)'" onmouseout="this.style.color='var(--text-muted)'">Faiz Azzahra Winanto Putra</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; {{ date('Y') }} HematCuy &ndash; Sistem Pencatat Keuangan
                <div class="footer-links">
                    <a href="javascript:void(0)" onclick="openModal('termsModal')">Terms & Conditions</a>
                    <a href="javascript:void(0)" onclick="openModal('privacyModal')">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <div id="termsModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('termsModal')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <h2 style="font-size: 2rem; margin-bottom: 10px; color: #fff;">Terms & Conditions</h2>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">1. Pendahuluan</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Selamat datang di HematCuy. Dengan mengakses atau menggunakan website HematCuy, Anda setuju untuk terikat oleh Syarat & Ketentuan ini.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">2. Penggunaan Website</h3>
            <p style="color: var(--text-muted); margin-bottom: 10px;">HematCuy adalah perangkat lunak untuk membantu Anda mencatat dan mengelola anggaran keuangan pribadi. Kami tidak menyediakan layanan perbankan, penyimpanan uang tunai, investasi, atau nasihat keuangan profesional.</p>
            <ul style="color: var(--text-muted); margin-bottom: 15px; padding-left: 20px;">
                <li style="margin-bottom: 5px;">Anda bertanggung jawab penuh atas keakuratan data keuangan yang Anda masukkan.</li>
                <li style="margin-bottom: 5px;">Anda wajib menjaga kerahasiaan kata sandi dan akun Anda.</li>
                <li style="margin-bottom: 5px;">Anda setuju untuk tidak menyalahgunakan sistem kami, seperti melakukan peretasan (hacking) atau merusak server.</li>
            </ul>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">3. Layanan Pihak Ketiga</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Website ini mungkin memuat tautan atau layanan dari pihak ketiga. Kami tidak bertanggung jawab atas ketersediaan, isi, atau kebijakan dari pihak ketiga tersebut.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">4. Batasan Tanggung Jawab</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">HematCuy disediakan "sebagaimana adanya". Kami tidak menjamin bahwa website ini akan selalu bebas dari kesalahan, bug, atau gangguan. Kami tidak bertanggung jawab atas kerugian finansial yang diakibatkan oleh kesalahan pencatatan atau masalah sistem.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">5. Perubahan Syarat & Ketentuan</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Kami berhak untuk mengubah Terms & Conditions ini sewaktu-waktu. Perubahan akan berlaku seketika setelah diperbarui di halaman ini. Anda diharapkan untuk mengecek halaman ini secara berkala.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">6. Kontak</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Jika Anda memiliki pertanyaan seputar syarat dan ketentuan ini, silakan hubungi kami melalui email di hematcuy@gmail.com.</p>
        </div>
    </div>

    <div id="privacyModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('privacyModal')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <h2 style="font-size: 2rem; margin-bottom: 10px; color: #fff;">Privacy Policy</h2>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">1. Informasi yang Kami Kumpulkan</h3>
            <p style="color: var(--text-muted); margin-bottom: 10px;">Untuk memberikan pengalaman terbaik di HematCuy, kami mungkin mengumpulkan informasi berikut:</p>
            <ul style="color: var(--text-muted); margin-bottom: 15px; padding-left: 20px;">
                <li style="margin-bottom: 5px;"><strong>Informasi Akun:</strong> Nama, alamat email, dan kata sandi saat Anda mendaftar.</li>
                <li style="margin-bottom: 5px;"><strong>Data Keuangan:</strong> Nominal transaksi, kategori pengeluaran/pemasukan, dan daftar keinginan (wishlist) yang Anda input secara sadar ke dalam website.</li>
                <li style="margin-bottom: 5px;"><strong>Data Teknis:</strong> Alamat IP, jenis peramban (browser), dan data log sistem untuk keperluan keamanan.</li>
            </ul>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">2. Bagaimana Kami Menggunakan Informasi Anda</h3>
            <p style="color: var(--text-muted); margin-bottom: 10px;">Data yang kami kumpulkan hanya digunakan untuk:</p>
            <ul style="color: var(--text-muted); margin-bottom: 15px; padding-left: 20px;">
                <li style="margin-bottom: 5px;">Mengoperasikan dan mengelola fitur pencatatan keuangan pribadi Anda di dalam website HematCuy.</li>
                <li style="margin-bottom: 5px;">Meningkatkan pengalaman pengguna dan memantau kinerja keamanan website.</li>
                <li style="margin-bottom: 5px;">Mengirimkan email terkait akun (seperti kode OTP dan reset password).</li>
            </ul>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">3. Perlindungan dan Keamanan Data</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Kami sangat menghargai privasi Anda. Kata sandi Anda dienkripsi secara ketat di dalam sistem kami. Kami menerapkan langkah-langkah keamanan teknis standar industri untuk melindungi data keuangan Anda dari akses yang tidak sah, pengubahan, atau kebocoran.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">4. Berbagi Data dengan Pihak Ketiga</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Kami <strong>tidak pernah menjual, menyewakan, atau membagikan</strong> data keuangan pribadi Anda kepada pihak ketiga untuk tujuan pemasaran. Kami hanya akan mengungkapkan informasi jika diwajibkan oleh hukum atau permintaan resmi otoritas pemerintah.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">5. Hak Anda atas Data</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Anda memegang kendali penuh atas data Anda. Anda berhak untuk mengedit atau menghapus seluruh catatan keuangan Anda. Jika Anda ingin menghapus akun dan semua data Anda secara permanen dari server kami, Anda dapat menghubungi tim dukungan kami.</p>

            <h3 style="color: var(--accent-blue); margin-top: 20px; margin-bottom: 10px;">6. Hubungi Kami</h3>
            <p style="color: var(--text-muted); margin-bottom: 15px;">Jika Anda memiliki pertanyaan lebih lanjut mengenai kebijakan privasi ini, jangan ragu untuk menghubungi kami melalui email di hematcuy@gmail.com.</p>
        </div>
    </div>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const toggleBtn = document.getElementById('mobile-toggle');

            menu.classList.toggle('active');
            toggleBtn.classList.toggle('active');

            if (menu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>

</html>