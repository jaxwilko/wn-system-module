<?php

use October\Rain\Database\Updates\Migration;

class DbFailedJobs extends Migration
{
    public function up()
    {
        Schema::create('failed_jobs', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('connection');
            $table->text('queue');
            $table->text('payload');
            $table->timestamp('failed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
