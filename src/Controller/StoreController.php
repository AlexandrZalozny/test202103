<?php
namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;

class StoreController
{
    /**
     * @return Response
     */
    public function number()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}