<?php
namespace View;

class View
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $values;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $layout;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = "{$template}.phtml";
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param array $values
     */
    public function assign(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function render()
    {
        ob_start();
        require_once "{$this->path}/{$this->template}";
        $this->values['content'] = ob_get_clean();

        ob_start();
        require_once "{$this->path}/{$this->layout}";

        return ob_get_clean();
    }

    /**
     * @param unknown $template
     */
    public function renderTemplate($template)
    {
        require "{$this->path}/$template";
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->values[$name]) ? $this->values[$name] : '';
    }
}