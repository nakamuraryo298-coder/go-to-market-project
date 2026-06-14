<?php

declare(strict_types=1);

use Dompdf\Options;

function gtm_create_pdf_options(string $chroot, bool $remoteEnabled = true): Options
{
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', $remoteEnabled);
    $options->set('dpi', 96);
    $options->setChroot($chroot);

    // Keep font subsetting enabled to avoid multi-MB Japanese PDFs.
    $options->setIsFontSubsettingEnabled(true);

    return $options;
}

function gtm_pdf_output_options(): array
{
    // Keep streams readable for viewer-side "Save As" / re-save operations
    // without embedding full Japanese fonts.
    return ['compress' => 0];
}
