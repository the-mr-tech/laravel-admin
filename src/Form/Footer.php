<?php

namespace Encore\Admin\Form;

use Encore\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class Footer implements Renderable
{
    const CHECKBOX_VIEW = 'view';
    const CHECKBOX_EDIT = 'continue_editing';
    const CHECKBOX_CREATE = 'continue_creating';

    /**
     * Footer view.
     *
     * @var string
     */
    protected $view = 'admin::form.footer';

    /**
     * Form builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Available buttons.
     *
     * @var array
     */
    protected $buttons = ['reset', 'submit'];

    /**
     * Available checkboxes.
     *
     * @var array
     */
    protected $checkboxes = ['view', 'continue_editing', 'continue_creating'];

    /**
     * The default option of the after-submit-checkboxes
     * @var string|null
     */
    protected $defaultOption;

    /**
     * Footer constructor.
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Disable reset button.
     *
     * @return $this
     */
    public function disableReset(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->buttons, 'reset');
        } elseif (!in_array('reset', $this->buttons)) {
            array_push($this->buttons, 'reset');
        }

        return $this;
    }

    /**
     * Disable submit button.
     *
     * @return $this
     */
    public function disableSubmit(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->buttons, 'submit');
        } elseif (!in_array('submit', $this->buttons)) {
            array_push($this->buttons, 'submit');
        }

        return $this;
    }

    /**
     * Disable View Checkbox.
     *
     * @return $this
     */
    public function disableViewCheck(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->checkboxes, 'view');
        } elseif (!in_array('view', $this->checkboxes)) {
            array_push($this->checkboxes, 'view');
        }

        return $this;
    }

    /**
     * Disable Editing Checkbox.
     *
     * @return $this
     */
    public function disableEditingCheck(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->checkboxes, 'continue_editing');
        } elseif (!in_array('continue_editing', $this->checkboxes)) {
            array_push($this->checkboxes, 'continue_editing');
        }

        return $this;
    }

    /**
     * Disable Creating Checkbox.
     *
     * @return $this
     */
    public function disableCreatingCheck(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->checkboxes, 'continue_creating');
        } elseif (!in_array('continue_creating', $this->checkboxes)) {
            array_push($this->checkboxes, 'continue_creating');
        }

        return $this;
    }

    public function setDefaultOption($checkboxOption)
    {
        if (!in_array($checkboxOption, $this->checkboxes)) {
            return $this;
        }

        $this->defaultOption = $checkboxOption;
        return $this;
    }

    /**
     * Setup scripts.
     */
    protected function setupScript()
    {
        $script = <<<'EOT'
$('.after-submit').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChecked', function () {
    $('.after-submit').not(this).iCheck('uncheck');
});
EOT;

        Admin::script($script);
    }

    /**
     * Render footer.
     *
     * @return string
     */
    public function render()
    {
        $this->setupScript();

        $data = [
            'buttons'      => $this->buttons,
            'checkboxes'   => $this->checkboxes,
            'width'        => $this->builder->getWidth(),
            'default_checkbox' => $this->defaultOption,
        ];

        return view($this->view, $data)->render();
    }
}
