<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\LandingPageService;
use App\Services\PaymentService;
use App\Services\StudentRegistrationService;
use App\Services\StudentService;
use App\Http\Requests\StoreLandingRegistrationRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(LandingPageService $service)
    {
        return view('landing.index', [
            'stats'           => $service->getStats(),
            'packages'        => $service->getPackages(),
            'tutors'          => $service->getTutors(),
            'activities'      => $service->getActivities(),
            'carousel_slides' => $service->getCarouselSlides(),
            'settings'        => $service->getSettings(),
        ]);
    }

    public function packages(LandingPageService $s)
    {
        return view('landing.packages.index', $s->getPackagesPageData());
    }

    public function showPackage(Package $package, LandingPageService $s)
    {
        return view('landing.packages.show', ['package' => $s->loadPackageRelations($package)]);
    }

    public function registrationForm(Package $package)
    {
        return view('landing.registration.form', compact('package'));
    }

    public function storeRegistration(StoreLandingRegistrationRequest $request, StudentRegistrationService $registrationService)
    {
        $package = Package::findOrFail($request->package_id);

        $result = $registrationService->registerFromLanding($request->validated(), $package);

        if (!$result['success']) {
            return back()->with('error', 'Gagal membuat tagihan pembayaran: ' . ($result['message'] ?? 'Unknown error'));
        }

        ActivityLogger::log(
            "Siswa baru mendaftar (Pending Payment): {$result['student']->name} - Paket {$package->name}",
            $result['student']
        );

        return redirect($result['redirect_url']);
    }

    public function tutors(LandingPageService $s)
    {
        return view('landing.tutors.index', ['tutors' => $s->getTutorsPaginated(), 'settings' => $s->getSettings()]);
    }

    public function gallery(Request $request, LandingPageService $s)
    {
        return view('landing.gallery.index', [
            'galleries' => $s->getGallery($request->query('type')),
            'settings'  => $s->getSettings(),
        ]);
    }

    public function schedules(LandingPageService $s)
    {
        return view('landing.schedules.index', ['schedules' => $s->getSchedules(), 'settings' => $s->getSettings()]);
    }

    public function contact(LandingPageService $s)
    {
        return view('landing.contact.index', $s->getContactData());
    }

    public function showPayment($invoice_code, PaymentService $paymentService)
    {
        $result = $paymentService->checkAndProcessXenditPayment($invoice_code);
        if ($result['processed']) {
            session()->flash('success', $result['message']);
        }

        if (request('status') === 'success') {
            session()->flash('success', 'Pembayaran Berhasil! Terima kasih.');
        }

        return view('landing.payment.show', ['transaction' => $result['transaction']]);
    }

    public function processPayment(Request $request, PaymentService $paymentService)
    {
        $paymentService->simulatePayment($request->invoice_code);

        return redirect()->route('home')->with('success', 'Pembayaran Berhasil! Siswa telah aktif.');
    }

    public function studentPortal($token, StudentService $studentService)
    {
        $student = $studentService->getPortalData($token);

        return view('student.portal.index', compact('student'));
    }
}
