<?php

namespace KodiCMS\SleepingOwlAdmin\FormItems;

use Input;
use Route;
use Response;
use Validator;
use KodiCMS\SleepingOwlAdmin\Interfaces\WithRoutesInterface;

class Image extends NamedFormItem implements WithRoutesInterface
{
    /**
     * @var string
     */
    protected static $route = 'uploadImage';

    public static function registerRoutes()
    {
        Route::post('formitems/image/'.static::$route, ['as' => 'admin.formitems.image.'.static::$route,
            function () {
                $validator = Validator::make(Input::all(), static::uploadValidationRules());
                if ($validator->fails()) {
                    return Response::make($validator->errors()->get('file'), 400);
                }

                $file = Input::file('file');
                $filename = md5(time().$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
                $path = config('sleeping_owl.imagesUploadDirectory');
                $fullpath = public_path($path);
                $file->move($fullpath, $filename);
                $value = $path.'/'.$filename;

                return [
                    'url'   => asset($value),
                    'value' => $value,
                ];
            },
        ]);
    }

    /**
     * @return array
     */
    protected static function uploadValidationRules()
    {
        return [
            'file' => 'image',
        ];
    }
}
