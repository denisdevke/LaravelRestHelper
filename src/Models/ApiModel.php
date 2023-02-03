<?php

namespace Denniskemboi\LaravelRestHelper\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiModel extends Model
{
    protected $fillable = [];

    public function fromReq(Request $request)
    {
        foreach ($this->fillable as $key) {
            if ($request->input($key) != null) {
                $this->$key = $request->input($key);
            }
        }
    }
}