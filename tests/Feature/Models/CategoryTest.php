<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Category::factory()->count(1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
                'deleted_at',
                'is_active'
            ],
            $categoryKey);
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test1'
        ]);
        $category->refresh();

        $this->assertMatchesRegularExpression('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', $category->id);
        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'description' => null,
        ]);

        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description',
        ]);

        $this->assertEquals('test_description', $category->description);


        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($category->is_active);
    }

    public function testUpdate()
    {
        /**@var Category $category */
        $category = Category::factory()->create([
            'description' => 'test_description',
            'is_active' => true,
        ]);

        $data = [
            'description' => 'test_description_updated',
            'name' => 'test_name_updated',
            'is_active' => false
        ];
        $category->update($data);

        foreach($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDelete()
    {
        /**@var Category $category */
        $category = Category::factory()->count(1)->create()->first();
        $category->delete();
        $this->assertNotNull($category->deleted_at);
    }

    public function testRestore()
    {
        /**@var Category $category */
        $category = Category::factory()->count(1)->create()->first();
        $category->delete();
        $this->assertNotNull($category->deleted_at);
        $category->restore();
        $this->assertNull($category->deleted_at);
    }
}
