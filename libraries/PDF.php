<?php

require_once '../vendor/fpdf/fpdf.php';

class PDF extends FPDF
{
    function Row($data, $widths, $aligns)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($widths[$i], $data[$i]));
        }
        $h = 8 * $nb;

        $this->CheckPageBreak($h);

        for ($i = 0; $i < count($data); $i++) {
            $w = $widths[$i];
            $a = $aligns[$i] ?? 'L';

            $x = $this->GetX();
            $y = $this->GetY();

            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 8, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w, $txt)
    {
        // (kode tetap sama)
    }
}
