<?php
/**
 * cart.php
 *
 * Cart management
 *
 * @author     Opencart-api.com
 * @copyright  2017
 * @license    License.txt
 * @version    2.0
 * @link       https://opencart-api.com/product/shopping-cart-rest-api/
 * @documentations https://opencart-api.com/opencart-rest-api-documentations/
 */

require_once(DIR_SYSTEM . 'engine/restcontroller.php');


class ControllerRestTest extends RestController
{

    private $error = array();


    public function test()
    {
        $this->json["data"] = "Test";
        return $this->sendResponse();
    }




}
