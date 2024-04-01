<?php

namespace App\Libraries\SpatiaDbMail;

use Spatie\MailTemplates\TemplateMailable;

class TemplateMailableExtender extends TemplateMailable
{

    public function getHtmlLayout(): string
    {
        $style = $this->getStyle();

        $layout = $this->getMailLayout();

        return $style.$layout;
    }



    private function getStyle()
    {
        $template = $this->getMailTemplate();

        return !empty($template->html_style) ? $template->html_style : getMailTemplate($template->style_path);
    }

    private function getMailLayout()
    {
        $template = $this->getMailTemplate();

        return !empty($template->html_layout) ? $template->html_layout : getMailTemplate($template->layout_path);
    }

}