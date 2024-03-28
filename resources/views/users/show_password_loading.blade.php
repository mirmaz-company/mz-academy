<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>جاري التحويل الى الصفحة</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

 
</head>
<body>


  <div style="text-align: center">
    <h1>جاري تحويلك الى البوابة الاخرى لمرماز اكاديمي</h1>
    <div class="spinner-border text-dark" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script>
    // Delay the opening of the page by 5 seconds
    setTimeout(function() {
   
      window.location.href = '{{route('show_password',$ip)}}';
    }, 3000);
  </script>
</body>


</html>