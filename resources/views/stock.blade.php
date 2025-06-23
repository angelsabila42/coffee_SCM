<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <title>Stock Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  @extends('layouts.head')
  <style>
    .section-header {
      font-weight: bold;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .detail-label {
      font-weight: 500;
    }
    .edit-btn {
      float: right;
    }
  </style>
</head>
<body class="p-4 bg-light">

  @extends('layouts.stockbody')
</body>
@extends('layouts.scripts')
</html>
