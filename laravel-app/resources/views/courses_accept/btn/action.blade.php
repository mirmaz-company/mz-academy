      
      
        <a class="btn btn-primary btn-sm" data-toggle="modal" href="#inlineForm"
                <?php $sections = \App\Models\Section::where('course_id',$data->id)->get(); ?>

                  data-showw="

                  <table style='width:100%; border:1px solid black;'>
                        <tr>
                          <th style='border:1px solid black;padding:3%;text-align:center;color:black;font-size:19px;'>القسم</th>
                          <th style='border:1px solid black;padding:3%;text-align:center;color:black;font-size:19px;'>الدروس</th>
                       
                        </tr>
                        @foreach ($sections as  $key=>$section)
                        <tr>
                          <td style='border:1px solid black;'><h1>  {{ $key }}# {{$section->name ?? "-"}} </h1></td>
                          <td style='border:1px solid black;'>
                                <?php $lessons = \App\Models\Lesson::where('section_id',$section->id)
                                        ->where("status_laravel",1)
                                        ->where("status_node",1)
                                        ->where('updated_at' ,"<", \Carbon\Carbon::now()->subHours(1)->toDateTimeString())
                                        ->where('is_scheduler',1)->where('link','!=',NULL)->get(); ?>


                                @foreach ($lessons as  $key=>$lesson)
      
                                
                                   <h1> {{ $key }}#-{{$lesson->name ?? "-"}}  </h1> 
      
                                @endforeach</td>
                       
                        </tr>
                        @endforeach
                      </table>"

                   <?php $course = \App\Models\Course::where('id',$data->id)->first(); ?>
                   <?php $price = $course->price - $course->discount;?>

                     data-name =  "اسم الدورة : {{ $course->name?? "-" }} "
                     data-description =  " الوصف : {{ $course->description?? "لا يوجد وصف" }} "
                     data-image =  " {{ $course->image_100k?? "-" }}"
                     data-type =  " نوع الدورة : {{ $course->type?? "-" }}"
                     data-price =  " سعر الدورة : {{ $price }}"

                  
                 
                style="margin-bottom:1%">عرض تفاصيل الدورة

            
        </a> 




        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

                data-id=             "{{ $data->id }}"
                data-teacher_id=             "{{ $data->teacher_id }}"
            
      
   

        > موافقة<i class="fa fa-true"></i> </a>





        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#decline_modal"

                data-id=             "{{ $data->id }}"
                data-teacher_id=     "{{ $data->teacher_id }}"
              


        > رفض<i class="fa fa-true"></i> </a>
   
  
                






