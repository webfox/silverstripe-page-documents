# silverstripe-page-documents
A Documents module for silverstripe that implements the backend on any pagetype via an extension but does not dictate the frontend!

## How to use

### Install through composer
```bash
composer require webfox/silverstripe-page-document
```

### Apply to any pagetype you want the "Document Categories" tab to appear on
(can be applied to multiple page types)
```yaml
Page:
  extensions:
    - PageDocumentsExtensions
  document_category_title: 'Document Categories'
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
