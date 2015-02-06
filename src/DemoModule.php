<?php
namespace Puppy;

use Puppy\Controller\AppController;
use Puppy\Module\IModule;

/**
 * Class MainModule
 * some funny things
 *
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DemoModule implements IModule
{
    /**
     * init the module.
     *
     * @param Application $application
     */
    public function init(Application $application)
    {
        $application->get(
            'redirect-from',
            function () {
                /**
                 * @var AppController $this
                 */
                $this->flash()->set('funny', 'redirection done with fun! :)');
                return $this->redirect('redirect-to');
            }
        );

        $application->get(
            'redirect-to',
            function () {
                /**
                 * @var AppController $this
                 */
                return $funny = $this->flash()->get('funny', ['no redirection'])[0];
            }
        );
    }
}
 