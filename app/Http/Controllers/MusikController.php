<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusikController extends Controller
{
    public function index()
    {
        $arreglo = collect(scandir(public_path('songs/')));
        $songs = collect();

        foreach ($arreglo as $aux) {
            if (strpos($aux, 'mp3')) {
                $songs->push($aux);
            }
        }

        return view('index')->with(compact('songs'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        if ($request->file('audio')) {
            $name = $request->file('audio')->getClientOriginalName();

            if ($request->file('audio')->getClientOriginalExtension() == 'mp3') {
                $request->file('audio')->move(public_path('songs/'), $name);
                return redirect()->action('MusikController@index')->with('alert', 'File Upload!');
            } else {
                return redirect()->back()->with('alert', 'Only files .mp3');
            }
        } else {
            return redirect()->back()->with('alert', 'Select File!');
        }
    }

    public function play($song)
    {
        $file = public_path('songs/' . $song);

        return response(['headers' => ''])->file($file);
    }

    public function copy($song)
    {
        $origen   = fopen(public_path('songs/' . $song), 'r');
        $destino1 = fopen(public_path('songs/' . 'COPIA ' . $song), 'w');
        stream_copy_to_stream($origen, $destino1);
        return redirect()->action('MusikController@index');
    }

    public function eliminar($song)
    {
        $file = public_path('songs/' . $song);
        unlink($file);
        return redirect()->action('MusikController@index');
    }

    public function descargar($song)
    {
        $file = public_path('songs/' . $song);

        return response()->download($file);
    }

    public function download(Request $request)
    {
        // $vid = substr($request->get('link'), -11);

        // parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=" . $vid), $info);

        // $aux = $info['player_response'];

        // $arr = json_decode($aux, true);

        // parse_str($arr['streamingData']['formats'][0]['cipher'], $variable);

        // return $variable;

        // $var = [];

        // foreach ($arr['streamingData']['adaptiveFormats'] as $item) {
        //     if ($item['itag'] == 140) {
        //         $var = $item;
        //     };
        // }

        // $vformat = $arr['streamingData']['formats'][0]['mimeType'];

        // $cipher = $arr['streamingData']['formats'][0]['cipher'];

        // parse_str($arr['streamingData']['formats'][0]['cipher'], $cipher);

        // parse_str($var['cipher'], $cipher);

        // return $cipher['url'];

        // $aux = urldecode(urldecode($cipher));

        // return explode('&', $aux);

        // $url = 'https://r1---sn-uxaxjvh5gbxoupo5-jo9l.googlevideo.com/videoplayback?';
        // $id = 'o-AE-0EAYSROR0U8jyoW8HpBPNRtd3vZDaWZLhsl2gZK5T';
        // $signature = 'ILILgxI2wwRAtgC9DKtWqx2FehLi3ZE8hshADZbI4LugmX3s47N_5WotwCIGvvgTm2_j5PS4M1PHscT7JRnJx2Ta2c_82PwYT6DTLK';

        // $cadena = $url . 'id=' . $id . '&signature=' . $signature;

        // ------------------------------------------------------------------------------------------

        // $origen   = fopen($cipher['url'], 'r');
        // $destino1 = fopen(public_path('nuevo/' . 'descargando.mp4'), 'w');
        // stream_copy_to_stream($origen, $destino1);
        // return redirect()->action('MusikController@index');
        return redirect()->back()->with('youtube', 'Coming to soon!');
    }
}
