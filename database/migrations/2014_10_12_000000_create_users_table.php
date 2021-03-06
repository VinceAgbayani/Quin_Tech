<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email')->unique();
            $table->string('password')->nullable();

            $table->date('hiring_date', 255);
            $table->date('birth_date', 255);

            $table->string('department', 255);

            $table->integer('supervisor_id')->unsigned()->nullable();
            $table->foreign('supervisor_id')->references('id')->on('users');

            $table->integer('position')->unsigned()->nullable();
            $table->foreign('position')->references('id')->on('positions');

            $table->boolean('manager_check')->default(false);

            $table->string('profile_photo', 255)->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        /*Informal Seed*/

        DB::table('users')->insert(
        array(
            'first_name' => 'Quin',
            'last_name' => 'Tech',
            'email' => 'qt@qt.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Executive Board',
            'supervisor_id' => '1',
            'position' => '1',
            'manager_check' => true


        )  );

        DB::table('users')->insert(
        array(
            'first_name' => 'Zen',
            'last_name' => 'Tiongson',
            'email' => 'zt@zt.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Finance',
            'supervisor_id' => '1', 
            'position' => '1',
            'manager_check' => true,
            'profile_photo' => 'zen.jpg'
        ));   

        DB::table('users')->insert(
        array(
            'first_name' => 'Anferny',
            'last_name' => 'Vanta',
            'email' => 'vantanferny@gmail.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Human Resources',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => false,
            'profile_photo' => 'ferny.jpg'
        ));   

         

         DB::table('users')->insert(
        array(
            'first_name' => 'Stephen',
            'last_name' => 'Wenceslao',
            'email' => 'sw@sw.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Human Resources',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => false,
            'profile_photo' => 'stephen.jpg'
        ));   

         DB::table('users')->insert(
        array(
            'first_name' => 'Vince',
            'last_name' => 'Agbayani',
            'email' => 'jvinceagbayani@gmail.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Customer Service',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => false,
            'profile_photo' => 'vicente.jpg'
        ));   

         DB::table('users')->insert(
        array(
            'first_name' => 'Chesco',
            'last_name' => 'Mamaradlo',
            'email' => 'cm@cm.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Human Resources',
            'supervisor_id' => '1', 
            'position' => '1',
            'manager_check' => true
        ));

         DB::table('users')->insert(
        array(
            'first_name' => 'Quin',
            'last_name' => 'Technologies',
            'email' => 'quintech@ph.zalora.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Finance',
            'supervisor_id' => '1', 
            'position' => '1',
            'manager_check' => false
        ));

         DB::table('users')->insert(
        array(
            'first_name' => 'Manager',
            'last_name' => 'Account',
            'email' => 'manager@ph.zalora.com',
            'password' => bcrypt('password01'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Finance',
            'supervisor_id' => '1', 
            'position' => '1',
            'manager_check' => true
        ));

         DB::table('users')->insert(
        array(
            'first_name' => 'HR',
            'last_name' => 'Account',
            'email' => 'hr@ph.zalora.com',
            'password' => bcrypt('password02'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Human Resources',
            'supervisor_id' => '1', 
            'position' => '1',
            'manager_check' => false
        ));

         DB::table('users')->insert(
        array(
            'first_name' => 'Board',
            'last_name' => 'Executive',
            'email' => 'boardexec@ph.zalora.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Administration',
            'supervisor_id' => '1', 
            'position' => '1',
            'manager_check' => true
        ));

        DB::table('users')->insert(
        array(
            'first_name' => 'Eunice',
            'last_name' => 'Santos',
            'email' => 'es@es.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Finance',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => false,
        ));

        DB::table('users')->insert(
        array(
            'first_name' => 'Roni',
            'last_name' => 'Reyes',
            'email' => 'rr@rr.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Human Resources',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => false,
        ));

        DB::table('users')->insert(
        array(
            'first_name' => 'Cindy',
            'last_name' => 'Santos',
            'email' => 'cs@cs.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Customer Service',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => false,
        ));

        DB::table('users')->insert(
        array(
            'first_name' => 'Ricky',
            'last_name' => 'Flores',
            'email' => 'rf@rf.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Customer Service',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => true,
        ));

        DB::table('users')->insert(
        array(
            'first_name' => 'Anne',
            'last_name' => 'Cruz',
            'email' => 'ac@ac.com',
            'password' => bcrypt('password00'),
            'hiring_date' => '2018-12-31',
            'birth_date' => '2018-12-31',
            'department' => 'Finance',
            'supervisor_id' => '2', 
            'position' => '1',
            'manager_check' => true,
        ));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
