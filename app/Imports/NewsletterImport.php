<?php

namespace App\Imports;

use App\Models\Newsletter;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class NewsletterImport implements ToModel, SkipsEmptyRows, WithHeadingRow
{
    private $subscribe_type;

    public function __construct($subscribe_type)
    {
        $this->subscribe_type = $subscribe_type;
    }
    
    // public function rules(): array
    // {
    //     return [
    //         'email' => [
    //             'required',
    //             'email',
    //         ],
    //     ];
    // }

    public function onError(\Throwable $e)
    {
        //  echo $e->getMessage;
        // Handle the exception how you'd like.
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (trim($row['email']) != '') {

            $mail_name = trim($row['email']);
            $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
            if (preg_match($regex, $mail_name)) {
                $newsletter  = Newsletter::withoutGlobalScope('status')->where('email', trim($row['email']))->first();

                if (!$newsletter) {
                    $newsletter = new Newsletter();
                    $newsletter->email = trim($row['email']);
                }
                $newsletter->subscribed_type = $this->subscribe_type;

                if($row['status']) {
                    $newsletter->status = $row['status'];
                } else {
                    $newsletter->status = 0;
                }

                if($row['subscribed']) {
                    $newsletter->is_subscribed = $row['subscribed'];
                }else {
                    $newsletter->is_subscribed = 0;
                }
                
                $newsletter->save();

                return $newsletter;
            }
        }
    }
}
