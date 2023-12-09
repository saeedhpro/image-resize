<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class ResizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:resize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resize images in a specific directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = storage_path('app/images'); // مسیر دلخواه تصاویر

        $files = File::files($directory);

        $this->info('Resizing images...');
        $manager = new ImageManager(
            new Driver()
        );
        foreach ($files as $file) {
            $image = $manager->read($file);

            $image->resize(100, 100);
            if (!File::exists($directory . '/resized/')) {
                File::makeDirectory($directory . '/resized/');
            }
            $newPath = $directory . '/resized/' . $file->getFilenameWithoutExtension().'_'.Carbon::now()->format('Y_m_d_H_i_s').'.'.$file->getExtension();

            $encoded = $image->toJpeg();
            $encoded->save($newPath);
        }

        $this->info('Images resized successfully.');
    }
}
