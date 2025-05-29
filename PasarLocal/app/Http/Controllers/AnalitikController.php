<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class AnalitikController extends Controller
{
    // Menampilkan halaman dashboard analitik
    public function index()
    {
        return view('admin.analitik.index');
    }

    // Mengambil semua nama tabel dari database
    public function getTables()
    {
        $databaseName = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . $databaseName;

        $tableNames = array_map(function ($item) use ($tableKey) {
            return $item->$tableKey;
        }, $tables);

        return response()->json($tableNames);
    }

    // Mengambil nama kolom dari tabel tertentu
    public function getColumns($table)
    {
        $columns = Schema::getColumnListing($table);
        $columnData = [];

        foreach ($columns as $col) {
            $type = DB::getSchemaBuilder()->getColumnType($table, $col);
            $columnData[] = [
                'name' => $col,
                'type' => $type
            ];
        }

        // Ambil foreign key
        $foreignKeyData = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_NAME', $table)
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->get();

        foreach ($foreignKeyData as $fk) {
            $refCols = Schema::getColumnListing($fk->REFERENCED_TABLE_NAME);
            foreach ($refCols as $refCol) {
                $type = DB::getSchemaBuilder()->getColumnType($fk->REFERENCED_TABLE_NAME, $refCol);
                $columnData[] = [
                    'name' => $fk->REFERENCED_TABLE_NAME . '.' . $refCol,
                    'type' => $type
                ];
            }
        }

        return response()->json($columnData);
    }

    // Mengambil data untuk ditampilkan di chart
    public function getChartData(Request $request)
    {
        $table = $request->table;
        $x = $request->x;
        $y = $request->y;
        $aggregation = strtolower($request->aggregation);

        // Validasi agregasi (optional, supaya aman)
        $allowedAgg = ['sum', 'avg', 'count', 'min', 'max'];
        if (!in_array($aggregation, $allowedAgg)) {
            return response()->json(['error' => 'Invalid aggregation type'], 400);
        }

        $query = DB::table($table);

        // Ambil foreign key relasi dari information_schema
        $foreignKeyData = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_NAME', $table)
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->get();

        $fkMap = [];
        foreach ($foreignKeyData as $fk) {
            $fkMap[$fk->REFERENCED_TABLE_NAME] = [
                'local' => $fk->COLUMN_NAME,
                'foreign' => $fk->REFERENCED_COLUMN_NAME,
            ];
        }

        // Cek apakah kolom x dan y mengandung nama tabel lain (format: tabel.kolom)
        foreach ([$x, $y] as $col) {
            if (str_contains($col, '.')) {
                [$joinTable, $joinCol] = explode('.', $col);
                if (isset($fkMap[$joinTable])) {
                    // Join hanya sekali per tabel agar tidak double join
                    $query->leftJoin($joinTable, "$table.{$fkMap[$joinTable]['local']}", '=', "$joinTable.{$fkMap[$joinTable]['foreign']}");
                }
            }
        }

        // Cek tipe kolom x (kalau ada join, kolom bisa berupa tabel.kolom, ambil kolomnya saja)
        $xParts = explode('.', $x);
        $xTable = count($xParts) > 1 ? $xParts[0] : $table;
        $xCol = end($xParts);

        $columnsInfo = DB::select("SHOW COLUMNS FROM `$xTable` WHERE Field = ?", [$xCol]);
        $typeX = $columnsInfo[0]->Type ?? '';

        if (strpos($typeX, 'date') !== false || strpos($typeX, 'timestamp') !== false || strpos($typeX, 'datetime') !== false) {
            // Kalau x adalah tanggal, gunakan DATE() dan COUNT(*)
            $query->selectRaw("DATE($x) as x, COUNT(*) as value")
                ->groupBy('x');
        } else {
            // Default gunakan agregasi yg dipilih
            $query->selectRaw("$x as x, $aggregation($y) as value")
                ->groupBy('x');
        }

        $data = $query->get()->map(fn($item) => [
            'x' => $item->x,
            'value' => $item->value,
        ]);

        return response()->json($data);
    }


}

