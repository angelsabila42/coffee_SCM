<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>Globalbean connect</title>
 
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.ico')}}"> 

    <!-- Fonts  and  icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/light-bootstrap-dashboard.css?v=2.0.0')}}" rel="stylesheet" />

    <link href="{{asset('assets/css/custom1.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- <link href="{asset('assets/css/custom.css')" rel="stylesheet"> // IAm commented while merging --}}
     {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite([/*'resources/sass/app.scss',*/ 'resources/js/app.js'])
    @livewireStyles
 
 <style>
        .row.g-4.mb-4{
            padding: 20px;
            margin-left: 10%;

        }
         .crad{
            border-radius: 10px;
            height:100px;
            background-color: gray;
            padding: 10px;
        }
        .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .pagination button {
      padding: 8px 12px;
      margin: 0 2px;
      border: 1px solid #ccc;
      background: white;
      cursor: pointer;
      border-radius: 5px;
    }
    .pagination button:hover{
        background: rgb(223, 186, 186);
    }
    .pagination .active {
      background: #2c3e50;
      color: white;
    }
    .top-controls {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    .top-controls .right {
      display: flex;
      align-items: center;
      gap: 10px;
    } 
    .fas.fa-filter:hover{
        cursor: pointer;
        background-color: rgba(8, 2, 2, 0.034)
    }
    .actions a {
      color: red;
      cursor: pointer;
    } 
    th{
      text-transform: none;
    }
    #able{
      background-color: rgba(0, 128, 0, 0.89);
      border-radius: 5px;
      width: 50px;
      cursor: pointer;
    }
     #able:hover{
      background-color: rgba(0, 128, 0, 0.993); 
     }
    </style>
</head>