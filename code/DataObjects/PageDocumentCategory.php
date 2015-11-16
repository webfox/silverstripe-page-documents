<?php

class PageDocumentCategory extends DataObject {

    protected static $db = [
        'Title'     => 'Varchar(255)',
        'SortOrder' => 'Int'
    ];

    protected static $has_one = [
        'Page' => 'Page'
    ];

    private static $summary_fields = [
        'Title'           => 'Category Title',
        'Documents.Count' => 'Documents'
    ];

    private static $many_many = [
        'Documents' => 'File'
    ];

    private static $many_many_extraFields = [
        'Images' => ['SortOrder' => 'Int']
    ];

    protected static $default_sort = 'SortOrder';

    public function getCMSFields() {

        $fields = new FieldList([
            TextField::create('Title'),
        ]);

        if ($this->exists()) {
            $folderName = 'Documents';

            $config = $this->Page()->exists() ? $this->Page()->config()->get('page_documents') : null;

            if (is_array($config)) {
                if (isset($config['folder'])) {
                    $folderName = $config['folder'];
                }

                if (isset($config['section']) && $config['section']) {
                    $filter  = new URLSegmentFilter();
                    $section = implode('-',
                        array_map(
                            function ($string) { return ucfirst($string); },
                            explode('-', $filter->filter($this->Title))
                        )
                    );
                    $folderName .= '/' . $section;
                }
            }

            $fields->push(SortableUploadField::create('Documents', 'Documents')->setDescription('Drag documents by thumbnail to sort')->setFolderName($folderName));
        } else {
            $fields->push(LiteralField::create('DocumentsNotSaved', '<p>Save category to add documents</p>'));

        }

        return $fields;

    }

    public function SortedDocuments() {
        return $this->Documents()->Sort('SortOrder');
    }

    public function canView($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

}
