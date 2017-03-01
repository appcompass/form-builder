##Plus 3 Interactive OptionableTrait

Provides an abstraction for transparently handling options.

**Usage:**
Add a 'use P3in\Traits\OptionableTrait' clause in your class.

__Methods:__

* setOption(string $option_label, mixed $option_id)       Set an option/s for the current model
* setOptions(array $options)                              Set multiple options at once
* getOption(string $label)                                Get model's associated options

__Relations:__

* options()                                               Reurns a relation

__Delete__

To delete an option from a model just set the option to null.