<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Tutor;
use App\Services\ActivityLogger;
use App\Services\TutorService;
use App\Http\Requests\StoreTutorRequest;
use App\Http\Requests\UpdateTutorRequest;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function __construct(
        private TutorService $tutorService,
    ) {}

    public function index(Request $request)
    {
        $tutors = $this->tutorService->searchQuery($request->all())
            ->paginate(12)
            ->withQueryString();

        $filterData = $this->tutorService->getFilterData();

        if ($request->ajax()) {
            return view('admin.tutor.partials.list', compact('tutors'))->render();
        }

        return view('admin.tutor.index', compact('tutors', 'filterData') + $filterData);
    }

    public function create()
    {
        return view('admin.tutor.create', $this->tutorService->getCreateData());
    }

    public function store(StoreTutorRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->tutorService->handleImage($request);

        $this->tutorService->createTutor($data);

        ActivityLogger::log("Admin mendaftarkan tutor baru: {$request->name}");

        return redirect()->route('admin.tutors.index')->with('success', 'Tutor berhasil ditambahkan!');
    }

    public function edit(Tutor $tutor)
    {
        return view('admin.tutor.edit', $this->tutorService->getEditData($tutor));
    }

    public function update(UpdateTutorRequest $request, Tutor $tutor)
    {
        $data = $request->validated();
        $data['image'] = $this->tutorService->handleImage($request);

        $this->tutorService->updateTutor($tutor, $data);

        ActivityLogger::log("Admin memperbarui data tutor: {$tutor->user->name}", $tutor);

        return redirect()->route('admin.tutors.index')->with('success', 'Data tutor diperbarui!');
    }

    public function destroy(Tutor $tutor)
    {
        $name = $tutor->user->name ?? 'Unknown';
        $this->tutorService->deleteTutor($tutor);

        ActivityLogger::log("Admin menghapus tutor: {$name}", $tutor);

        return redirect()->route('admin.tutors.index')->with('success', 'Tutor dihapus!');
    }

    public function show(Tutor $tutor)
    {
        $tutor->load(['user', 'branch', 'packages.branch']);
        return view('admin.tutor.show', compact('tutor'));
    }
}
