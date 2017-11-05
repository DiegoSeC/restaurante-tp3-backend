<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL vÃ¡lida.',
    'after'                => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => ':attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => ':attribute sÃ³lo debe contener letras.',
    'alpha_dash'           => ':attribute sÃ³lo debe contener letras, nÃºmeros y guiones.',
    'alpha_num'            => ':attribute sÃ³lo debe contener letras y nÃºmeros.',
    'array'                => ':attribute debe ser un conjunto.',
    'before'               => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => ':attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => ':attribute tiene que estar entre :min - :max.',
        'file'    => ':attribute debe pesar entre :min - :max kilobytes.',
        'string'  => ':attribute tiene que tener entre :min - :max caracteres.',
        'array'   => ':attribute tiene que tener entre :min - :max Ã­tems.',
    ],
    'boolean'              => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed'            => 'La confirmaciÃ³n de :attribute no coincide.',
    'date'                 => ':attribute no es una fecha vÃ¡lida.',
    'date_format'          => ':attribute no corresponde al formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => ':attribute debe tener :digits dÃ­gitos.',
    'digits_between'       => ':attribute debe tener entre :min y :max dÃ­gitos.',
    'dimensions'           => 'Las dimensiones de la imagen :attribute no son vÃ¡lidas.',
    'distinct'             => 'El campo :attribute contiene un valor duplicado.',
    'email'                => ':attribute no es un correo vÃ¡lido',
    'exists'               => ':attribute es invÃ¡lido.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => ':attribute es invÃ¡lido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => ':attribute debe ser un nÃºmero entero.',
    'ip'                   => ':attribute debe ser una direcciÃ³n IP vÃ¡lida.',
    'json'                 => 'El campo :attribute debe tener una cadena JSON vÃ¡lida.',
    'max'                  => [
        'numeric' => ':attribute no debe ser mayor a :max.',
        'file'    => ':attribute no debe ser mayor que :max kilobytes.',
        'string'  => ':attribute no debe ser mayor que :max caracteres.',
        'array'   => ':attribute no debe tener mÃ¡s de :max elementos.',
    ],
    'mimes'                => ':attribute debe ser un archivo con formato: :values.',
    'mimetypes'            => ':attribute debe ser un archivo con formato: :values.',
    'min'                  => [
        'numeric' => 'El valor mÃ­nimo de :attribute debe ser al menos :min.',
        'file'    => 'El tamaÃ±o de :attribute debe ser de al menos :min kilobytes.',
        'string'  => ':attribute debe contener al menos :min caracteres.',
        'array'   => ':attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => ':attribute es invÃ¡lido.',
    'numeric'              => ':attribute debe ser numÃ©rico.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato de :attribute es invÃ¡lido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio a menos que :other estÃ© en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values estÃ¡ presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values estÃ¡ presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no estÃ¡ presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values estÃ©n presentes.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El tamaÃ±o de :attribute debe ser :size.',
        'file'    => 'El tamaÃ±o de :attribute debe ser :size kilobytes.',
        'string'  => ':attribute debe contener :size caracteres.',
        'array'   => ':attribute debe contener :size elementos.',
    ],
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El :attribute debe ser una zona vÃ¡lida.',
    'unique'               => ':attribute ya ha sido registrado.',
    'uploaded'             => 'Subir :attribute ha fallado.',
    'url'                  => 'El formato :attribute es invÃ¡lido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [

    ],

];