<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Models\Province;

class CommitteeController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->respond(function () {
            $committees = Committee::with('user')->get();
            return $this->success($committees, 'Committees retrieved successfully.');
        });
    }

    public function store(StoreCommitteeRequest $request): JsonResponse
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validated();

            // Create User
            $user = $this->createUserFromRequest($validated);

            if ($request->has('avatar')) {
                $user->addMedia($request->file('avatar'))
                    ->toMediaCollection('avatar');
            }

            // Add the 'user_id' to validated data for committee creation
            $validated['user_id'] = $user->id;

            // Create Committee
            $committee = Committee::create($validated);

            return $this->success($committee, 'Committee created successfully.', 201);
        });
    }

    public function show($id)
    {
        $committee = Committee::with('user')->findOrFail($id);
        $provinces = Province::where('region_code', 8)->get();
        return view('admin.edit_committee', compact('committee', 'provinces'));
    }

    public function update(UpdateCommitteeRequest $request, Committee $committee): JsonResponse
    {
        return $this->respond(function () use ($request, $committee) {
            $validated = $request->validated();

            // Update related User
            $committee->user->update([
                'first_name'     => $validated['first_name'],
                'middle_name'    => $validated['middle_name'] ?? null,
                'last_name'      => $validated['last_name'],
                'extension_name' => $validated['extension_name'] ?? null,
                'email'          => $validated['email'],
                'contact_number' => $validated['contact_number'],
                'user_type'      => $validated['user_type'],
            ]);

            if ($request->has('avatar')) {
                $committee->user->addMedia($request->file('avatar'))
                    ->toMediaCollection('avatar');
            }

            // Format birth_date if needed
            if (isset($validated['birth_date'])) {
                $validated['birth_date'] = \Carbon\Carbon::parse($validated['birth_date'])->format('Y-m-d');
            }

            // Update Committee
            $committee->update([
                'member_id'        => $validated['member_id'],
                'pta_id'           => $validated['pta_id'] ?? null,
                'ncc_id'           => $validated['ncc_id'] ?? null,
                'birth_date'       => $validated['birth_date'],
                'gender'           => $validated['gender'],
                'civil_status'     => $validated['civil_status'],
                'belt_level'       => $validated['belt_level'],
                'religion'         => $validated['religion'],
                'province_code'    => $validated['province_code'],
                'municipality_code' => $validated['municipality_code'],
                'brgy_code'        => $validated['brgy_code'],
            ]);

            return $this->success($committee, 'Committee updated successfully.');
        }, 'Committee not found.');
    }

    public function destroy($id): JsonResponse
    {
        return $this->respond(function () use ($id) {
            $committee = Committee::findOrFail($id);

            // Soft delete the committee first
            $committee->delete();

            // Then soft delete the user
            $committee->user()->delete();

            return $this->success(null, 'Committee deleted successfully.');
        }, 'Committee not found.');
    }
}
