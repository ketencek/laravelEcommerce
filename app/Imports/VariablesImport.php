<?php
  
namespace App\Imports;
  
use App\Models\Variable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
  
class VariablesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // echo "As";
        // exit;
        $lang=['en', 'tr'];
        // echo "<pre>";
        // print_R($row);
        // exit;
        if(trim($row['name']) != '') {
            $variable  = Variable::where('name', trim($row['name']))->first();

            if(!$variable) {
                $variable = new Variable();
                $variable->name = trim($row['name']); 
            }

            if(isset($row['cat_type'])) {
                $variable->cat_type = $row['cat_type'];
            }else {
                $variable->cat_type = 'OTHER';
            }

            if(isset($row['status'])) {
                $variable->status = $row['status'];
            } else {
                $variable->status = 1;
            }
            foreach($lang as $l) {
                if(isset($row[$l.'_value']) && $row[$l.'_value'] != '') {
                    $variable->translateOrNew("$l")->value = $row[$l.'_value']; 
                }
            }
            $variable->save();           
            return $variable;
        }
    }
}