<?php namespace Initbiz\CumulusDemo\Models;

use Model;

/**
 * todoitem Model
 */
class Todoitem extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'initbiz_cumulusdemo_todoitems';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
