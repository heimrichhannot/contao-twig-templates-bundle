# Changelog
All notable changes to this project will be documented in this file.

## [2.0.5] - 2021-02-15
- fixed tag

## [2.0.4] - 2021-01-26
- added bs4 version of mod_password template

## [2.0.3] - 2021-01-26
- fixed custom controls for bs4

## [2.0.2] - 2021-01-18
- add raw to logged in message

## [2.0.1] - 2020-12-08
- add raw to cssId in unsearchable block template

## [2.0.0] - 2020-12-03
- moved service loading to Extension class

## [2.0.0-beta11] - 2020-11-09
- fixed Bootstrap4Framework::prepareAccordions to accept custom template names

## [2.0.0-beta10] - 2020-11-09
- fixes for contao 4.4

## [2.0.0-beta9] - 2020-09-23
- fixed missing _entity variable in template data

## [2.0.0-beta8] - 2020-09-22
- **BREAKING:** renamed bundle class to HeimrichHannotTwigTemplatesBundle (old twig namespaces are preserved, but should be updated till next major version)
- raised twig support bundle dependency to 0.2

## [2.0.0-beta7] - 2020-09-17
- twig template base logic moved into contao-twig-support-bundle
- removed deprecated code: AbstractTemplate, AbstractFramework, ...
- replaced parseTemplate and parseWidget with BeforeParseTwigTemplateEvent and BeforeRenderTwigTemplateEvent
- removed template proxy templates
- deprecated BeforeRenderTwigTemplateEvent
- added layout to BeforeRenderCallback and PrepareTemplateCallback
- removed legacyTemplate from BeforeRenderCallback and PrepareTemplateCallback
- code enhancements
- added errorClass variable to multiple module templates
- added error block to multiple variable templates
- added role alert to message templates
- fixed hook method call
- fixed support for formhybrid subpalettes
- fixed placeholders to only be applied in frontend

## [2.0.0-beta6] - 2020-09-10
- added blocks to mod_password template
- fixed variable name in mod_password

## [2.0.0-beta5] - 2020-09-08
- added placeholder for date/time fields (accessibility)

## [2.0.0-beta3] - 2020-08-12
- removed HookListener class
- fixed method call in RenderListener

## [2.0.0-beta2] - 2020-08-12
Merged changes from 1.4.0 and 1.4.1, especially:

- added FrontendFrameworkInterface::getLabel()
- refactored code to use FrontendFrameworkInterface

## [2.0.0-beta1] - 2020-08-04
- added proxy template to replace html5 template dublicates
- added FrontendFrameworkInterface to soon replace AbstractFrontendFramework
- refactored HookListener into RenderListener
- deprecated AbstractTemplate and its childs

## [1.4.2] - 2020-09-10
- added blocks to mod_password template
- fixed variable name in mod_password

## [1.4.1] - 2020-08-12
- added missing getLabel method to FrontendFrameworkInterface
- implemented getLabel into AbstractFrontendFramework for bc
- fixed constructor parameter in AbstractTemplate

## [1.4.0] - 2020-08-12
This release introduce a lot of enhancements to ease the upgrate to version 2.0.

- added FrontendFrameworkInterface
- refactored relevant code to use FrontendFrameworkInterface instead of AbstractFrontendFramework, provide backward compatibility through AbstractFrontendFramework
- deprecated AbstractFrontendFramework
- deprecated AbstractTemplate and it's childs
- deprecated TemplateFactory

## [1.3.0] - 2020-08-04
- removed form_captcha template as it not used and working anymore
- added blocks and formAttributes variable to member_default template
- added formClass to mod_login template
- fixed not default contao label used in

## [1.2.0] - 2020-07-30
- added blocks to mod_login template
- fixed autologin block position in mod_login

## [1.1.47] - 2020-07-15
- removed height 100% style from form_textarea_bs4

## [1.1.46] - 2020-07-15
- fixed wrong variable in nav_inline_bs4

## [1.1.45] - 2020-07-15
- fixed pagination role

## [1.1.44] - 2020-07-15
- added raw to hyperlink 

## [1.1.43] - 2020-07-01
- fixed action in mod_password template

## [1.1.42] - 2020-06-11
- fixed typo in form_row_double template

## [1.1.41] - 2020-06-11
- fixed inserttags in member templates

## [1.1.40] - 2020-06-11
- fixed missing } in pagination tempalte

## [1.1.39] - 2020-05-18
- fixed missing space after attribute required and missing relation between input and invalid-feedback

