<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bill;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use App\Services\BillingService;
use App\Services\StudentService;
use App\Services\TransactionService;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BillingServiceTest extends TestCase
{
    use RefreshDatabase;

    private BillingService $billingService;
    private StudentService|\PHPUnit\Framework\MockObject\MockObject $studentService;
    private TransactionService|\PHPUnit\Framework\MockObject\MockObject $transactionService;
    private WhatsAppServiceInterface|\PHPUnit\Framework\MockObject\MockObject $whatsappService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentService = $this->createMock(StudentService::class);

        $this->transactionService = $this->createMock(TransactionService::class);
        $this->transactionService->method('createInvoice')
            ->willReturn(['success' => true, 'redirect_url' => 'https://xendit.test/inv']);

        $this->whatsappService = $this->createMock(WhatsAppServiceInterface::class);

        $this->billingService = new BillingService(
            $this->studentService,
            $this->transactionService,
            $this->whatsappService
        );
    }

    // ─── Helpers ────────────────────────────────────────────────

    private function createActiveStudent(array $overrides = []): Student
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
            'next_billing_date' => now()->addDay(),
            'join_date' => now()->subDays(10),
            'parent_phone' => '081234567890',
        ], $overrides));
    }

    // ─── processManualPayment Tests ────────────────────────────

    public function test_manual_payment_fails_when_student_has_no_package(): void
    {
        $student = Student::factory()->create([
            'package_id' => null,
            'status' => 'active',
        ]);

        $result = $this->billingService->processManualPayment($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('tidak memiliki paket', $result['message']);
    }

    public function test_manual_payment_fails_for_inactive_student(): void
    {
        $student = $this->createActiveStudent(['status' => 'inactive']);

        $result = $this->billingService->processManualPayment($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('tidak aktif', $result['message']);
        $this->assertEquals(0, Transaction::where('student_id', $student->id)->count());
    }

    public function test_manual_payment_prevents_duplicate_paid_bill(): void
    {
        $student = $this->createActiveStudent([
            'next_billing_date' => now()->format('Y-m-d'),
        ]);

        Bill::factory()->paid()->create([
            'student_id' => $student->id,
            'due_date' => $student->next_billing_date,
        ]);

        $result = $this->billingService->processManualPayment($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('LUNAS', $result['message']);

        $this->assertEquals(1, Transaction::count());
    }

    public function test_manual_payment_prevents_duplicate_unpaid_bill(): void
    {
        $student = $this->createActiveStudent([
            'next_billing_date' => now()->format('Y-m-d'),
        ]);

        Bill::factory()->unpaid()->create([
            'student_id' => $student->id,
            'due_date' => $student->next_billing_date,
        ]);

        $result = $this->billingService->processManualPayment($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('UNPAID', $result['message']);

        $this->assertEquals(0, Transaction::count());
    }

    public function test_manual_payment_success_creates_transaction_and_bill(): void
    {
        $student = $this->createActiveStudent([
            'next_billing_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $this->studentService->expects($this->once())
            ->method('processPaymentSuccess')
            ->with(
                $this->isInstanceOf(Student::class),
                $this->callback(fn($tx) => $tx !== null && $tx instanceof Transaction),
                false
            );

        $result = $this->billingService->processManualPayment($student);

        $this->assertTrue($result['success']);

        $tx = Transaction::where('student_id', $student->id)->first();
        $this->assertNotNull($tx);
        $this->assertEquals('PAID', $tx->status);
        $this->assertEquals('CASH', $tx->payment_method);
        $this->assertEquals('ADMIN_MANUAL', $tx->payment_channel);

        $bill = Bill::where('student_id', $student->id)->first();
        $this->assertNotNull($bill);
        $this->assertEquals('PAID', $bill->status);
        $this->assertEquals($tx->id, $bill->transaction_id);
        $this->assertEquals($student->next_billing_date->format('Y-m-d'), $bill->due_date->format('Y-m-d'));
    }

    public function test_manual_payment_passes_real_transaction_to_process_payment_success(): void
    {
        $student = $this->createActiveStudent([
            'next_billing_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $actualTx = null;
        $this->studentService->expects($this->once())
            ->method('processPaymentSuccess')
            ->with(
                $this->isInstanceOf(Student::class),
                $this->callback(function ($tx) use (&$actualTx) {
                    $actualTx = $tx;
                    return $tx !== null && $tx instanceof Transaction;
                }),
                false
            );

        $this->billingService->processManualPayment($student);

        $this->assertNotNull($actualTx, 'processPaymentSuccess harus menerima Transaction object, bukan null');
        $this->assertEquals('PAID', $actualTx->status);
        $this->assertEquals($student->id, $actualTx->student_id);
    }

    // ─── createNextBill Tests ──────────────────────────────────

    public function test_create_next_bill_fails_for_inactive_student(): void
    {
        $student = $this->createActiveStudent(['status' => 'inactive']);

        $result = $this->billingService->createNextBill($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('tidak aktif', $result['message']);
    }

    public function test_create_next_bill_fails_for_pending_student(): void
    {
        $student = $this->createActiveStudent(['status' => 'pending']);

        $result = $this->billingService->createNextBill($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('PENDING', $result['message']);
    }

    public function test_create_next_bill_prevents_duplicate(): void
    {
        $student = $this->createActiveStudent();

        Bill::factory()->create([
            'student_id' => $student->id,
            'due_date' => $student->next_billing_date,
        ]);

        $result = $this->billingService->createNextBill($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('SUDAH ADA', $result['message']);

        $this->assertEquals(1, Bill::where('student_id', $student->id)->count());
    }

    public function test_create_next_bill_success_creates_bill_and_transaction(): void
    {
        $student = $this->createActiveStudent([
            'next_billing_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $expectedDueDate = $student->next_billing_date->format('Y-m-d');

        $result = $this->billingService->createNextBill($student);

        $this->assertTrue($result['success']);

        $bill = Bill::where('student_id', $student->id)->first();
        $this->assertNotNull($bill);
        $this->assertEquals('PENDING', $bill->status);
        $this->assertEquals($expectedDueDate, $bill->due_date->format('Y-m-d'));

        $tx = Transaction::where('student_id', $student->id)->first();
        $this->assertNotNull($tx);
        $this->assertEquals('PENDING', $tx->status);
        $this->assertEquals($bill->transaction_id, $tx->id);
    }

    public function test_create_next_bill_xendit_failure_does_not_advance_next_billing_date(): void
    {
        $student = $this->createActiveStudent([
            'next_billing_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $originalNextDate = $student->next_billing_date->format('Y-m-d');

        $this->transactionService = $this->createMock(TransactionService::class);
        $this->transactionService->method('createInvoice')
            ->willReturn(['success' => false, 'message' => 'Xendit API error']);

        $this->billingService = new BillingService(
            $this->studentService,
            $this->transactionService,
            $this->whatsappService
        );

        $result = $this->billingService->createNextBill($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('GAGAL', $result['message']);

        $student->refresh();
        $this->assertEquals($originalNextDate, $student->next_billing_date->format('Y-m-d'),
            'next_billing_date harus tetap sama saat Xendit gagal');
    }

    public function test_create_next_bill_respects_max_bills(): void
    {
        $student = $this->createActiveStudent([
            'billing_cycle' => 'monthly',
        ]);

        $package = $student->package;
        $package->update(['duration' => 30]);
        $package->refresh();

        $dueDate = $student->next_billing_date;

        Bill::factory()->create([
            'student_id' => $student->id,
            'due_date' => $dueDate,
        ]);

        $result = $this->billingService->createNextBill($student);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Batas max tagihan', $result['message']);
    }
}
