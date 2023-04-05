<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInquiries extends Model
{
    //
    protected $fillable = ['name','email','subject','message'];
}
