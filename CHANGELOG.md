# Changelog
All notable changes to this project will be documented in this file.

## [0.6.4] - 2019-04-11

### Fixed
- login templates (now extending)

## [0.6.3] - 2019-04-11

### Fixed
- login templates

## [0.6.2] - 2019-04-10

### Fixed
- 1 option and multiple checkbox "groups"

## [0.6.1] - 2019-04-09

### Fixed 
- custom controls

## [0.6.0] - 2019-04-08

### Changed 
- decoupled framework dependend logic to make bundle expandable for other frontend frameworks

## [0.5.1] - 2019-03-15

### Fixed
- headline in `ce_text_core` not outputted raw

## [0.5.0] - 2019-03-13

### Changed
- bs4 submit button now extends row

## [0.4.6] - 2019-03-06

### Fixed
- english translations


## [0.4.5] - 2019-03-06

### Added
- some english and polish translations

## [0.4.4] - 2019-03-05

### Fixed
* nav target output in nav templates
* FrontendTemplate type in `TemplateFactory`

## [0.4.3] - 2019-03-04

### Fixed
- checkbox label for 1 option checkbox "groups"

## [0.4.2] - 2019-03-04

### Fixed
- removed checkbox label for 1 option checkbox "groups"

## [0.4.1] - 2019-03-04

### Fixed
- ">" character in label of some of the widget templates

## [0.4.0] - 2019-03-04

### Added
- `nav_inline_bs4`
- `nav_vertical_bs4`

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
