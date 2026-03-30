<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DwUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiGenerateMedicalCard extends Controller
{
    /**
     * Generate medical card for authenticated user
     */
    public function generateMedicalCard(Request $request)
    {
        try {
            $user = $request->user();

            // Already has card — return existing card info
            if ($user->medical_card_no && $user->memberid) {
                return response()->json([
                    'status'  => true,
                    'message' => 'Medical card already exists.',
                    'data'    => [
                        'member_id'       => $user->memberid,
                        'medical_card_no' => $user->medical_card_no,
                    ]
                ], 200);
            }

            $currentYear      = now()->format('Y');
            $currentYearShort = now()->format('y');

            // Serial: count users of this year who already have a card
            $serial = DwUserModel::whereYear('created_at', $currentYear)
                ->whereNotNull('medical_card_no')
                ->count() + 1;

            // ── 1. memberid  →  DW-2026-001 ───────────────────────────────────
            $memberId = 'DW-' . $currentYear . '-' . str_pad($serial, 3, '0', STR_PAD_LEFT);

            // ── 2. medical_card_no  →  DW26 4866 01 ───────────────────────────
            $last4Mobile   = substr(preg_replace('/\D/', '', $user->user_mobile), -4);
            $medicalCardNo = 'DW' . $currentYearShort . ' ' . $last4Mobile . ' ' . str_pad($serial, 2, '0', STR_PAD_LEFT);

            // ── Save ───────────────────────────────────────────────────────────
            DB::table('dw_user_models')
                ->where('id', $user->id)
                ->update([
                    'memberid'        => $memberId,
                    'medical_card_no' => $medicalCardNo,
                ]);

            return response()->json([
                'status'  => true,
                'message' => 'Medical card created successfully!',
                'data'    => [
                    'member_id'       => $memberId,
                    'medical_card_no' => $medicalCardNo,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }
}
