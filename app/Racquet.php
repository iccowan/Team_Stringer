<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Racquet extends Model
{
    protected $table = 'racquets';
    protected $fillable = ['id', 'user_id', 'team_token', 'manufacturer', 'type', 'tension_lbs', 'string', 'notes', 'created_at', 'updated_at'];

    public function getFullTextAttribute() {
        $racquet = Racquet::find($this->id);
        $text = $racquet->manufacturer.' '.$racquet->type.' (Strung at '.$racquet->tension_lbs.'LBS with '.$racquet->string;
        return $this->manufacturer.' - '.$this->type.' (Strung at '.$this->tension_lbs.'LBS with '.$this->string.')';
    }
}
