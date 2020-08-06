<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('JobType');
            $table->text('location');
            $table->text('company');
            $table->text('address');
            $table->integer('experience');
            $table->integer('category');
            $table->string('offday');
            $table->integer('salary');
            $table->longText('jobDetails');
            $table->longText('requerments');
            $table->longText('qualification');
            $table->text('image');
            $table->longText('benefit');
            $table->text('lastdate');
            $table->text('dutyStart');
            $table->text('dutyEnd');
            $table->integer('vacency');
            $table->boolean('verify')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
}
