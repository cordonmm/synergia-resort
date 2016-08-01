<?phpclass Configuracion extends Eloquent {    protected   $table          =   "configuraciones";    public      $timestamps     =   false;    private static $rules          =    array(        'fecha_ini'                =>   array('required', 'date', 'date_format:Y-m-d', 'before:fecha_fin'),        'fecha_fin'                =>   array('required', 'date', 'date_format:Y-m-d'),        'alias'                    =>   array('required', 'max:255'),        'tarifa_minima'            =>   array('required', 'numeric', 'min:0', 'digits_between:1,17'),        'precio_noche_adicional'   =>   array('required', 'numeric', 'min:0', 'digits_between:1,17'),        'precio_semana'            =>   array('required', 'numeric', 'min:0', 'digits_between:1,17'),        'noches_minimas'           =>   array('required', 'integer', 'min:1', 'max:10')    );    private static $messages       =    array(        'required'                 =>  'El campo :attribute es requerido.',        'date'                     =>  'El campo :attribute debe ser una fecha válida.',        'date_format'              =>  'El campo :attribute debe tener el siguiente formato "yyyy-mm-dd".',        'max'                      =>  'El campo :attribute no puede tener más de :max carácteres.',        'min'                      =>  'El campo :attribute no puede ser menor a :min.',        'numeric'                  =>  'El campo :attribute debe ser numérico.',        'integer'                  =>  'El campo :attribute debe ser un número entero.',        'noches_minimas.max'       =>  'El campo noches_minimas no puede ser superior a :max.',        'digits_between'           =>  'El campo :attribute no puede tener menos de :min dígitos y más de :max dígitos.',        'fecha_ini.before'         =>  'La fecha de inicio no puede ser superior o igual a la final.'    );    public static function validate($input){        $validator  =   Validator::make(            $input,            self::$rules,            self::$messages        );        return $validator;    }}