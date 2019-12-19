<?php
namespace Noondaysun\Cli;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 *
 * @author Feighen Oosterbroek <feighen@gmail.com>
 *
 */
class Replication
{

    public static function checkReplication(): void
    {
        $file = (string) __DIR__ . DIRECTORY_SEPARATOR . "../config/config.json";

        if (is_file($file) && is_readable($file)) {
            $config = json_decode(file_get_contents($file), true);
        } else {
            throw new FileNotFoundException("Could not successfully parse configuration file");
        }

        if (isset($config) && is_array($config) && $config) {
            $data = (array) [];
            foreach ($config['Replication'] as $key => $conn) {
                $data[0]['Host'][] = $key;

                try {
                    $pdo = new \PDO($conn['dsn'], $conn['user'], $conn['password']);
                    try {
                        if (preg_match('/master/', $key)) {
                            $sql = (string) 'SHOW MASTER STATUS';
                        } else {
                            $sql = (string) 'SHOW SLAVE STATUS';
                        }

                        $result = $pdo->query($sql);
                        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
                        print_r($rows);

                        if (array_key_exists(0, $rows) === false) {
                            return;
                        }

                        if (array_key_exists('File', $rows[0])) {
                            $data[1]['File'][] = $rows[0]['File'];
                        }

                        if (array_key_exists('Master_Log_File', $rows[0])) {
                            $data[1]['File'][] = $rows[0]['Master_Log_File'];
                        }

                        if (array_key_exists('Position', $rows[0])) {
                            $data[2]['Position'][] = $rows[0]['Position'];
                        }

                        if (array_key_exists('Read_Master_Log_Pos', $rows[0])) {
                            $data[2]['Position'][] = $rows[0]['Read_Master_Log_Pos'];
                        }
                    } catch (\PDOException $ex) {
                        return ;
                    }
                } catch (\PDOException $e) {
                    return ;
                }

                if (preg_match('/master/', $key)) {
                    $sql = (string) 'SHOW MASTER STATUS';
                } else {
                    $sql = (string) 'SHOW SLAVE STATUS';
                }
            }
            print_r($data);
        }
    }
}

$r = new Replication();
$r::checkReplication();