<?php

namespace App\Exports;

use App\Models\Newsletter;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsletterExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping 
{

  
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        $newsletter = Newsletter::query()->withoutGlobalScope('status');
        // ->get();
        
        return $newsletter;
    }

    public function map($newsletter): array
    {
        $single_array = [];
        $single_array[] = 1;
        $single_array[] = $newsletter['email'];
        $single_array[] = $newsletter['is_subscribed'] ? 1 :0;
        $single_array[] = $newsletter['status'] ? 1 :0;
        return $single_array;
    }

    public function headings() :array
    {
        $heading =  ['No', 'Email', 'Subscribed', 'Status'];
        return $heading;
    }

}
