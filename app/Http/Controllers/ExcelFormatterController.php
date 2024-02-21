<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomDataImport;
use App\Exports\CustomDataExport;
use Illuminate\Support\Facades\Storage;

class ExcelFormatterController extends Controller
{
    public function index()
    {
        return view('excel.index');
    }

    public function uploadFile(Request $request)
    {
        ini_set("memory_limit","4096M");    # 4 GB
        set_time_limit(0);          # unlimited transfer time

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        // Storing file information in session or flash data
        $request->session()->flash('uploaded_file_path', $path);

        $collection = Excel::toArray(new CustomDataImport, $file)[0];

        return view('excel.export_data', [
            'data' => $collection[0]
        ]);
    }

    public function downloadFile(Request $request){
        $file_name = $request->session()->get('uploaded_file_path');
        $file = Storage::disk('public')->path($file_name);

        $collection = Excel::toCollection(new CustomDataImport, $file)->first();

        $updatedData = $this->processData($collection, $request->fields);

        if (Storage::disk('public')->exists($file_name)) {
            Storage::disk('public')->delete($file_name);
        }

        return Excel::download(new CustomDataExport($updatedData), 'Excel_' . time() . '.xlsx');
        return redirect()->route('excel-formatter');
    }

    private function processData($data, $fields)
    {
        return $data->map(function ($row) use ($fields) {
            // Initialize an empty array to store the elements at the specified indices
            $filteredRow = [];

            // Iterate through the indices array and access the corresponding elements from $row
            foreach ($fields as $index) {
                // Cast the index to an integer to ensure it is treated as a numeric index
                $index = (int)$index;

                // Add the element at the specified index to the $filteredRow array
                $filteredRow[] = isset($row[$index]) ? $row[$index] : null;
            }
            return $filteredRow;
        });

    }
}
