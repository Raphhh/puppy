<?php
namespace Puppy;

use Puppy\Controller\AppController;
use Puppy\Module\IModule;
use Puppy\StaticRoute\StaticController;
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
        $this->exampleOfFormHandling($application);

        $this->exampleOfRedirection($application);
    }

    /**
     * @param Application $application
     */
    private function exampleOfFormHandling(Application $application)
    {
        $application->post('contact', function (Request $request, StaticController $staticController) {

                if (!$request->get('email')) {
                    //if the form is not filled, we display the form with the error
                    return $staticController->render([
                        'text-danger' => 'Form not filled'
                    ]);
                }

                //send the email...

                //if the email is send, we redirect to avoid F5.
                return $staticController->redirect([
                    'text-info' => sprintf('Email sent from %s', $request->get('email'))
                ]);

            }
        );
    }

    /**
     * @param Application $application
     */
    private function exampleOfRedirection(Application $application)
    {
        $application->get('redirect-from', function () {
                /**
                 * @var AppController $this
                 */
                $this->flash()->set('funny', 'redirection done with fun! :)');
                return $this->redirect('redirect-to');
            }
        );

        $application->get('redirect-to', function () {
                /**
                 * @var AppController $this
                 */
                return $funny = $this->flash()->get('funny', ['no redirection'])[0];
            }
        );
    }
}
 