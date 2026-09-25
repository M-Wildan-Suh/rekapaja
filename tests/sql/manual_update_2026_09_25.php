<?php

// Runs only against disposable databases, never against the application's tables.
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$pdo = Illuminate\Support\Facades\DB::connection()->getPdo();
if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'mysql') {
    throw new RuntimeException('Pengujian ini memerlukan MySQL / MariaDB.');
}
$originalDatabase = $pdo->query('SELECT DATABASE()')->fetchColumn();
$script = file_get_contents(__DIR__.'/../../database/sql/update_2026_09_25.sql');
$script = preg_replace('/^\s*--[^\r\n]*/m', '', $script);
$run = function (string $sql) use ($pdo): void {
    $statement = $pdo->query($sql);
    $statement->closeCursor();
};
$assert = function (bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
};

foreach (['legacy', 'json', 'without_template_id'] as $scenario) {
    $database = 'rekapaja_sql_test_'.bin2hex(random_bytes(6));
    $pdo->exec('CREATE DATABASE `'.$database.'`');
    try {
        $pdo->exec('USE `'.$database.'`');
        $pdo->exec('CREATE TABLE users (id BIGINT UNSIGNED PRIMARY KEY, role VARCHAR(32)) ENGINE=InnoDB');
        $pdo->exec('CREATE TABLE migrations (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255), batch INT) ENGINE=InnoDB');
        $columns = $scenario === 'legacy'
            ? implode(', ', array_map(fn ($field) => '`'.$field.'` VARCHAR(255) NULL', array_keys(App\Models\Template::SECTION_FIELDS)))
            : implode(', ', array_map(fn ($field) => '`'.$field.'` JSON NULL', array_keys(App\Models\Template::defaultSettings())));
        $pdo->exec('CREATE TABLE templates (id BIGINT UNSIGNED PRIMARY KEY, '.$columns.') ENGINE=InnoDB');
        $pdo->exec('CREATE TABLE products (id BIGINT UNSIGNED PRIMARY KEY'.($scenario !== 'without_template_id' ? ', template_id BIGINT UNSIGNED NULL' : '').') ENGINE=InnoDB');
        $pdo->exec("INSERT INTO users VALUES (1, 'operator')");
        if ($scenario === 'legacy') {
            $pdo->exec("INSERT INTO templates (id, head_type, bg_type, bg_main_color) VALUES (1, 'network', 'normal', '#123456')");
        } else {
            $pdo->exec("INSERT INTO templates (id, head, background) VALUES (1, JSON_OBJECT('type', 'network'), JSON_OBJECT('type', 'normal', 'main_color', '#123456'))");
        }
        $pdo->exec($scenario === 'without_template_id' ? 'INSERT INTO products VALUES (1)' : 'INSERT INTO products VALUES (1, 1)');
        if ($scenario === 'json') {
            $pdo->exec('ALTER TABLE products ADD template_settings JSON NULL, ADD created_by BIGINT UNSIGNED NULL');
            $pdo->exec('ALTER TABLE products ADD CONSTRAINT products_created_by_foreign FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL');
            $pdo->exec("INSERT INTO products VALUES (2, 1, JSON_OBJECT('head', JSON_OBJECT('type', 'donut'), 'custom', 'keep'), 1)");
        }

        for ($attempt = 0; $attempt < 2; $attempt++) {
            foreach (explode(';', $script) as $statement) {
                if (trim($statement) !== '') $run($statement);
            }
            $settings = json_decode($pdo->query('SELECT template_settings FROM products WHERE id=1')->fetchColumn(), true);
            $assert($settings['head']['type'] === ($scenario === 'without_template_id' ? 'one' : 'network'), 'Header hasil salinan tidak sesuai.');
            $assert($settings['product']['type'] === 'grid2', 'Default section tidak lengkap.');
            $assert((int) $pdo->query('SELECT COUNT(*) FROM migrations')->fetchColumn() === 2, 'Migration tercatat berulang.');
            $assert($pdo->query('SELECT created_by FROM products WHERE id=1')->fetchColumn() === null, 'Pembuat usaha lama tidak boleh ditebak.');
            if ($scenario === 'json') {
                $existing = json_decode($pdo->query('SELECT template_settings FROM products WHERE id=2')->fetchColumn(), true);
                $assert($existing['head']['type'] === 'donut' && $existing['custom'] === 'keep', 'Desain tersimpan ditimpa.');
            }
        }
        $pdo->exec('UPDATE products SET created_by=1 WHERE id=1');
        $pdo->exec('DELETE FROM users WHERE id=1');
        $assert($pdo->query('SELECT created_by FROM products WHERE id=1')->fetchColumn() === null, 'Foreign key harus ON DELETE SET NULL.');
        echo 'PASS '.$scenario." (termasuk pengulangan script)\n";
    } finally {
        if ($pdo->inTransaction()) $pdo->rollBack();
        // Only the database created above can be removed.
        if (!preg_match('/^rekapaja_sql_test_[a-f0-9]{12}$/', $database)) throw new RuntimeException('Nama database uji tidak valid.');
        $pdo->exec('DROP DATABASE `'.$database.'`');
        $pdo->exec('USE `'.str_replace('`', '``', $originalDatabase).'`');
    }
}
