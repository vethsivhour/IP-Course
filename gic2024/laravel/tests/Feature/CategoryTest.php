<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** Test ID: Category-001
     * Description: Check if we can access the get all categories api
     */
    public function test_get_all_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /** Test ID: Category-002
     * Description: Verify creating a new category with valid data
     */
    public function test_admin_can_create_category()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson('/api/categories', [
            'name' => 'Electronics',
            'description' => 'Electronic devices'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Electronics']);
        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics',
            'description' => 'Electronic devices'
        ]);
    }

    /** Test ID: Category-003
     * Description: Attempt to create category with duplicate name
     */
    public function test_prevent_duplicate_category_creation()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Category::factory()->create(['name' => 'Electronics']);

        $response = $this->actingAs($admin)->postJson('/api/categories', [
            'name' => 'Electronics',
            'description' => 'Test description'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
        $this->assertDatabaseCount('categories', 1);
    }

    /** Test ID: Category-004
     * Description: Update existing category information
     */
    public function test_update_existing_category()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create(['id' => 1]);

        $response = $this->actingAs($admin)->putJson("/api/categories/{$category->id}", [
            'name' => 'Updated Electronics',
            'description' => 'New description'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Electronics']);
        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'name' => 'Updated Electronics',
            'description' => 'New description'
        ]);
    }

    /** Test ID: Category-005
     * Description: Delete existing category
     */
    public function test_delete_existing_category()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create(['id' => 1]);

        $response = $this->actingAs($admin)->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => 1]);
    }

    /** Test ID: Category-006
     * Description: Get single category by ID
     */
    public function test_get_single_category_by_id()
    {
        $category = Category::factory()->create(['id' => 1, 'name' => 'Electronics']);

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => 1,
                     'name' => 'Electronics'
                 ]);
    }

    /** Test ID: Category-007
     * Description: Create category with invalid data (empty name)
     */
    public function test_create_category_with_empty_name()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson('/api/categories', [
            'name' => '',
            'description' => 'Test description'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /** Test ID: Category-008
     * Description: Update non-existent category
     */
    public function test_update_non_existent_category()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->putJson('/api/categories/999', [
            'name' => 'Test',
            'description' => 'Test'
        ]);

        $response->assertStatus(404);
    }

    /** Test ID: Category-009
     * Description: Get categories with pagination
     */
    public function test_get_categories_with_pagination()
    {
        Category::factory()->count(15)->create();

        $response = $this->getJson('/api/categories?page=1&limit=10');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'meta' => ['current_page', 'per_page', 'total']
                 ])
                 ->assertJsonCount(10, 'data')
                 ->assertJsonFragment([
                     'current_page' => 1,
                     'per_page' => 10
                 ]);
    }

    /** Test ID: Category-010
     * Description: Search categories by name
     */
    public function test_search_categories_by_name()
    {
        Category::factory()->create(['name' => 'Electronics']);
        Category::factory()->create(['name' => 'Electrical']);
        Category::factory()->create(['name' => 'Furniture']);

        $response = $this->getJson('/api/categories?search=Elec');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data')
                 ->assertJsonFragment(['name' => 'Electronics'])
                 ->assertJsonFragment(['name' => 'Electrical'])
                 ->assertJsonMissing(['name' => 'Furniture']);
    }
}