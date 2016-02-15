<?php

use KodiCMS\SleepingOwlAdmin\Display\DisplayTabbed;
use KodiCMS\Users\Model\User;
use KodiCMS\Users\Model\UserRole;
use KodiCMS\SleepingOwlAdmin\Filter\Filter;
use KodiCMS\SleepingOwlAdmin\Columns\Column;
use KodiCMS\SleepingOwlAdmin\Filter\FilterBase;
use KodiCMS\SleepingOwlAdmin\FormItems\FormItem;
use KodiCMS\SleepingOwlAdmin\Model\ModelConfiguration;

SleepingOwlModule::registerModel(User::class, function (ModelConfiguration $model) {
        $model->setTitle('User')
            ->onDisplay(function () {
                $display = SleepingOwlDisplay::tabbed();

                $display->setTabs(function (DisplayTabbed $tabbed) {

                    $tabbed->appendDisplay(
                        SleepingOwlDisplay::table()
                            ->setFilters([
                                Filter::field('username')->setOperator(FilterBase::BEGINS_WITH),
                            ])
                            ->setColumns([
                                Column::link('username')->setLabel('Username'),
                                Column::lists('roles.name')->setLabel('Roles'),
                                Column::email('email')->setLabel('E-mail')->setWidth('100px'),
                            ]), 'First Tab');

                    $tabbed->appendDisplay(SleepingOwlDisplay::table(), 'Second Tab');
                });

                return $display;
            })->onCreateAndEdit(function () {
                $form = SleepingOwlForm::form();
                $form->setItems(
                    FormItem::columns()->setColumns([
                        [
                            FormItem::text('username', 'Username')->required(),
                            FormItem::text('email', 'E-mail')->required()->addValidationRule('email'),
                            FormItem::date('created_at', 'Date creation'),

                            FormItem::multiselect('roles', 'Roles')->setModelForOptions(new UserRole)->setDisplay('name'),
                        ],
                    ])
                );

                return $form;
            });
    })
    ->addMenuLink(User::class)
    ->setIcon('users');