## [1.1.38] - 2020-05-07
- added aria-label and role button Links to pagination templates

## [1.1.36] - 2020-04-27
- added fallback if href is empty

## [1.1.35] - 2020-02-06
- fixed useTwigTemplate checkbox not evaluated before applying logic
- fixed dca issue in tl_layout

## [1.1.34] - 2020-01-27
- pagination role button and alt attribute

## [1.1.33] - 2020-01-15
- fixed member_default

## [1.1.32] - 2020-01-10
- fixed missing attributes in form_password

## [1.1.31] - 2020-01-09
- fixed display of form in mod_password

## [1.1.30] - 2019-11-29
- added aria-label to form submit button
- translated aria-label for form submit button

## [1.1.29] - 2019-11-26
- fixed checkbox and radio id issue

## [1.1.28] - 2019-11-13
- raw output pagination

## [1.1.27] - 2019-11-13
- raw output of ce_table content

## [1.1.26] - 2019-11-12
- raw output of subitems in nav_default

## [1.1.25] - 2019-11-07
- removed debug echo in config.php

## [1.1.24] - 2019-11-07

### Fixed 
- formhybrid sub palettes again

## [1.1.23] - 2019-11-04

### Fixed 
- formhybrid sub palettes

## [1.1.22] - 2019-11-01

### Fixed 
- fixed attributes issue in checkbox custom

## [1.1.21] - 2019-10-14

### Fixed 
- attribute issues for ce_text

## [1.1.20] - 2019-10-08

### Fixed 
- form_checkbox template lable not raw output
- form_checkbox checkbox syntax

## [1.1.19] - 2019-10-04

### Added
- explanation bs4

## [1.1.18] - 2019-09-30

### Fixed
- raw `form_row_bs4.html`

## [1.1.17] - 2019-09-24

### Fixed
- hyperlink

## [1.1.16] - 2019-09-23

### Fixed
- accordion
- hyperlink
- list

## [1.1.15] - 2019-09-20

### Fixed
- accordion

## [1.1.14] - 2019-09-20

### Fixed
- issue in ce_download.html.twig

## [1.1.13] - 2019-09-20

### Fixed
- issue in ce_image.html.twig

## [1.1.12] - 2019-09-13

### Fixed
- issue in gallery_default_bs4.html.twig

## [1.1.11] - 2019-09-12

### Fixed
- raw output of subitems in navigation templates

## [1.1.10] - 2019-09-09

### Added
- 'open in new window' support in gallery templates

## [1.1.9] - 2019-08-13

### Fixed
- class render issue in nav_default.html.twig

## [1.1.8] - 2019-08-06

### Fixed
- fix from action issue in search templates

## [1.1.7] - 2019-07-26

### Fixed
- issue in pagination.html.twig

## [1.1.6] - 2019-07-17

### Fixed
- issue in mod_article.html.twig

## [1.1.5] - 2019-06-05

### Fixed
- issue in ce_hyperlink.html.twig

## [1.1.1] - 2019-06-05

### Fixed
- typos in templates

## [1.1.0] - 2019-06-04

### Removed
- block_searchable.html5 and block_unsearchable.html5 because they caused issues concerning non-twig templates inheriting from one of them

### Fixed
- issue in form_hidden.html.twig

## [1.0.2] - 2019-06-03

### Added
- support to show element preview in back end
- support to select contao as framework to prevent empty or missleading templates

## [1.0.1] - 2019-06-03

### Removed
- all _core from template files.

## [1.0.0] - 2019-05-28
        
### Changed
- readme

### Added
- nearly all available contao core templates
- all depending bootstrap 4 templates
- LGPL License

## [0.8.1] - 2019-05-22

### Changed
- changed accordion_parentId to optional in accordion start and single templates to prevent errors while rendering

## [0.8.0] - 2019-04-30

### Changed
- render checkbox and radio groups as fieldset and render fieldset label as legend for better accessibility support

## [0.7.2] - 2019-04-30

### Fixed
- `aria-current="page"` added for links in `nav_` templates for better accessibility support for active links

## [0.7.1] - 2019-04-30

### Fixed
- removed `for` from `label` in `form_checkbox_bs4` and `form_radio_bs4`, as they do not have any related form control with the given `id` (options have labels)

## [0.7.0] - 2019-04-30

### Added
- `_entity` variable within each twig template, to have access on the original contao template object (e.g. `FormTextField`)

### Fixed
- set proper input type on `form_textfield_bs4.html.twig`, based on field rgxp (`number`, `tel`, `email`, `url`) 

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
