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
            background-image: url('/images/bean-bg.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: white;
            position: relative;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5); 
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
            color: #ffffff;
            border: solid 1px white; 
            padding: 0.75rem 2rem;
            transition: 0.3s;
        }

        .btn-welcome:hover {
            background-color: #6F4E37;
            color: #f0f8ff;
        }
    </style>
</head>
<body>


    <div class="welcome-section">
                   
        <div class="overlay">

        </div>
        <div class="content">
            <form action="{{ route('logout') }}" method="Post">
                @csrf
                <a href="" class="d-flex justify-content-end"><button type="submit" 
                 style="border: none; text-decoration :none;" class="btn text-white"
                >Logout</button></a>
        </form>
            <h2 class="display-4 fw-bold " style=" font-family: 'Playfair Display', serif;">Welcome </h2>
            <h2 class="display-4 fw-bold" style=" font-family: 'Playfair Display', serif;">to Globalbean connect</h2>
            <div class="lead mb-4 text-white " style="max-width: 1500px">Your one-stop solution for coffee supply chain management.
                
            We combine the love of coffee with the power of technology.
            Our intelligent supply platform connects coffee producers, suppliers, and buyers in one seamless ecosystem.
            With transparent sourcing and reliable delivery, we're redefining how coffee moves.
            <p class="fs-5 fw-bold mt-3">Join Our Network Today</p>
             </div>
            <div class="fs-5 fw-bold">
                <span class="fs-5 fw-bold"><a href="{{ route('vendor') }}" class="btn btn-welcome">Vendor</a></span>
                <span class="fs-5 fw-bold"><a href="{{ route('importer') }}" class="btn btn-welcome">Importer</a></span>
                <span class="fs-5 fw-bold"><a href="{{ route('transporter') }}" class="btn btn-welcome">Transporter</a></span>
            </div>
            
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
