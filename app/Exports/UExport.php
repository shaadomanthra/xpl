<?php

namespace PacketPrep\Exports;

use PacketPrep\Models\User\User_Details;
use Maatwebsite\Excel\Concerns\FromCollection;

class UExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User_Details::all();
    }
}
