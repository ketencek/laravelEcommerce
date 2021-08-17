<?php

namespace App\Exports;

use App\Models\Variable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class VariablesExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping 
{

    // use Exportable;
    protected $ids;

 function __construct($ids) {
        $this->ids = $ids;
 }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        $all_ids = $this->ids;
        $all_ids = explode(',', $all_ids);
        $variable = Variable::query()->whereIn('id', $all_ids);
        // ->get();
        
        return $variable;
    }

    public function map($variable): array
    {
        $lang=['en', 'tr'];
        $single_array = [];
        $single_array[] = 1;
        $single_array[] = $variable['name'];
        $single_array[] = $variable['status'];
        $single_array[] = $variable['cat_type'];
        foreach($lang as $l) {
            if(isset($variable->translate("$l")->value)) {
                $single_array[] = $variable->translate("$l")->value;
            }else {
                $single_array[] = '';
            }
        }
        return $single_array;
    }

    public function headings() :array
    {
        $lang=['en', 'tr'];
        $heading =  ['no', 'name', 'status', 'cat_type'];
        foreach($lang as $l) {
            $heading[] = $l.'_value';
        }
        return $heading;
    }

}
