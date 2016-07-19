<?phpclass Reserva extends Eloquent {    protected $table = 'reservas';	public function fecha_ini(){        return $this->fecha_ini;    }    public function fecha_fin(){        return $this->fecha_fin;    }    public function nombre(){        return $this->nombre;    }    public function email(){        return $this->email;    }    public function telefono(){        return $this->telefono;    }    public function dni(){        return $this->dni;    }    public function adultos(){        return $this->adultos;    }    public function ninos(){        return $this->ninos;    }    public function precio(){        return $this->precio;    }    public function observaciones(){        return $this->observaciones;    }    public function created_at(){        return $this->created_at;    }    public function updated_at(){        return $this->updated_at;    }    public static function validate($input){        $rules = array(            'nombre'            =>  array('required', 'max:255'),            'email'             =>  array('required', 'email', 'max:255'),            'telefono'          =>  array('required', 'regex:/^\d{9}$/'),            'dni'               =>  array('required', 'regex:/^\d{8}[a-zA-Z]{1}$/'),            'adultos'           =>  array('required', 'numeric', 'min:1', 'max:5'),            'ninos'             =>  array('required', 'numeric', 'min:0', 'max:4'),            'precio'            =>  array('required', 'numeric', 'min:0')        );        $messages = array(            'required'  =>      'Este campo debe ser rellenado.',            'email'     =>      'Este campo debe tener el formato de un email.',            'numeric'   =>      'Este campo debe ser solamente numérico.',            'min'       =>      'Este campo debe tener al menos :min carácteres.',            'max'       =>      'Este campo debe tener como máximo :max carácteres.',            'regex'     =>      'Este campo no tiene un formato válido.',            'adultos.min'   =>  'El número de adultos no puede ser menor a :min.',            'adultos.max'   =>  'El número de adultos no puede ser superior a :max.',            'ninos.min'     =>  'El número de niños no puede ser menor a :min.',            'ninos.max'     =>  'El número de niños no puede ser superior a :max.',            'precio.min'    =>  'El precio no puede ser menor a : min.'        );        $validator = Validator::make(            $input,            $rules,            $messages        );        return $validator;    }    public static function validate_dates_reserva(){    }}