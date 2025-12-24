<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<x-navbar></x-navbar>
<body>
  <div class="container">
    <x-sidebar />
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h2>About</h2>
                <h1>Digital Creative Hub<h1>
            </div>
            <div class="hero-image">
                <img src="images/image 5 (1).png" alt="Creative workspace">
            </div>
        </section>
     
        <x-footer></x-footer>
  <x-sidebar-assets />
</div>
</body>
</html>

<style>

        

        /* Hero Section */
        .hero {
            padding: 60px 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .hero-content h1 {
            padding: 0 0 20px 0;
            font-size: 48px;
            color: #197547;
            margin-top: 10px;
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
        .site-footer {
           background: #ffffffff;padding:30px 40px;border-top:1px solid #dfdfdfff;font-family:inherit
        }
