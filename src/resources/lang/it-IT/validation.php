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

    'accepted'             => 'Il valore di :attribute deve essere accettata.',
    'active_url'           => 'Il valore di :attribute non è un URL valido.',
    'after'                => 'Il valore di :attribute deve essere una data successiva a :date.',
    'alpha'                => 'Il valore di :attribute deve contenere solo lettere.',
    'alpha_dash'           => 'Il valore di :attribute deve contenere solo lettere, numeri e trattini.',
    'alpha_num'            => 'Il valore di :attribute deve contenere solo lettere e numeri.',
    'array'                => 'Il valore di :attribute deve essere un array.',
    'before'               => 'Il valore di :attribute deve essere una data precedente a :date.',
    'between'              => [
        'numeric' => 'Il valore di :attribute deve essere compreso tra :min e :max.',
        'file'    => 'Il valore di :attribute deve essere compreso tra :min e :max kilobytes.',
        'string'  => 'Il valore di :attribute deve essere compreso tra :min e :max caratteri.',
        'array'   => 'Il valore di :attribute deve essere compreso tra :min e :max elementi.',
    ],
    'boolean'              => 'Il valore di :attribute deve essere vero o falso.',
    'confirmed'            => 'Il valore di conferma di :attribute non combacia.',
    'date'                 => 'Il valore di :attribute non è una data valida.',
    'date_format'          => 'Il valore di :attribute non corrisponde al formato :format.',
    'different'            => 'Il valore di :attribute e di :other devono essere differenti.',
    'digits'               => 'Il valore di :attribute deve essere lungo almeno :digits cifre.',
    'digits_between'       => 'Il valore di :attribute deve essere compreso tra :min e :max cifre.',
    'dimensions'           => 'Il valore di :attribute ha una dimensione dell\'immagine non valida.',
    'distinct'             => 'Il valore di :attribute è duplicato.',
    'email'                => 'Il valore di :attribute deve essere un indirizzo email valido.',
    'exists'               => 'Il valore selezionato di :attribute non è valido.',
    'file'                 => 'Il valore di :attribute deve essere un file.',
    'filled'               => 'Il valore di :attribute è obbligatorio.',
    'image'                => 'Il valore di :attribute deve essere un immagine.',
    'in'                   => 'Il valore selezionato di :attribute non è valido.',
    'in_array'             => 'Il valore di :attribute non è presente in :other.',
    'integer'              => 'Il valore di :attribute deve essere un numero intero.',
    'ip'                   => 'Il valore di :attribute deve essere un indirizzo IP valido.',
    'json'                 => 'Il valore di :attribute deve essere una stringa JSON valida.',
    'max'                  => [
        'numeric' => 'Il valore di :attribute non deve essere superiore a :max.',
        'file'    => 'Il valore di :attribute non deve essere superiore a :max kilobytes.',
        'string'  => 'Il valore di :attribute non deve essere superiore a :max caratteri.',
        'array'   => 'Il valore di :attribute non deve avere più di :max elementi.',
    ],
    'mimes'                => 'Il valore di :attribute deve essere un file del tipo: :values.',
    'mimetypes'            => 'Il valore di :attribute deve essere un file del tipo: :values.',
    'min'                  => [
        'numeric' => 'Il valore di :attribute deve essere almeno :min.',
        'file'    => 'Il valore di :attribute deve essere almeno :min kilobytes.',
        'string'  => 'Il valore di :attribute deve essere almeno :min caratteri.',
        'array'   => 'Il valore di :attribute deve avere almeno :min elementi.',
    ],
    'not_in'               => 'Il valore selezionato di :attribute non è valido.',
    'numeric'              => 'Il valore di :attribute deve essere un numero.',
    'present'              => 'Il valore di :attribute deve essere presente.',
    'regex'                => 'Il formato del valore di :attribute non è valido.',
    'required'             => 'Il valore di :attribute è obbligatorio.',
    'required_if'          => 'Il valore di :attribute è obbligatorio quando :other è uguale a :value.',
    'required_unless'      => 'Il valore di :attribute è obbligatorio a meno che :other sia in :values.',
    'required_with'        => 'Il valore di :attribute è obbligatorio quando :values è presente.',
    'required_with_all'    => 'Il valore di :attribute è obbligatorio quando :values è presente.',
    'required_without'     => 'Il valore di :attribute è obbligatorio quando :values non è presente.',
    'required_without_all' => 'Il valore di :attribute è obbligatorio quando nessuno di questi valori :values è presente.',
    'same'                 => 'Il valore di :attribute e di :other devono corrispondere.',
    'size'                 => [
        'numeric' => 'Il valore di :attribute deve essere di :size.',
        'file'    => 'Il valore di :attribute deve essere di :size kilobytes.',
        'string'  => 'Il valore di :attribute deve essere di :size carattero.',
        'array'   => 'Il valore di :attribute deve contenere :size elementi.',
    ],
    'string'               => 'Il valore di :attribute deve essere una stringa.',
    'timezone'             => 'Il valore di :attribute deve essere una timezone valida.',
    'unique'               => 'Esiste già un contenuto con questo :attribute.',
    'uploaded'             => 'Caricamento del file :attribute fallito.',
    'url'                  => 'Il formato di :attribute non è corretto.',

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
