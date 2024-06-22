<?php

namespace App\Exports;

use App\Models\User;
use App\Models\TeacherCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CodeExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $id;

    public function __construct(int $id) 
    {
        $this->id = $id;
    }

    public function collection()
    {
        return TeacherCode::where('section_code',$this->id)->where('user_id',0)->get(['serial','code']);
    }

    public function headings(): array
    {
        return [
            'serial',
            'code',
        ];
    }
}
