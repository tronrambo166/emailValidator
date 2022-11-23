<?php

/**
 * This file is part of Berevi Collection applications.
 *
 * (c) Alan Da Silva
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or on Codecanyon
 *
 * @see https://codecanyon.net/licenses/terms/regular
 */

namespace app\library;

use app\Kernel;

class View extends Kernel
{
    protected $contentFile;
    protected $vars = [];

    public function varsModelization()
    {
        return new Variables();
    }

    public function addVar($var, $value)
    {
        if (!is_string($var) || is_numeric($var) || empty($var)) {
            throw new \InvalidArgumentException('The name of the variable must be a non-null string');
        }
 
        $this->vars[$var] = $value;
    }

    public function render($mainTemplate, $action, $variables = [])
    {
        $appConfig = new \app\config\AppConfig('routes');
        foreach ($appConfig->appRoutes() as $view) {
            $views[] = $view["controller"];
        }

        $tryRender = explode(";", $this->getController());
        list($src, $module, $controller, $returnedAction) = explode('\\', $tryRender[0]);

        $control = explode("Controller:", $returnedAction);
        if ($action != $control[1]) {
            throw new \InvalidArgumentException('The name of the variable must be a non-null string');
        }

        $template = __DIR__.'/../../src/'.$module.'/Resources/views/'.$control[0].'/'.$control[1].'.php';
        if (!file_exists($template)) {
            throw new \RuntimeException('The specified view does not exist');
        }

        $render = file_get_contents(__DIR__.'/../../src/'.$module.'/Resources/views/'.$control[0].'/'.$control[1].'.php', FILE_USE_INCLUDE_PATH);
        $render = $this->loadMainTemplate($mainTemplate, $render);
        $render = $this->scriptBodyRender($render);
        foreach ($variables as $key => $value) {
            if ($key == "httpGetAutorization") {
                $render = $this->coreVariables("{{ ".$key." }}", $value, $render);
                $render = $this->coreVariables("{{".$key."}}", $value, $render);
            }

            $render = str_replace(["{{ ".$key." }}", "{{".$key."}}"], $value, $render);
        }

        echo $render;
    }

    public function loadMainTemplate($mainTemplate, $render)
    {
        $ifExists = __DIR__.'/../../app/Resources/views/'.$mainTemplate.'.php';
        if (!file_exists($ifExists)) {
            throw new \RuntimeException('The specified view does not exist');
        }

        $template = file_get_contents($ifExists, FILE_USE_INCLUDE_PATH);
        $template = str_replace(["{{ app_path }}", "{{app_path}}"], $_SESSION['_appPath'], $template);
        $template = str_replace(["{{ server_name }}", "{{server_name}}"], $this->request->realURL(), $template);
        $template = str_replace(["{{ body_render }}", "{{body_render}}"], $render, $template);

        $page = $this->titleRender($template);
        $page = $this->servicesRender($page);
        $page = $this->includeRender($page);
        $page = $this->scriptAndStyleRender($page);
        $page = $this->scriptBodyRender($page);
        $page = $this->commentRender($page);

        return $page;
    }

