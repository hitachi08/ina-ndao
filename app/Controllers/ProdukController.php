<?php
require_once __DIR__ . '/../models/ProdukModel.php';

class ProdukController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new ProdukModel($pdo);
    }

    public function handle($action)
    {
        try {
            switch ($action) {
                case 'index':
                    return ['status' => 'success', 'data' => $this->model->getAllProduk()];

                case 'get_by_id':
                    $id = $_POST['id_produk'] ?? 0;
                    $data = $this->model->getById($id);
                    return $data
                        ? ['status' => 'success', 'data' => $data]
                        : ['status' => 'error', 'message' => 'Produk tidak ditemukan'];

                case 'add_produk':
                    $id = $this->model->addProduk($_POST, $_FILES);
                    return ['status' => 'success', 'id' => $id];

                case 'update_produk':
                    $id = $_POST['id_produk'] ?? null;
                    if (!$id)
                        return ['status' => 'error', 'message' => 'ID produk tidak ditemukan'];
                    $this->model->updateProduk($id, $_POST, $_FILES);
                    return ['status' => 'success'];

                case 'delete_produk':
                    $id = $_POST['id_produk'] ?? 0;
                    $this->model->deleteProduk($id);
                    return ['status' => 'success'];

                case 'get_options':
                    return ['status' => 'success', 'data' => $this->model->getOptions()];

                case 'search':
                    $keyword = $_GET['q'] ?? '';
                    $data = $this->model->searchProduk($keyword);
                    return ['status' => 'success', 'data' => $data];

                case 'filter':
                    $filters = [
                        'id_daerah' => $_POST['daerah'] ?? null,
                        'id_jenis_kain' => $_POST['jenis'] ?? null,
                        'id_kategori' => $_POST['kategori'] ?? null,
                        'id_sub_kategori' => $_POST['subkategori'] ?? null,
                        'harga_min' => $_POST['harga_min'] ?? null,
                        'harga_max' => $_POST['harga_max'] ?? null,
                    ];
                    $data = $this->model->filterProduk($filters);
                    return ['status' => 'success', 'data' => $data];

                case 'detail':
                    $slug = $_POST['slug'] ?? $_GET['slug'] ?? null;
                    return $this->model->getDetailProduk($slug);

                default:
                    return ['status' => 'error', 'message' => 'Action tidak valid'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
