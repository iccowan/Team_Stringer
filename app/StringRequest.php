<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StringRequest extends Model
{
    protected $table = 'string';
    protected $fillable = ['id', 'user_id', 'team_token', 'racquet_id', 'status', 'updated_by', 'created_at', 'updated_at'];

    public function getRequestDateAttribute() {
        return $this->created_at->format('d/m/Y');
    }

    public function getCompletionDateAttribute() {
        return $this->updated_at->format('d/m/Y');
    }
}
