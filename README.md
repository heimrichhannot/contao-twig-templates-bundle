# Contao Twig Templates Bundle

This bundle brings twig support to Contao CMS. In addition to supporting replacing the core templates with twig pendants, it also supports different frontend frameworks like [Bootstrap](https://getbootstrap.com) (Bootstrap 4 templates are supported out of the box).
 
## Features

- replaces various core templates with twig templates
- automatic usage of templates prepared for frontend frameworks, if set in settings (inspired by [contao-bootstrap/templates](https://github.com/contao-bootstrap/templates))
- bundles bootstrap 4 support with optional support for custom form controls
- template caching using [Twig](https://twig.symfony.com)

## Installation

Install via composer: `composer require heimrichhannot/contao-bootstrap-templates-bundle` and update your database.

### Additional frontend frameworks

Currently available (known) extensions:
* [Bootstrap 3](https://github.com/heimrichhannot/contao-twig-templates-bootstrap3-bundle)

## Usage


It's as simple as that: Check 'Use twig templates' in your page layout configuration. If your want to use a frontend framework like bootstrap, select the corresponding option in the 'Use framework' select. This way the *automapping* takes place and according to the current content element or module, the correct template is used.

Automapping order (check if template exists, else use the next one):
1. Frontend framework twig template
1. modified Template Files in your specific bundle
1. Core twig template
1. default (contao html5) template

If you don't want to use *automapping* you can also assign the template you want in the ordinary way by selecting it in the `customTpl` field of your module or content element.

## Update

If you used _core templates in versions before 1.0 you need to refactor them to filenames without _core. 

### Additional dca configuration keys

These keys can be used in fields eval entry:

Key            | Description
-------------- |-----------
`inputPrepend` | Content to be added before the input (within input-group-prepend). Overrides other prepended elements.
`inputAppend`  | Content to be added after the input (within input-group-append). Overrides other appended elements.
`inline`       | Input will be displayed horizontal. Only for checkboxes and radio buttons. 
`groupClass`   | Classes for outer form group wrapper (default: form-group)
`inputGroupClass`   | Classes for input group wrapper (input-group is always added)

## Bundled templates

### Block templates

Template | Bundled
-------- | -------
block_searchable | core
block_unsearchable | core

### Content elements

Content Element  | bundled core | bundled bs4
---------------- | :----------: | :----------:
Accordion Single |       x      |       x     
Accordion Start  |       x      |       x    
Accordion Stop   |       x      |       x    
Code             |       x      |       x    
Download         |       x      |       x    
Downloads        |       x      |       x    
Gallery          |       x      |       x    
Headline         |       x      |       x    
HTML             |       x      |           
Hyperlink        |       x      |           
Image            |       x      |           
List             |       x      |           
Markdown         |       x      |           
Player           |       x      |           
Slider Start     |       x      |           
Slider Stop      |       x      |           
Table            |       x      |           
Teaser           |       x      |            
Text             |       x      |           
Toplink          |       x      |           
Vimeo            |       x      |       x    
Youtube          |       x      |       x   

### Member elements

Content Element  | bundled core | bundled bs4
---------------- | :----------: | :----------:
Member default   |       x      |            
Member grouped   |       x      |     

### Gallery

Content Element  | bundled core | bundled bs4
---------------- | :----------: | :----------:
Gallery default  |       x      |       x

Both version with minimal setting. You definitely need to change those templates to fit your requirements.

### Modules

Modules          | bundled core | bundled bs4  | changes
---------------- | :----------: | :----------: | :----------:
Article          |       x      |              | removed Gplus Button
Article List     |       x      |              | 
Article Nav      |       x      |              | 
Book Nav         |       x      |              | 
Breadcrumb       |       x      |       x      | 
Change Password  |       x      |              | 
Close Account    |       x      |              | 
Custom Nav       |       x      |              | 
HTML             |       x      |              | 
Login            |       x      |       x      | 
Lost Password    |       x      |              | 
Message          |       x      |              | 
Navigation       |       x      |              | 
Password         |       x      |              | 
Quicklink        |       x      |              | 
Quicknav         |       x      |              | 
Random Image     |       x      |              | 
Search           |       x      |       x      | 
Sitemap          |       x      |              | 

### Navigation

Modules          | bundled core | bundled bs4  | 
---------------- | :----------: | :----------: | 
Nav Default      |       x      |              | 
Nav Inline       |              |       x      | 
Nav Tabs         |              |       x      | 
Nav Vertical     |              |       x      | 

### Search

Modules          | bundled core | bundled bs4  | 
---------------- | :----------: | :----------: | 
Search Default   |       x      |       x      | 
Search List Group|              |       x      | 

## Developers

### Events

Through the bundle lifecycle following [Events](https://symfony.com/doc/current/event_dispatcher.html) are dispatched: 

Event                         | Description
----------------------------- | -----------
huh.twig.beforeRenderTemplate | Modify template data before rendering the widget

### Add custom frontend frameworks

1. Create a class which extends `HeimrichHannot\TwigTemplatesBundle\FrontendFramework\AbstractFrontendFramework` and implement the abstract methods
    > Please read the method comments for implementation
1. Register your newly created class as service with `huh.contao_twig_templates.framework` service tag
1. For each template, you want to replace, create an html5 template (where filename suffix is the same as the alias set in the class, example `form_checkbox_bs4.html5`) and call the template factory. Typical this code can be used without any adjustment: 

    ```php
    <?= \Contao\System::getContainer()->get('huh.utils.template')->renderTwigTemplate($this->getName(), $this->getData()); ?>
    ```
    * If your want to set template specific options (for example bootstrap 4 custom control support) you can use `$template::addSupport()`. Example:
    
        ```
         <?php 
        $template = \Contao\System::getContainer()->get('huh.twig.template.factory')->createInstance($this);
        $template->addSupport('custom-forms', true);
        echo $template->render();
        ```

1. Create a twig template with the same name as the html5 template (e.g. `form_checkbox_bs4.html.twig`). This is the place where your custom template code will live. All template variable are given as twig variables. Please see bundle templates for some examples.

### Template variables

Additional template variables

Name            | Type   | Default    | Description
--------------- | ------ | ---------- | -----------
groupClass      | string | form-group | The outer form group class
inputGroupClass | string | form-group | The input group class
_entity | object | - | The context entity object (e.g. \Contao\FormTextField)
