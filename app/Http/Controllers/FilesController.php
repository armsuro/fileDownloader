<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\FileDownload;
use App\File;

class FilesController extends Controller
{

    /**
     * This function returns view which contains list of files
     * @param int $id
     * @param Request $request
     * @return view
    */
    public function view($id = null, Request $request) {
        $data = null;
        $query = File::with('status');

        if (!is_null($id)) {
            $query->where('id', $id);

            $data = $query->first();
        } else {
            $data = $query->get();
        }

        return view('files', [
            'files' => $data
        ]);
    }

    /**
    *  This function pushes provided url in queue and redirects to home page
    *
    *  @param Request $request
    *  @return redirects to home page
    */
    public function create(Request $request) {

        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->input('url');
        $name = substr($url, strrpos($url, '/') + 1);


        $file = File::create([
            'name' => $name,
            'url' => $url,
            'hash' => bin2hex(random_bytes(6))
        ]);

        $this->dispatch(new FileDownload($file));

        return redirect('/');
    }

    /**
    *  This function opens write stream to client and sends requested file content by id
    *
    *  @param int $id
    *  @return file
    */

    public function download($id) {
        $file = File::where('id', $id)->first();

        if (!$file) {
            return view('errors.404');
        }

        $fileName = $file->hash;

        $stream = \Storage::disk('files')->getDriver()->readStream($fileName);

        return response()->stream(
            function() use ($stream) {
                fpassthru($stream);
            },
            200,
            [
                'Content-Type' => $file->mime_type,
                'Content-Disposition' => 'attachment;filename="'.$file->name.'"'
            ]
        );
    }
}
