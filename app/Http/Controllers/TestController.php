<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'required|file|mimetypes:text/plain'
            ],
            [
                'file.required' => 'log file is required!',
                'file.mimetypes' => 'file must be a (.txt) file!',
            ]
        );
        $file = $request->file('file');
        $path = $file->store('temp');
        $file_content = file_get_contents(storage_path("app/$path"));
        $lines = explode(PHP_EOL, $file_content);
        $matched = false;
        $count = 0;
        DB::beginTransaction();
        try {
            $values = "";
            foreach ($lines as $line) {
                $pattern = '/^(\S+) (\S+) (\S+) \[(.+)\] "(\S+) (\S+) (\S+)" (\S+) (\S+) "(.*?)" "(.*?)" "(.*?)"/';
                preg_match($pattern, $line, $matches);
                if ($matches) {
                    $log = [
                        'remote_host' => $matches[1],
                        'remote_log' => $matches[2],
                        'remote_user' => $matches[3],
                        'time_stamp' => date('Y-m-d H:i:s', strtotime($matches[4])),
                        'http_method' => $matches[5],
                        'url_path' => $matches[6],
                        'protocol_version' => $matches[7],
                        'http_status_code' => $matches[8],
                        'bytes_sent' => $matches[9],
                        'referer_url' => $matches[10],
                        'user_agent' => $matches[11],
                        'forwarded_info' => $matches[12],
                        'status' => 'pending'
                    ];
                    $values .= "('" . implode("', '", $log) . "'),";
                    $matched = true;
                    $count++;
                } else {
                    continue;
                }
            }
            $query = "INSERT INTO tests (remote_host, remote_log, remote_user, time_stamp, http_method, url_path, protocol_version, http_status_code, bytes_sent, referer_url, user_agent, forwarded_info, status) VALUES " . rtrim($values, ", ") . ";";
            DB::statement($query);
            DB::commit();
            $latestLogs = Test::orderBy('id', 'desc')->take($count)->get();
            if (!$matched) {
                return response()->json([
                    'status' => false,
                    'message' => 'no log found in your file!'
                ]);
            };
            Storage::delete($path);
            return response()->json([
                'status' => true,
                'message' => "$count logs saved successfully!",
                'data' => $latestLogs
            ]);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    // client side pagination
    public function get()
    {
        try {
            $data = Test::get()->all();
            return response()->json([
                'status' => true,
                'message' => 'data get successfully!',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // server side pagination
    public function getAll(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 5;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $query = Test::orderBy('id', $request->query('sortOrder', 'asc'));
            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('remote_host', 'like', '%' . $searchTerm . '%')
                        ->orWhere('id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('time_stamp', 'like', '%' . $searchTerm . '%')
                        ->orWhere('remote_log', 'like', '%' . $searchTerm . '%')
                        ->orWhere('remote_user', 'like', '%' . $searchTerm . '%')
                        ->orWhere('http_method', 'like', '%' . $searchTerm . '%')
                        ->orWhere('url_path', 'like', '%' . $searchTerm . '%')
                        ->orWhere('protocol_version', 'like', '%' . $searchTerm . '%')
                        ->orWhere('status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('http_status_code', 'like', '%' . $searchTerm . '%')
                        ->orWhere('bytes_sent', 'like', '%' . $searchTerm . '%')
                        ->orWhere('referer_url', 'like', '%' . $searchTerm . '%')
                        ->orWhere('user_agent', 'like', '%' . $searchTerm . '%')
                        ->orWhere('forwarded_info', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(status) = ?', strtolower($statusFilter));
            }
            $paginationData = $query->paginate($perPage);
            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'total_items' => $paginationData->total(),
                'current_page' => $paginationData->currentPage(),
                'fetched_items' => count($paginationData->items()),
                'data' => $paginationData->items()
            ]);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $data =  Test::where('id', '=', $id)->first();
            $data->status = $request->status;
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'data update successfully!',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function delete($id)
    {
        try {
            $data = Test::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'data deleted successfully!',
                'data' => $data
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}