<?php

namespace App\Services;

use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

class DocumentTitleExtractor
{
    public function extract($file, $fileType)
    {
        if ($fileType === 'pdf') {
            try {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($file->getRealPath());
                $text = $pdf->getText();
                return str()->limit(trim(strtok($text, "\n")), 60);
            } catch (\Exception $e) {
                return 'no title';
            }
        } elseif (in_array($fileType, ['doc', 'docx'])) {
            try {
                $phpWord = WordIOFactory::load($file->getRealPath());
                $sections = $phpWord->getSections();
                foreach ($sections as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        if (method_exists($element, '__toString')) {
                            $text = (string) $element;
                            if (trim($text)) {
                                return str()->limit(trim(strtok($text, "\n")), 60);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                return 'no title';
            }
        }
        return null;
    }
}
