<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pings', static function (Blueprint $table) { // Static function for slightly better performance
            $table->id();
            $table->uuid('uuid');
            $table->unsignedTinyInteger('battery_percent')->default(0);
            $table->timestamps();
        });
    }
};
