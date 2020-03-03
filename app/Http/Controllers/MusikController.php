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

        $cant = $this->contador();

        return view('index')->with(compact('songs', 'cant'));
    }

    public function contador()
    {
        $jsonString = file_get_contents(base_path('contador.json'));
        $contador = json_decode($jsonString, true);

        $cantidad = $contador['cantidad'] + 1;

        $contador['cantidad'] = $cantidad;

        $updateJson = json_encode($contador);
        file_put_contents(base_path('contador.json'), $updateJson);

        return $cantidad;
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
        if ($request->get('link')) {

            $vid = substr($request->get('link'), -11);

            parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=" . $vid), $info);

            if (key_exists('player_response', $info)) {
                $aux = $info['player_response'];

                $arr = json_decode($aux, true);

                $nombre = $arr['videoDetails']['title'];

                if (key_exists('streamingData', $arr)) {
                    $formats = $arr['streamingData']['adaptiveFormats'];

                    $url = '';
                    foreach ($formats as $forma) {
                        if ($forma['itag'] == 140) {
                            if (key_exists('cipher', $forma)) {
                                parse_str($forma['cipher'], $aux);
                                $url = $aux['url'];
                                $sp = $aux['sp'];
                                $s = $aux['s'];
                                header("Content-Type: application/force-download");
                                header("Content-Disposition: attachment; filename=\"$nombre.mp3\"");
                                readfile($url);;
                            } else {
                                header("Content-Type: application/force-download");
                                header("Content-Disposition: attachment; filename=\"$nombre.mp3\"");
                                readfile($forma['url']);
                            }
                        }
                    }
                } else {
                    return redirect()->action('MusikController@index')->with('youtube', 'Not supported!');
                }
            } else {
                return redirect()->back()->with('formato', 'Copy and paste the video link!');
            }
        } else {
            return redirect()->back()->with('vacio', 'The link cannot be empty!');
        }
    }
}
