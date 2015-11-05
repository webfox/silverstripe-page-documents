<?php

class PageDocumentsExtension extends SiteTreeExtension {

	private static $has_many = [
		'DocumentCategories' => 'DocumentCategory'
	];

	public function updateCMSFields(FieldList $fields) {

		/** @var TabSet $rootTab */
		//We need to repush Metadata to ensure it is the last tab
		$rootTab = $fields->fieldByName('Root');
		$rootTab->push($documentsTab = Tab::create('DocumentCategories'));
		if ($rootTab->fieldByName('Metadata')) {
			$metaChildren = $rootTab->fieldByName('Metadata')->getChildren();
			$rootTab->removeByName('Metadata');
			$rootTab->push(Tab::create('Metadata')->setChildren($metaChildren));
		}

		$DocumentCategoriesConfig = new GridFieldConfig_RecordEditor();
		$DocumentCategoriesConfig->addComponent(new GridFieldSortableRows('SortOrder'));
		$DocumentCategories = new GridField("DocumentCategoriesGridField", "Document Categories", $this->owner->DocumentCategories(), $DocumentCategoriesConfig);
		$fields->addFieldToTab('Root.DocumentCategories', $DocumentCategories);

		if($this->owner->config()->get('document_category_title')) {
			$documentsTab->setTitle($this->owner->config()->get('document_category_title'));
		}

		return $fields;
	}

}
