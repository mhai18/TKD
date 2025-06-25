<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use App\Models\Committee;
use App\Models\Province;
use Illuminate\Http\JsonResponse;

class ChapterController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->respond(function () {
            $chapters = Chapter::with('user')->get();
            return $this->success($chapters, 'Chapters retrieved successfully.');
        });
    }

    public function store(ChapterRequest $request): JsonResponse
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validated();

            // Create Chapter
            $chapter = Chapter::create($validated);

            return $this->success($chapter, 'Chapter created successfully.', 201);
        });
    }

    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);
        $committees = Committee::with('user')->get();
        $provinces = Province::where('region_code', 8)->get();
        return view('admin.edit_chapter', compact('chapter', 'committees', 'provinces'));
    }

    public function update(ChapterRequest $request, Chapter $chapter): JsonResponse
    {
        return $this->respond(function () use ($request, $chapter) {
            $validated = $request->validated();

            // Update Chapter
            $chapter->update([
                'coach_id'          => $validated['coach_id'],
                'chapter_name'      => $validated['chapter_name'],
                'date_started'      => $validated['date_started'],
                'province_code'     => $validated['province_code'],
                'municipality_code' => $validated['municipality_code'],
                'brgy_code'         => $validated['brgy_code'],
            ]);

            return $this->success($chapter, 'Chapter updated successfully.');
        }, 'Chapter not found.');
    }

    public function destroy($id): JsonResponse
    {
        return $this->respond(function () use ($id) {
            $chapter = Chapter::findOrFail($id);

            $chapter->delete();

            return $this->success(null, 'Chapter deleted successfully.');
        }, 'Chapter not found.');
    }
}
