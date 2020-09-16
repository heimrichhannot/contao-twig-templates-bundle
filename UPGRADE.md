# Upgrade notices

## Version 1.* to 2.0
- removed AbstractTemplate and inherited classes -> no replacement. Use events and framework callback for custom functionality
- removed AbstractFrontendFramework -> replaced by FrontendFrameworkInterface
- removed BeforeRenderTwigTemplateEvent::getType() and BeforeRenderTwigTemplateEvent::setType()
- added layout to BeforeRenderCallback and PrepareTemplateCallback
- removed legacyTemplate from BeforeRenderCallback and PrepareTemplateCallback
- removed TemplateTypeNotSupportedException
