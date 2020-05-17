<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {

        $response = $this->post('/books', [
            'title' => 'A very interesting book',
            'author' => 'Ion Cojocaru'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */

    public function a_title_is_required()
    {

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Ion Cojocaru'
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */

    public function an_author_is_required()
    {

        $response = $this->post('/books', [
            'title' => 'A very interesting book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }


    /**
     * @test
     */
    public function a_book_can_be_updated()
    {

        $this->post('/books', [
            'title' => 'A very interesting book',
            'author' => 'Ion Cojocaru'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path() , [
            'title' => 'A truly interesting book',
            'author' => 'Ion Cojocaru Vasile'
        ]);


        $this->assertEquals('A truly interesting book', Book::first()->title);
        $this->assertEquals('Ion Cojocaru Vasile', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /**  @test */

    public function a_book_can_be_deleted()
    {

        $this->post('/books', [
            'title' => 'A very interesting book',
            'author' => 'Ion Cojocaru'
        ]);

        $this->assertCount(1, Book::all());

        $book = Book::first();

        $response = $this->delete($book->path());


        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');

    }

}
