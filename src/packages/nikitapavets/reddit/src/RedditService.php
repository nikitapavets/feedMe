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

    public function getSubRedditInfo($subredditName, $lastPostName = '')
    {
        $response = $this->client->get($this->getSubredditUrl($subredditName), [
            'query' => [
                'after' => $lastPostName,
                'limit' => config('reddit.limit'),
            ],
        ]);

        return $this->parseSubRedditResponse($this->decodeResponse($response));
    }

    public function getPostComments($permalink, $lastCommentName = '')
    {
        $response = $this->client->get($this->makeUrl($permalink), [
            'query' => [
                'after' => $lastCommentName,
                'limit' => config('reddit.limit'),
            ],
        ]);

        return $this->parsePostResponse($this->decodeResponse($response)[1]);
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
            'name'        => $subReddit['name'],
            'title'       => $subReddit['title'],
            'description' => $subReddit['selftext_html'],
            'author'      => $subReddit['author'],
            'domain'      => $subReddit['domain'],
            'url'         => $subReddit['url'],
            'ups'         => $subReddit['ups'],
            'permalink'   => $subReddit['permalink'],
            'created_at'  => date('Y-m-d H:i:s', $subReddit['created']),
        ];
    }

    private function parsePostResponse($decodedResponse)
    {
//        if(!$decodedResponse['data']['after'] && !$decodedResponse['data']['before']) {
//            throw new NotFoundHttpException();
//        }
        $comments = $decodedResponse['data']['children'];
        $response = [];
        foreach ($comments as $comment) {
            $comment = $comment['data'];
            $parsedComment = $this->parseComment($comment);
            $parsedComment['children'] = [];
            if($comment['replies']) {
                $parsedComment['children'] = $this->parsePostResponse($comment['replies']);
            }
            $response[] = $parsedComment;
        }
        return $response;
    }

    private function parseComment($comment)
    {
        return [
            'parent_id'  => $comment['parent_id'],
            'name'       => $comment['id'],
            'message'    => $comment['body'],
            'author'     => $comment['author'],
            'permalink'  => $comment['permalink'],
            'ups'        => $comment['ups'],
            'created_at' => date('Y-m-d H:i:s', $comment['created']),
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

    private function getSubredditUrl($subredditName)
    {
        return $this->makeUrl(sprintf("%s%s",
                config('reddit.url.subreddit'),
                $subredditName
            )
        );
    }
}
