<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bill;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenerateRecurringBillsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        putenv('XENDIT_SECRET_KEY=dummy_test_key');

        $waMock = $this->createMock(WhatsAppServiceInterface::class);
        $this->app->instance(WhatsAppServiceInterface::class, $waMock);
    }

    private function createDueStudent(array $overrides = []): Student
    {
        $branch = Branch::factory()->create();
        $package = Package::factory()->create([
            'branch_id' => $branch->id,
            'price' => 150000,
            'duration' => 60,
        ]);

        return Student::factory()->create(array_merge([
            'branch_id' => $branch->id,
            'package_id' => $package->id,
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'next_billing_date' => now()->format('Y-m-d'),
            'join_date' => now()->subDays(10),
            'parent_phone' => '081234567890',
        ], $overrides));
    }

    public function test_skips_student_with_existing_bill(): void
    {
        $student = $this->createDueStudent();

        Bill::factory()->create([
            'student_id' => $student->id,
            'due_date' => $student->next_billing_date,
        ]);

        $this->artisan('bills:generate')
            ->expectsOutputToContain('already has bill')
            ->assertExitCode(0);

        $this->assertEquals(1, Bill::where('student_id', $student->id)->count());
    }

    public function test_creates_bill_for_due_student(): void
    {
        $this->createDueStudent();

        $this->artisan('bills:generate')
            ->assertExitCode(0);

        $this->assertEquals(1, Transaction::count());
        $this->assertEquals(1, Bill::count());

        $tx = Transaction::first();
        $this->assertEquals('PENDING', $tx->status);

        $bill = Bill::first();
        $this->assertEquals('UNPAID', $bill->status);
    }

    public function test_skips_student_with_no_package(): void
    {
        $branch = Branch::factory()->create();
        $student = Student::factory()->create([
            'branch_id' => $branch->id,
            'package_id' => null,
            'status' => 'active',
            'next_billing_date' => now()->format('Y-m-d'),
        ]);

        $this->artisan('bills:generate')
            ->expectsOutputToContain('has no package')
            ->assertExitCode(0);

        $this->assertEquals(0, Bill::count());
    }

    public function test_skips_inactive_student(): void
    {
        $branch = Branch::factory()->create();
        $package = Package::factory()->create(['branch_id' => $branch->id]);
        Student::factory()->create([
            'branch_id' => $branch->id,
            'package_id' => $package->id,
            'status' => 'inactive',
            'next_billing_date' => now()->format('Y-m-d'),
        ]);

        $this->artisan('bills:generate')
            ->assertExitCode(0);

        $this->assertEquals(0, Bill::count());
    }

    public function test_clears_next_billing_date_when_marking_inactive(): void
    {
        $branch = Branch::factory()->create();
        $package = Package::factory()->create([
            'branch_id' => $branch->id,
            'price' => 150000,
            'duration' => 30,
        ]);

        $student = Student::factory()->create([
            'branch_id' => $branch->id,
            'package_id' => $package->id,
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'next_billing_date' => now()->format('Y-m-d'),
            'join_date' => now()->subDays(30),
        ]);

        $this->artisan('bills:generate')
            ->assertExitCode(0);

        $student->refresh();

        $this->assertEquals('inactive', $student->status);
        $this->assertNull($student->next_billing_date);
    }

    public function test_processes_only_due_students(): void
    {
        $this->createDueStudent(['next_billing_date' => now()->format('Y-m-d')]);

        $branch = Branch::factory()->create();
        $package = Package::factory()->create(['branch_id' => $branch->id]);
        Student::factory()->create([
            'branch_id' => $branch->id,
            'package_id' => $package->id,
            'status' => 'active',
            'next_billing_date' => now()->addMonth()->format('Y-m-d'),
        ]);

        $this->artisan('bills:generate')
            ->assertExitCode(0);

        $this->assertEquals(1, Bill::count());
    }
}
