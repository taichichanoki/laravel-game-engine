<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function exportSeeder(): StreamedResponse
    {
        $tables = ['assets', 'scenes', 'scene_steps', 'choices'];
        return response()->streamDownload(function () use ($tables){
            echo "<?php\n\n";
            echo "namespace Database\Seeders;\n\n";
            echo "use Illuminate\Database\Seeder;\n";
            echo "use Illuminate\Support\Facades\DB;\n\n";
            echo "class MasterDataSeeder extends Seeder\n";
            echo "{\n";
            echo "    /**\n";
            echo "     * Run the database seeds.\n";
            echo "     */\n";
            echo "    public function run(): void\n";
            echo "    {\n";
            echo "        DB::statement('SET FOREIGN_KEY_CHECKS=0;');\n";
            foreach (array_reverse($tables) as $table) {
                echo "        DB::table('{$table}')->truncate();\n";
            }
            echo "        DB::statement('SET FOREIGN_KEY_CHECKS=1;');\n\n";

            foreach ($tables as $table) {
                echo "        // --- {$table} テーブルのデータ ---\n";
                $rows = DB::table($table)->get();

                if ($rows->isEmpty()) {
                    echo "        // データなし\n\n";
                    continue;
                }

                echo "        DB::table('{$table}')->insert([\n";

                foreach ($rows as $row) {
                    echo "            [\n";
                    foreach ((array)$row as $column => $value) {
                        if (is_null($value)) {
                            echo "                '{$column}' => null,\n";
                        } elseif (is_numeric($value) && !str_starts_with($value, '0')) {
                            echo "                '{$column}' => {$value},\n";
                        } else {
                            $escaped = addslashes($value);
                            echo "                '{$column}' => '{$escaped}',\n";
                        }
                    }
                    echo "            ],\n";
                }

                echo "        ]);\n\n";
            }

            echo "    }\n";
            echo "}\n";

        }, 'MasterDataSeeder.php', [
            'Content-Type' => 'text/x-php',
        ]);
    }
}
