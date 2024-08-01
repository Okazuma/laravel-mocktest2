<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     *
     * @param string $data
     * @return string
     */
    public function generateQrCode($data)
    {
        $qrCode = QrCode::format('png')->size(300)->generate($data);
        return 'data:image/png;base64,' . base64_encode($qrCode);
    }

    /**
     *
     * @param string $data
     * @return string
     */
    public function generateQrCodeImage($data)
    {
        return QrCode::format('png')->size(300)->generate($data);
    }
}
