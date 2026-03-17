<?php

namespace App\Utils;

class CardGenerator
{
    public static function generate($user)
    {
        $bgPath = public_path('img/card-bg.png');
        if (!file_exists($bgPath)) {
            return null;
        }

        $image = imagecreatefrompng($bgPath);
        if (!$image) {
            return null;
        }

        // Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $cyan  = imagecolorallocate($image, 0, 210, 255);
        $gray  = imagecolorallocate($image, 148, 163, 184);

        // Font Path (Windows default)
        $fontBold = 'C:\Windows\Fonts\arialbd.ttf';
        $fontReg  = 'C:\Windows\Fonts\arial.ttf';

        if (!file_exists($fontBold)) {
            // Fallback for non-Windows or if font missing
            $fontBold = $fontReg = 5; // Use built-in GD font
            
            imagestring($image, 5, 70, 420, "NAME: " . strtoupper($user->user_name), $white);
            imagestring($image, 5, 70, 500, "MEMBER ID: " . $user->memberid, $white);
            imagestring($image, 5, 600, 500, "CARD NUMBER: " . $user->medical_card_no, $cyan);
        } else {
            // High-quality text with TTF
            // Name
            imagettftext($image, 26, 0, 70, 440, $white, $fontBold, strtoupper($user->user_name));
            
            // Labels
            imagettftext($image, 12, 0, 70, 500, $gray, $fontReg, "MEMBER ID");
            imagettftext($image, 12, 0, 600, 500, $gray, $fontReg, "CARD NUMBER");
            
            // Values
            imagettftext($image, 20, 0, 70, 545, $white, $fontBold, $user->memberid);
            imagettftext($image, 20, 0, 600, 545, $cyan, $fontBold, $user->medical_card_no);
            
            // Footer
            imagettftext($image, 11, 0, 70, 600, $gray, $fontReg, "PREMIUM HEALTHCARE ACCESS • DOCTORWALA.INFO");
        }

        $tempPath = storage_path('app/temp_card_' . $user->id . '.png');
        imagepng($image, $tempPath);
        imagedestroy($image);

        return $tempPath;
    }
}
