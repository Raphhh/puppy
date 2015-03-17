<?php
namespace Puppy\StaticModule;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateRouter
 * returns the templates from route
 *
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TemplateRouter
{
    /**
     * @var \ArrayAccess
     */
    private $config;

    /**
     * @param \ArrayAccess $config
     * @throws \InvalidArgumentException
     */
    public function __construct(\ArrayAccess $config)
    {
        if (empty($config['template.directory.main'])) {
            throw new \InvalidArgumentException(
                'Config must define the key "template.directory.main" for the path to the template files'
            );
        }

        $this->setConfig($config);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function findTemplateFile(Request $request)
    {
        foreach ($this->getPathList($request) as $path) {
            if ($this->isFile($path)) {
                return $path;
            }
        }
        return '';
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getPathList(Request $request)
    {
        $pathList = [];
        $url = $this->getUrl($request);

        if ($url) {
            $pathList[] = $url . DIRECTORY_SEPARATOR . $this->getDefaultFile();  //foo => foo/index.html.twig
            $pathList[] = $url . $this->getTemplateFileExtension(); //index.html => index.html.twig
        } else {
            $pathList[] = $this->getDefaultFile(); // / => index.html.twig
        }

        return $this->cleanPathList($pathList);
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getUrl(Request $request)
    {
        $urlData = $this->parseUrl($request);
        if (!empty($urlData['path']) && $urlData['path'] !== '/') {
            return trim($urlData['path'], '/');
        }
        return '';
    }

    /**
     * @param string[] $pathList
     * @return string[]
     */
    private function cleanPathList(array $pathList)
    {
        foreach ($pathList as $index => $path) {
            $pathList[$index] = 'public' . DIRECTORY_SEPARATOR . $path;
        }
        return $pathList;
    }

    /**
     * @param Request $request
     * @return string[]
     */
    private function parseUrl(Request $request)
    {
        if (!empty($this->getConfig()['baseUrl'])) {
            return parse_url(str_replace($this->getConfig()['baseUrl'], '', $request->getRequestUri()));
        }
        return parse_url($request->getRequestUri());
    }

    /**
     * @return string
     */
    private function getDefaultFile()
    {
        if (!empty($this->getConfig()['template.file.default'])) {
            return $this->getConfig()['template.file.default'] . $this->getTemplateFileExtension();
        }
        return 'index' . $this->getExtendedFileExtension();
    }

    /**
     * @return string
     */
    private function getServerFileExtension()
    {
        if (!empty($this->getConfig()['template.file.server.extension'])) {
            return $this->getConfig()['template.file.server.extension'];
        }
        return '.html';
    }

    /**
     * @return string
     */
    private function getTemplateFileExtension()
    {
        if (!empty($this->getConfig()['template.file.template.extension'])) {
            return $this->getConfig()['template.file.template.extension'];
        }
        return '.twig';
    }

    /**
     * @return string
     */
    private function getExtendedFileExtension()
    {
        return $this->getServerFileExtension() . $this->getTemplateFileExtension();
    }

    /**
     * @return string
     */
    private function getTemplatesDirectory()
    {
        return $this->getConfig()['template.directory.main'] . DIRECTORY_SEPARATOR;
    }

    /**
     * Getter of $config
     *
     * @return \ArrayAccess
     */
    private function getConfig()
    {
        return $this->config;
    }

    /**
     * Setter of $config.
     *
     * @param \ArrayAccess $config
     */
    private function setConfig(\ArrayAccess $config)
    {
        $this->config = $config;
    }

    /**
     * @param $path
     * @return bool
     */
    private function isFile($path)
    {
        return file_exists($this->getTemplatesDirectory() . $path);
    }
}
