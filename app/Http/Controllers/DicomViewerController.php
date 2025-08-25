<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DicomViewerController extends Controller
{
    public function viewer(string $instanceID)
    {
        return view('dicom.viewer', compact('instanceID'));
    }

    public function rendered(string $instanceID)
    {
        $orthanc = 'http://localhost:8042'; // adjust if Orthanc runs elsewhere
        $res = Http::timeout(30)->get("$orthanc/instances/$instanceID/rendered");

        if (! $res->ok()) {
            abort($res->status(), 'Failed to fetch rendered image from Orthanc');
        }

        return response($res->body(), 200)
            ->header('Content-Type', 'image/png');
    }
}
