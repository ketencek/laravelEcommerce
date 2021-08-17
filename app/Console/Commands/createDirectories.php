<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use Artisan;

class createDirectories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createDirectories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create directories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $storagePath = storage_path() . "/app/public/";

        $folder_name = [
            'banner', 'blog', 'blogcat', 'category', 'page', 'product',
            'staticimage', 'faq', 'faqcat', 'contact',
            'newslettermessage', 'logo'
        ];

        $image_size = config('customconfig.image.thumb_folder');

        foreach ($folder_name as $folder) {
            foreach ($image_size as $size) {
                $file = $storagePath . $folder . '/' . $size;
                if (!File::exists($file)) {
                    $oldmask = umask(0);
                    File::makeDirectory($file, 0777, true, true);
                    umask($oldmask);
                }
            }
            $file = $storagePath . $folder . '/original';
            if (!File::exists($file)) {
                $oldmask = umask(0);
                File::makeDirectory($file, 0777, true, true);
                umask($oldmask);
            }

            if ($folder == 'newslettermessage') {
                $file = $storagePath . $folder . '/attachment';
                if (!File::exists($file)) {
                    $oldmask = umask(0);
                    File::makeDirectory($file, 0777, true, true);
                    umask($oldmask);
                }
            }
        }

        Artisan::call('storage:link');
        $this->info('Directories was created.');
        return 0;
    }
}
