<?php

namespace Terranet\Administrator\Controllers;

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Manager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Media\File;
use Terranet\Administrator\Middleware\ProtectMedia;
use Terranet\Administrator\Middleware\SanitizePaths;
use Terranet\Administrator\Services\FileStorage;

class MediaController extends AdminController
{
    /**
     * @var Manager
     */
    private $breadcrumbs;

    /**
     * @var FileStorage
     */
    private $storage;

    /**
     * MediaController constructor.
     *
     * @param FileStorage $storage
     */
    public function __construct(FileStorage $storage)
    {
        $this->breadcrumbs = app('breadcrumbs');

        $this->storage = $storage;

        parent::__construct();

        $this->middleware(SanitizePaths::class);
        $this->middleware(ProtectMedia::class);
    }

    public function index(Request $request)
    {
        $directory = $this->storage->path(
            $path = $request->get('path')
        );

        $files = $this->storage->files($directory)->merge($this->storage->directories($directory));

        $data = [
            'files' => $files,
            'path' => $path,
            'breadcrumbs' => $this->breadcrumbs($directory),
        ];

        return view(app('scaffold.template')->media('index'), $data);
    }

    public function mkdir(Request $request)
    {
        try {
            $directory = $this->storage->mkdir($name = $request->get('name'), $request->get('basedir'));

            return response()->json([
                'message' => 'Directory created.',
                'data' => (new File($directory, $this->storage))->toArray(),
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function move(Request $request)
    {
        $target = $request->get('target');
        $files = array_filter($request->get('files'), function ($file) use ($target) {
            return $file !== $target;
        });

        $this->storage->move($files, $target, $request->get('basedir'));

        return response()->json([], Response::HTTP_OK);
    }

    public function rename(Request $request)
    {
        try {
            $path = $this->storage->rename($request->get('from'), $request->get('to'));

            return response()->json([
                'message' => 'File renamed.',
                'file' => (new File($path, $this->storage))->toArray(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function upload(Request $request)
    {
        $path = $request->get('path');

        try {
            $path = $this->storage->upload($request->allFiles(), $path);

            return response()->json(['path' => $path], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([], Response::HTTP_FOUND);
        }
    }

    public function removeSelected(Request $request)
    {
        $this->storage->delete($request->get('files'), $request->get('directories'));

        return response()->json([
            'message' => 'Files removed successfully.',
        ], Response::HTTP_NO_CONTENT);
    }

    protected function breadcrumbs($directory)
    {
        $directory = str_replace($this->storage->path(), '', $directory);

        # remove storage path from $directory
        $directory = implode("/", array_slice(explode("/", $directory), 1));

        $this->breadcrumbs->register('index', function (Generator $generator) {
            $generator->push("Home", route('scaffold.media'));
        });

        $dirs = $directory ? explode("/", trim($directory, '/')) : [];
        $parent = $section = 'index';
        $path[] = 'index';

        foreach ($dirs as $index => $dir) {
            $tmpPath = $path;
            $path[] = $dir;
            $this->breadcrumbs->register($section = implode(".", $path), function (Generator $generator) use (
                &$parent,
                $dir,
                $tmpPath,
                $dirs
            ) {
                $generator->parent($parent = implode(".", $tmpPath));
                $generator->push($dir, route('scaffold.media', ['path' => implode('/', array_slice($dirs, 0, -1))]));
            });
        }

        return $this->breadcrumbs->render($section);
    }
}