<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/* TaxitManager Routes */

Route::get(
    '/',
    function () {
        return redirect()->route('dashboard');
    }
)->name('landingPage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/change-password', 'HomeController@ChangePassword')
    ->name('change.password');
Route::post(
    '/admin/change-password/store',
    'HomeController@UpdatePassword'
)->name('change.password.store');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// client routes
Route::resource('client', 'ClientController');
Route::resource('payment', 'PaymentController');

Route::get('/admin/payment/{param}', 'PaymentController@directQuery')
    ->name('payment.param');
Route::get('/admin/feenote/{param}', 'FeenoteController@directQuery')
    ->name('feenote.param');
Route::post(
    '/admin/feenote/{feenote}/generate',
    'FeenoteController@remit'
)->name('feenote.generate');

Route::resource('feenote', 'FeenoteController');

Route::get('/client/manager/summary', 'ClientController@manager')
    ->name('client.manager');
Route::put(
    '/instruction/manager/update/api',
    'InstructionController@updateStatusAPI'
);


// contract routes
Route::name('client')->group(
    function () {
        Route::prefix('client')->group(
            function () {
                Route::get('/{client}/contract', 'ContractController@index')
                    ->name('.contract.index');
                Route::post('/{client}/contract', 'ContractController@store')
                    ->name('.contract.store');
                Route::get(
                    '/{client}/contract/create',
                    'ContractController@create'
                )
                    ->name('.contract.create');
                Route::get(
                    '/{client}/contract/{contract}',
                    'ContractController@show'
                )
                    ->name('.contract.show');
                Route::put(
                    '/{client}/contract/{contract}',
                    'ContractController@update'
                )
                    ->name('.contract.update');
                Route::get(
                    '/{client}/contract/{contract}/edit',
                    'ContractController@edit'
                )
                    ->name('.contract.edit');
                Route::delete(
                    '/{client}/contract/{contract}',
                    'ContractController@destroy'
                )
                    ->name('.contract.destroy');
            }
        );
    }
);

// instruction routes
Route::name('contract')
    ->group(
        function () {
            Route::prefix('contract')
                ->group(
                    function () {
                        Route::get(
                            '/{contract}/instruction',
                            'InstructionController@index'
                        )->name('.instruction.index');
                        Route::post(
                            '/{contract}/instruction',
                            'InstructionController@store'
                        )->name('.instruction.store');
                        Route::get(
                            '/{contract}/instruction/create',
                            'InstructionController@create'
                        )->name('.instruction.create');
                        Route::get(
                            '/{contract}/instruction{instruction}',
                            'InstructionController@show'
                        )->name('.instruction.show');
                        Route::put(
                            '/{contract}/instruction/{instruction}',
                            'InstructionController@update'
                        )->name('.instruction.update');
                        Route::get(
                            '/{contract}/instruction/{instruction}/edit',
                            'InstructionController@edit'
                        )->name('.instruction.edit');
                        Route::delete(
                            '/{contract}/instruction/{instruction}',
                            'InstructionController@destroy'
                        )->name('.instruction.destroy');
                    }
                );
        }
    );

// task routes
Route::name('instruction')
    ->group(
        function () {
            Route::prefix('instruction')
                ->group(
                    function () {
                        Route::get(
                            '/{instruction}/task',
                            'TaskController@index'
                        )->name('.task.index');
                        Route::post(
                            '/{instruction}/task',
                            'TaskController@store'
                        )->name('.task.store');
                        Route::get(
                            '/{instruction}/task/create',
                            'TaskController@create'
                        )->name('.task.create');
                        Route::get(
                            '/{instruction}/task/{task}',
                            'TaskController@show'
                        )->name('.task.show');
                        Route::put(
                            '/{instruction}/task/{task}',
                            'TaskController@update'
                        )->name('.task.update');
                        Route::get(
                            '/{instruction}/task/{task}/edit',
                            'TaskController@edit'
                        )->name('.task.edit');
                        Route::delete(
                            '/{instruction}/task/{task}',
                            'TaskController@destroy'
                        )->name('.task.destroy');
                    }
                );
        }
    );


