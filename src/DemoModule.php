<?php
namespace Puppy;

use Puppy\Controller\AppController;
use Puppy\Module\IModule;
use Puppy\StaticModule\StaticController;
use Symfony\Component\HttpFoundation\Request;

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

        $application->post(
            'contact',
            function(Request $request, StaticController $staticController){
                /**
                 * @var AppController $this
                 */

                if(!$request->get('email')){
                    //if the form is not filled, we display the form with the error
                    return $staticController->render(['error' => 'Form not filled']);
                }

                //send the email...

                //if the email is send, we redirect to avoid F5.
                $this->flash()->set('message', sprintf('Email sent from %s', $request->get('email')));
                return $this->redirect($request->getRequestUri());

            }
        );
    }
}
 