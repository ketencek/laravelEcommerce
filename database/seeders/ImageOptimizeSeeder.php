<?php

namespace Database\Seeders;

use App\Models\ImageOptimize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageOptimizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `image_optimizes` (`module_name`, `thumb_folder`, `is_optimise`, `width`, `height`, `crop_ratio`, `ord`, `created_at`, `updated_at`) VALUES
            ('Newsletter_image', 'big', 0, '1000', '500', '2', 0, now(), now()),
            ('Newsletter_image', 'medium', 0, '400', '200', '2', 0, now(), now()),
            ('Newsletter_image', 'small', 0, '200', '100', '2', 0, now(), now()),
            ('Category', 'big', 0, '500', '800', '0.625', 0, now(), now()),
            ('Category', 'medium', 0, '350', '560', '0.625', 0, now(), now()),
            ('Category', 'small', 0, '200', '320', '0.625', 0, now(), now()),
            ('Banner', 'big', 1, '1920', '750', '2.56', 0, now(),now()),
            ('Banner', 'medium', 0, '400', '156', '2.56', 0, now(), now()),
            ('Banner', 'small', 0, '200', '78', '2.56', 0, now(), now()),
            ('Product', 'big', 0, '1200', '1200', '1', 0, now(), now()),
            ('Product', 'medium', 0, '500', '500', '1', 0, now(), now()),
            ('Product', 'small', 0, '260', '260', '1', 0, now(), now()),
            ('Product', 'tiny', 0, '80', '80', '1', 0, now(), now()),
            ('BreadcrumbBanner', 'big', 1, '1920', '750', '2.56', 0, now(),now()),
            ('BreadcrumbBanner', 'medium', 0, '400', '156', '2.56', 0, now(), now()),
            ('BreadcrumbBanner', 'small', 0, '200', '78', '2.56', 0, now(), now()),
             ('Contact', 'big', 0, '1000', '500', '2', 0, now(), now()),
             ('Contact', 'medium', 0, '400', '200', '2', 0, now(), now()),
             ('Contact', 'small', 0, '200', '100', '2', 0, now(), now()),
             ('Faq', 'big', 0, '1000', '1429', '0.7', 0, now(), now()),
             ('Faq', 'medium', 0, '400', '571', '0.7', 0, now(), now()),
             ('Faq', 'small', 0, '200', '286', '0.7', 0, now(), now()),
             ('FaqCategory', 'big', 0, '600', '300', '2', 0, now(), now()),
             ('FaqCategory', 'medium', 0, '300', '150', '2', 0, now(), now()),
             ('FaqCategory', 'small', 0, '200', '100', '2', 0, now(), now()),
             ('Blog', 'big', 0, '1000', '600', '1.666', 0, now(), now()),
             ('Blog', 'medium', 0, '350', '210', '1.666', 0, now(), now()),
             ('Blog', 'small', 0, '200', '120', '1.666', 0, now(), now()),
             ('BlogCategory', 'big', 0, '600', '300', '2', 0, now(), now()),
             ('BlogCategory', 'medium', 0, '300', '150', '2', 0, now(), now()),
             ('BlogCategory', 'small', 0, '200', '100', '2', 0, now(), now())
             ");

        ImageOptimize::saveImageSize();
    }
}
