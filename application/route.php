<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'user' => 'index/index/index',
    'book' => 'index/book/index',
    'book/addbook' => 'index/book/addbook',
    'book/addb' => 'index/book/addb',
    'books/deletebook/:id' => 'index/book/deletebook',
    'books/deleteb' => 'index/book/deleteb',
    'books/editbook/:id' => 'index/book/editbook',
    'books/editb' => 'index/book/editb',
    'books/view/:id' => 'index/book/view',
    'books/query' => 'index/book/query',
    'user/jump' => 'index/user/jump',
    'user/logout' => 'index/user/logout',
    'records/:id' => 'index/record/index',
    'record/addrecord/:user_id/:book_id' => 'index/record/addrecord',
    'record/addr' => 'index/record/addr',
    'record/rebook/:id/:book_id' => 'index/record/rebook',
    'record/reb' => 'index/record/reb',
    'records/view' => 'index/record/view',
    'records/viewall' => 'index/record/viewall',
    'record/details/:id' => 'index/record/details',
    'records/query' => 'index/record/query',
    'user/register' => 'index/user/register',
    'user/doregister' => 'index/user/doregister',
    
];
