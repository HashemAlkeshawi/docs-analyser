<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doc;
use Smalot\PdfParser\Parser;

class DocController extends Controller
{
  
    public function index()
    {
        $docs = Doc::orderByDesc('uploaded_at')->get();
        return view('docs.index', ['docs' => $docs]);
    }

  
    public function create()
    {
        //
        return view('docs.upload');
    }

    /**
     * Extract a generated title from a file (PDF, DOC, DOCX).
     */
    private function extractGeneratedTitle($file, $fileType)
    {
        if ($fileType === 'pdf') {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($file->getRealPath());
    
                $text = $pdf->getText();
                return str()->limit(trim(strtok($text, "\n")), 60);
            } catch (\Exception $e) {
                return 'no title';
            }
        } elseif (in_array($fileType, ['doc', 'docx'])) {
            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getRealPath());
                $sections = $phpWord->getSections();
                foreach ($sections as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        // Use __toString() if available, otherwise skip
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

    /**
     * Predefined classification tree and rule-based classifier.
     */
    private $classificationTree = [
        'Finance' => ['invoice', 'payment', 'receipt', 'budget', 'tax'],
        'HR' => ['contract', 'policy', 'employee', 'recruitment', 'salary'],
        'Projects' => ['project', 'plan', 'report', 'milestone', 'timeline'],
        'Meetings' => ['meeting', 'minutes', 'agenda', 'attendance'],
        'Legal' => ['agreement', 'nda', 'law', 'legal', 'compliance'],
    ];

    private function classifyDocument($content)
    {
        $content = strtolower($content ?? '');
        foreach ($this->classificationTree as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($content, $keyword)) {
                    return $category;
                }
            }
        }
        return 'Unclassified';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'documents' => 'required',
            'documents.*' => 'file|mimes:pdf,doc,docx|max:20480', // 20MB max per file
        ]);

        $highlighted = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, 'public');
                $fileType = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $generatedTitle = $this->extractGeneratedTitle($file, $fileType) ?? $title;
                $content = null;

                // Extract text content for search (basic, for demo)
                if (in_array($fileType, ['txt'])) {
                    $content = file_get_contents($file->getRealPath());
                } elseif ($fileType === 'pdf') {
                    // Optionally extract all text for search
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($file->getRealPath());
                        $content = $pdf->getText();
                    } catch (\Exception $e) {}
                } elseif (in_array($fileType, ['doc', 'docx'])) {
                    try {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getRealPath());
                        $text = '';
                        foreach ($phpWord->getSections() as $section) {
                            foreach ($section->getElements() as $element) {
                                if (method_exists($element, '__toString')) {
                                    $text .= (string) $element . "\n";
                                }
                            }
                        }
                        $content = $text;
                    } catch (\Exception $e) {}
                }

                $classification = $this->classifyDocument($content);

                $doc = Doc::create([
                    'title' => $title,
                    'generated_name' => $generatedTitle,
                    'file_path' => 'uploads/' . $filename,
                    'content' => $content,
                    'classification' => $classification, // Set this based on your logic/tree
                    'file_type' => $fileType,
                    'size' => $size,
                    'uploaded_at' => now(),
                    'description' => null,
                ]);
                $highlighted[] = $doc->id;
            }
        }
        return redirect()->route('docs.index')
            ->with('success', 'Documents uploaded successfully!')
            ->with('highlighted_docs', $highlighted);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(string $id)
    {
        $doc = Doc::findOrFail($id);
        $doc->delete();
        return redirect()->route('docs.index')->with('success', 'Document deleted successfully!');
    }

    /**
     * Display a listing of the resource ordered by generated_name (title).
     */
    public function indexByTitle()
    {
        $docs = Doc::orderBy('generated_name')->get();
        return view('docs.index', ['docs' => $docs]);
    }
}
