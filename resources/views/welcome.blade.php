<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .welcome-section {
            background-image: url('/images/bean-bg.jpg'); /* You can change this to any URL or local image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: white;
            position: relative;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5); /* Dark semi-transparent overlay */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }

        .btn-welcome {
            background-color: #ffffff;
            color: #007bff;
            font-weight: 500;
            border-radius: 30px;
            padding: 0.75rem 2rem;
            border: none;
            transition: 0.3s;
        }

        .btn-welcome:hover {
            background-color: #f0f8ff;
            color: #0056b3;
        }
    </style>
</head>
<body>
 @include('layouts.nav')
    <div class="welcome-section">
        <div class="overlay"></div>
        <div class="content">
            <h1 class="display-3 fw-bold card">Welcome to Globalbean connect</h1>
            <div class="lead mb-4 text-white card card-title bg-primary " style="max-width: 1500px">Your one-stop solution for coffee supply chain management
                
            We combine the love of coffee with the power of technology.
            Our intelligent supply platform connects coffee producers, suppliers, and buyers in one seamless ecosystem.
            With transparent sourcing and reliable delivery, we’re redefining how coffee moves.
             </div>
               <div> <span class="fs-5 fw-bold">follow the links below to become an </span>
                <a href="{{ route('vendor') }}" class="btn btn-welcome">Vendor</a>
                <a href="{{ route('importer') }}" class="btn btn-welcome">importer</a>
                <a href="{{ route('transporter') }}" class="btn btn-welcome">transporter</a>
            </div>
            
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
