# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.5.0] - 2026-06-25

### Added
- **Premium Thumbnail Uploader UI/UX:** Replaced KBoard's default file upload field in the editor (`editor.php`) with a modern, single-image drag-and-drop card.
  - Supports click and drag-and-drop image selection.
  - Client-side validation: Restricts files to images under 10MB.
  - Real-time preview: Renders the selected image instantly using `FileReader`.
  - Float "X" delete button: Interactive clear button with backdrop filter blur, scale animation, and red hover state.
  - Smart deletion: Clears local file input directly or redirects to KBoard's server attachment delete route for saved remote images with user confirmation.
- **Admin View Count Indicator:**
  - Added admin-only table row displaying post view counts in the obituary list view (`list.php`) for both desktop and mobile layouts.
  - Added admin-only table row displaying post view counts in the document detail view (`document.php`).

### Changed
- **Disabled Thumbnail Auto-Cropping:** Removed dimensions from `$content->getThumbnail()` in `functions.php` to prevent WordPress server-side auto-cropping, maintaining the original aspect ratio of uploaded obituary photos.
- **Photo Display Fitting:** Modified `.duo-obituary-photo img` styling in `style.css` to use `object-fit: contain` and background `#f8f8f8` to prevent cropped views on detail pages.
- **Responsive Uploader:** Centered the premium thumbnail uploader on mobile devices.
