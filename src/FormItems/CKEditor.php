<?php

namespace KodiCMS\SleepingOwlAdmin\FormItems;

use Input;
use Route;
use stdClass;
use Exception;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use KodiCMS\SleepingOwlAdmin\Interfaces\WithRoutesInterface;

class CKEditor extends NamedFormItem implements WithRoutesInterface
{
    public static function registerRoutes()
    {
        Route::get('assets/images/all', function () {
            return static::getAll();
        });
        Route::post('assets/images/upload', function () {
            return static::postUpload();
        });
    }

    /**
     * @var string
     */
    protected $view = 'ckeditor';

    /**
     * @return array
     */
    protected static function getAll()
    {
        $files = static::getAllFiles();
        $result = [];
        foreach ($files as $file) {
            $result[] = static::createImageObject($file);
        }

        return $result;
    }

    /**
     * @return Finder
     */
    protected static function getAllFiles()
    {
        $path = public_path(config('sleeping_owl.imagesUploadDirectory'));

        return Finder::create()->files()->in($path);
    }

    /**
     * @param SplFileInfo $file
     *
     * @return stdClass
     */
    protected static function createImageObject(SplFileInfo $file)
    {
        $obj = new StdClass;
        $path = $file->getRelativePathname();
        $url = config('sleeping_owl.imagesUploadDirectory').'/'.$path;
        $url = asset($url);
        $obj->url = $url;
        $obj->thumbnail = $url;

        return $obj;
    }

    /**
     * @return string
     */
    protected static function postUpload()
    {
        $path = config('sleeping_owl.imagesUploadDirectory').'/';
        $upload_dir = public_path($path);
        $allowedExtensions = [
            'bmp',
            'gif',
            'jpg',
            'jpeg',
            'png',
        ];
        $maxsize = 2000;
        $maxwidth = 9000;
        $maxheight = 8000;
        $minwidth = 10;
        $minheight = 10;
        $file = Input::file('upload');
        $errors = [];
        $extension = null;
        $width = 0;
        $height = 0;
        try {
            if (is_null($file)) {
                $errors[] = trans('sleepingowl::core.ckeditor.upload.error.common');
                throw new Exception;
            }
            $extension = $file->guessClientExtension();
            if (! in_array($extension, $allowedExtensions)) {
                $errors[] = trans('sleepingowl::core.ckeditor.upload.error.wrong_extension',
                    ['file' => $file->getClientOriginalName()]);
                throw new Exception;
            }
            if ($file->getSize() > $maxsize * 1000) {
                $errors[] = trans('sleepingowl::core.ckeditor.upload.error.filesize_limit', ['size' => $maxsize]);
            }
            list($width, $height) = getimagesize($file);
            if ($width > $maxwidth || $height > $maxheight) {
                $errors[] = trans('sleepingowl::core.ckeditor.upload.error.imagesize_max_limit', [
                    'width'     => $width,
                    'height'    => $height,
                    'maxwidth'  => $maxwidth,
                    'maxheight' => $maxheight,
                ]);
            }
            if ($width < $minwidth || $height < $minheight) {
                $errors[] = trans('sleepingowl::core.ckeditor.upload.error.imagesize_min_limit', [
                    'width'     => $width,
                    'height'    => $height,
                    'minwidth'  => $minwidth,
                    'minheight' => $minheight,
                ]);
            }
        } catch (Exception $e) {
        }
        if (! empty($errors)) {
            return '<script>alert("'.implode('\\n', $errors).'");</script>';
        }
        $finalFilename = $file->getClientOriginalName();
        $file = $file->move($upload_dir, $finalFilename);
        $CKEditorFuncNum = Input::get('CKEditorFuncNum');
        $url = asset($path.$finalFilename);
        $message = trans('sleepingowl::core.ckeditor.upload.success', [
            'size'   => number_format($file->getSize() / 1024, 3, '.', ''),
            'width'  => $width,
            'height' => $height,
        ]);
        $result = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";

        return '<script>'.$result.';</script>';
    }
}
