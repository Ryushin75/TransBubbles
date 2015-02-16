<?php

class Strip extends Eloquent {

    use UploadFile;
    
    protected $table = 'strips';
    public $timestamps = true;
    protected $guarded = [ 'id', 'updated_at', 'created_at',
        'insertion_date', 'path', 'validated_at'];
    public static $rules = [
        'pageNumber' => 'numeric',
        'title' => 'max:64',
        'strip' => 'required|mimes:jpeg,bmp,png,tiff,tif,jpg|between:40,4096|image'
    ];
    
    public static $updateRules = [
        'title' => 'max:64'
    ];
    
    public function comic () {
        return $this->belongsTo('Comic');
    }
    
    public function shapes() {
        return $this->hasMany('Shape');
    }
    
    public function user() {
        return $this->belongsTo('User');
    }

}