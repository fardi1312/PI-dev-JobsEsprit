<?php

namespace App\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\LabelMargin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;

class QrcodeService
{
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function generateQrCodeForLocation($location)
    {
        $url = 'https://www.google.com/maps/place/';

        // Set up QR code
        $result = $this->builder
            ->data($url . urlencode($location))
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->margin(10)
            ->build();

        return $result->getDataUri();
    }
}

