<?php
    return [
        'admin' => 1,
        'staff' => 0,
        "table_module" => [
            "posts",
            "admins",
            "users",
            "roles",
        ],
        "childrent_module" => [
            "list",
            "add",
            "edit",
            "delete",
        ],
        "access" => [
            "admins-list" => "admins_list",
            "admins-add" => "admins_add",
            "admins-edit" => "admins_edit",
            "admins-delete" => "admins_delete",

            "posts-list" => "posts_list",
            "posts-add" => "posts_add",
            "posts-edit" => "posts_edit",
            "posts-delete" => "posts_delete",

            "users-list" => "users_list",
            "users-add" => "users_add",
            "users-edit" => "users_edit",
            "users-delete" => "users_delete",
        ]
    ];
