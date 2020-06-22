<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guests_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        $this->get('threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');;
    }
    
    /**
     * @test
     */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post(route('store_thread'), $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 5)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 777])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Testing\TestResponse
     */
    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('store_thread'), $thread->toArray());
    }
}
