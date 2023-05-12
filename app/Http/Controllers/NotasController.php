<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
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

        return response()->json($groupBy, Response::HTTP_OK);
    }

    public function totalRemetente()
    {
        $notas = $this->getData();

        $notasPorRemetente = collect($notas)->groupBy('nome_remete');

        $valorPorRemetente = $notasPorRemetente->map(function ($notas) {
            return $notas->sum('valor');
        });

        return response()->json($valorPorRemetente, Response::HTTP_OK);
    }

    public function valorEntregue()
    {
        $notas = $this->getData();

        $notasPorRemetenteEntregue = collect($notas)->where('status','COMPROVADO')
            ->filter(function ($nota) {
                $dataEmissao = Carbon::createFromFormat('d/m/Y H:i:s', $nota['dt_emis']);
                $dataEntrega = Carbon::createFromFormat('d/m/Y H:i:s', $nota['dt_entrega']);
                $diffEmDias = $dataEntrega->diffInDays($dataEmissao);
                return $diffEmDias <= 2;
            })
            ->groupBy('nome_remete');

        $valorPorRemetenteEntregue = $notasPorRemetenteEntregue->map(function ($notas) {
            return $notas->sum('valor');
        });

        return response()->json($valorPorRemetenteEntregue, Response::HTTP_OK);
    }

    public function emAberto()
    {
        $notas = $this->getData();

        $notasPorRemetenteAberto = collect($notas)->where('status','ABERTO')->groupBy('nome_remete');

        $valorPorRemetenteAberto = $notasPorRemetenteAberto->map(function ($notas) {
            return $notas->sum('valor');
        });

        return response()->json($valorPorRemetenteAberto, Response::HTTP_OK);
    }

    public function deixouReceber()
    {
        $notas = $this->getData();

        $notasPorRemetenteEntregueFora = collect($notas)->where('status','COMPROVADO')
            ->filter(function ($nota) {
                $dataEmissao = Carbon::createFromFormat('d/m/Y H:i:s', $nota['dt_emis']);
                $dataEntrega = Carbon::createFromFormat('d/m/Y H:i:s', $nota['dt_entrega']);
                $diffEmDias = $dataEntrega->diffInDays($dataEmissao);
                return $diffEmDias >= 3;
            })
            ->groupBy('nome_remete');

        $valorPorRemetenteEntregueFora = $notasPorRemetenteEntregueFora->map(function ($notas) {
            return $notas->sum('valor');
        });

        return response()->json($valorPorRemetenteEntregueFora, Response::HTTP_OK);
    }
}
