<?php
//Require the Slim PHP 5 Framework
require '../vendor/slim/Slim/Slim.php';

//Require the Condensate Library
require '../lib/Condensate.class.php';

//Instantiate the Slim application
$app = new Slim(array(
    'templates.path' => '../templates/',
    'data.path' => '../data/',
));

/**
 * ROUTES
 */

//Home
$app->get('/', function () use ($app) {
    $app->render('home.tmpl.php');
});

//Info
$app->get('/info', function () use ($app) {
    $app->render('info.tmpl.php');
});

//Create a new resource
$app->get('/new(/:type)', function ($type = 'upload') use ($app) {
    switch($type)
    {
        case 'url':
            $app->render('new-line.tmpl.php'); break;
        case 'php':
            $app->render('new-text.tmpl.php'); break;
        case 'upload':
            $app->render('new-upload.tmpl.php'); break;
        default;
            $app->notFound();
    }
})->name('new');

$app->post('/new/upload', function () use ($app) {
    $dir = $app->config('data.path');
    if(isset($_FILES['file']))
    {
        $resource = Condensate::upload($_FILES['file'], $dir);
        if($resource)
        {
            $app->redirect($app->urlFor('ls',array('key'=>$resource->getKey())));
        }
    }
    else
    {
        throw new Exception('Empty file');
    }
});

//list a resource
$app->get('/ls/:key', function ($key) use ($app) {
    Resource::path($app->config('data.path'));
    $r = Resource::findResource($key);
    if(!$r) { $app->notFound(); }

    $url = 'http://' . $_SERVER['SERVER_NAME'] . $app->urlFor('ls',array('key' => $key));
    $app->view()->appendData(array('key' => $key, 'name' => $r->getName(), 'url' => $url));

    $app->render('list.tmpl.php');
})->name('ls');

//display a resource
$app->get('/see/:key', function ($key) use ($app) {
    $app->render('see.tmpl.php');
})->name('see');

//download a resource
$app->get('/get/:key', function ($key) use ($app) {
    Resource::path($app->config('data.path'));
    $r = Resource::findResource($key);
    if(!$r) { $app->notFound(); }

    $app->contentType('application/octet-stream');
    $app->response()->header('Content-Disposition','filename="'. $r->getName() . '"');
    $app->response()->header('Content-Transfer-Encoding','binary');

    $r->echo_raw();

})->name('get');

//edit a resource
$app->get('/mod/:key', function ($key) use ($app) {
    $app->render('modify.tmpl.php');
})->name('mod');

//run a resource
$app->get('/run/:key', function ($key) use ($app) {
    $app->render('run.tmpl.php');
})->name('run');


//Run the Slim application
$app->run();
/**
 * DO NOT ADD ANYTHING AFTER THIS CALL
 */
