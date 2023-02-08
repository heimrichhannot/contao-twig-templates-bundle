# Changelog

All notable changes to this project will be documented in this file.

## [2.5.0] - 2023-02-08
- Added: create template without label for submit button
- Changed: use updated accordion util in bs4
- Changed: dropped support for php <7.4

## [2.4.10] - 2022-08-10
- Fixed: added missing `|raw` filters at `mod_breadcrumb_bs4.html.twig` and `mod_breadcrumb.html.twig` 

## [2.4.9] - 2022-07-25
- Changed: added optgroup syntax (thanks @werph)

## [2.4.8] - 2022-05-31
- Changed: removed test setup
- Fixed: warning in php 8

## [2.4.7] - 2022-05-10
- Fixed: respect request attributes for layout evaluation

## [2.4.6] - 2022-05-09

- Fixed: added missing `|default` at `block_searchable.html.twig` and `block_unsearchable.html.twig` 

## [2.4.5] - 2022-04-05

- Fixed: added missing `|raw` filter to download/s elements

## [2.4.4] - 2022-03-17

- Fixed: added missing `|raw` filter at `form_wrapper_bs4.html.twig` and `form_wrapper.html.twig`
- Fixed: html markup at `form_wrapper_bs4.html.twig`

## [2.4.3] - 2022-02-10

- Fixed: type hint

## [2.4.2] - 2022-02-09

- Fixed: type hint

## [2.4.1] - 2022-02-09

- Fixed: event dispatcher for symfony 4+
- Fixed: event inheritance

## [2.4.0] - 2022-02-09

- Changed: minimum contao version is now 4.9
- Changed: supported symfony versions are `^4.4||^5.4`
- Fixed: config for symfony 4+

## [2.3.3] - 2022-01-13

- Fixed: missing link title in gallery

## [2.3.2] - 2022-01-12

- Fixed: link attributes for gallery_default templates

## [2.3.1] - 2021-11-30

- Fixed: added missing `|raw` filter at `ce_headline.html.twig`

## [2.3.0] - 2021-08-31

- Added: support for php 8

## [2.2.2] - 2021-08-25

- Fixed: added missing `|raw` filters for form inputs

## [2.2.1] - 2021-08-17

- Fixed: added missing error class to form_checkbox and form_radio templates

## [2.2.0] - 2021-06-29

- added Polish translations

## [2.1.7] - 2021-06-21

- fixed missing raw filter in mod_navigation template ([#4])

## [2.1.6] - 2021-05-27

- deprecated getCurrentLanguage function, use app.request.locale instead

## [2.1.5] - 2021-05-21

- fixed `message.html.twig`

## [2.1.4] - 2021-05-21

- fixed `form_password.html.twig`

## [2.1.3] - 2021-05-21

- fixed `member_grouped.html.twig`

## [2.1.2] - 2021-05-18

- fixed GetAttributesFromDcaListener to add placeholder only if its not set in dca

## [2.1.1] - 2021-05-12

- fixed issue in Bootstrap4Framework class

## [2.1.0] - 2021-05-12

- added AbstractFrontendFramework to prevent repeating code
- corrected license file

## [2.0.6] - 2021-05-10

- allow twig support bundle ^1.0

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

- **BREAKING:** renamed bundle class to HeimrichHannotTwigTemplatesBundle (old twig namespaces are preserved, but should
  be updated till next major version)
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

[#4]: https://github.com/heimrichhannot/contao-twig-templates-bundle/issues/4
