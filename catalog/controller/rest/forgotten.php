<?php

/**
 * forgotten.php
 *
 * Forgotten password
 *
 * @author     Opencart-api.com
 * @copyright  2017
 * @license    License.txt
 * @version    2.0
 * @link       https://opencart-api.com/product/shopping-cart-rest-api/
 * @documentations https://opencart-api.com/opencart-rest-api-documentations/
 */

require_once(DIR_SYSTEM . 'engine/restcontroller.php');

class ControllerRestForgotten extends RestController
{

    /*
    * forgotten password
    */
    public function forgotten()
    {

        $this->checkPlugin();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->customer->isLogged()) {
                $this->json['error'][] = "User is already logged";
                $this->statusCode = 400;
            } else {
                $this->load->model('account/customer');
                $this->load->language('account/forgotten');

                $post = $this->getPost();
                $error = $this->forgotten_validate($post);

                if (empty($error)) {
                    $code = token(40);
                    $this->model_account_customer->editCode($post['email'], $code);
                } else {
                    $this->json["error"] = $error;
                    $this->statusCode = 400;
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();

    }

    protected function forgotten_validate($post)
    {
        $error = array();
        if (!isset($post['email'])) {
            $error[] = $this->language->get('error_email');
        } elseif (!$this->model_account_customer->getTotalCustomersByEmail($post['email'])) {
            $error[] = $this->language->get('error_email');
        }
        return $error;
    }


    /*
    * reset password
     * */
    public function reset()
    {
        $this->checkPlugin();

        echo "FFFF";
        return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->customer->isLogged()) {
                $this->json['error'][] = "User is already logged";
                $this->statusCode = 400;
            } else {
                $this->load->model('account/customer');
                $this->load->language('account/reset');

                $post = $this->getPost();
                $error = $this->reset_validate($post);

                if (empty($error)) {
                    $customer_info = $this->model_account_customer->getCustomerByCode($post['code']);
                    $this->model_account_customer->editPassword($customer_info['email'], $post['password']);

                } else {
                    $this->json["error"] = $error;
                    $this->statusCode = 400;
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }


        $this->json["error"] = "Test";

        return $this->sendResponse();

    }


    protected function reset_validate($post)
    {
        $error = array();
        if (!isset($post['code'])) {
            $error[] = "Test";
        } elseif (!$this->model_account_customer->getCustomerByCode($post['code'])) {
            $error[] = "Test";
        }

        if ((utf8_strlen(html_entity_decode($post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
            $error[] = $this->language->get('error_password');
        }

        if ($post['confirm'] != $post['password']) {
            $error[] = $this->language->get('error_confirm');
        }

        return $error;
    }
}
