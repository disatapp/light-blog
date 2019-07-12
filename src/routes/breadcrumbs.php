<?php

// Home
Breadcrumbs::for('lightBlog::dashboard', function ($trail) {
    $trail->push('Home', route('dashboard'));
});

Breadcrumbs::for('lightBlog::admin.postManage', function ($trail) {
    $trail->parent('lightBlog::dashboard');
    $trail->push('Posts', route('admin.postManage'));
});

Breadcrumbs::for('lightBlog::admin.showEdit', function ($trail, $tag) {
    $trail->parent('lightBlog::admin.postManage');
    $trail->push('Edit', route('admin.showEdit', $tag));
});

Breadcrumbs::for('lightBlog::admin.tagManage', function ($trail) {
    $trail->parent('lightBlog::dashboard');
    $trail->push('Tags', route('admin.tagManage'));
});

Breadcrumbs::for('lightBlog::admin.tagEdit', function ($trail, $tag) {
    $trail->parent('lightBlog::admin.tagManage');
    $trail->push('Edit', route('admin.tagEdit', $tag));
});


Breadcrumbs::for('lightBlog::admin.photoManage', function ($trail) {
    $trail->parent('lightBlog::dashboard');
    $trail->push('Photo', route('admin.imgManage'));
});