    public function titleRender($template)
    {
        $searchFor = "title_render::";
        $pattern = preg_quote($searchFor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if (preg_match_all($pattern, $template, $matches)) {
            $title = explode("::", implode($matches[0]));
            strpos($title[1], " }}") !== false ?
                $titleRender = explode(" }}", $title[1]) :
                $titleRender = explode("}}", $title[1])
            ;

            $template = str_replace(implode($matches[0]), "", $template);
            $template = str_replace(["{{ title_render }}", "{{title_render}}"], $titleRender[0], $template);
        }

        return $template;
    }

    public function scriptAndStyleRender($template)
    {
        $delimiter = '#';
        $tags = [
            '{{ script_render:: }}' => '{{ ::script_render }}',
            '{{script_render::}}' => '{{::script_render}}',
            '{{ style_render:: }}' => '{{ ::style_render }}',
            '{{style_render::}}' => '{{::style_render}}'
        ];
        foreach ($tags as $startTag => $endTag) {
            $regex = $delimiter.preg_quote($startTag, $delimiter).'(.*?)'.preg_quote($endTag, $delimiter).$delimiter.'s';
            if (preg_match_all($regex, $template, $matches)) {
                $template = str_replace($startTag.$matches[1][0].$endTag, "", $template);
                $template = str_replace("</head>", $matches[1][0]."</head>", $template);
            }
        }

        $template = str_replace(["{{ app_path }}", "{{app_path}}"], $_SESSION['_appPath'], $template);

        return $template;
    }

    public function scriptBodyRender($template)
    {
        $delimiter = '#';
        $tags = [
            '{{ script_body_render:: }}' => '{{ ::script_body_render }}',
            '{{script_body_render::}}' => '{{::script_body_render}}'
        ];
        foreach ($tags as $startTag => $endTag) {
            $regex = $delimiter.preg_quote($startTag, $delimiter).'(.*?)'.preg_quote($endTag, $delimiter).$delimiter.'s';
            if (preg_match_all($regex, $template, $matches)) {
                $template = str_replace($startTag.$matches[1][0].$endTag, "", $template);
                $template = str_replace("</body>", $matches[1][0]."</body>", $template);
            }
        }

        $template = str_replace(["{{ app_path }}", "{{app_path}}"], $_SESSION['_appPath'], $template);

        return $template;
    }

    public function commentRender($template)
    {
        $searchFor = "{{#";
        $pattern = preg_quote($searchFor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if (preg_match_all($pattern, $template, $matches)) {
            $title = explode("{{#", implode($matches[0]));
            strpos($title[1], "#}}") !== false ?
                $titleRender = explode(" #}}", $title[1]) :
                $titleRender = explode("#}}", $title[1])
            ;

            foreach ($matches[0] as $matche) {
                $template = str_replace($matche, "", $template);
            }
        }

        return $template;
    }

    public function includeRender($template)
    {
        $searchFor = "{{ @include::";
        $pattern = preg_quote($searchFor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if (preg_match_all($pattern, $template, $matches)) {
            $title = explode("{{ @include::", implode($matches[0]));
            strpos($title[1], "}}") !== false ?
                $titleRender = explode(" }}", $title[1]) :
                $titleRender = explode("}}", $title[1])
            ;

            foreach ($matches[0] as $matche) {
                $inclusion = explode($searchFor, $matche);
                $include = explode("}}", $inclusion[1]);
                $render = trim($include[0]);
                list($pack, $view, $layout) = explode(':', $render);
                $view = empty($view) ? "" : $view.'/';
                $ifExists = __DIR__.'/../../src/'.$pack.'/Resources/views/'.$view.$layout;
                if (!file_exists($ifExists)) {
                    throw new \RuntimeException('The specified view does not exist');
                }

                $output = file_get_contents($ifExists, FILE_USE_INCLUDE_PATH);

                $template = str_replace($matche, $output, $template);
                $template = $this->scriptAndStyleRender($template);
                $template = $this->commentRender($template);
            }
        }

        return $template;
    }

    /**
     * Example of use in the view:
     * {{ @services::BereviCollectionPack:Name:john }} OR
     * {{ @services::BereviCollectionPack:Name:john,BereviCollectionPack:logEncryption:getToken }}
     * For display in the view: {{ @output::$key }}
     */
    public function servicesRender($template)
    {
        $searchFor = "{{ @services::";
        $pattern = preg_quote($searchFor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if (preg_match_all($pattern, $template, $matches)) {
            $title = explode("{{ @services::", implode($matches[0]));
            strpos($title[1], "}}") !== false ?
                $titleRender = explode(" }}", $title[1]) :
                $titleRender = explode("}}", $title[1])
            ;

            $serviceContainer = new Services;
            foreach ($matches[0] as $key => $matche) {
                $inclusion = explode($searchFor, $matche);
                $services = explode("}}", $inclusion[1]);
                $render = trim($services[0]);
                $multipleService = explode(",", $render);
                $output = "";
                foreach ($multipleService as $service) {
                    list($pack, $class, $method) = explode(':', $service);
                    $ifExists = __DIR__.'/../../src/'.$pack.'/Services/'.$class.'.php';
                    if (!file_exists($ifExists)) {
                        throw new \RuntimeException('The requested service '.$class.' does not exist');
                    }

                    $class = lcfirst($class);
                    $output .= $serviceContainer->loadServices()->$class->$method();
                }

                $template = str_replace($matche, "", $template);
                $template = str_replace(["{{ @output::$key }}", "{{@output::$key}}"], $output, $template);
            }
        }

        return $template;
    }

    public function coreVariables($key, $value, $render)
    {
        return str_replace($key, $this->varsModelization()->getVariables($value), $render);
    }

    public function getData($httpGetAutorization)
    {
        return $this->varsModelization()->getVariables($httpGetAutorization);
    }
}
