

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Make a Payment</h4>
                </div>
                <div class="card-body">
                    <form action="pesapal-iframe.php" method="post">
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <td class="label-column">
                                        <label for="amount" class="form-label">Amount (UGX)</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="number" class="form-control" id="amount" name="amount" value="500" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="type" class="form-label">Type</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="type" name="type" value="MERCHANT" readonly>
                                        <div class="form-text">Leave as default - MERCHANT</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="description" class="form-label">Description</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="description" name="description" value="Making Payment" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="reference" class="form-label">Reference</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="reference" name="reference" value="001" required>
                                        <div class="form-text">Order ID</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="first_name" class="form-label">First Name</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="Khan" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="last_name" class="form-label">Last Name</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="Blair" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="email" class="form-label">Email Address</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="email" class="form-control" id="email" name="email" value="khanblair@gmail.com" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="button-column">
                                        <button type="submit" class="btn btn-primary">Make Payment</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

