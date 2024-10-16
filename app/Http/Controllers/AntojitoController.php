<?php

namespace App\Http\Controllers;

use App\Models\mongoAntojito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AntojitoController extends Controller
{
    public function index()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current', $tables);
        return view("tables", compact('tables'));
    }

    public function showJson(Request $request)
    {
        try {
            $table = $request->input('table');
            $data = DB::table($table)->get();
            Log::info("Datos recuperados de la tabla {$table}", ['data' => $data]);
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error("Error al mostrar JSON de la tabla {$table}: " . $e->getMessage());
            return response()->json([
                'message' => 'Error durante la transferencia: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function insertJson(Request $request)
    {
        try {
            $table = $request->input('table');
            $data = DB::table($table)->get()->toArray();

            // Crear una nueva instancia de MongoClient
            $client = new \MongoDB\Client(env('MONGO_DB_HOST'));
            // Seleccionar la base de datos y la colección
            $collection = $client->selectCollection(env('MONGO_DB_DATABASE'), $table);

            // Insertar los datos en MongoDB
            $collection->insertMany($data);

            Log::info("Datos insertados en MongoDB desde la tabla {$table}", ['data' => $data]);

            return response()->json([
                'message' => 'Data successfully inserted into MongoDB!',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error al insertar JSON en MongoDB desde la tabla {$table}: " . $e->getMessage());
            return response()->json([
                'message' => 'Error durante la transferencia: ' . $e->getMessage(),
            ], 500);
        }
    }
}
