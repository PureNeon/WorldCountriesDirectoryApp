<?php

namespace App\Rdb;

use Exception;

use App\Model\CountryRepository;
use App\Model\Country;
use App\Rdb\SqlHelper;


class CountryStorage implements CountryRepository
{
    private $sqlHelper;
    public function __construct()
    {
        $this->sqlHelper = new SqlHelper();
    }

    public function GetAll():array
    {
        $countries = array();
        $connection = $this->sqlHelper->openDbConnection();
        $queryStr = 'SELECT short_name, full_name, iso_alpha_2, iso_alpha_3, iso_numeric, human_population, country_square
        FROM countries_t;';
        $rows = $connection->query(query: $queryStr);
        while ($row = $rows->fetch_array())
        {
            $country = new Country(
                shortName: $row[0],
                fullName: $row[1],
                isoAlpha2: $row[2],
                isoAlpha3: $row[3],
                isoNumeric: $row[4],
                population: $row[5],
                square: $row[6],
            );
            array_push($countries, $country);
        }
        $connection->close();
        return $countries;
    }
    public function Get($code): ?Country
    {
        $country = null;
        strtoupper($code);
        $connection = $this->sqlHelper->openDbConnection();
        $queryStr = 'SELECT short_name, full_name, iso_alpha_2, iso_alpha_3, iso_numeric, human_population, country_square FROM countries_t ';
        if (preg_match("/^\d{3}$/", $code))
        {
            $queryStr .= 'WHERE iso_numeric = \''.$code.'\'';
        }
        else
        {
            switch (strlen($code))
            {
                case 2:
                    $queryStr .= 'WHERE iso_alpha_2 = \''.$code.'\'';
                    break;
                case 3:
                    $queryStr .= 'WHERE iso_alpha_3 = \''.$code.'\'';
                    break;
                default:
                    throw new Exception(message: 'invalid country code format', code:'400');
            }
        }
        $rows = $connection->query(query: $queryStr);
        $connection->close();
        while ($row = $rows->fetch_array())
        {
            return new Country(
                shortName: $row[0],
                fullName: $row[1],
                isoAlpha2: $row[2],
                isoAlpha3: $row[3],
                isoNumeric: $row[4],
                population: $row[5],
                square: $row[6]
        );}
    throw new Exception(message: 'not found', code:'404');
    }
    public function Store($country): void
    {
        $connection = $this->sqlHelper->openDbConnection();
        if ($country->shortName === ''|| $country->fullName === '' || strlen($country->isoAlpha2) != 2 || strlen($country->isoAlpha3) != 3 || !preg_match("/^\d{3}$/", $country->isoNumeric) || $country->population == null || $country->square == null)
        {
            throw new Exception(message:'invalid country format', code:'400');
        }
        $queryStr = 'INSERT INTO countries_t (short_name, full_name, iso_alpha_2, iso_alpha_3, iso_numeric, human_population, country_square) VALUES (\''.$country->shortName.'\', \''.$country->fullName.'\', \''.$country->isoAlpha2.'\', \''.$country->isoAlpha3.'\', \''.$country->isoNumeric.'\', \''.$country->population.'\', \''.$country->square.'\')';

        try
        {
            $connection->query($queryStr);
        }
        catch(Exception $e)
        {
            if ($e->getCode() == 1062) throw new Exception(message:$e->getMessage(), code:'409');
            else throw new Exception(message:$e->getMessage(), code:'400');
        }
        $connection->close();
    }
    public function Edit($code, $country): void
    {
        strtoupper($code);
        $connection = $this->sqlHelper->openDbConnection();
        $tryCountryStr = 'SELECT * FROM countries_t ';
        $queryStr = 'UPDATE countries_t SET short_name = \''.$country->shortName.'\', full_name = \''.$country->fullName.'\', iso_alpha_2 = \''.$country->isoAlpha2.'\', iso_alpha_3 = \''.$country->isoAlpha3.'\', iso_numeric = \''.$country->isoNumeric.'\', human_population = \''.$country->population.'\', country_square = \''.$country->square.'\' ';

        if (preg_match("/^\d{3}$/", $code))
        {
            $tryCountryStr .= 'WHERE iso_numeric = \''.$code.'\'';
            $queryStr .= 'WHERE iso_numeric = \''.$code.'\'';
        }
        else
        {
            switch (strlen($code))
            {
                case 2:
                    $tryCountryStr .= 'WHERE iso_alpha_2 = \''.$code.'\'';
                    $queryStr .= 'WHERE iso_alpha_2 = \''.$code.'\'';
                    break;
                case 3:
                    $tryCountryStr .= 'WHERE iso_alpha_3 = \''.$code.'\'';
                    $queryStr .= 'WHERE iso_alpha_3 = \''.$code.'\'';
                    break;
                default:
                    throw new Exception(message: 'invalid country code format', code:'400');
            }
        }
        $queryStr.= ' LIMIT 1';

        $rows = $connection->query(query: $tryCountryStr);

        while ($row = $rows->fetch_array())
        {
            try
            {
                $connection->query($queryStr);
                exit;
            }
            catch(Exception $e)
            {
                if (str_contains($e->getMessage(), 'Duplicate')) 
                {
                    throw new Exception(message:$e->getMessage(), code:'409');
                }
                else
                {
                    throw new Exception(message:$e->getMessage(), code:'400');
                }
            }
                break;
        }
        $connection->close();
        throw new Exception(message:'not found', code:'404');
    }
    public function Delete($code): void
    {
        strtoupper($code);
        $connection = $this->sqlHelper->openDbConnection();
        $tryCountryStr = 'SELECT * FROM countries_t ';
        $queryStr = 'DELETE FROM countries_t ';
        if (preg_match("/^\d{3}$/", $code))
        {
            $tryCountryStr .= 'WHERE iso_numeric = \''.$code.'\'';
            $queryStr .= 'WHERE iso_numeric = \''.$code.'\'';
        }
        else
        {
            switch (strlen($code))
            {
                case 2:
                    $tryCountryStr .= 'WHERE iso_alpha_2 = \''.$code.'\'';
                    $queryStr .= 'WHERE iso_alpha_2 = \''.$code.'\'';
                    break;
                case 3:
                    $tryCountryStr .= 'WHERE iso_alpha_3 = \''.$code.'\'';
                    $queryStr .= 'WHERE iso_alpha_3 = \''.$code.'\'';
                    break;
                default:
                    throw new Exception(message: 'invalid country code format', code:'400');
            }
        }
        $rows = $connection->query(query: $tryCountryStr);

        while ($row = $rows->fetch_array())
        {
            try
            {
                $connection->query($queryStr);
                exit;
            }
            catch(Exception $e)
            {
                throw new Exception(message:$e->getMessage(), code:'400');
            }
                break;
        }
        $connection->close();
        throw new Exception(message:'not found', code:'404');
    }
}