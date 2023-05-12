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

    public function totalPorRemetente()
    {
        $notas = $this->getData();

        $notasPorRemetente = collect($notas)->groupBy('nome_remete');

        $valorPorRemetente = $notasPorRemetente->map(function ($notas) {
            return $notas->sum('valor');
        });

        dd($valorPorRemetente);

    }

    public function valorEntregue()
    {
        $notas = $this->getData();

        $notasPorRemetenteEntregue = collect($notas)->where('status','COMPROVADO')->groupBy('nome_remete');

        $valorPorRemetenteEntregue = $notasPorRemetenteEntregue->map(function ($notas) {
            return $notas->sum('valor');
        });

        dd($valorPorRemetenteEntregue);

    }

    public function valorReceber()
    {
        $notas = $this->getData();

        $notasPorRemetenteAberto = collect($notas)->where('status','ABERTO')->groupBy('nome_remete');

        $valorPorRemetenteAberto = $notasPorRemetenteAberto->map(function ($notas) {
            return $notas->sum('valor');
        });

        dd($valorPorRemetenteAberto);
    }
}
