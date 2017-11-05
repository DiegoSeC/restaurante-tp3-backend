<?php

namespace App\Http\Controllers\Traits;

use App\Exceptions\Classes\BadRequestException;
use Illuminate\Http\Request;
use Validator;


Trait ValidateRequestTrait
{

     private $contentTypeJson = 'json';

    /**
     * @param Request $request
     * @throws BadRequestException
     */
    public function validateRequestJson(Request $request)
    {
        if (!$request->isJson() || ($request->getContentType() != $this->contentTypeJson)) {
            throw new BadRequestException(trans('exception.bad_request'));
        }
    }

    /**
     * @param Request $request
     * @param array $rules
     * @throws BadRequestException
     */
    public function validateParams(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new BadRequestException(trans('exception.bad_request'));
        }
    }

    /**
     * @param Request $request
     * @param array $rules
     * @throws BadRequestException
     */
    public function validateExistParams(Request $request, array $rules)
    {
        $params = $request->all();
        if (empty($params)) {
            throw new BadRequestException(trans('exception.bad_request'));
        }

        $keysParams = array_keys($params);
        $keysRules = array_keys($rules);

        $exists = array_intersect($keysParams, $keysRules);
        if (empty($exists)) {
            throw new BadRequestException(trans('exception.bad_request'));
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new BadRequestException(trans('exception.bad_request'));
        }

    }

}