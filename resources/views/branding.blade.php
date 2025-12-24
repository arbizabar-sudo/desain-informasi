<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<x-navbar></x-navbar>
<body>
    <div class="container">
        <x-sidebar />

        <!-- page content -->
    </div>

    <x-sidebar-assets />
</body>
</html>

<style>
    header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            border-bottom: 2px solid #f0f0f0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
        
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #bfff8647;
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-register {
            background: #ffffffff;
            color: black;
        }

        .btn-register:hover {
            background: #c82333;
        }

        .btn-login {
            background: transparent;
            color: #333;
            border: 2px solid #333;
        }

        .btn-login:hover {
            background: #333;
            color: white;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: #333;
            border-radius: 3px;
        }

        /* Hero Section */
        .hero {
            padding: 60px 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-image {
            background: #e0e0e0;
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Search Bar */
        .search-section {
            padding: 0 200px 40px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            padding: 12px 20px;
            border-radius: 25px;
            gap: 10px;
        }

        .search-bar input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 16px;
        }

        .search-icon {
            color: #666;
            cursor: pointer;
        }
