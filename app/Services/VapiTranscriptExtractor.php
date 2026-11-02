<?php

namespace App\Services;

class VapiTranscriptExtractor
{
    /**
     * Extract structured discovery data from conversation transcript and messages
     */
    public static function extract(string $transcript, array $messages = []): array
    {
        $data = [];

        if (empty($transcript) && !empty($messages)) {
            $transcript = self::buildTranscriptFromMessages($messages);
        }

        if (empty($transcript)) {
            return $data;
        }

        // 1. Language Detection
        $bengaliCount = preg_match_all('/[\x{0980}-\x{09FF}]/u', $transcript);
        $hindiCount = preg_match_all('/[\x{0900}-\x{097F}]/u', $transcript);

        if ($bengaliCount > $hindiCount && $bengaliCount > 10) {
            $data['language'] = 'Bengali';
        } elseif ($hindiCount > 10) {
            $data['language'] = 'Hindi';
        } else {
            $data['language'] = 'English';
        }

        // 2. Extract Provider Name
        // Method A: Check Riya's confirmation line ("আপনি [নাম] থেকে বলছেন, ঠিক তো?" or "आप [नाम] से बोल रहे हैं, ठीक है?")
        if (preg_match('/(?:আপনি|आप)\s+([^।\?]+?)\s+(?:থেকে|से)\s+(?:বলছেন|बोल रहे)/u', $transcript, $m)) {
            $name = trim(str_replace(['।', '?', '.', ',', 'ঠিক তো', 'ঠিক', 'जी', 'জি'], '', $m[1]));
            if (mb_strlen($name) >= 2) {
                $data['provider_name'] = $name;
            }
        }

        // Method B: Follow-up reply to name question
        if (empty($data['provider_name'])) {
            if (preg_match('/(?:ল্যাবের নাম|হাসপাতালের নাম|ক্লিনিকের নাম|ডাক্তার.*?নাম|নামটা দয়া করে বলবেন|নাম बताइए|नाम क्या है|কিসের পক্ষ থেকে)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
                $name = trim(str_replace(['।', '.', ',', 'আমার', 'নাম'], '', $m[1]));
                if (mb_strlen($name) >= 2) {
                    $data['provider_name'] = $name;
                }
            }
        }

        // 3. Extract Provider Type
        $lowerTrans = mb_strtolower($transcript);
        if (preg_match('/(?:ল্যাব টেস্ট|ল্যাব আছে|শুধুমাত্র.*?ল্যাব|প্যাথলজি|pathology|lab|पैथोलॉजी|लैब)/iu', $transcript)) {
            if (preg_match('/(?:ওপিডি.*?প্যাথলজি|opd.*?pathology|দুটোই|दोनों)/iu', $transcript)) {
                $data['provider_type'] = 'OPD & Pathology';
            } else {
                $data['provider_type'] = 'Pathology';
            }
        } elseif (preg_match('/(?:হসপিটাল|হাসপাতাল|hospital|अस्पताल)/iu', $transcript)) {
            $data['provider_type'] = 'Hospital';
        } elseif (preg_match('/(?:মেডিকেল শপ|মেডিকেল স্টোর|medical shop|दुकान)/iu', $transcript)) {
            $data['provider_type'] = 'Medical Shop';
        } elseif (preg_match('/(?:ডাক্তার|doctor|চেম্বার|opd|ओपीडी)/iu', $transcript)) {
            $data['provider_type'] = 'OPD / Doctor';
        }

        // 4. Extract Location
        // Method A: Confirmation line ("বুঝলাম, [লোকেশন]" / "समझ गई, [लोकेशन]")
        if (preg_match('/(?:বুঝলাম|समझ गई)[,\s]+([^।\?\n]+)/u', $transcript, $m)) {
            $loc = trim(str_replace(['।', '?', '.'], '', $m[1]));
            if (mb_strlen($loc) >= 2 && !preg_match('/(?:ধন্যবাদ|ঠিক আছে|ল্যাব)/iu', $loc)) {
                $data['location'] = $loc;
            }
        }

        // Method B: Follow-up reply to location question
        if (empty($data['location'])) {
            if (preg_match('/(?:কোথায় বসেন|কোথায় অবস্থিত|কোন এলাকা|কোন শহর|कहाँ बैठते|कहाँ स्थित|शहर বলবেন)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
                $loc = trim(str_replace(['।', '.', ','], '', $m[1]));
                if (mb_strlen($loc) >= 2 && !preg_match('/(?:ল্যাব|টেস্ট)/iu', $loc)) {
                    $data['location'] = $loc;
                }
            }
        }

        // 5. Extract Tests Offered
        if (preg_match('/(?:কোন কোন টেস্ট|টেস্ট হয়|কোন-কোন টেস্ট|যেমন ব্লাড|কোন কোন টেস্টের)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
            $tests = trim(str_replace(['।', '.'], '', $m[1]));
            if (mb_strlen($tests) >= 2) {
                $data['tests_offered'] = $tests;
            }
        }

        // 6. Extract Rates List Exists
        if (preg_match('/(?:রেটের লিস্ট|রেট লিস্ট|রেট আছে|रेट की लिस्ट|रेट लिस्ट)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
            $ans = $m[1];
            if (preg_match('/(?:হ্যাঁ|হাঁ|আছে|हाँ|yes)/iu', $ans)) {
                $data['rates_list_exists'] = 'yes';
            } elseif (preg_match('/(?:না|নেই|नहीं|no)/iu', $ans)) {
                $data['rates_list_exists'] = 'no';
            }
        }

        // 7. Extract Home Sample Collection
        if (preg_match('/(?:বাড়িতে গিয়ে|হোম কালেকশন|হোম স্যাম্পল|home sample|घर जाकर)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
            $ans = $m[1];
            if (preg_match('/(?:না|হয় না|নেই|नहीं|no)/iu', $ans)) {
                $data['home_sample_collection'] = 'no';
            } elseif (preg_match('/(?:হ্যাঁ|হাঁ|হয়|हाँ|yes)/iu', $ans)) {
                $data['home_sample_collection'] = 'yes';
            }
        }

        // 8. Extract Doctors and Timings
        if (preg_match('/(?:কোন-কোন ডাক্তার|কোন কোন ডাক্তার|ডাক্তার বসেন|दिन किस समय|कौन-कौन से डॉक्टर)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
            $docInfo = trim(str_replace(['।', '.'], '', $m[1]));
            if (mb_strlen($docInfo) >= 2) {
                $data['doctors_and_timings'] = $docInfo;
            }
        }

        // 9. Extract Consultation Modes
        if (preg_match('/(?:চেম্বারে এসে|ভিডিও কল|offline|video|क्लीनिक में आकर|वीडियो कॉल)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
            $ans = $m[1];
            if (preg_match('/(?:দুটোই|both|দুটো|दोनों)/iu', $ans)) {
                $data['consultation_modes'] = 'both';
            } elseif (preg_match('/(?:ভিডিও|video)/iu', $ans)) {
                $data['consultation_modes'] = 'video';
            } elseif (preg_match('/(?:চেম্বার|অফলাইন|offline|क्लीनिक)/iu', $ans)) {
                $data['consultation_modes'] = 'offline';
            }
        }

        // 10. Extract Doctor Fee
        if (preg_match('/(?:ডাক্তারের ফি|ফি কত|ফি কি ঠিক|डॉक्टर की फ़ीस|फ़ीस कितनी)[^\n]*\nUser:\s*([^\n]+)/iu', $transcript, $m)) {
            $fee = trim(str_replace(['।', '.'], '', $m[1]));
            if (mb_strlen($fee) >= 1) {
                $data['doctor_fee_known'] = $fee;
            }
        }

        // 11. Extract App Link Sent
        if (preg_match('/(?:লিংক পাঠিয়ে দিচ্ছি|লিঙ্ক পাঠিয়ে দিচ্ছি|link भेज देती हूँ|লিংক পাঠিয়ে দিন|দুটোরই লিংক পাঠিয়ে দিচ্ছি|link পাঠিয়ে দেব)/iu', $transcript)) {
            $data['app_link_sent'] = true;
        }

        // 12. Extract Callback Request
        if (preg_match('/(?:পরে ফোন করুন|পরে কল করবেন|কালকে ফোন করবেন|পরে কথা বলব|बाद में कॉल|व्यस्त हूँ|बिजी)/iu', $transcript, $m)) {
            $data['callback_scheduled'] = true;
            $data['callback_notes'] = 'Requested callback: ' . trim($m[0]);
        }

        // 13. Extract DND
        if (preg_match('/(?:DND|ফোন করবেন না|কল করবেন না|disturb করবেন না|कॉल मत करो|परेशान मत करो)/iu', $transcript, $m)) {
            $data['is_dnd'] = true;
        }

        // 14. Generate Clear AI Summary
        $data['summary'] = self::generateSummary($data);

        return $data;
    }

    /**
     * Generate concise human-readable summary
     */
    protected static function generateSummary(array $data): string
    {
        $parts = [];

        if (!empty($data['provider_name'])) {
            $p = $data['provider_name'];
            if (!empty($data['location'])) {
                $p .= " ({$data['location']})";
            }
            $parts[] = $p;
        }

        if (!empty($data['provider_type'])) {
            $parts[] = "ধরন: " . $data['provider_type'];
        }

        if (!empty($data['tests_offered'])) {
            $t = "টেস্ট: " . $data['tests_offered'];
            $extras = [];
            if (!empty($data['rates_list_exists'])) {
                $extras[] = $data['rates_list_exists'] === 'yes' ? 'রেট লিস্ট আছে' : 'রেট লিস্ট নেই';
            }
            if (!empty($data['home_sample_collection'])) {
                $extras[] = $data['home_sample_collection'] === 'yes' ? 'হোম কালেকশন আছে' : 'হোম কালেকশন নেই';
            }
            if (!empty($extras)) {
                $t .= " (" . implode(', ', $extras) . ")";
            }
            $parts[] = $t;
        }

        if (!empty($data['doctors_and_timings'])) {
            $parts[] = "ডাক্তার ও সময়: " . $data['doctors_and_timings'];
        }

        if (!empty($data['app_link_sent'])) {
            $parts[] = "হোয়াটসঅ্যাপে পার্টনার অ্যাপের লিঙ্ক পাঠানো হয়েছে।";
        }

        if (!empty($data['callback_scheduled'])) {
            $parts[] = "কলব্যাক করতে বলা হয়েছে।";
        }

        if (!empty($data['is_dnd'])) {
            $parts[] = "DND অনুরোধ জানানো হয়েছে।";
        }

        return !empty($parts) ? implode(' | ', $parts) : 'কথোপকথন রেকর্ড করা হয়েছে।';
    }

    /**
     * Build text transcript from OpenAI / Vapi messages array
     */
    public static function buildTranscriptFromMessages(array $messages): string
    {
        $lines = [];
        foreach ($messages as $msg) {
            $role = $msg['role'] ?? '';
            $text = $msg['message'] ?? $msg['content'] ?? '';
            if (empty($text) || $role === 'system') {
                continue;
            }
            $speaker = ($role === 'bot' || $role === 'assistant') ? 'AI' : 'User';
            $lines[] = "{$speaker}: {$text}";
        }
        return implode("\n", $lines);
    }
}

