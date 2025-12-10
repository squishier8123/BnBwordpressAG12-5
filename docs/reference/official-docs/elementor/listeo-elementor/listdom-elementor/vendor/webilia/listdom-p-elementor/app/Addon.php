<?php
namespace LSDPACELM;

class Addon extends Base
{
    public function form($default)
    {
        $subtab = isset($_GET['subtab']) ? sanitize_text_field($_GET['subtab']) : $default;
        $this->include_html_file('form.php', ['parameters' => compact('subtab')]);
    }
}
