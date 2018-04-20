<?php

namespace NikitaPavets\Reddit;

use FeedMe\Exceptions\NotFoundHttpException;
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
                'limit' => config('reddit.limit'),
            ],
        ]);

        return $this->parseSubRedditResponse($this->decodeResponse($response));
    }

    private function parseSubRedditResponse($decodedResponse)
    {
        if(!$decodedResponse['data']['after'] && !$decodedResponse['data']['before']) {
            throw new NotFoundHttpException();
        }

        $response = [
            'name'        => '',
            'title'       => '',
            'after'       => $decodedResponse['data']['after'],
            'posts_count' => $decodedResponse['data']['dist'],
            'posts'       => [],
        ];

        if ($response['posts_count'] > 0) {
            $post = $decodedResponse['data']['children'][0]['data'];
            $response['name'] = $post['subreddit_id'];
            $response['title'] = $post['subreddit'];
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
            'author'     => $subReddit['author'],
            'domain'     => $subReddit['domain'],
            'url'        => $subReddit['url'],
            'ups'        => $subReddit['ups'],
            'created_at' => date('Y-m-d H:i:s', $subReddit['created']),
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
