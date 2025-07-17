<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobalBean Connect</title>
    <style>
    .row{
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
    <h4 style="margin: 15px 0;"><strong> OrderID: {{$order->orderID}} </strong></h4>

       <p class="row"><b>From: </b> {{$order->importerModel->name}} </p>
       <p class="row"><b>Date Sent: </b> {{$order->created_at}} </p>
       <p class="row"><b>Coffee Type: </b> {{$order->coffeeType}} </p>
        
        <p class="row"><b>Quantity: </b> {{$order->quantity}}kgs </p>
        <p class="row"><b>Grade: </b> {{$order->grade}} </p>
        <p class="row"><b>Destination: </b> {{$order->destination}} </p>
        <p>
            <span style="color: red;"><b>Deadline: </b></span>
        {{$order->deadline}} </p>
</body>
</html>