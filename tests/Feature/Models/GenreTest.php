<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Genre::factory()->count(1)->create();
        $genres = Genre::all();
        $this->assertCount(1, $genres);
        $genreKeys = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'created_at',
                'updated_at',
                'deleted_at',
                'is_active'
            ],
            $genreKeys);
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genre->refresh();

        $this->assertMatchesRegularExpression('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', $genre->id);
        $this->assertEquals('test1', $genre->name);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($genre->is_active);
    }

    public function testUpdate()
    {
        /**@var Genre $genre */
        $genre = Genre::factory()->create([
            'is_active' => true,
        ]);

        $data = [
            'name' => 'test_name_updated',
            'is_active' => false
        ];
        $genre->update($data);

        foreach($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        /**@var Genre $genre */
        $genre = Genre::factory()->count(1)->create()->first();
        $genre->delete();
        $this->assertNotNull($genre->deleted_at);
    }

    public function testRestore()
    {
        /**@var Genre $genre */
        $genre = Genre::factory()->count(1)->create()->first();
        $genre->delete();
        $genre->restore();
        $this->assertNull($genre->deleted_at);
    }
}
