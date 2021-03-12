<?php namespace Initbiz\CumulusDemo\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTodoItemsTable extends Migration
{
    public function up()
    {
        Schema::create('initbiz_cumulusdemo_todo_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');            
            $table->integer('user_id')->unsigned();
            $table->integer('cluster_id')->unsigned();
            $table->mediumText('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initbiz_cumulusdemo_todo_items');
    }
}
