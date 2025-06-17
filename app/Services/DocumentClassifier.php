<?php

namespace App\Services;

class DocumentClassifier
{
    private $classificationTree = [
        'Finance' => ['invoice', 'payment', 'receipt', 'budget', 'tax', 'expense', 'revenue', 'balance'],
        'HR' => ['contract', 'policy', 'employee', 'recruitment', 'salary', 'leave', 'benefit', 'hiring'],
        'Projects' => ['project', 'plan', 'report', 'milestone', 'timeline', 'deliverable', 'scope'],
        'Meetings' => ['meeting', 'minutes', 'agenda', 'attendance', 'invite', 'schedule'],
        'Legal' => ['agreement', 'nda', 'law', 'legal', 'compliance', 'court', 'regulation'],
        'Technical' => ['manual', 'specification', 'guide', 'documentation', 'requirement', 'architecture', 'api'],
        'Marketing' => ['brochure', 'campaign', 'press release', 'branding', 'advertisement', 'promo', 'newsletter'],
        'Sales' => ['proposal', 'quote', 'order', 'invoice', 'receipt', 'customer', 'deal'],
        'Operations' => ['procedure', 'workflow', 'sop', 'checklist', 'operation', 'maintenance'],
        'Training' => ['tutorial', 'onboarding', 'e-learning', 'handbook', 'training', 'course'],
        'Research' => ['study', 'whitepaper', 'survey', 'analysis', 'research', 'experiment'],
        'Correspondence' => ['letter', 'email', 'memo', 'notice', 'correspondence'],
        'Administration' => ['form', 'application', 'record', 'log', 'admin', 'registration'],
        'IT' => ['support', 'ticket', 'system log', 'configuration', 'it', 'incident'],
        'Procurement' => ['purchase order', 'bid', 'tender', 'procurement', 'supplier'],
        'Compliance' => ['audit', 'certification', 'policy', 'standard', 'compliance'],
        'Personal' => ['cv', 'resume', 'personal statement', 'reference', 'bio'],
        'Miscellaneous' => ['misc', 'other', 'general', 'note'],
    ];

    public function classify(string $content = null): string
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
}
