<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matrimonial Biodata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Add your custom CSS styles here */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    .biodata-container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>

<div class="container my-5 biodata-container">
  <h2 class="text-center mb-4">Matrimonial Biodata</h2>
  
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" placeholder="Your Name">
  </div>
  
  <div class="mb-3">
    <label for="age" class="form-label">Age</label>
    <input type="number" class="form-control" id="age" placeholder="Your Age">
  </div>
  
  <div class="mb-3">
    <label for="location" class="form-label">Location</label>
    <input type="text" class="form-control" id="location" placeholder="Your Location">
  </div>
  
  <div class="mb-3">
    <label for="education" class="form-label">Education</label>
    <input type="text" class="form-control" id="education" placeholder="Your Education">
  </div>
  
  <div class="mb-3">
    <label for="occupation" class="form-label">Occupation</label>
    <input type="text" class="form-control" id="occupation" placeholder="Your Occupation">
  </div>
  
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" rows="4" placeholder="Write a brief about yourself"></textarea>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
