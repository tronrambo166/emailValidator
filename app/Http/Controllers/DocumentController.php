<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DocumentController extends BaseController
{
    //

    public function documents()
    {
        if ($this->modules && !in_array("documents", $this->modules)) {
            abort(401);
        }

        $documents = Document::where(
            "workspace_id",
            $this->user->workspace_id
        )->get();

        return \view("documents", [
            "selected_navigation" => "documents",
            "documents" => $documents,
        ]);
    }

    public function documentPost(Request $request)
    {
        if ($this->modules && !in_array("documents", $this->modules)) {
            abort(401);
        }

        if (config("app.environment") === "demo") {
            return;
        }

        $request->validate([
            "file" => "required|mimes:jpeg,bmp,png,gif,svg,pdf",
        ]);
        $path = false;
        if ($request->file) {
            $path = $request->file("file")->store("media", "uploads");
        }

        $document = new Document();
        $document->uuid = Str::uuid();
        $document->workspace_id = $this->user->workspace_id;
        $document->name = $path;
        $document->path = $path;
        $document->name = $request->file("file")->getClientOriginalName();
        $document->save();
    }
}
