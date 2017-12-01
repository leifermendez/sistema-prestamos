<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class db_supervisor_has_agent extends Model
{
    protected $table = 'agent_has_supervisor';
    public $timestamps = false;
}
