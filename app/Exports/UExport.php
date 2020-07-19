<?php

namespace PacketPrep\Exports;

use PacketPrep\Models\User\User_Details;
use Maatwebsite\Excel\Concerns\FromCollection;
use PacketPrep\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UExport implements FromQuery, ShouldQueue,WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Email',
            'Phone',
            'Roll Number/Fathers Name',
            'Year of Passing/ Father Phone',
            'Hometown/ District',
            'Current City/ Address',
            'Date of Birth',
            'Gender',
            'Custom Field 1',
            'Custom Field 2',
            'Custom Field 3',
            'Custom Field 4',
            'Custom Field 5',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        return User::query()->select('id','name', 'email','phone','roll_number','year_of_passing','hometown','current_city','dob','gender','video','personality','confidence','fluency','language');
    }
}
