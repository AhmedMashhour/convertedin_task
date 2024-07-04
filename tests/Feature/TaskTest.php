<?php


use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_page_is_displayed(): void
    {
        $admin = User::factory([
            'role' => User::ROLE_TYPE_ADMIN
        ])->create();

        $response = $this
            ->actingAs($admin)
            ->get('/profile');

        $response->assertOk();
    }



    public function test_task_creating_validation(): void
    {
        $admin = User::factory([
            'role' => User::ROLE_TYPE_ADMIN
        ])->create();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($admin)
            ->post('/tasks/store', [
                'assigned_to_id' => $user->id,
                'assigned_by_id' => $admin->id,
            ]);
        $response
            ->assertSessionHasErrors([
                'title',
                'description'
            ]);

    }

    public function test_task_assigned_by_id_must_be_user(): void
    {
        $admin = User::factory([
            'role' => User::ROLE_TYPE_ADMIN
        ])->create();


        $response = $this
            ->actingAs($admin)
            ->post('/tasks/store', [
                'title' => 'title test',
                'description' => 'description test',
                'assigned_to_id' => $admin->id,
                'assigned_by_id' => $admin->id,
            ]);
        $response
            ->assertSessionHasErrors([
                'assigned_to_id'
            ]);


    }

    public function test_task_assigned_to_id_must_be_admin(): void
    {
        $admin = User::factory([
            'role' => User::ROLE_TYPE_ADMIN
        ])->create();

        $user = User::factory()->create();
        $response = $this
            ->actingAs($admin)
            ->post('/tasks/store', [
                'title' => 'title test',
                'description' => 'description test',
                'assigned_to_id' => $admin->id,
                'assigned_by_id' => $user->id,
            ]);
        $response
            ->assertSessionHasErrors([
                'assigned_to_id'
            ]);


    }

    /**
     * @throws JsonException
     */
    public function test_task_can_be_created(): void
    {
        $admin = User::factory([
            'role' => User::ROLE_TYPE_ADMIN
        ])->create();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($admin)
            ->post('/tasks/store', [
                'title' => 'title test',
                'description' => 'description test',
                'assigned_to_id' => $user->id,
                'assigned_by_id' => $admin->id,
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/dashboard');

        $task = \App\Models\Task::query()->latest('id')->first();

        $this->assertSame('title test', $task->title);
        $this->assertSame('description test', $task->description);
        $this->assertSame($admin->id, $task->assigned_by_id);
        $this->assertSame($user->id, $task->assigned_to_id);

    }

    public function test_user_can_not_create_task()
    {


        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/tasks/store', [
                'title' => 'title test',
                'description' => 'description test',
                'assigned_to_id' => $user->id,
                'assigned_by_id' => $user->id,
            ]);
        $response
            ->assertStatus(403);

    }

}
