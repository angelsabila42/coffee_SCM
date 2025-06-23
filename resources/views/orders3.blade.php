<html lang="en">
<head>
    @extends('layouts.head')
    
    <style>
        .content {
      padding: 20px;
    }
    .tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    .tabs button {
      padding: 10px 20px;
      border: 1px solid #ccc;
      background: white;
      cursor: pointer;
      border-radius: 30px;
      width: 200px;
    }
    .tabs button:hover{
        background: rgb(166, 194, 166); 
    }
    .tabs button.active {
      background:gray;
      color: white;
    }
    table {
      width: 100%;
      border: 1px solid #ddd;
      background: white;
    }
    th{
        background-color: rgba(0, 0, 0, 0.555);
        color: #ccc
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    tr:hover {
      background-color: #f1f1f1;
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
    .actions a {
      color: red;
      cursor: pointer;
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
   
    
    </style>
    
    <title>Document</title>
</head>
<body>
     
       @extends('layouts.body1')    
    
    
        
         
        
        

</body>
@extends('layouts.scripts')
</html>