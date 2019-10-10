<?php namespace Initbiz\CumulusDemo\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTodoitemsTable extends Migration
{
    public function up()
    {
        Schema::create('initbiz_cumulusdemo_todoitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initbiz_cumulusdemo_todoitems');
    }
}
