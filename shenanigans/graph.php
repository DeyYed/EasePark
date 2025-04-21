<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .mother-div {
      display: flex;
      align-items: center;
      justify-content: center;
      border: solid 1px red;
      width: 1000px;
      height: 500px;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      column-gap: 10px;
      border: solid 1px red;
      width: 900px;
      height: 400px;
    }
    .one-graph {
      border: black 1px solid;
    }
    .jan {
      background: linear-gradient(to top, rgba(255, 0, 0, 0.5) 0%, transparent 0%);
      height: 100%; /* Ensure the height of the div fills its parent */
    }
  </style>
</head>
<body>
  <div class="mother-div">
    <div class="grid">
      <div class="one-graph jan"></div>
      <div class="one-graph feb"></div>
      <!-- Other month divs -->
    </div>
  </div>

  <?php $january = (80000/90000)*100; 
  ?> 
  <script> 
  const percentage = <?php echo $january?>; 
  var janElement = document.querySelector('.jan'); 
  janElement.style.background = `linear-gradient(to top, rgba(255, 0, 0, 0.5) ${percentage}%, transparent 0%)`;
  </script>
</body>
</html>
