<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->respond(function () {
            $eventCategories = EventCategory::all();
            return $this->success($eventCategories, 'Event Categories retrieved successfully.');
        });
    }

    public function store(Request $request): JsonResponse
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Create Event Category
            $eventCategory = EventCategory::create($validated);

            return $this->success($eventCategory, 'Event Category created successfully.', 201);
        });
    }

    public function show(EventCategory $eventCategory): JsonResponse
    {
        return $this->respond(function () use ($eventCategory) {

            return $this->success($eventCategory, 'Event Category found.', 201);
        }, 'Event Category not found.');
    }

    public function update(Request $request, EventCategory $eventCategory): JsonResponse
    {
        return $this->respond(function () use ($request, $eventCategory) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Update EventCategory
            $eventCategory->update($validated);

            return $this->success($eventCategory, 'Event Category updated successfully.');
        }, 'Event Category not found.');
    }

    public function destroy(EventCategory $eventCategory): JsonResponse
    {
        return $this->respond(function () use ($eventCategory) {

            $eventCategory->delete();

            return $this->success(null, 'EventCategory deleted successfully.');
        }, 'Event Category not found.');
    }
}
