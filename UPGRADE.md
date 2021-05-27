# Upgrade notices

## Version 2.* to 3.0
- removed bundled bootstrap 4 templates (moved into [own bundle](https://github.com/heimrichhannot/contao-twig-templates-bootstrap4-bundle))
- removed getCurrentLanguage function, use app.request.locale instead

## Version 1.* to 2.0
- renamed bundle class to HeimrichHannotTwigTemplatesBundle
- removed AbstractTemplate and inherited classes -> no replacement. Use events and framework callback for custom functionality
- removed AbstractFrontendFramework -> replaced by FrontendFrameworkInterface
- removed BeforeRenderTwigTemplateEvent::getType() and BeforeRenderTwigTemplateEvent::setType()
- added layout to BeforeRenderCallback and PrepareTemplateCallback
- removed legacyTemplate from BeforeRenderCallback and PrepareTemplateCallback
- removed TemplateTypeNotSupportedException

## Version 0.x to 1.0

If you used _core templates in versions before 1.0 you need to refactor them to filenames without _core. 