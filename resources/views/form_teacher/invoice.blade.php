
{{-- لما يعلق معي وما يفتح البي دي اف بمسح الكاش وبعيد تشغيل السيرفر --}}

<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
         body {
          background-image: url('{{ public_path('vvv.png') }}');
          /* background-repeat: no-repeat; */
          /* background-size: cover; */
          /* background-attachment: fixed; */

        }
    </style>
</head>
<body>
        <div style="text-align: center">
           <img src="{{ public_path('ss.png') }}" style="width:25%" alt="">
        </div> <br><br>

            <div style="">
               <span style="font-size: 20px">الاسم : </span>  <span style="font-size: 20px">  {{ $form_teacher['name'] }} </span>
            </div> <br><br>
           
            <div style="">
               <span style="font-size: 20px">التحصيل الدراسي : </span>  <span style="font-size: 20px">   {{ $form_teacher['collection_school'] }}</span>
            </div> <br><br>

            <div style="">
               <span style="font-size: 20px"> المحافظة : </span>  <span style="font-size: 20px"> {{ $form_teacher['governorate'] }}  </span>
            </div> <br><br>
           
            <div style="">
               <span style="font-size: 20px">  العنوان: </span>  <span style="font-size: 20px">  {{ $form_teacher['address'] }} </span>
            </div> <br><br>
           
            <div style="">
               <span style="font-size: 20px"> رقم الهاتف : </span>  <span style="font-size: 20px">  {{ $form_teacher['phone'] }} </span>
            </div> <br><br>
           
            <div style="">
               <span style="font-size: 20px"> البريد الالكتروني : </span>  <span style="font-size: 20px"> {{ $form_teacher['email'] }}  </span>
            </div> <br><br>
           
            <div style="">
               <span style="font-size: 20px"> المادة : </span>  <span style="font-size: 20px">  {{ $form_teacher['subject'] }} </span>
            </div> <br><br>
           
            <div style="">
               <span style="font-size: 20px">  المراحل الدراسية: </span>  <span style="font-size: 20px"> {{ $form_teacher['level'] }}   </span>
            </div> <br><br>

            <div style="">
               <span style="font-size: 20px">   تاريخ ارسال الطلب: </span>  <span style="font-size: 20px"> {{ $form_teacher['created_at']->format('Y-M-D') }}   </span>
            </div> <br><br>
           
        </div> <br><br><br><br>

        <div style="text-align: center">
         <img src="{{ public_path('xx.png') }}" style="width:100%" alt="">
      </div>
       
         
</body>
</html>