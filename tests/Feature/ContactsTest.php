<?php

namespace Tests\Feature;

use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_contact_can_be_added()
    {
        $this->withExceptionHandling();

        $this->post('/api/contacts', [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
        ]);

        $contact = Contact::first();

        // assertCount($count, $array) 配列$arrayの値の数が$countである。
        // $this->assertCount(1, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday);
        $this->assertEquals('ABC String', $contact->company);

    }

    /** @test */
    public function a_name_is_required()
    {
        $response = $this->post('/api/contacts', [
            'email' => 'test@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
        ]);

        $response->assertSessionHasErrors('name');
        // すべての連絡先がデータベースに追加されていないことをテストする。assertCount($count, $array) 配列$arrayの値の数が$countである。
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->post('/api/contacts', [
            'name' => 'Test Name',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
        ]);

        $response->assertSessionHasErrors('email');
        // すべての連絡先がデータベースに追加されていないことをテストする。assertCount($count, $array) 配列$arrayの値の数が$countである。
        $this->assertCount(0, Contact::all());
    }
}
