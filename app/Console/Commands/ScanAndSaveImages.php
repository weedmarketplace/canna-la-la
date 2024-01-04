<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScanAndSaveImages extends Command
{
    protected $signature = 'images:scan';
    protected $description = 'Scan specified folders for new images and save their paths';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $foldersToScan = ['products', 'brend', 'content', 'pairing'];

        foreach ($foldersToScan as $folder) {
            $files = File::files(public_path($folder));

            foreach ($files as $file) {
                $fileName = str_replace('.' . $file->getExtension(), '', $file->getFilename());

                $model = Image::query()->where('filename', $fileName)->first() ?: new Image();

                $model->fill([
                    'filename' => $fileName,
                    'ext' => $file->getExtension(),
                    'size' => $file->getSize(),
                    'image_path' => "public/$folder/" . $file->getFilename(),
                ])->save();
            }
        }

        $this->info('Scanning and saving images completed.');
    }
}