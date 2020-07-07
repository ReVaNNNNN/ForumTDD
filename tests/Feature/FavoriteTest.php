<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_cannot_favorite_anything()
    {
        $this->withExceptionHandling();

        $this->post(route('favorite_reply', 1))
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post(route('favorite_reply', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    public function an_authenticated_user_may_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
        $this->post(route('favorite_reply', $reply->id));
        $this->post(route('favorite_reply', $reply->id));
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }

        $this->assertCount(1, $reply->favorites);
    }
}

