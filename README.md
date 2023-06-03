[![Latest Stable Version](https://poser.pugx.org/r3h6/form-frontend-validation/v/stable)](https://extensions.typo3.org/extension/form_frontend_validation/)
[![TYPO3 12](https://img.shields.io/badge/TYPO3-12-green.svg?style=flat-square)](https://get.typo3.org/version/12)
[![TYPO3 11](https://img.shields.io/badge/TYPO3-11-green.svg?style=flat-square)](https://get.typo3.org/version/11)
[![Total Downloads](https://poser.pugx.org/r3h6/form-frontend-validation/d/total)](https://packagist.org/packages/r3h6/form-frontend-validation)
[![Monthly Downloads](https://poser.pugx.org/r3h6/form-frontend-validation/d/monthly)](https://packagist.org/packages/r3h6/form-frontend-validation)

# form_frontend_validation

Frontend validation for the TYPO3 form framework.

Adds data attributes to form elements for the [Parsley](https://parsleyjs.org/) JavaScript form validation library.<br>
Currently implemented validators:
- AdvancedPassword
- AlphanumericValidator
- CountValidator
- DateRangeValidator
- EmailAddressValidator
- FloatValidator
- IntegerValidator
- NotEmptyValidator
- NumberRangeValidator
- NumberValidator
- RegularExpressionValidator
- StringLengthValidator


## Installation

```
$ composer req r3h6/form-frontend-validation
```

## Integration

Include in your TypoScript template following static templates:
- Form Validation "Parsley"
- Form Validation "Parsley JavaScript" _(Optional)_
- Form Validation "Parsley Styles" _(Optional)_

New template paths will be added to the form framework on key 11.
If you changed the form field partial template you must add following HTML code to your partial:
```html
<span id="{element.uniqueIdentifier}-errors" class="error help-block"></span>
```
