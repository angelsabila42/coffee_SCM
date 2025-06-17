<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <title>New Stock</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #6c757d;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background-color: #fff;
      padding: 25px 30px;
      border-radius: 8px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    h2 {
      margin-top: 0;
      margin-bottom: 15px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
      width: 100%;
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .button-group {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    button {
      padding: 8px 18px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-add {
      background-color: #000;
      color: white;
    }

    .btn-cancel {
      background-color: #e0e0e0;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>New Stock</h2>
    <form action="">
      <div class="form-group">
        <label for="coffeeType">Coffee Type</label>
        <select id="coffeeType" required>
          <option selected disabled>Select</option>
          <option>Arabica</option>
          <option>Robusta</option>
        </select>
      </div>

      <div class="form-group">
        <label for="quantity">Quantity (kgs)</label>
        <input type="number" id="quantity" placeholder="kgs" required>
      </div>

      <div class="form-group">
        <label for="grade">Grade</label>
        <select id="grade" required>
          <option selected disabled>Select</option>
          <option>A</option>
          <option>B</option>
          <option>C</option>
        </select>
      </div>

      <div class="form-group">
        <label for="minThreshold">Min Threshold</label>
        <input type="number" id="minThreshold" required>
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select id="status" required>
          <option selected disabled>Select</option>
          <option>Available</option>
          <option>Pending</option>
        </select>
      </div>

      <div class="form-group">
        <label for="warehouse">Warehouse</label>
        <select id="warehouse" required>
          <option selected disabled>Select</option>
          <option>Main</option>
          <option>Branch 1</option>
        </select>
      </div>

      <div class="form-group">
        <label for="dateAdded">Date Added</label>
        <input type="date" id="dateAdded" value="2025-05-30" required>
      </div>

      <div class="button-group">
        <button type="submit" class="btn-add">Add</button>
        <button type="button" class="btn-cancel">Cancel</button>
      </div>
    </form>
  </div>
</body>
</html>
