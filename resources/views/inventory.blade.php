<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @extends('layouts.head')
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
    </style>
</head>
<body>
   @extends('layouts.inven_body') 
   

</body>
@extends('layouts.scripts')
</html>

