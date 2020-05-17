<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'A very interesting book',
            'author' => 'Ion Cojocaru'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());

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
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'A very interesting book',
            'author' => 'Ion Cojocaru'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id , [
            'title' => 'A truly interesting book',
            'author' => 'Ion Cojocaru Vasile'
        ]);

        $response->assertOk();
        $this->assertEquals('A truly interesting book', Book::first()->title);
        $this->assertEquals('Ion Cojocaru Vasile', Book::first()->author);

    }

}
