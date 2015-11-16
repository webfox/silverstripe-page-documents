# silverstripe-page-documents
A Documents module for silverstripe that implements the backend on any pagetype via an extension but does not dictate the frontend!

## How to use

### Install through composer
```bash
composer require webfox/silverstripe-page-documents
```

### Apply to any pagetype you want the "Document Categories" tab to appear on
(can be applied to multiple page types)
```yaml
Page:
  extensions:
    - PageDocumentsExtension
  page_documents:
    title: 'Page Documents'  #Tab Title: defaults to 'Document Categories'
    folder: 'Docs'           #Where to store docs: defaults to  'Documents'
    section: true            #If true the documents are stored in a child folder named after the 
                             #category e.g. Docs/Category-Title/myfile.pdf: defaults to false
```

### Use on the frontend

```
<% if $DocumentCategories.Exists %>
    <% loop $DocumentCategories %>
        <% if $SortedDocuments.Exists %>
            <h2>Category: {$Title}</h2>
            <% loop $SortedDocuments %>
                <p>
                    <a href="{$Link}" download="{$FileName}">{$Title} [{$Size}]</a>
                </p>
            <% end_loop %>
        <% end_if %>
    <% end_loop %>
<% end_if %>
```
