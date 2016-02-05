<?php

namespace Files\Http\Controllers;

use Request;

use Files\Http\Requests;
use Files\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;



class FileController extends Controller
{
    /*
     * Login page
     */
    public function login()
    {
        /*
         * TODO: Handle via CAS
         * Hard-coded values for demo purposes
         */

        if(Session::get('isLogged'))
            return redirect()->action('FileController@user');
        else
        {
            Session::put('isLogged', true); // вредноста треба да се земе од CAS
            Session::put('index', "141042"); // вредноста треба да се земе од CAS
            return View::make('login');
        }
    }

    /*
     * Post-login page
     */

    public function user()
    {
        if (Session::get('isLogged') == true)
        {
            $path = storage_path().'\upload\\'.Session::get('index');
            $files = array_diff(scandir($path), array('.', '..'));

            $parse = array();

            foreach($files as $k => $v)
            {
                // име на фајл
                $array = array();
                array_push($array, $v);

                // големина на фајл
                $path = storage_path() . '\upload\\' . Session::get('index') . '\\' . $v;
                $bytes = File::size($path);
                $bytes = self::formatSizeUnits($bytes);
                array_push($array, $bytes);

                // пат до фајлот
                array_push($array, $path);

                // array-от кој се испраќа на view
                array_push($parse, $array);
            }

            $data = array(
                'files' => $parse,
             );

            return View::make('user')->with($data);
        }
        else
            abort(404);
    }

    /*
     * REST прикачување на фајл
     */

    public function upload()
    {
        if (Session::get('isLogged') == true)
        {
            return \Plupload::file('file', function($file)
            {
                // екстракт на наставката
                $originName = $file->getClientOriginalName();
                $array = explode('.', $originName);
                $extension = end($array);
                // името без наставка
                $name = self::normalizeString(pathinfo($originName, PATHINFO_FILENAME));
                // base64 од името на фајлот
                $fileName = base64_encode($name).'.'.$extension;
                // пат до фајлот
                $path = storage_path().'\upload\\'.Session::get('index').'\\'.$fileName;

                if(!File::exists($path))
                {
                    // фајловите се чуваат во storage/upload/brIndeks/base64(filename).extension
                    $file->move(storage_path('upload/' . Session::get('index')), $fileName);

                    return [
                        'success' => true,
                        'message' => 'Upload successful.',
                        'deleteUrl' => action('FileController@delete', [$file])
                    ];
                }
                // ако веќе постои фајл со исто име, одбиј го
                // за да се избегне ова треба фајловите да се чуваат во база по Id
                else
                {
                    return [
                        'success' => false,
                        'message' => 'File with that name already exists!',
                        'deleteUrl' => action('FileController@delete', [$file])
                    ];
                }
            });
        }
        else
            abort(404);
    }

    public function download($file)
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);

        $array = explode('.', $file);
        $extension = end($array);
        $decodeFile = base64_decode($fileName).'.'.$extension;

        $downloadUrl = storage_path().'\upload\\'.Session::get('index').'\\'.$file;

        return Response::download($downloadUrl, $decodeFile);
    }

    /*
     * REST бришење на фајл
     */

    public function delete()
    {
        $data = Input::all();
        // дали барањето дошло од библиотеката или custom
        if(!isset($data['rowId']))
        {
            // првиот клуч е името на фајлот
            $keys = array_keys($data);
            // библиотеката го враќа името на фајлот со додаден _part на крај
            $tokens = explode('_', $keys[1]);
            array_pop($tokens);
            // последниот _ да се замени со .
            $fileName = implode('_', $tokens);
            $search = '_';
            $replace = '.';

            // името на фајлот со се наставката
            $cleanName = strrev(implode(strrev($replace), explode($search, strrev($fileName), 2)));

            $array = explode('.', $cleanName);
            $extension = end($array);

            // base64.extension
            $encodedName = base64_encode(self::normalizeString(pathinfo($cleanName, PATHINFO_FILENAME))) . '.' . $extension;
            // пат до фајлот
            $path = storage_path() . '\upload\\' . Session::get('index') . '\\' . $encodedName;
        }
        else
            $path = $data['filePath'];

        if(File::delete($path))
        {
            return [
                'success' => true,
                'message' => 'File deleted.',
            ];
        }
        else
        {
            return [
                'success' => false,
                'message' => 'File not deleted.',
            ];
        }
    }

    /*
     * Sanitize filename string
     */

    private function normalizeString($str = '')
    {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '_', $str);
        $str = str_replace('.', '_', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '_', $str);

        return $str;
    }

    /*
     * Convert filesize to units
     */

    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
