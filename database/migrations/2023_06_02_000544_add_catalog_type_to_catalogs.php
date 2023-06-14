<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalogs', function (Blueprint $table) {
<<<<<<< HEAD
            $table->string('catalog_type')->after('business_id');
=======
            $table->string('catalog_type');
>>>>>>> 057d6f0509a0904381860dc4403b5e03ce995bfd
        });
    }

    public function down()
    {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropColumn('catalog_type');
        });
    }
};
