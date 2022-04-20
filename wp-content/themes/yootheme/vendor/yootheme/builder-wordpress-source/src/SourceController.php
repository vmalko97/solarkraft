<?php

namespace YOOtheme\Builder\Wordpress\Source;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class SourceController
{
    /**
     * @param Request  $request
     * @param Response $response
     *
     * @throws \Exception
     *
     * @return Response
     */
    public static function posts(Request $request, Response $response)
    {
        $names = [];

        foreach (get_posts(['include' => (array) $request('ids')]) as $post) {
            $names[] = ['id' => $post->ID, 'title' => $post->post_title];
        }

        return $response->withJson($names);
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @throws \Exception
     *
     * @return Response
     */
    public static function users(Request $request, Response $response)
    {
        $names = [];

        foreach (
            get_users([
                'include' => ($ids = $request('ids')) ? (array) $ids : [],
                'search' => ($search = $request('search')) ? "*{$search}*" : '',
                'number' => 20,
                'fields' => ['ID', 'display_name'],
                'orderby' => 'display_name',
            ])
            as $user
        ) {
            $names[] = ['id' => (int) $user->ID, 'title' => $user->display_name];
        }

        return $response->withJson($names);
    }
}
