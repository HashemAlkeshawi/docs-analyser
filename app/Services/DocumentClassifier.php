<?php

namespace App\Services;

class DocumentClassifier
{
    private $classificationTree =
    [
        'Finance' => ['invoice', 'payment', 'receipt', 'budget', 'tax', 'expense', 'revenue', 'balance', 'audit', 'forecast', 'statement', 'cash flow', 'ledger', 'credit', 'debit', 'fiscal'],

        'HR' => ['contract', 'policy', 'employee', 'recruitment', 'salary', 'leave', 'benefit', 'hiring', 'onboarding', 'performance', 'appraisal', 'termination', 'discipline', 'training', 'diversity', 'payroll'],

        'Projects' => ['project', 'plan', 'report', 'milestone', 'timeline', 'deliverable', 'scope', 'budget', 'risk', 'status', 'resource', 'schedule', 'roadmap', 'stakeholder', 'proposal'],

        'Meetings' => ['meeting', 'minutes', 'agenda', 'attendance', 'invite', 'schedule', 'follow-up', 'discussion', 'action items', 'conference', 'workshop', 'webinar'],

        'Legal' => ['agreement', 'nda', 'law', 'legal', 'compliance', 'court', 'regulation', 'contract', 'litigation', 'policy', 'terms', 'conditions', 'intellectual property', 'patent', 'trademark'],

        'Technical' => ['manual', 'specification', 'guide', 'documentation', 'requirement', 'architecture', 'api', 'design', 'code', 'deployment', 'testing', 'debug', 'integration', 'system', 'upgrade', 'maintenance'],

        'Marketing' => ['brochure', 'campaign', 'press release', 'branding', 'advertisement', 'promo', 'newsletter', 'seo', 'social media', 'content', 'market research', 'strategy', 'email marketing', 'event', 'public relations'],

        'Sales' => ['proposal', 'quote', 'order', 'invoice', 'receipt', 'customer', 'deal', 'lead', 'pipeline', 'forecast', 'commission', 'contact', 'contract', 'negotiation', 'follow-up', 'closing'],

        'Operations' => ['procedure', 'workflow', 'sop', 'checklist', 'operation', 'maintenance', 'logistics', 'inventory', 'quality control', 'supplier', 'production', 'efficiency', 'process', 'safety', 'compliance'],

        'Training' => ['tutorial', 'onboarding', 'e-learning', 'handbook', 'training', 'course', 'module', 'assessment', 'webinar', 'workshop', 'certificate', 'curriculum', 'instructor', 'evaluation'],

        'Research' => ['study', 'whitepaper', 'survey', 'analysis', 'research', 'experiment', 'data', 'report', 'publication', 'hypothesis', 'fieldwork', 'case study', 'literature review', 'methodology'],

        'Correspondence' => ['letter', 'email', 'memo', 'notice', 'correspondence', 'fax', 'telegram', 'notification', 'announcement', 'reminder', 'invitation'],

        'Administration' => ['form', 'application', 'record', 'log', 'admin', 'registration', 'permit', 'license', 'certificate', 'compliance', 'document', 'report', 'schedule', 'approval'],

        'IT' => ['support', 'ticket', 'system log', 'configuration', 'it', 'incident', 'network', 'server', 'security', 'backup', 'restore', 'software', 'hardware', 'patch', 'update', 'monitoring'],

        'Procurement' => ['purchase order', 'bid', 'tender', 'procurement', 'supplier', 'contract', 'invoice', 'quotation', 'vendor', 'negotiation', 'delivery', 'inventory', 'approval', 'payment'],

        'Compliance' => ['audit', 'certification', 'policy', 'standard', 'compliance', 'regulation', 'risk', 'assessment', 'control', 'reporting', 'internal control', 'governance'],

        'Personal' => ['cv', 'resume', 'personal statement', 'reference', 'bio', 'portfolio', 'certificate', 'award', 'recognition', 'goal', 'development plan', 'profile'],

        'Miscellaneous' => ['misc', 'other', 'general', 'note', 'draft', 'idea', 'template', 'archive', 'temporary', 'reference'],

        'Customer Service' => ['complaint', 'feedback', 'ticket', 'support', 'resolution', 'query', 'call log', 'chat transcript', 'satisfaction', 'response time'],

        'Finance Planning' => ['forecast', 'investment', 'portfolio', 'capital', 'risk management', 'dividend', 'tax planning', 'budgeting', 'cash management'],

        'Quality Assurance' => ['test case', 'defect', 'bug report', 'test plan', 'quality', 'inspection', 'compliance', 'validation', 'verification', 'audit'],

        'Health & Safety' => ['incident report', 'hazard', 'risk assessment', 'safety procedure', 'emergency plan', 'inspection', 'compliance', 'training', 'first aid', 'accident report'],

        'Event Management' => ['event plan', 'venue', 'agenda', 'invitation', 'registration', 'schedule', 'logistics', 'speaker', 'feedback', 'follow-up'],

        'Finance Reports' => ['balance sheet', 'profit and loss', 'cash flow statement', 'financial statement', 'annual report', 'quarterly report', 'tax return'],

        'Legal Contracts' => ['lease', 'service agreement', 'partnership agreement', 'nda', 'licensing', 'terms of service', 'contract amendment'],

        'Product Management' => ['product roadmap', 'feature', 'release plan', 'user story', 'backlog', 'epic', 'sprint', 'bug', 'version', 'deployment'],

        'Vendor Management' => ['vendor contract', 'service level agreement', 'purchase order', 'invoice', 'delivery note', 'vendor evaluation'],

        'Strategy & Planning' => ['business plan', 'strategic plan', 'roadmap', 'goals', 'objectives', 'key results', 'performance metrics', 'budget forecast'],
        'Data Analysis' => ['data report', 'dashboard', 'analytics', 'data visualization', 'statistical analysis', 'data mining', 'business intelligence', 'key performance indicators', 'trends', 'insights'],
        'Content Management' => ['content strategy', 'editorial calendar', 'content creation', 'content review', 'content distribution', 'content marketing', 'blog post', 'social media content', 'email newsletter', 'copywriting', 'SEO optimization'],

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
