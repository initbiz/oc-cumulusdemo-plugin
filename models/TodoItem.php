<?php namespace Initbiz\CumulusDemo\Models;

use Lang;
use Model;
use RainLab\User\Models\User;
use Initbiz\CumulusCore\Models\Cluster;
use Initbiz\CumulusCore\Classes\Helpers;
use Initbiz\CumulusDemo\Models\TodoItem;
use Initbiz\CumulusCore\Classes\FeatureManager;
use October\Rain\Exception\ApplicationException;

/**
 * todoitem Model
 */
class TodoItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
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

    protected $rules = [
        'name' => 'required|max:50',
    ];

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
    
    public function beforeSave()
    {
        $cluster = Helpers::getCluster();
        $item = TodoItem::clusterIdFiltered()->count();
        
        if(!$cluster->canEnterFeature('initbiz.cumulusdemo.basic.todo')||
            !$cluster->canEnterFeature('initbiz.cumulusdemo.advanced.todo') &&    
            $cluster->canEnterFeature('initbiz.cumulusdemo.basic.todo') && $item >= 5)
        {
            throw new ApplicationException(Lang::get('initbiz.cumulusdemo::lang.exceptions.todo_error'));
        }        

        if($cluster->canEnterFeature('initbiz.cumulusdemo.advanced.todo') && $item >= 10)
        {
            throw new ApplicationException(Lang::get('initbiz.cumulusdemo::lang.exceptions.todo_error'));
        }        
    }
}
