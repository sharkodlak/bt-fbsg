<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->string('month');
            $table->string('day');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('holidays')->insert([
            ['state' => 'CZ', 'month' => '01', 'day' => '01', 'name' => 'Nový rok'],
            ['state' => 'CZ', 'month' => '05', 'day' => '01', 'name' => 'Svátek práce'],
            ['state' => 'CZ', 'month' => '05', 'day' => '08', 'name' => 'Den vítězství'],
            ['state' => 'CZ', 'month' => '07', 'day' => '05', 'name' => 'Den slovanských věrozvěstů Cyrila a Metoděje'],
            ['state' => 'CZ', 'month' => '07', 'day' => '06', 'name' => 'Den upálení mistra Jana Husa'],
            ['state' => 'CZ', 'month' => '09', 'day' => '28', 'name' => 'Den české státnosti'],
            ['state' => 'CZ', 'month' => '10', 'day' => '28', 'name' => 'Den vzniku samostatného československého státu'],
            ['state' => 'CZ', 'month' => '11', 'day' => '17', 'name' => 'Den boje za svobodu a demokracii'],
            ['state' => 'CZ', 'month' => '12', 'day' => '24', 'name' => 'Štědrý den'],
            ['state' => 'CZ', 'month' => '12', 'day' => '25', 'name' => '1. svátek vánoční'],
            ['state' => 'CZ', 'month' => '12', 'day' => '26', 'name' => '2. svátek vánoční'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
