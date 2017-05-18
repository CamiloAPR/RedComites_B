<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(CommitteeStatusSeeder::class);
        $this->call(PublicationStatusSeeder::class);
        $this->call(CommitteeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommitteeMemberSeeder::class);
        $this->call(PublicationSeeder::class);
    }
}

class RoleSeeder extends Seeder {

    public function run()
    {
        DB::table('role')->delete();

        DB::table('role')->insert(
            array(
                'role' => 'Administrador',
            )
        );
        DB::table('role')->insert(
            array(
                'role' => 'Usuario',
            )
        );
    }
}


class MemberSeeder extends Seeder {

    public function run()
    {
        DB::table('member')->delete();

        DB::table('member')->insert(
        	array(
                'name' => 'Clara Nensthiel',
                'email' => 'eventos.ingenierias@unbosque.edu.co',
                'function' => 'function1'
                // 'fec_nacimiento' => '01/01/2017',
                // 'estado' => 'ACTIVO',
                // 'rol' => 'A'
            )
        );
    }
}

class CommitteeStatusSeeder extends Seeder {

    public function run()
    {
        DB::table('committee_status')->delete();

        DB::table('committee_status')->insert(
            array(
                'status' => 'Activo',

            )
        );

        DB::table('committee_status')->insert(
            array(
                'status' => 'Inactivo',

            )
        );
    }
}

class PublicationStatusSeeder extends Seeder {

    public function run()
    {
        DB::table('publication_status')->delete();

        DB::table('publication_status')->insert(
            array(
                'status' => 'Activo',

            )
        );

        DB::table('publication_status')->insert(
            array(
                'status' => 'Inactivo',

            )
        );
    }
}

class CommitteeSeeder extends Seeder {

    public function run()
    {
        DB::table('committee')->delete();

        DB::table('committee')->insert(
            array(
                'general_info' => 'C comunicaciones',
                'function' => 'Función de comunicaciones',
                'banner' => 'banner',
                'icon' => 'icon',
                'color' => '#000000',
                'status' => '1'

            )
        );

        DB::table('committee')->insert(
            array(
                'general_info' => 'C internacionalizacion',
                'function' => 'Función de internacionalizacion',
                'banner' => 'banner',
                'icon' => 'icon',
                'color' => '#000000',
                'status' => '1'

            )
        );

        DB::table('committee')->insert(
            array(
                'general_info' => 'C responsabilidad social',
                'function' => 'Función de responsabilidad social',
                'banner' => 'banner',
                'icon' => 'icon',
                'color' => '#000000',
                'status' => '1'

            )
        );

    }
}

class UserSeeder extends Seeder {

    public function run()
    {
        DB::table('user')->delete();

        DB::table('user')->insert(
            array(
                'name' => 'Comité de comunicaciones',
                'email' => 'eventos.ingenierias@unbosque.edu.co',
                'password' => '123456',
                'role' => '1',
                'committee' => '1'

            )
        );

        DB::table('user')->insert(
            array(
                'name' => 'Internacionalizacion',
                'email' => 'eventos.ingenieriasinter@unbosque.edu.co',
                'password' => '123456',
                'role' => '2',
                'committee' => '2'

            )
        );

        DB::table('user')->insert(
            array(
                'name' => 'Responsabilidad social',
                'email' => 'eventos.ingenieriasrso@unbosque.edu.co',
                'password' => '123456',
                'role' => '2',
                'committee' => '3'

            )
        );
    }
}

class CommitteeMemberSeeder extends Seeder {

    public function run()
    {
        DB::table('committee_member')->delete();

        DB::table('committee_member')->insert(
            array(
                'committee' => '1',
                'member' => '1'


            )
        );

    }
}

class PublicationSeeder extends Seeder {

    public function run()
    {
        DB::table('publication')->delete();

        DB::table('publication')->insert(
            array(
                'committee' => '1',
                'title' => 'Publicación de comunicación',
                'content' => 'Contenido de publicación',
                'status' => '1'

            )
        );
    }
}