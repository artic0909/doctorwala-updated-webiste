<?php

namespace Tests\Feature;

use App\Models\DwPartnerModel;
use App\Models\DwUserModel;
use App\Models\PartnerPatientInquiry;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AppointmentsApiTest extends TestCase
{
    use RefreshDatabase;

    protected DwPartnerModel $testPartner;
    protected DwUserModel $testUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testPartner = new DwPartnerModel();
        $this->testPartner->id = 1;
        $this->testPartner->partner_id = 'DWPTR1';
        $this->testPartner->partner_clinic_name = 'Test Partner Clinic';
        $this->testPartner->partner_contact_person_name = 'Dr. Test';
        $this->testPartner->partner_mobile_number = '9876543200';
        $this->testPartner->partner_email = 'partner1@example.com';
        $this->testPartner->partner_state = 'WB';
        $this->testPartner->partner_city = 'Kolkata';
        $this->testPartner->partner_pincode = '700001';
        $this->testPartner->partner_landmark = 'Park Street';
        $this->testPartner->partner_address = '123 Park Street';
        $this->testPartner->partner_password = bcrypt('secret123');
        $this->testPartner->registration_type = json_encode(['OPD']);
        $this->testPartner->save();

        $this->testUser = new DwUserModel();
        $this->testUser->id = 101;
        $this->testUser->user_name = 'Patient One';
        $this->testUser->user_mobile = '9876543210';
        $this->testUser->user_city = 'Kolkata';
        $this->testUser->user_email = 'patient1@example.com';
        $this->testUser->user_password = bcrypt('secret123');
        $this->testUser->save();
    }

    public function test_confirmed_appointment_remains_in_upcoming_appointments_for_user()
    {
        $appointment = new PartnerPatientInquiry();
        $appointment->currently_loggedin_partner_id = $this->testPartner->id;
        $appointment->dw_user_id = $this->testUser->id;
        $appointment->clinic_type = 'OPD';
        $appointment->clinic_name = 'Test Partner Clinic';
        $appointment->user_name = 'Patient One';
        $appointment->user_mobile = '9876543210';
        $appointment->user_email = 'patient1@example.com';
        $appointment->user_inquiry = 'Doctor consultation inquiry';
        $appointment->booking_date = Carbon::tomorrow()->toDateString();
        $appointment->booking_time = '10:00:00';
        $appointment->visit_mode = 'offline';
        $appointment->status = 'Confirmed';
        $appointment->save();

        Sanctum::actingAs($this->testUser);

        $response = $this->getJson('/api/appointments/status/Upcoming');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'total' => 1,
        ]);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Confirmed', $data[0]['status']);
    }

    public function test_partner_confirming_status_keeps_it_in_upcoming()
    {
        $appointment = new PartnerPatientInquiry();
        $appointment->currently_loggedin_partner_id = $this->testPartner->id;
        $appointment->dw_user_id = $this->testUser->id;
        $appointment->clinic_type = 'OPD';
        $appointment->clinic_name = 'Test Partner Clinic';
        $appointment->user_name = 'Patient One';
        $appointment->user_mobile = '9876543210';
        $appointment->user_email = 'patient1@example.com';
        $appointment->user_inquiry = 'Doctor consultation inquiry';
        $appointment->booking_date = Carbon::tomorrow()->toDateString();
        $appointment->booking_time = '10:00:00';
        $appointment->visit_mode = 'offline';
        $appointment->status = 'Upcoming';
        $appointment->save();

        // 1. Partner confirms appointment
        Sanctum::actingAs($this->testPartner);
        $updateResponse = $this->postJson("/api/partner/appointments/{$appointment->id}/status", [
            'status' => 'Confirmed'
        ]);
        $updateResponse->assertStatus(200);
        $this->assertEquals('Confirmed', $appointment->fresh()->status);

        // 2. User fetches Upcoming appointments
        Sanctum::actingAs($this->testUser);
        $userResponse = $this->getJson('/api/appointments/status/Upcoming');

        $userResponse->assertStatus(200);
        $this->assertEquals(1, $userResponse->json('total'));
        $this->assertEquals('Confirmed', $userResponse->json('data.0.status'));
    }
}
