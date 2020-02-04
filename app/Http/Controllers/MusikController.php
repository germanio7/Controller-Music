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

        return response()->file($file);
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
        $vid = substr($request->get('link'), -11);

        parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=" . $vid), $info);

        $aux = $info['player_response'];

        $arr = json_decode($aux, true);

        $nombre = $arr['videoDetails']['title'];

        $formats = $arr['streamingData']['adaptiveFormats'];

        $url = '';
        foreach ($formats as $forma) {
            if ($forma['itag'] == 140) {
                if (key_exists('cipher', $forma)) {

                    return redirect()->action('MusikController@index')->with('youtube', 'Not supported!');

                    // parse_str($forma['cipher'], $aux);
                    // $url = $aux['url'];
                    // $sig = $aux['s'];
                    // $file = fopen($url . '&signature=' . $sig, 'r');
                    // return response()->download($file);
                } else {
                    set_time_limit(300);

                    $origen = fopen($forma['url'], 'rb');
                    $destino = fopen(public_path('songs/' . $nombre . '.mp3'), 'w');

                    stream_copy_to_stream($origen, $destino);

                    // fclose($origen);
                    // fclose($destino);

                    return redirect()->action('MusikController@index')->with('alert', 'File Download!');
                }
            }
        }
    }
}
