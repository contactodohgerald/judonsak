<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('toastReturnUpdate')) {

    function toastReturnUpdate($message = 'Update Successfull', $type = 'success', $title = 'Success')
    {
        $data = [
            'message' => $message,
            'type' => $type,
            'titl' => $title
        ];
        return $data;
    }
}

if (!function_exists('toastReturnError')) {

    function toastReturnError($message = 'Action Unsuccessfull', $type = 'error', $title = 'Error')
    {
        $data = [
            'message' => $message,
            'type' => $type,
            'titl' => $title
        ];
        return $data;
    }
}

if (!function_exists('toastReturnSuccess')) {

    function toastReturnSuccess($message = 'Action Successfull', $type = 'success', $title = 'Success')
    {
        $data = [
            'message' => $message,
            'type' => $type,
            'titl' => $title
        ];
        return $data;
    }
}

if (!function_exists('logPersonAction')) {

    function logPersonAction($action, $person, $description, $model)
    {
        $log = new App\Models\Log;
        $log->action_type = $action;
        $log->person_id = $person;
        $log->Description = $description;
        $model->logs()->save($log);
    }
}

if (!function_exists('prettyDate')) {
    function prettyDate($param)
    {
        return $param->diffForHumans();
    }
}

if (!function_exists('currentUser')) {

    function currentUser()
    {
        return Auth::user();
    }
}

if (!function_exists('showPartnerName')) {

    function showPartnerName($person_id, $other_id)
    {
        $person = new App\Models\Person;
        // dd($person->where('id', '=', $other_id)->first());
        if (Auth::id() == $person_id) {
            $res = $person->where('id', '=', $other_id)->first();
        } else {
            $res = $person->where('id', '=', $person_id)->first();
        }
        return $res->first_name . ' ' . $res->last_name;
    }
}

if (!function_exists('appLogAction')) {

    function appLogAction($param)
    {
        switch ($param) {
            case 1:
                $res = 'Created';
                break;

            case 2:
                $res = 'Updated';
                break;

            case 3:
                $res = 'Deleted';
                break;

            case 4:
                $res = 'Restored';
                break;

            case 5:
                $res = 'Completed';
                break;

            default:
                $res = 'Viewed';
                break;
        }
        return $res;
    }
}
