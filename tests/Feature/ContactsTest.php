<?php

namespace Tests\Feature;

use App\Contact;
use Carbon\Carbon;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     * ユーザーに関連づけられているものを削除、表示および編集する。
     * 認証されたユーザーの連絡先のリストを取得できるかのテスト。
     */
    public function a_list_of_contacts_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $anotherContact = factory(Contact::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/contacts?api_token=' . $user->api_token);

        $response->assertJsonCount(1)->assertJson([['id' => $contact->id]]);
    }
    /** @test
     *
     */
    public function an_unauthenticated_user_should_redirect_to_login()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['api_token' => '']));
        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function an_authenticated_user_can_add_a_contact()
    {
        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        // assertCount($count, $array) 配列$arrayの値の数が$countである。
        // $this->assertCount(1, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
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
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'name' => $contact->name,
            'email' => $contact->email,
            'birthday' => $contact->birthday,
            'company' => $contact->company,
        ]);
    }

    /**
     * @test
     */
    public function only_the_users_contacts_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $anotherUser = factory(User::class)->create();
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $anotherUser->api_token);
        $response->assertStatus(403);
    }

    /** @test
     *
     */
    public function a_contact_can_be_patched()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());
        $contact = $contact->fresh();
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
    }

    /**
     * @test
     */
    public function only_the_owner_of_the_contact_can_patch_the_contact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $anotherUser = factory(User::class)->create();
        $response = $this->patch('/api/contacts/' . $contact->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));
        $response->assertStatus(403);
    }

    public function a_contact_can_be_deleted()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);
        $this->assertCount(0, Contact::all());
    }

    /**
     * @test
     */
    public function only_the_owner_can_delete_the_contact()
    {
        $contact = factory(Contact::class)->create();
        $anotherUser = factory(User::class)->create();
        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
            'api_token' => $this->user->api_token,
        ];
    }
}
