<?php

namespace Tests\Feature;

use App\Contact;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_contact_can_be_added()
    {
        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        // assertCount($count, $array) 配列$arrayの値の数が$countである。
        // $this->assertCount(1, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday);
        $this->assertEquals('ABC String', $contact->company);

    }

    /** @test
     * required のフィールドのテスト
     */
    public function fields_are_required()
    {
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function($field) {
            $response = $this->post('/api/contacts', array_merge($this->data(), [$field => '']));

        $response->assertSessionHasErrors($field);
        // すべての連絡先がデータベースに追加されていないことをテストする。assertCount($count, $array) 配列$arrayの値の数が$countである。
        $this->assertCount(0, Contact::all());
        });
    }

    /** @test
     * emailの形式であるかチェック、また、有効なemailであるかチェック
     */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['email' => 'NOT AN EMAIL']));
        $response->assertSessionHasErrors('email');
        // emailの形式にテストする。assertCount($count, $array) 配列$arrayの値の数が$countである。
        $this->assertCount(0, Contact::all());
    }

    /** @test
     *
     */
    public function birthdays_are_properly_stored()
    {
        $this->withExceptionHandling();
        $response = $this->post('/api/contacts', array_merge($this->data()));
        // 下記のように、実際の値を入れても正常にグリーンのままである。綺麗にCarbonによって変換されている。ここは一旦、より柔軟なようにしておきたいので、値を指定する方法はやめておく。
        // $response = $this->post('/api/contacts', array_merge($this->data(), ['birthday' => 'May 14, 1988']));

        // birthdayの形式にテストする。postしたデータの中でbirthdayに関する1つであることを期待している。
        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('05-14-1988', Contact::first()->birthday->format('m-d-Y'));
    }

    /** @test
     *
     */
    public function a_contact_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->get('/api/contacts/' . $contact->id);
        $response->assertJson([
            'name' => $contact->name,
            'email' => $contact->email,
            'birthday' => $contact->birthday,
            'company' => $contact->company,
        ]);
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
        ];
    }
}
