<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doc;
use Smalot\PdfParser\Parser;
use App\Services\DocumentClassifier;
use App\Services\DocumentTitleExtractor;

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
                $titleExtractor = new DocumentTitleExtractor();
                $generatedTitle = $titleExtractor->extract($file, $fileType) ?? $title;
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

                $classifier = new DocumentClassifier();
                $classification = $classifier->classify($content);

                $doc = Doc::create([
                    'title' => $title,
                    'generated_name' => $generatedTitle,
                    'file_path' => 'uploads/' . $filename,
                    'content' => $content,
                    'classification' => $classification,
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

    /**
     * Display the specified resource in-app (viewer).
     */
    public function show($id)
    {
        $doc = Doc::findOrFail($id);
        return view('docs.show', compact('doc'));
    }
}
