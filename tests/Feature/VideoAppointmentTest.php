<?php

namespace Tests\Feature;

use App\Models\DwPartnerModel;
use App\Models\DwUserModel;
use App\Models\PartnerPatientInquiry;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VideoAppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected DwPartnerModel $testPartner;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.agora.app_id' => 'c257317458474909993786619e91830b',
            'services.agora.app_certificate' => '5b21c7ffb38049c0a3784c54f2f7fd17',
        ]);

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
    }

    public function test_unauthenticated_user_cannot_access_video_token()
    {
        $response = $this->postJson('/api/appointments/1/video-token');
        $response->assertStatus(401);
    }

    public function test_unauthorized_wrong_user_gets_forbidden()
    {
        $patient = new DwUserModel();
        $patient->id = 101;
        $patient->user_name = 'Patient One';
        $patient->user_mobile = '9876543210';
        $patient->user_city = 'Kolkata';
        $patient->user_email = 'patient1@example.com';
        $patient->user_password = bcrypt('secret123');
        $patient->save();

        $intruder = new DwUserModel();
        $intruder->id = 102;
        $intruder->user_name = 'Intruder';
        $intruder->user_mobile = '9876543211';
        $intruder->user_city = 'Kolkata';
        $intruder->user_email = 'intruder@example.com';
        $intruder->user_password = bcrypt('secret123');
        $intruder->save();

        $appointment = PartnerPatientInquiry::create([
            'dw_user_id' => $patient->id,
            'currently_loggedin_partner_id' => $this->testPartner->id,
            'clinic_type' => 'OPD',
            'clinic_name' => 'Test Partner Clinic',
            'user_name' => 'Patient One',
            'user_mobile' => '9876543210',
            'user_email' => 'patient1@example.com',
            'user_inquiry' => 'Online test inquiry',
            'visit_mode' => 'online',
            'is_video' => true,
            'status' => 'Confirmed',
            'booking_date' => Carbon::today()->format('Y-m-d'),
            'booking_time' => Carbon::now()->format('H:i'),
        ]);

        Sanctum::actingAs($intruder, ['*']);

        $response = $this->postJson("/api/appointments/{$appointment->id}/video-token");
        $response->assertStatus(403);
    }

    public function test_cannot_generate_token_outside_window()
    {
        $patient = new DwUserModel();
        $patient->id = 103;
        $patient->user_name = 'Patient Future';
        $patient->user_mobile = '9876543212';
        $patient->user_city = 'Kolkata';
        $patient->user_email = 'patientfuture@example.com';
        $patient->user_password = bcrypt('secret123');
        $patient->save();

        // 3 days in the future
        $futureDate = Carbon::now()->addDays(3)->format('Y-m-d');
        $futureTime = '14:00';

        $appointment = PartnerPatientInquiry::create([
            'dw_user_id' => $patient->id,
            'currently_loggedin_partner_id' => $this->testPartner->id,
            'clinic_type' => 'OPD',
            'clinic_name' => 'Test Partner Clinic',
            'user_name' => 'Patient Future',
            'user_mobile' => '9876543212',
            'user_email' => 'patientfuture@example.com',
            'user_inquiry' => 'Future consultation',
            'visit_mode' => 'online',
            'is_video' => true,
            'status' => 'Confirmed',
            'booking_date' => $futureDate,
            'booking_time' => $futureTime,
        ]);

        Sanctum::actingAs($patient, ['*']);

        $response = $this->postJson("/api/appointments/{$appointment->id}/video-token");
        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
                'is_open' => false,
            ]);
    }

    public function test_valid_patient_can_generate_video_token_within_window()
    {
        $patient = new DwUserModel();
        $patient->id = 104;
        $patient->user_name = 'Patient Valid';
        $patient->user_mobile = '9876543213';
        $patient->user_city = 'Kolkata';
        $patient->user_email = 'patientvalid@example.com';
        $patient->user_password = bcrypt('secret123');
        $patient->save();

        $appointment = PartnerPatientInquiry::create([
            'dw_user_id' => $patient->id,
            'currently_loggedin_partner_id' => $this->testPartner->id,
            'clinic_type' => 'OPD',
            'clinic_name' => 'Test Partner Clinic',
            'user_name' => 'Patient Valid',
            'user_mobile' => '9876543213',
            'user_email' => 'patientvalid@example.com',
            'user_inquiry' => 'Current consultation',
            'visit_mode' => 'online',
            'is_video' => true,
            'status' => 'Confirmed',
            'booking_date' => Carbon::today()->format('Y-m-d'),
            'booking_time' => Carbon::now()->format('H:i'),
        ]);

        Sanctum::actingAs($patient, ['*']);

        $response = $this->postJson("/api/appointments/{$appointment->id}/video-token");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'app_id',
                    'channel',
                    'uid',
                    'token',
                    'role',
                    'expires_at',
                    'appointment_id',
                ]
            ]);

        $this->assertEquals('c257317458474909993786619e91830b', $response->json('data.app_id'));
        $this->assertNotEmpty($response->json('data.token'));
        $this->assertNotEmpty($response->json('data.channel'));
        $this->assertEquals('patient', $response->json('data.role'));
    }

    public function test_valid_partner_doctor_can_generate_video_token_within_window()
    {
        $patient = new DwUserModel();
        $patient->id = 105;
        $patient->user_name = 'Patient Doctor Test';
        $patient->user_mobile = '9876543214';
        $patient->user_city = 'Kolkata';
        $patient->user_email = 'patientdoc@example.com';
        $patient->user_password = bcrypt('secret123');
        $patient->save();

        $appointment = PartnerPatientInquiry::create([
            'dw_user_id' => $patient->id,
            'currently_loggedin_partner_id' => $this->testPartner->id,
            'clinic_type' => 'OPD',
            'clinic_name' => 'Test Partner Clinic',
            'user_name' => 'Patient Doctor Test',
            'user_mobile' => '9876543214',
            'user_email' => 'patientdoc@example.com',
            'user_inquiry' => 'Consultation with doctor',
            'visit_mode' => 'online',
            'is_video' => true,
            'status' => 'Confirmed',
            'booking_date' => Carbon::today()->format('Y-m-d'),
            'booking_time' => Carbon::now()->format('H:i'),
        ]);

        Sanctum::actingAs($this->testPartner, ['*']);

        $response = $this->postJson("/api/partner/appointments/{$appointment->id}/video-token");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'app_id',
                    'channel',
                    'uid',
                    'token',
                    'role',
                ]
            ]);

        $this->assertEquals('doctor', $response->json('data.role'));
    }
}
