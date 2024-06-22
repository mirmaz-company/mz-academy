<?php

namespace App\Exports;

use App\Models\User;
use App\Models\TeacherCode;
use Maatwebsite\Excel\Columns\Column;
use App\Models\WalletCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CodeWalletExport implements FromCollection,WithHeadings
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
        return WalletCode::where('section_course_id',$this->id)->where('user_id',NULL)->get(['serial','code']);
    }

    public function headings(): array
    {
        return [
            'serial',
            'code',
        ];
    }
}
