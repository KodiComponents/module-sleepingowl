<?php

namespace KodiCMS\SleepingOwlAdmin\Providers;

use Route;
use Event;
use ModulesLoader;
use ModulesFileSystem;
use KodiCMS\Navigation\Navigation;
use KodiCMS\Support\ServiceProvider;
use KodiCMS\SleepingOwlAdmin\Filter\Filter;
use KodiCMS\SleepingOwlAdmin\Columns\Column;
use KodiCMS\SleepingOwlAdmin\Form\AdminForm;
use KodiCMS\SleepingOwlAdmin\TemplateDefault;
use KodiCMS\SleepingOwlAdmin\SleepingOwlAdmin;
use KodiCMS\SleepingOwlAdmin\FormItems\FormItem;
use KodiCMS\SleepingOwlAdmin\Facades\SleepingOwlModule;
use KodiCMS\SleepingOwlAdmin\Display\SleepingOwlDisplay;
use KodiCMS\SleepingOwlAdmin\ColumnFilters\ColumnFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('sleeping_owl', function () {
            return new SleepingOwlAdmin();
        });

        $this->app->singleton('sleeping_owl.template', function () {
            return new TemplateDefault();
        });

        $this->registerProviders([
            ColumnFilterServiceProvider::class,
            ColumnServiceProvider::class,
            DisplayServiceProvider::class,
            FilterServiceProvider::class,
            FormServiceProvider::class,
            FormItemServiceProvider::class,
        ]);

        $this->registerAliases([
            'SleepingOwlModule'       => SleepingOwlModule::class,
            'SleepingOwlColumn'       => Column::class,
            'SleepingOwlColumnFilter' => ColumnFilter::class,
            'SleepingOwlFilter'       => Filter::class,
            'SleepingOwlDisplay'      => SleepingOwlDisplay::class,
            'SleepingOwlForm'         => AdminForm::class,
            'SleepingOwlFormItem'     => FormItem::class,
        ]);

        foreach (ModulesFileSystem::listFiles('SleepingOwlModels') as $file) {
            require $file;
        }

        $this->registerRoutePatterns();
    }

    public function boot()
    {
        Event::listen('navigation.inited', function (Navigation $navigation) {
            $this->app['sleeping_owl']->buildMenu($navigation);
        });

        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cms' => public_path('cms')
        ], 'kodicms');
    }

    protected function registerRoutePatterns()
    {
        Route::pattern('adminModelId', '[0-9]+');

        $aliases = $this->app['sleeping_owl']->modelAliases();

        if (count($aliases) > 0) {
            Route::pattern('adminModel', implode('|', $aliases));
            Route::bind('adminModel', function ($model) use ($aliases) {
                $class = array_search($model, $aliases);

                if ($class === false) {
                    throw new ModelNotFoundException;
                }
                return $this->app['sleeping_owl']->getModel($class);
            });
        }

        Route::pattern('adminWildcard', '.*');
    }
}
