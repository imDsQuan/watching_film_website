<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var store response object
     */
    public $response;

    /**
     * @var store repository object
     */
    public $repository;

    protected $status  = 'fail';

    protected $message = '';

    protected $code    = 200;

    public function callAction($method, $parameters)
    {
        unset($parameters['guard']);
        unset($parameters['trans']);

        return parent::callAction($method, $parameters);
    }

    protected function responseData($data = [], $more = '', $code = 200) {
        $res = [
            'status'  => $this->status,
            'message' => $this->message,
            'code'    => $this->code,
            'data'    => $data
        ];
        if($more)
            $res = array_merge($res, $more);
        return response()->json($res, $code);
    }

    protected function validateBase(Request $request ,$rules)
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors      = $validator->errors();
            return json_decode($errors, true);
        }
        return false;
    }
}
