<?php

    namespace BrokenTitan\StorableEvents\Models;

    use Illuminate\Database\Eloquent\Model;

    class Event extends Model {
        protected $attributes = [
            "class" => null,
            "data" => null,
            "name" => null
        ];
        protected $fillable = [
            "class",
            "data",
            "name"
        ];
    }