// checklist routes
Route::name('instruction')
    ->group(
        function () {
            Route::prefix('instruction')
                ->group(
                    function () {
                        Route::get(
                            '/{instruction}/checklist',
                            'ChecklistController@index'
                        )->name('.checklist.index');
                        Route::post(
                            '/{instruction}/checklist',
                            'ChecklistController@store'
                        )->name('.checklist.store');
                        Route::get(
                            '/{instruction}/checklist/create',
                            'ChecklistController@create'
                        )->name('.checklist.create');
                        Route::get(
                            '/{instruction}/checklist/{checklist}',
                            'ChecklistController@show'
                        )->name('.checklist.show');
                        Route::put(
                            '/{instruction}/checklist/{checklist}',
                            'ChecklistController@update'
                        )->name('.checklist.update');
                        Route::get(
                            '/{instruction}/checklist/{checklist}/edit',
                            'ChecklistController@edit'
                        )->name('.checklist.edit');
                        Route::delete(
                            '/{instruction}/checklist/{checklist}',
                            'ChecklistController@destroy'
                        )->name('.checklist.destroy');
                    }
                );
        }
    );


// admin sidebar
Route::prefix('admin')
    ->group(
        function () {
            Route::resource('bank', 'BankController');
            Route::resource('budget', 'BudgetController');
            Route::resource('recievable', 'RecievableController');
            Route::get(
                'financial/summary',
                'RevenueController@financialSummary'
            )->name('financial.summary');
            Route::post(
                '/modal/upload/expenditure',
                'ExpenditureController@upload'
            )->name('expenditure.upload');
            Route::delete(
                '/destroy/{expenditure}/{budget}',
                'ExpenditureController@destroy'
            )->name('expenditure.destroy');
            Route::put(
                '/update/{expenditure}/status/{budget}',
                'ExpenditureController@pend'
            )->name('expenditure.pend');
            Route::post(
                '/accept/{expenditure}/{budget}',
                'ExpenditureController@accept'
            )->name('expenditure.accept');
            Route::get(
                '/desks',
                'ServiceController@index'
            )->name('service.index');
            Route::get(
                '/desks/{service}',
                'ServiceController@show'
            )->name('service.show');
            Route::get(
                '/contract',
                'ContractController@directIndex'
            )->name('contract.index');
            Route::get(
                '/contract/new',
                'ContractController@directCreate'
            )->name('contract.create');
            Route::get(
                '/instruction',
                'InstructionController@directIndex'
            )->name('instruction.index');
            Route::get(
                '/instruction/new',
                'InstructionController@directCreate'
            )->name('instruction.create');
            Route::get(
                '/instruction/deleted',
                'InstructionController@viewDeleted'
            )->name('instruction.viewDeleted');
            Route::put(
                '/instruction/deleted/{instruction}',
                'InstructionController@restoreDeleted'
            )->name('instruction.restoreDeleted');
            Route::get(
                '/task',
                'TaskController@directIndex'
            )->name('task.index');
            Route::get(
                '/checklist',
                'ChecklistController@index'
            )->name('checklist.index');
            Route::get(
                '/task/new',
                'TaskController@directCreate'
            )->name('task.create');
            Route::get(
                '/calendar/events',
                'CalendarController@index'
            )->name('calendar.index');
            Route::resource('document', 'DocumentController');
            Route::resource('finance', 'RevenueController');
            Route::get(
                '/staff/create',
                'PersonController@create'
            )->name('staff.create');
            Route::get(
                '/staff/edit/{person}',
                'PersonController@edit'
            )->name('staff.edit');
            Route::get(
                '/task/{query}',
                'TaskController@directQuery'
            )->name('task.param');
            Route::get(
                '/instruction/{query}',
                'InstructionController@directQuery'
            )->name('instruction.param');


            /* PartnerPoint */
            Route::post(
                '/store_partner_point',
                'PartnerPointController@store'
            )->name('partnerPoint');

            /* LineManagerPoint */
            Route::post(
                '/store_linemanager_point',
                'LineManagerPointController@store'
            )->name('linemanagerPoint');

            /* Supervisor Task */
            Route::get('/supervisor/task/{query}', 'TaskController@supervisorTask')->name('supervisor.task');

            /* Point Detials */
            Route::get('/executor/partner/point-details/{person}', 'PersonController@partnerPointDetails')->name('partnerPointDetails');
            Route::get('/executor/linemanage/point-details/{person}', 'PersonController@linemanagerPointDetails')->name('linemanagerPointDetails');
            Route::get('/executor/hr/point-details/{person}', 'PersonController@hrPoint')->name('hrPoint');
            Route::get('/executor/total/point-details/{person}', 'PersonController@totalPoint')->name('totalPoint');
            Route::get('/executor/total-tasks/{person}', 'PersonController@totalTask')->name('totalTask');


            Route::post(
                '/contract/store',
                'ContractController@directStore'
            )->name('contract.store');
            Route::post(
                '/instruction/store',
                'InstructionController@directStore'
            )->name('instruction.store');
            Route::post(
                '/task/store',
                'TaskController@directStore'
            )->name('task.store');

            //profile
            Route::resource('profile', 'PersonController');
            Route::resource('cashbook', 'CashbookController');
            Route::get('/cashbook/{param}/entry', 'CashbookController@create')
                ->name('cashbook.param.entry');
            Route::post('/profile/update/{profileId}', 'PersonController@update')->name('update');


            Route::post('/store-bonus', 'HRPointController@store')->name('storehr');
            Route::post('/store-deficit', 'DeficitPointController@store')->name('storeDeficit');

            // Route::post('profile/{profile}', 'PostPointController@findAction')->name('postPoint');
        }
    );


