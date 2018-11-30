<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\FileDownload;
use App\File;

class FilesController extends Controller
{
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
}