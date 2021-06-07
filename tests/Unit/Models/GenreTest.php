<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class GenreTest extends TestCase
{

    public function testFillableAttribute()
    {
        $genre = new Genre();
        $fillable =  ['name', 'is_active'];
        $this->assertEqualsCanonicalizing($fillable, $genre->getFillable());
    }

    public function testCastsAttribute()
    {
        $casts = ['id' => 'string', 'deleted_at' => 'datetime', 'is_active' => 'boolean'];
        $genre = new Genre();
        $this->assertEqualsCanonicalizing($casts, $genre->getCasts());
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $genre = new Genre();
        $this->assertEqualsCanonicalizing($dates, $genre->getDates());
        $this->assertCount(count($dates), $genre->getDates());
    }

    public function testIncrementingAttribute()
    {
        $genre = new Genre();
        $this->assertFalse($genre->getIncrementing());
    }


    public function testIfUseTraits()
    {
        $traits = [
            HasFactory::class, SoftDeletes::class, Uuid::class,
        ];
        $categoryTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $categoryTraits);
    }
}
