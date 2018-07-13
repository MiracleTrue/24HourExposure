<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExposureCommentRequest;
use App\Models\ExposureComment;

class ExposureCommentsController extends Controller
{
    public function store(ExposureCommentRequest $request, ExposureComment $exposureComment)
    {

        $exposureComment->user()->associate($request->user());
        $exposureComment->exposure()->associate($request->input('exposure_id'));
        $exposureComment->content = $request->input('content');
        $exposureComment->save();

        return [];
    }
}
