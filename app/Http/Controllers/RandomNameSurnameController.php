<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RandomName;
use App\Models\RandomSurname;

class RandomNameSurnameController extends Controller
{
    public function index()
    {
        $namesByGender = RandomName::all();
        $maleNames = $namesByGender->filter(function ($group) {
            return $group->gender === 'm';
        });

        $femaleNames = $namesByGender->filter(function ($group) {
            return $group->gender === 'f';
        });

        $surnames = RandomSurname::all();

        return view('randoms.index', compact('maleNames', 'femaleNames', 'surnames'));
    }

    public function storeNameView()
    {
        return view('randoms.store_name');
    }

    public function storeSurnameView()
    {
        return view('randoms.store_surname');
    }

    public function storeName(Request $request)
    {
        if($request->hasFile('file_name')) {
            $path = $request->file('file_name')->getRealPath();
            $namesData = [];
            $file = fopen($path, 'r');

            while (($line = fgetcsv($file)) !== FALSE) {
                if (!isset($line[0])) {
                    continue;
                }

                $names = explode(' ', $line[0]);
                $name = $names[0];

                $namesData[] = [
                    'name' => $name,
                    'gender' => $request->gender,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            fclose($file);
            $names = collect($namesData);

            $names->chunk(1000)->each(function($chunk) {
                $chunk->each(function($name) {
                    RandomName::firstOrCreate(['name' => $name['name'], 'gender' => $name['gender']]);
                });
            });

            return redirect()->route('randoms');

        }else{
            RandomName::firstOrCreate(['name' => $request->name, 'gender' => $request->gender]);
        }

        return redirect()->route('randoms');
    }

    public function storeSurname(Request $request)
    {
        if($request->hasFile('file_surname')) {
            $path = $request->file('file_surname')->getRealPath();
            $surnamesData = [];
            $file = fopen($path, 'r');

            while (($line = fgetcsv($file)) !== FALSE) {
                if (!isset($line[0])) {
                    continue;
                }

                $surnames = explode(' ', $line[0]);
                $surname = $surnames[0];

                $surnamesData[] = [
                    'surname' => $surname,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            fclose($file);
            $surnames = collect($surnamesData);

            $surnames->chunk(1000)->each(function($chunk) {
                $chunk->each(function($surname) {
                    RandomSurname::firstOrCreate(['surname' => $surname['surname']]);
                });
            });

            return redirect()->route('randoms');

        }else{
            RandomSurname::firstOrCreate(['surname' => $request->surname]);
        }

        return redirect()->route('randoms');
    }

    public function storeFromFile(Request $request)
    {
        $path = $request->file('name_surname')->getRealPath();
        $names = [];
        $surnames = [];

        $file = fopen($path, 'r');

        while (($line = fgetcsv($file)) !== FALSE) {
            if (!isset($line[0])) {
                continue;
            }

            $nameSurname = explode(' ', $line[0]);

            $name = $nameSurname[0];
            $surname = $nameSurname[1];

            $names[] = [
                'name' => $name,
                'gender' => $request->gender,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $surnames[] = [
                'surname' => $surname,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        fclose($file);
        $names = collect($names);
        $surnames = collect($surnames);

        $names->chunk(1000)->each(function($chunk) {
            $chunk->each(function($name) {
                RandomName::firstOrCreate(['name' => $name['name'], 'gender' => $name['gender']]);
            });
        });

        $surnames->chunk(1000)->each(function($chunk) {
            $chunk->each(function($surname) {
                RandomSurname::firstOrCreate(['surname' => $surname['surname']]);
            });
        });

        return redirect()->route('randoms');
    }

    public function export($name)
    {
        $surnames = RandomSurname::all();
        $surnames = $surnames->pluck('surname')->toArray();
        $formattedSurnames = [];

        foreach ($surnames as $surname) {
            $formattedSurnames[] = $name . ' ' . $surname;
        }

        $surnames = implode("\n", $formattedSurnames);

        $filename = $name . '.txt';
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
        ];

        return response($surnames, 200, $headers);
    }

    public function generator(Request $request)
    {
        $query = RandomName::query();

        if ($request->has('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        $names = $query->pluck('name')->toArray();
        $surnames = RandomSurname::pluck('surname')->toArray();

        $randomNames = [];
        $totalRow = $request->total_row;

        for ($i = 0; $i < $totalRow; $i++) {
            $randomName = $names[array_rand($names)];
            $randomSurname = $surnames[array_rand($surnames)];
            $randomNames[] = $randomName . ' ' . $randomSurname;
        }

        $randomNames = implode("\n", array_unique($randomNames));

        $filename = 'random-names.txt';
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
        ];

        return response($randomNames, 200, $headers);
    }


    public function deleteName($id)
    {
        RandomName::where('id', $id)->delete();

        return redirect()->route('randoms');
    }

    public function deleteSurname($id)
    {
        RandomSurname::where('id', $id)->delete();

        return redirect()->route('randoms');
    }
}
