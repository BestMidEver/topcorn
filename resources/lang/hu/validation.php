<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Az e-mailt el kell fogadni.',
    'active_url'           => 'A: attribútum nem érvényes URL.',
    'after'                => 'Az :attribute :date a dátum után kell lennie.',
    'after_or_equal'       => 'Az :attribute :date dátum után kell lennie, vagy egyenlőnek kell lennie',
    'alpha'                => 'Az :attribute csak betűket tartalmazhat.',
    'alpha_dash'           => 'Az :attribute csak betűket, számokat és kötőjeleket tartalmazhat.',
    'alpha_num'            => 'Az :attribute csak betűket és számokat tartalmazhat.',
    'array'                => 'Az :attribute egy tömbnek kell lennie.',
    'before'               => 'Az :attribute :date a dátum előtt kell lennie.',
    'before_or_equal'      => 'Az :attribute :date dátum előtt kell lennie, vagy egyenlőnek kell lennie.',
    'between'              => [
        'numeric' => 'Az :attribute :min és :max között kell lennie.',
        'file'    => 'Az :attribute :min és :max kilobájt között kell lennie.',
        'string'  => 'Az :attribute :min és :max karakter között kell lennie.',
        'array'   => 'Az :attribute :min és :max elem között kell lennie.',
    ],
    'boolean'              => 'Az :attribute mezőnek igaznak vagy hamisnak kell lennie.',
    'confirmed'            => 'Az :attribute a megerősítés nem egyezik.',
    'date'                 => 'Az :attribute nem érvényes dátum.',
    'date_format'          => 'Az :attribute :format nem felel meg a formátumnak.',
    'different'            => 'Az :attribute és :other különbözőnek kell lennie.',
    'digits'               => 'Az :attribute :digits számjegynek kell lennie.',
    'digits_between'       => 'Az :attribute :min és :max számjegy között kell lennie.',
    'dimensions'           => 'Az :attribute érvénytelen képméretekkel rendelkezik.',
    'distinct'             => 'Az :attribute mező duplikált értékkel rendelkezik.',
    'email'                => 'Az :attribute létező e-mail címnek kell lennie.',
    'exists'               => 'A kiválasztott :attribute érvénytelen.',
    'file'                 => 'Az :attribute fájlnak kell lennie.',
    'filled'               => 'Az :attribute mezőt nem lehet üresen hagyni.',
    'image'                => 'Az :attribute képnek kell lennie.',
    'in'                   => 'A kiválasztott :attribute érvénytelen.',
    'in_array'             => 'Az :attribute a mező nem létezik :other.',
    'integer'              => 'Az :attribute egész számnak kell lennie.',
    'ip'                   => 'Az :attribute érvényes IP-címnek kell lennie.',
    'ipv4'                 => 'Az :attribute érvényes IPv4-címnek kell lennie.',
    'ipv6'                 => 'Az :attribute érvényes IPv6-címnek kell lennie.',
    'json'                 => 'Az :attribute ésvényes JSON string-nek kell lennie.',
    'max'                  => [
        'numeric' => 'Az :attribute nem lehet nagyobb, mint :max.',
        'file'    => 'Az :attribute nem lehet nagyobb, mint :max kilobájt.',
        'string'  => 'Az :attribute nem lehet nagyobb, mint :max karakter.',
        'array'   => 'Az :attribute nem lehet több, mint :max elem.',
    ],
    'mimes'                => 'Az :attribute :values típusú fájlnak kell lennie.',
    'mimetypes'            => 'Az :attribute :values típusú fájlnak kell lennie.',
    'min'                  => [
        'numeric' => 'Az :attribute legalább :min legyen.',
        'file'    => 'Az :attribute legalább :min kilobájt.',
        'string'  => 'Az :attribute legalább :min karakter.',
        'array'   => 'Az :attribute legalább :min elemet kell tartalmaznia.',
    ],
    'not_in'               => 'A kiválasztott :attribute érvénytelen.',
    'numeric'              => 'Az :attribute egy számnak kell lennie.',
    'present'              => 'Az :attribute mezőnek jelen kell lennie.',
    'regex'                => 'Az :attribute formátuma érvénytelen.',
    'required'             => 'Az :attribute kötelező mező.',
    'required_if'          => 'Ha :other :value, akkor :attribute nem lehet üres.',
    'required_unless'      => 'Az :attribute nem lehet üres, hacsak :other  :values.',
    'required_with'        => 'Ha :values a jelenlegi, akkor :attribute nem lehet üres.',
    'required_with_all'    => 'Ha :values a jelenlegi, akkor :attribute nem lehet üres.',
    'required_without'     => 'Ha :values nem a jelenlegi, akkor :attribute nem lehet üres.',
    'required_without_all' => 'Ha :values közül egyik sem a jelenlegi, akkor :attribute nem lehet üres.',
    'same'                 => 'Az :attribute és :other egyeznie kell.',
    'size'                 => [
        'numeric' => 'Az :attribute :size kell legyen.',
        'file'    => 'Az :attribute :size kilobájt kell legyen.',
        'string'  => 'Az :attribute :size karakter kell legyen.',
        'array'   => 'Az :attribute tartalmaznia kell :size elemet.',
    ],
    'string'               => 'Az :attribute egy stringnek kell lennie.',
    'timezone'             => 'Az :attribute érvényes zónának kell lennie.',
    'unique'               => 'Az :attribute már foglalt.',
    'uploaded'             => 'Az :attribute feltöltés nem sikerült.',
    'url'                  => 'Az :attribute formátum érvénytelen.',

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

    'custom' => [
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

    'attributes' => [],

];
