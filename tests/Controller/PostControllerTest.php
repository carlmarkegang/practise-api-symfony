<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;

class PostControllerTest extends WebTestCase
{

    public function testPageResponding()
    {
        $client = static::createClient();
        $client->request('GET', 'http://192.168.50.4:8081/');
        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://192.168.50.4:8081/posts');

        $this->assertGreaterThan(
            '0',
            $crawler->filter('div.mainposts')
        );
    }


    public function testGetOnePost()
    {
        $client = static::createClient();
        $Post = $client->getContainer()->get('doctrine')->getRepository(Post::class)->find(1);
        $this->assertGreaterThan(
            0,
            $Post->getId()
        );
    }

    /**
     * This test changes the database contents by creating a new comment. However,
     * thanks to the DAMADoctrineTestBundle and its PHPUnit listener, all changes
     * to the database are rolled back when this test completes. This means that
     * all the application tests begin with the same database contents.

    public function testNewComment()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john_user',
            'PHP_AUTH_PW' => 'kitten',
        ]);
        $client->followRedirects();

        // Find first blog post
        $crawler = $client->request('GET', '/en/blog/');
        $postLink = $crawler->filter('article.post > h2 a')->link();

        $crawler = $client->click($postLink);

        $form = $crawler->selectButton('Publish comment')->form([
            'comment[content]' => 'Hi, Symfony!',
        ]);
        $crawler = $client->submit($form);

        $newComment = $crawler->filter('.post-comment')->first()->filter('div > p')->text();

        $this->assertSame('Hi, Symfony!', $newComment);
    }
     * */
}