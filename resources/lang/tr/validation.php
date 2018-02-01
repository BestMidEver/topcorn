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

    'accepted'             => ':attribute doğrulanmalıdır.',
    'active_url'           => ':attribute geçerli URL değil.',
    'after'                => ':attribute :date\'ten sonra olmalıdır.',
    'after_or_equal'       => ':attribute :date\'te ya da bu tarihten sonra olmalıdır.',
    'alpha'                => ':attribute sadece harflerden oluşabilir.',
    'alpha_dash'           => ':attribute sadece harflerden, rakamlardan ve tirelerden oluşabilir.',
    'alpha_num'            => ':attribute sadece harflerden ve rakamlardan oluşabilir.',
    'array'                => ':attribute dizi olmalıdır.',
    'before'               => ':attribute :date\'ten önce olmalıdır.',
    'before_or_equal'      => ':attribute :date\'te ya da bu tarihten önce olmalıdır.',
    'between'              => [
        'numeric' => ':attribute :min ve :max arasında olmalıdır.',
        'file'    => ':attribute en az :min, en çok :max kilobayt olabilir.',
        'string'  => ':attribute :min ve :max karakterleri arasında olmalıdır.',
        'array'   => ':attribute en az :min, en çok :max öğeden oluşmalıdır.',
    ],
    'boolean'              => ':attribute alanı doğru ya da yanlış olmalıdır.',
    'confirmed'            => ':attribute ve tekrarı uyuşmamaktadır.',
    'date'                 => ':attribute geçerli bir tarih değildir.',
    'date_format'          => ':attribute :format formatı ile uyuşmamaktadır.',
    'different'            => ':attribute ve :other farklı olmalıdır.',
    'digits'               => ':attribute :digits basamak olmalıdır.',
    'digits_between'       => ':attribute en az :min, en çok :max basamaklı olabilir.',
    'dimensions'           => ':attribute geçersiz boyuttadır.',
    'distinct'             => ':attribute alanı tekrar eden değer barındırmaktadır.',
    'email'                => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'exists'               => 'Seçilen :attribute geçersizdir.',
    'file'                 => ':attribute bir dosya olmalıdır.',
    'filled'               => ':attribute alanı boş bırakılamaz.',
    'image'                => ':attribute bir görüntü olmalıdır.',
    'in'                   => 'Seçilen :attribute geçersizdir.',
    'in_array'             => ':attribute alanı :other\'da bulunmamaktadır.',
    'integer'              => ':attribute tam sayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'                 => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'                 => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json'                 => ':attribute geçerli bir JSON stringi olmalıdır.',
    'max'                  => [
        'numeric' => ':attribute en çok :max olabilir.',
        'file'    => ':attribute en çok :max kilobayt olabilir.',
        'string'  => ':attribute en çok :max karakterden oluşabilir.',
        'array'   => ':attribute en çok :max öğeden oluşabilir.',
    ],
    'mimes'                => ':attribute, :values tipinde bir dosya olmalıdır.',
    'mimetypes'            => ':attribute, :values tipinde bir dosya olmalıdır.',
    'min'                  => [
        'numeric' => ':attribute en az :min olabilir.',
        'file'    => ':attribute en az :min kilobayt olabilir.',
        'string'  => ':attribute en az :min karakterden oluşmalıdır.',
        'array'   => ':attribute en az :min öğeden oluşmalıdır.',
    ],
    'not_in'               => 'Seçilen :attribute geçersizdir.',
    'numeric'              => ':attribute bir sayı olmalıdır.',
    'present'              => ':attribute alanı güncel olmalıdır.',
    'regex'                => ':attribute formatı geçersizdir.',
    'required'             => ':attribute alanı boş bırakılamaz.',
    'required_if'          => ':attribute alanı, eğer :other :value ise boş bırakılamaz.',
    'required_unless'      => ':attribute alanı, :other :values değerlerinden birisi değilse boş bırakılamaz.',
    'required_with'        => ':attribute alanı, eğer :values güncel ise boş bırakılamaz.',
    'required_with_all'    => ':attribute alanı, eğer :values güncel ise boş bırakılamaz.',
    'required_without'     => ':attribute alanı, eğer :values güncel değil ise boş bırakılamaz.',
    'required_without_all' => ':attribute alanı, eğer is :values değerlerinden hiç birisi güncel değilse boş bırakılamaz.',
    'same'                 => ':attribute ve :other eşleşmelidir.',
    'size'                 => [
        'numeric' => ':attribute :size basamaklı olmalıdır.',
        'file'    => ':attribute :size kilobayt olmalıdır.',
        'string'  => ':attribute :size karakterden oluşmalıdır.',
        'array'   => ':attribute :size öğeden oluşmalıdır.',
    ],
    'string'               => ':attribute karakter dizisi olmalıdır.',
    'timezone'             => ':attribute geçerli zaman dilimi olmalıdır.',
    'unique'               => ':attribute daha önce alınmış.',
    'uploaded'             => ':attribute karşıya yükleme başarısız oldu.',
    'url'                  => ':attribute formatı geçersiz.',

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
