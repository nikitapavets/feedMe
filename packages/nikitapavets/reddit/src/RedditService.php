<?php

namespace NikitaPavets\Reddit;

use GuzzleHttp\Client;

class RedditService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * RedditService constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getSubRedditInfo($name, $lastPostName = '')
    {
        $response = $this->client->get($this->makeUrl(config('reddit.url.subreddit').$name), [
            'query' => [
                'after' => $lastPostName,
            ],
        ]);

        return $this->parseSubRedditResponse($this->decodeResponse($response));
    }

    private function parseSubRedditResponse($decodedResponse)
    {
        $response = [
            'id'          => '',
            'name'        => '',
            'after'       => $decodedResponse['data']['after'],
            'posts_count' => $decodedResponse['data']['dist'],
            'posts'       => [],
        ];

        if ($response['posts_count'] > 0) {
            $post = $decodedResponse['data']['children'][0]['data'];
            $response['id'] = $post['subreddit_id'];
            $response['name'] = $post['subreddit'];
        }

        for ($postNumber = 0; $postNumber < $response['posts_count']; $postNumber++) {
            $post = $decodedResponse['data']['children'][$postNumber]['data'];
            $response['posts'][] = $this->parsePost($post);
        }

        return $response;
    }

    private function parsePost($subReddit)
    {
        return [
            'name'       => $subReddit['name'],
            'title'      => $subReddit['title'],
            'author'      => $subReddit['author'],
            'domain'      => $subReddit['domain'],
            'created_at' => $subReddit['created'],
        ];
    }

    private function decodeResponse($response)
    {
        return json_decode($response->getBody(), true);
    }

    private function makeUrl($url)
    {
        return config('reddit.url.base').$url.'.json';
    }
}
