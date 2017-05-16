<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
 
class UserTest extends TestCase
{
 
    use DatabaseMigrations;
 
    public function testUserCreate()
    {
        $data = $this->getData();
        // Creamos un nuevo usuario y verificamos la respuesta
        $this->post('/persona', $data)
            ->seeJsonEquals(['created' => true]);
 
        $data = $this->getData(['nom_persona' => 'jane']);
        // Actualizamos al usuario recien creado (id = 1)
        $this->put('/persona/1', $data)
            ->seeJsonEquals(['updated' => true]);
 
        // Obtenemos los datos de dicho usuario modificado
        // y verificamos que el nombre sea el correcto
        $this->get('persona/1')->seeJson(['nom_persona' => 'jane']);
 
        // Eliminamos al usuario
        $this->delete('persona/1')->seeJson(['deleted' => true]);
    }
 
    public function getData($custom = array())
    {
        $data = [
            'nom_persona'      => 'joe',
            'correo'     => 'joe@doe.com',
            'clave'  => '12345'
            ];
        $data = array_merge($data, $custom);
        return $data;
    }
}