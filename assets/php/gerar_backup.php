<?php

function conectarAoBanco() {
    $conn = mysqli_connect('localhost', 'root', '', 'sistema');
    if (!$conn) {
        die('Erro de conexão: ' . mysqli_connect_error());
    }
    return $conn;
}

function obterTabelas($conn) {
    $result_tabela = "SHOW TABLES";
    $resultado_tabela = mysqli_query($conn, $result_tabela);
    $tabelas = [];
    while ($row_tabela = mysqli_fetch_row($resultado_tabela)) {
        $tabelas[] = $row_tabela[0];
    }
    return $tabelas;
}

function obterDadosTabela($conn, $tabela) {
    $result_colunas = "SELECT * FROM $tabela";
    $resultado_colunas = mysqli_query($conn, $result_colunas);
    return $resultado_colunas;
}

function exportarSQL($conn, $caminho) {
    $tabelas = obterTabelas($conn);
    $result = "";

    foreach ($tabelas as $tabela) {
        $result .= "DROP TABLE IF EXISTS $tabela;\n";

        $result_cr_col = "SHOW CREATE TABLE $tabela";
        $row_cr_col = mysqli_fetch_row(mysqli_query($conn, $result_cr_col));
        $result .= $row_cr_col[1] . ";\n";

        $resultado_colunas = obterDadosTabela($conn, $tabela);

        while ($row_tp_col = mysqli_fetch_row($resultado_colunas)) {
            $result .= 'INSERT INTO ' . $tabela . ' VALUES(';

            foreach ($row_tp_col as $valorColuna) {
                $valorColuna = addslashes($valorColuna);
                $valorColuna = str_replace("\n", "\\n", $valorColuna);

                if (!empty($valorColuna)) {
                    $result .= '"' . $valorColuna . '"';
                } else {
                    $result .= 'NULL';
                }

                $result .= ',';
            }

            $result = rtrim($result, ',');
            $result .= ");\n";
        }

        $result .= "\n";
    }

    $diretorio = 'backup/';

    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
        chmod($diretorio, 0777);
    }

    $data = date('Y-m-d-h-i-s');
    $nome_arquivo = $diretorio . "db_backup_" . $data;

    $handle = fopen($nome_arquivo . '.sql', 'a+');
    fwrite($handle, $result);
    fclose($handle);

    // Inserir informações do backup na tabela backup_control
    $caminho_backup = $nome_arquivo . '.sql';
    mysqli_query($conn, "INSERT INTO backup_control (caminho_backup) VALUES ('$caminho_backup')");

    $_SESSION['msg'] = file_exists($nome_arquivo . '.sql')
        ? "<span style='color: green;'>Exportado BD com sucesso</span>"
        : "<span style='color: red;'>Erro ao exportar o BD</span>";

    return $nome_arquivo . ".sql";
}

$conn = conectarAoBanco();
exportarSQL($conn, '');

?>
