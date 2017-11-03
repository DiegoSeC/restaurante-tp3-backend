<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Validator;


class ValidateRequestTrait
{

    const CONTENT_TYPE_JSON = 'json';

    /**
     * @param Request $request
     */
    public function validateRequestJson(Request $request)
    {
        if (!$request->isJson() || ($request->getContentType() != self::CONTENT_TYPE_JSON)) {
            //throw new BadRequestException(trans('exception.bad_request'));
        }
    }

    /**
     * @param Request $request
     * @param array $rules
     */
    public function validateParams(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            //throw new BadParamRequestException(trans('exception.bad_param_request'), $validator->errors());
        }
    }

    /**
     * @param Request $request
     * @param array $rules
     */
    public function validateExistParams(Request $request, array $rules)
    {
        $params = $request->all();
        if (empty($params)) {
            //throw new BadParamRequestException(trans('exception.bad_param_request'));
        }

        $keysParams = array_keys($params);
        $keysRules = array_keys($rules);

        $exists = array_intersect($keysParams, $keysRules);
        if (empty($exists)) {
            //throw new BadParamRequestException(trans('exception.bad_param_request'));
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            //throw new BadParamRequestException(trans('exception.bad_param_request'), $validator->errors());
        }

    }

}