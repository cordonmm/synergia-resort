<?phpclass Reserva extends Eloquent {	public function fecha_ini(){        return $this->fecha_ini;    }    public function fecha_fin(){        return $this->fecha_fin;    }    public function nombre(){        return $this->nombre;    }    public function email(){        return $this->email;    }    public function telefono(){        return $this->telefono;    }    public function dni(){        return $this->dni;    }    public function adultos(){        return $this->adultos;    }    public function ninos(){        return $this->ninos;    }    public function precio(){        return $this->precio;    }    public function observaciones(){        return $this->observaciones;    }    public function created_at(){        return $this->created_at;    }    public function updated_at(){        return $this->updated_at;    }}