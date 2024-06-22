<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Custom CSS for dark theme -->
    <style>

         body,table{
          background-image: url('{{asset('newhack.png') }}') ;
       
        }



            :root {
            --primary: #333;
            --secondary: #555;
            --success: #00cc00;
            --danger: #cc0000;
            --warning: #ff8800;
            --info: #33b5e5;
            --light: #f8f9fa;
            --dark: #444654;
            }


            /* Set the background color to the light color */
            body {
            background-color: var(--dark);
            }

            /* Set the color of the primary button to the primary color */
            .btn-primary {
            color: var(--primary);
            background-color: transparent;
            border-color: var(--primary);
            }

            /* Set the text color to the dark color */
            body {
            color: var(--light);
            }

            /* Set the background color of the table to the dark color */
            table {
            background-color: var(--dark);
            }

            /* Set the text color of the table header to the light color */
            th {
            color: var(--light);
            }
            td {
            color: var(--light);
            }
    </style>

    <title>اكاديمية مرماز</title>
  </head>
  <body>


    <div class="container">

        <h1 style="text-align: center">اكاديمية مرماز</h1> <br>


          <table class="table">
            <thead style="text-align: center">
              <tr>
                <th scope="col">#</th>
                <th scope="col">اسم الطالب</th>
                <th scope="col">كلمة السر</th>
                <th scope="col"> الصورة الشخصية</th>
                <th scope="col">  صورة الهوية</th>
                <th scope="col"> عدد مرات التعيين</th>
              </tr>
            </thead>
            <tbody style="text-align: center">
              @foreach($users as $user)
              <tr>
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->password_show }}</td>
                <td><img src="{{ $user->image ?? "https://cdn4.iconfinder.com/data/icons/political-elections/50/48-512.png" }}" style="width: 20%;" alt=""> </td>
                <?php $imagee = \App\Models\VerifiedData::Where('user_id',$user->id)->orderBy('id','desc')->first(); ?>
                <td><img src="{{ $imagee->front_image_id ?? "https://user-images.githubusercontent.com/24848110/33519396-7e56363c-d79d-11e7-969b-09782f5ccbab.png" }}" style="width: 20%;" alt=""> </td>
                <td>{{ $user->reset_count }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>

          {{ $users->links() }}

    </div>



    <audio id="myAudio" src="{{ asset('sound_e.mp3') }}"></audio>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.16.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>
      // Get a reference to the audio element and the play button
   
    

       var audio = document.getElementById("myAudio");
        $(document).click(function() {
          for (var i = 0; i < 10; i++) {
          audio.play();
        }
      });
</script>
     

    
  </body>
  </html>