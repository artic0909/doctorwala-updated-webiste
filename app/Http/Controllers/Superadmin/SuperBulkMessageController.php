<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendWhatsAppBulkMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SuperBulkMessageController extends Controller
{
    public function index()
    {
        return view('superadmin.bulkmessage.form');
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        try {
            // 1. Upload and store the image
            $imagePath = $request->file('image')->store('uploads/whatsapp', 'public');
            $imageUrl = asset('storage/' . $imagePath);

            // 2. Parse the CSV file
            $csvFile = $request->file('csv_file')->getRealPath();
            $file = fopen($csvFile, 'r');
            
            $phoneNumbers = [];
            
            // Extract header
            $header = fgetcsv($file);
            $phoneIndex = 0;
            
            if ($header !== false) {
                // Find index of 'Phone' column, case-insensitive. Default to 0 if not found.
                foreach ($header as $index => $colName) {
                    if (strtolower(trim($colName)) === 'phone') {
                        $phoneIndex = $index;
                        break;
                    }
                }
            }

            while (($row = fgetcsv($file)) !== false) {
                if (isset($row[$phoneIndex]) && !empty($row[$phoneIndex])) {
                    // Clean the phone number (remove spaces, dashes, etc.)
                    $number = preg_replace('/[^0-9\+]/', '', $row[$phoneIndex]);
                    
                    // Basic validation to ensure it looks like a phone number
                    if (strlen($number) >= 10) {
                        // Ensure it has country code prefix, assume Indian +91 if length is 10
                        if (strlen($number) == 10) {
                            $number = '+91' . $number;
                        }
                        $phoneNumbers[] = $number;
                    }
                }
            }
            fclose($file);

            // 3. Dispatch Jobs with Delay for Rate Limiting
            $delayCounter = 0;
            $delayIntervalSeconds = 2; // adjust based on Twilio limits (e.g. 1-2 msgs per second)

            foreach (array_unique($phoneNumbers) as $number) {
                SendWhatsAppBulkMessage::dispatch($number, $imageUrl)
                    ->delay(now()->addSeconds($delayCounter * $delayIntervalSeconds));
                $delayCounter++;
            }

            return redirect()->back()->with('success', 'Broadcast scheduled for ' . count($phoneNumbers) . ' contacts successfully.');

        } catch (\Exception $e) {
            Log::error('Bulk WhatsApp Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing the broadcast.');
        }
    }
}
