# Changelog
All notable changes to this project will be documented in this file.

## [0.3.3] - 2019-02-01

### Fixed
- dropped unused method in `HookListener`

## [0.3.2] - 2019-02-01

### Fixed
- performance improvement on `HookListener::applyTwigTemplate` (now roughly 5 times faster)

## [0.3.1] - 2019-01-30

### Fixed
- properly display `form-feedback` block on `input-grop` form elements

## [0.3.0] - 2019-01-29

### Added
- getCurrentLanguage() twig function

## [0.2.2] - 2019-01-29

### Fixed
- order of image and text at twig-template `ce_text_core`

## [0.2.1] - 2019-01-25

### Added
- attributes in checkbox template

## [0.2.0] - 2019-01-23

### Added
- form-feedback block containing the `aria-describedby` content (errors and explanations) 

### Fixed

- validation handling for checkbox, select and radios including custom forms 

## [0.1.0] - 2019-01-21

Initial release
