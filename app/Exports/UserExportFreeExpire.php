<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserCourse;
use App\Models\TeacherCode;
use App\Models\VerifiedData;
use App\Models\VerifiedDataNew;
use App\Models\Wallet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExportFreeExpire implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $course;

    public function __construct(int $course) 
    {
        $this->course = $course;
    }

    public function collection()
    {
        $wallet = Wallet::where('course_id', $this->course)
            ->where('type_recharge', 'subscripe')
            ->pluck('user_id');
    
        $user_course = UserCourse::where('course_id', $this->course)
            ->whereNotIn('user_id', $wallet)->onlyTrashed()
            ->pluck('user_id');
    
        // استخدم نموذج VerifiedData للحصول على البيانات
        $data = User::whereIn('id', $user_course)->where('id','!=', 2)
            ->get();
            
        foreach($data as $user){
            
            $user['notes'] = UserCourse::where('course_id', $this->course)->where('user_id',$user->id)->pluck('notes')->first();
            $user['full_name'] = VerifiedData::where('user_id', $user->id)->where('status',1)->pluck('full_name')->first();
        }

        // قم بتحويل البيانات إلى مصفوفة وتطبيق ال accessors
        $dataArray = [];
        foreach ($data as $item) {
            $dataArray[] = [
                'name' => $item->full_name,
                'mobile' => $item->mobile,
                'notes' => $item->notes,
    
            ];
        }

        return collect($dataArray);
    }
    

    public function headings(): array
    {
        return [
            'name',
            'mobile',
            'notes',
        ];
    }
}
