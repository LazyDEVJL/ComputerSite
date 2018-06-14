<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_customers';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
