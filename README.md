# Contao Bootstrap Templates Bundle

This bundle offers templates using the latest [Bootstrap](https://getbootstrap.com) framework's CSS for the Contao CMS.

## Features

- contains various templates already styled with Bootstrap's CSS classes
- (optional) support for custom form controls
- template caching using [Twig](https://twig.symfony.com)
- automatic usage of templates if the *bootstrap option* is checked in the layout (inspired by [contao-bootstrap/templates](https://github.com/contao-bootstrap/templates))

## Installation

Install via composer: `composer require heimrichhannot/contao-bootstrap-templates-bundle` and update your database.

## Configuration

It's as simple as that: Set the option `addBootstrapTemplates` in your existing layout or create a new one. This way the *automapping* takes place and
according to the current content element or module, the correct template is used which name's usually built with the suffix `_bs`.

If you don't want to use *automapping* you can also assign the template you want in the ordinary way by selecting it in the `customTpl` field of your module or content element.

### Supported content elements

Contao content element | Contao template | Twig template | Notes
---------------------- | --------------- | ------------- | -----
`ContentAccordion` | `ce_accordionSingle.html5` | `ce_accordionSingle_bs.html.twig` | single element accordions
`ContentAccordionStart` | `ce_accordionStart.html5` | `ce_accordionStart_bs.html.twig` |
`ContentAccordionStop` | `ce_accordionStop.html5` | `ce_accordionStop_bs.html.twig` |

### Supported modules

Contao module | Contao template | Twig template | Notes
------------- | --------------- | ------------- | -----
`ModuleLogin` | `mod_login.html5` | `mod_login_bs.html.twig` |

### Additional templates

Twig template | Notes
------------- | -----
`nav_tabs_bs.html.twig` |
`pagination_bs.html.twig` |

### Additional dca configuration keys

These keys can be used in fields eval entry:

Key            | Description
-------------- |-----------
`inputPrepend` | Content to be added before the input (within input-group-prepend). Overrides other prepended elements.
`inputAppend`  | Content to be added after the input (within input-group-append). Overrides other appended elements.
`inline`       | Input will be displayed horizontal. Only for checkboxes and radio buttons. 