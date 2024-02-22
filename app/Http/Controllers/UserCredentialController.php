<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCredential;
use Illuminate\Support\Facades\Queue;
        use App\Jobs\ProcessUserCredentials;

class UserCredentialController extends Controller
{
    public function index(Request $request) {
        $files = UserCredential::selectRaw('group_name,group_id, COUNT(*) as total, MAX(created_at) as date')
                                ->where('user_id', auth()->id())
                                ->groupBy('group_name','group_id')
                                ->orderByDesc('date')
                                ->get();

        return view('email.index', compact('files'));
    }

    public function storeFromFile(Request $request) {
        $path = $request->file('credentials')->getRealPath();
        $uuid = time();
        $insertData = [];

        $file = fopen($path, 'r');

        while (($line = fgetcsv($file)) !== FALSE) {
            if (!isset($line[0])) {
                continue;
            }

            $emailAndPassword = explode(':', $line[0]);
            $email = $emailAndPassword[0];
            $password = $emailAndPassword[1];

            $emailParts = explode('@', $email);
            $fullEmailProvider = $emailParts[1];
            $emailProvider = explode('.', $fullEmailProvider)[0];

            $credentialData = [
                'email' => $email,
                'password' => $password,
                'email_provider' => $emailProvider,
                'full_email_provider' => $fullEmailProvider,
                'group_name' => $request->group_name,
                'group_id' => $uuid,
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $insert_data[] = $credentialData;
        }

        fclose($file);
        $insert_data = collect($insert_data);

        $insert_data->chunk(1000)->each(function($chunk) {
            UserCredential::insert($chunk->toArray());
        });

        return redirect()->route('email-formatter');
    }

    public function file(Request $request) {
        $file_group = UserCredential::select('email_provider','full_email_provider', \DB::raw('count(*) as total'))
                                    ->where('group_id', $request->group_id)
                                    ->groupBy('email_provider','full_email_provider')
                                    ->orderBy('total', 'desc')
                                    ->get();

        return view('file', compact('file_group'));
    }

    public function export(Request $request) {
        $file_group = UserCredential::where('group_id', $request->group_id)
                                    ->where('full_email_provider', $request->full_email_provider)
                                    ->get();

        $filename = $request->full_email_provider . '.txt';
        $handle = fopen($filename, 'w+');

        foreach($file_group as $row) {
            fwrite($handle, $row['email'] . ":" . $row['password'] . "\n");
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/plain',
        );

        return response()->download($filename, $filename, $headers);
    }

    public function delete(Request $request) {
        if($request->full_email_provider) {
            UserCredential::where('group_id', $request->group_id)
                            ->where('full_email_provider', $request->full_email_provider)
                            ->delete();
        } else {
            UserCredential::where('group_id', $request->group_id)->delete();
        }

        return redirect()->back();
    }
}
