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
$ composer req r3h6/form-data
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
