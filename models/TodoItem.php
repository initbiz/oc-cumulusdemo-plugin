<?php namespace Initbiz\CumulusDemo\Models;

use Model;
use RainLab\User\Models\User;
use Initbiz\CumulusCore\Models\Cluster;

/**
 * todoitem Model
 */
class TodoItem extends Model
{
    use \Initbiz\CumulusCore\Traits\ClusterFiltrable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'initbiz_cumulusdemo_todo_items';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    public $belongsTo = [
        'cluster' => [
            Cluster::class,
            'table' => 'initbiz_cumuluscore_clusters',
        ],
        'user' => [
            User::class,
            'table' => 'users',
        ]
    ];
}
