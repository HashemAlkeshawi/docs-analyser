<?php

namespace App\Services;

use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

class DocumentContentExtractor
{
    public function extract($file, $fileType)
    {
        if ($fileType === 'pdf') {
            try {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($file->getRealPath());
                return $pdf->getText();
            } catch (\Exception $e) {
                return null;
            }
        } elseif (in_array($fileType, ['doc', 'docx'])) {
            try {
                $phpWord = WordIOFactory::load($file->getRealPath());
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        $text .= $this->extractTextFromElement($element);
                    }
                }
                return $text;
            } catch (\Exception $e) {
                return null;
            }
        } elseif ($fileType === 'txt') {
            return file_get_contents($file->getRealPath());
        }
        return null;
    }

    private function extractTextFromElement($element)
    {
        $text = '';
        if (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $subElement) {
                $text .= $this->extractTextFromElement($subElement);
            }
        } elseif (method_exists($element, '__toString')) {
            $text .= (string) $element . "\n";
        }
        return $text;
    }
}
