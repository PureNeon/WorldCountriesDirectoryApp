<?php

namespace App\Controller;

use Exception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

use App\Model\Country;
use App\Model\CountryScenarios;

#[Route(path:'api/country', name:'app_country')]
class CountryController extends AbstractController
{
    private $countryScenarios;
    public function __construct()
    {
        $this->countryScenarios = new CountryScenarios();
    }

    #[Route(path:'', name: 'country_get_all', methods:['GET'])]
    public function GetAll(): JsonResponse
    {
        $countries = $this->countryScenarios->GetAll();
        return $this->json(data: $countries, status: 200);
    }

    #[Route(path:'/{code}', name: 'country_get_by_code', methods:['GET'])]
    public function Get(string $code): JsonResponse
    {
        try{
            $country = $this->countryScenarios->Get($code);
            return $this->json(data: $country, status: 200);
        }
        catch(Exception $e)
        {
            return $this->json(data: $e->getMessage(), status: $e->getCode());
        }
    }

    #[Route(path:'', name: 'add_new_country', methods:['POST'])]
    public function Store(Request $request, #[MapRequestPayload] Country $country): JsonResponse
    {
        try{
            $this->countryScenarios->Store($country);
            return $this->json(data: '', status: 200);
        }
        catch(Exception $e)
        {
                return $this->json(data: $e->getMessage(), status:$e->getCode());
        }
    }

    #[Route(path:'/{code}', name: 'country_patch', methods:['PATCH'])]
    public function Edit(string $code, Request $request, #[MapRequestPayload] Country $country): JsonResponse
    {
        try
        {
            $this->countryScenarios->Edit($code, $country);
            return $this->json(data: 0, status: 200);
        }
        catch(Exception $e)
        {
            return $this->json(data: $e->getMessage(), status: $e->getCode());
        }
    }

    #[Route(path:'/{code}', name: 'country_delete', methods:['DELETE'])]
    public function Delete(string $code): JsonResponse
    {
        try
        {
            $this->countryScenarios->Delete($code);
            return $this->json(data: 0, status: 200);
        }
        catch(Exception $e)
        {
            return $this->json(data: $e->getMessage(), status: $e->getCode());
        }
    }
}
