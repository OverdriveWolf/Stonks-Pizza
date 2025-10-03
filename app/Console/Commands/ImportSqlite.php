<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportSqlite extends Command
{
    protected $signature = 'db:import-sqlite {file=database/stonks_pizza_sqlite.sql} {--database=database/stonks_pizza.db}';
    protected $description = 'Import a MySQL-converted SQL dump into SQLite';

    public function handle()
    {
        $file = base_path($this->argument('file'));
        $dbFile = base_path($this->option('database'));

        if (!file_exists($file)) {
            $this->error("SQL file not found: $file");
            return Command::FAILURE;
        }

        if (file_exists($dbFile)) {
            unlink($dbFile);
        }
        touch($dbFile);

        $this->info("Created new SQLite database at $dbFile");

        $pdo = new \PDO("sqlite:$dbFile");
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $sql = file_get_contents($file);

        // --- Basic MySQL → SQLite fixes ---
        $sql = preg_replace('/AUTO_INCREMENT/i', 'AUTOINCREMENT', $sql);
        $sql = preg_replace('/bigint\(\d+\)\s+UNSIGNED/i', 'INTEGER', $sql);
        $sql = preg_replace('/bigint\(\d+\)/i', 'INTEGER', $sql);
        $sql = preg_replace('/int\(\d+\)/i', 'INTEGER', $sql);
        $sql = preg_replace('/decimal\(\d+,\d+\)/i', 'REAL', $sql);
        $sql = preg_replace('/enum\([^)]+\)/i', 'TEXT', $sql);
        $sql = preg_replace('/ENGINE=.*?;/i', ';', $sql);
        $sql = preg_replace('/ COLLATE [a-zA-Z0-9_]+/i', '', $sql);
        $sql = preg_replace('/ CHARACTER SET [a-zA-Z0-9_]+/i', '', $sql);
        $sql = preg_replace('/DEFAULT CHARSET=[^;]+/i', '', $sql);
        $sql = preg_replace('/,?\s*`totaal_prijs`.*?VIRTUAL,?/i', '', $sql); // drop generated column

        // Split into statements
        $statements = array_filter(array_map('trim', explode(";", $sql)));

        foreach ($statements as $stmt) {
            if ($stmt === '') continue;
            try {
                $pdo->exec($stmt);
            } catch (\Exception $e) {
                $this->warn("Skipping invalid SQL: " . substr($stmt, 0, 80) . "...");
                $this->warn(" → " . $e->getMessage());
            }
        }

        $this->info("Import finished.");
        return Command::SUCCESS;
    }
}
