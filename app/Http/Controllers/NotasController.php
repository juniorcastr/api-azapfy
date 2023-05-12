<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NotasController extends Controller
{
    public function getData()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://homologacao3.azapfy.com.br/api/ps/notas');

        $body = $response->getBody();

        $data = json_decode($body, true);

        return $data;
    }

    public function groupByRemete()
    {
        $notas = $this->getData();
        $groupBy = collect($notas)->groupBy('nome_remete');

        dd($groupBy);

    }
}