//logs
Route::name('log')
    ->group(
        function () {
            Route::prefix('log')
                ->group(
                    function () {
                        Route::get('/{param}/latest', 'LogController@getParam')
                            ->name('.param');
                        Route::get('/{person}/logs', 'LogController@Person')
                            ->name('.person');
                        Route::delete('/{log}/delete', 'LogController@destroy')
                            ->name('.destroy');
                    }
                );
        }
    );


//documents
Route::name('document')
    ->group(
        function () {
            Route::prefix('document')
                ->group(
                    function () {
                        Route::get('/all', 'DocumentController@index');
                        Route::get(
                            '/{client}/folders',
                            'DocumentController@folder'
                        )->name('.client');
                        Route::get(
                            '/{client}/{folder}/document',
                            'DocumentController@clientDocument'
                        )->name('.client.document');
                        Route::get(
                            '/{client}/download/{document}',
                            'DocumentController@download'
                        )->name('.client.download');
                    }
                );
        }
    );

//conversations
Route::name('conversation')
    ->group(
        function () {
            Route::prefix('conversation')
                ->group(
                    function () {
                        Route::get(
                            '/{type}',
                            'ConversationController@index'
                        )->name('.index');
                        Route::get(
                            '/{conversation}/person',
                            'ConversationController@show'
                        )->name('.show');
                        Route::post(
                            '/{conversation}',
                            'MessageController@store'
                        )->name('.store');
                        Route::get(
                            'start/{person}',
                            'ConversationController@store'
                        )->name('.start');
                        Route::delete(
                            '/{conversation}/delete',
                            'ConversationController@destroy'
                        )->name('.destroy');
                    }
                );
        }
    );


// update status
Route::post(
    'update/checklist/status',
    'TaskController@updateStatus'
)->name('checklist.update.status');
Route::post(
    'update/project/status',
    'InstructionController@updateStatus'
)->name('project.update.status');

// update status
Route::post(
    'update/task/status',
    'TaskController@updateStatus'
)->name('task.update.status');
Route::post(
    'update/instruction/status',
    'InstructionController@updateStatus'
)->name('instruction.update.status');
Route::post(
    'create/task/note',
    'TaskController@createNote'
)->name('task.create.note');
Route::delete(
    '/{client}/contact/{contact}',
    'ContactController@destroy'
)->name('contact.destroy');


Route::get(
    'admin/import/clients',
    'ImportController@createClientManager'
)->name('client.create.import');
Route::post(
    'admin/import/clients',
    'ImportController@storeClientManager'
)->name('client.import.store');
Route::post(
    'admin/modal/save/task',
    'TaskController@storeModal'
)->name('task.modal.store');


//AJAX form APIs
Route::get(
    'admin/instruction/new/select/client/api/{id}',
    'InstructionController@clientAPI'
);
Route::get(
    'admin/instruction/new/select/contract/api/{id}',
    'InstructionController@contractAPI'
);
Route::get(
    'admin/instruction/new/select/service/api/{id}',
    'InstructionController@serviceAPI'
);
Route::get(
    'admin/instruction/new/select/instruction/api/{id}',
    'InstructionController@instructionAPI'
);

Route::get(
    'admin/instruction/new/service/all/api/{contract}/{service}',
    'InstructionController@getContractServicesAPI'
);

// desk APIs
// Route::get(
//     'admin/desk/client/api/{service}',
//     'ServiceController@getClientApi'
// );
Route::get(
    'admin/desk/instruction/api/{service}',
    'ServiceController@getInstructionApi'
);
Route::get(
    'admin/desk/task/api/{service}',
    'ServiceController@getTaskApi'
);
Route::get(
    'admin/desk/contract/api/{service}',
    'ServiceController@getContractApi'
);
Route::get(
    'admin/service/task/{task}',
    'TaskController@serviceShow'
);

Route::post('submit-task', 'TaskController@submitTask')->name('submitTask');

Route::get('best-emp_month', 'TaskController@bestEmployee')->name('bestEmployee');
